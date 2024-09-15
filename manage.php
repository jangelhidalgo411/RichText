<?php
session_start();

require('./db/connection.php');

if(!isset($_SESSION['Logger']))
	header('Location: ../index.php');

$Roles =  mysqli_query($Conn,"SELECT * FROM roles WHERE Role_Id <= ".$_SESSION['Role']);

while($Rol  = mysqli_fetch_array($Roles)){
	$rolArray[] = array_map("utf8_encode", $Rol);
}
?>
<!doctype html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<title>RichTExt</title>
		<!-- CSS CDN's Start -->
		<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
		<link rel="stylesheet" href="https://cdn.quilljs.com/1.3.6/quill.snow.css"/>
		<link href="https://cdn.datatables.net/2.1.4/css/dataTables.dataTables.min.css" rel="stylesheet" />
		<!-- CSS CDN's End -->
		<!-- your custom Style Sheet from addition file-->
		<link rel="stylesheet" type="text/css" href="./css/maincss.css">
		<!-- your custom Style Sheet for only this file in case is needed -->
	</head>
	<body>
		<nav class="navbar navbar-expand-lg navbar-light bg-light px-3">
			<?php if($_SESSION['Role'] > 1) : ?>
			<a class="navbar-brand" href="#">
				<button class="btn btn-outline-success my-2 my-sm-0" data-bs-toggle="modal" data-bs-target="#LoginModal">
					Register
				</button>
			</a>
			<?php endif; ?>
			<button class="navbar-toggler" type="button" data-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item">
						<a class="nav-link" href="./">Inicio</a>
					</li>
					<?php if(isset($_SESSION['Logger'])) : ?>
					<li class="nav-item active">
						<a class="nav-link" href="Manage.php">Gestion</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="./db/logout.php">Cerrar Session</a>
					</li>
					<?php endif; ?>
				</ul>
			</div>
		</nav>

		<?php if($_SESSION['Role'] > 1) : ?>


		<!-- Modal -->
		<div class="modal fade" id="LoginModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header p-0">
						<!-- Pills tab -->
						<ul class="nav nav-tabs w-100" id="Signin" role="tablist">
							<li class="nav-item w-50" role="presentation">
								<button class="nav-link w-100 active" id="signup-tab" data-bs-toggle="tab" data-bs-target="#signup" type="button" role="tab" aria-controls="signup" aria-selected="false">Registrarse</button>
							</li>
						</ul>
						<!-- Pills tab -->
					</div>
					<div class="modal-body">
						<!-- Pills content -->
						<div class="tab-content" id="LoginModalContent">
							<div class="tab-pane fade show active" id="signup" role="tabpanel" aria-labelledby="signup-tab">
								<form class="signup-form" action="SignUp()">
									<!-- Name input -->
									<div class="p-rel mb-3">
										<input type="text" id="registerName" name="registerName" class="form-control" />
										<label class="form-label" for="registerName">Name</label>
									</div>
									<!-- Email input -->
									<div class="p-rel mb-3">
										<input type="email" id="registerEmail" name="registerEmail" class="form-control" />
										<label class="form-label" for="registerEmail">Email</label>
									</div>
									<!-- Password input -->
									<div class="p-rel mb-3">
										<input type="password" id="registerPassword" name="registerPassword" class="form-control" />
										<label class="form-label" for="registerPassword">Password</label>
									</div>
									<!-- Repeat Password input -->
									<div class="p-rel mb-3">
										<input type="password" id="registerRepeatPassword" name="registerRepeatPassword" class="form-control" />
										<label class="form-label" for="registerRepeatPassword">Repeat password</label>
									</div>
									<!-- Submit button -->
									<button type="button" class="btn btn-primary btn-block mb-3" onclick="SignUp()">Sign in</button>
								</form>
							</div>
						</div>
						<!-- Pills content -->
					</div>
				</div>
			</div>
		</div>
		<?php endif; ?>


		<!-- Modal -->
		<div class="modal fade" id="EditModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header p-0">
						<!-- Pills tab -->
						<ul class="nav nav-tabs w-100" id="Signin" role="tablist">
							<li class="nav-item w-50" role="presentation">
								<button class="nav-link w-100 active" id="edit-tab" data-bs-toggle="tab" data-bs-target="#edit" type="button" role="tab" aria-controls="edit" aria-selected="false">Edit</button>
							</li>
						</ul>
						<!-- Pills tab -->
					</div>
					<div class="modal-body">
						<!-- Pills content -->
						<div class="tab-content" id="LoginModalContent">
							<div class="tab-pane fade show active" id="edit" role="tabpanel" aria-labelledby="edit-tab">
								<form class="edit-form">
									<input type="hidden" id="editID" name="editName" class="form-control" />
									<!-- Name input -->
									<div class="p-rel mb-3">
										<input type="text" id="editName" name="editName" class="form-control" />
										<label class="form-label" for="editName">Name</label>
									</div>
									<!-- Email input -->
									<div class="p-rel mb-3">
										<input type="email" id="editEmail" name="editEmail" class="form-control" />
										<label class="form-label" for="editEmail">Email</label>
									</div>
									<!-- Password input -->
									<div class="p-rel mb-3">
										<input type="password" id="editPassword" name="editPassword" class="form-control" />
										<label class="form-label" for="editPassword">Password</label>
									</div>
									<!-- Repeat Password input -->
									<div class="p-rel mb-3">
										<input type="password" id="editRepeatPassword" name="editRepeatPassword" class="form-control" />
										<label class="form-label" for="editRepeatPassword">Repeat password</label>
									</div>
									<!-- Role Select -->
									<div class="p-rel mb-3">
										<select class="form-control" id="editRole" name="editRole">
											<?php
												foreach ($rolArray as $Rol) {
													echo '<option value="'.$Rol['Role_Id'].'">'.$Rol['Role_Name'].'</option>';
												}
											?>
										</select>
										<label class="form-label" for="editRepeatPassword">Repeat password</label>
									</div>
									<!-- Active checkbox -->
									<div class="p-rel mb-3">
										<label class="form-check-label" for="editActive">Is Active</label>
										<input class="form-check-input" type="checkbox" id="editActive" name="editActive" />
									</div>
									<!-- Submit button -->
									<button type="button" class="btn btn-primary btn-block mb-3" onclick="EditUp()">Guardar</button>
								</form>
							</div>
						</div>
						<!-- Pills content -->
					</div>
				</div>
			</div>
		</div>
		<div class="col-12">
			<table id="DataTable" class="display compact" style="max-width:100%">
				<thead>
					<tr>
						<th>Id</th>
						<th>Name</th>
						<th>Email</th>
						<th>Password</th>
						<th>Confirm Password</th>
						<th>Role</th>
						<th>Active</th>
						<th>CreatedAt</th>
						<th>UpdatedAt</th>
						<th></th>
					</tr>
				</thead>
				<tbody>
				</tbody>
				<tfoot>
					<tr>
						<th>Id</th>
						<th>Name</th>
						<th>Email</th>
						<th>Password</th>
						<th>Confirm Password</th>
						<th>Role</th>
						<th>Active</th>
						<th>CreatedAt</th>
						<th>UpdatedAt</th>
						<th></th>
					</tr>
				</tfoot>
			</table>
		</div>
		<!-- JS CDN's Start -->
		<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
		<script src="https://unpkg.com/konva@9/konva.min.js"></script>
		<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<script type="text/javascript" src="//cdn.datatables.net/2.1.4/js/dataTables.min.js"></script>
		<!-- JS CDN's End -->
		<!-- your custom JavaScript from addition file-->
		<script type="text/javascript" src="./js/mainjs.js"></script>
		<script type="text/javascript" src="./js/dataTable.js"></script>
	</body>
</html>