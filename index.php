<?php
session_start();
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
		<!-- CSS CDN's End -->
		<!-- your custom Style Sheet from addition file-->
		<link rel="stylesheet" type="text/css" href="./css/maincss.css">
		<!-- your custom Style Sheet for only this file in case is needed -->
	</head>
	<body>
		<nav class="navbar navbar-expand-lg navbar-light bg-light px-3">
			<?php if(!isset($_SESSION['Logger'])) : ?>
			<a class="navbar-brand" href="#">
				<button class="btn btn-outline-success my-2 my-sm-0" data-bs-toggle="modal" data-bs-target="#LoginModal">
					Login / Register
				</button>
			</a>
			<?php endif; ?>
			<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
				<span class="navbar-toggler-icon"></span>
			</button>
			<div class="collapse navbar-collapse" id="navbarNav">
				<ul class="navbar-nav mr-auto">
					<li class="nav-item active">
						<a class="nav-link" href="./">Inicio</a>
					</li>
					<?php if(isset($_SESSION['Logger'])) : ?>
					<li class="nav-item">
						<a class="nav-link" href="Manage.php">Gestion</a>
					</li>
					<li class="nav-item">
						<a class="nav-link" href="./db/logout.php">Cerrar Session</a>
					</li>
					<?php endif; ?>
				</ul>
			</div>
			<div class="form-inline my-2 my-lg-0">
				<?php
					if(isset($_SESSION['Name'])){
						echo $_SESSION['Name'];
					}
				?>
			</div>

		</nav>
		<?php if(!isset($_SESSION['Logger'])) : ?>
		<!-- Modal -->
		<div class="modal fade" id="LoginModal" tabindex="-1" role="dialog" aria-labelledby="ModalLabel" aria-hidden="true">
			<div class="modal-dialog" role="document">
				<div class="modal-content">
					<div class="modal-header p-0">
						<!-- Pills tab -->
						<ul class="nav nav-tabs w-100" id="Signin" role="tablist">
							<li class="nav-item w-50" role="presentation">
								<button class="nav-link w-100 active" id="singin-tab" data-bs-toggle="tab" data-bs-target="#singin" type="button" role="tab" aria-controls="singin" aria-selected="true">Iniciar Session</button>
							</li>
							<li class="nav-item w-50" role="presentation">
								<button class="nav-link w-100" id="signup-tab" data-bs-toggle="tab" data-bs-target="#signup" type="button" role="tab" aria-controls="signup" aria-selected="false">Registrarse</button>
							</li>
						</ul>
						<!-- Pills tab -->
					</div>
					<div class="modal-body">
						<!-- Pills content -->
						<div class="tab-content" id="LoginModalContent">
							<div class="tab-pane fade show active" id="singin" role="tabpanel" aria-labelledby="singin-tab">
								<form class="signin-form" action="SignIn()">
									<!-- Email input -->
									<div class="p-rel mb-3">
										<input type="email" id="loginEmail" name="loginEmail" class="form-control" />
										<label class="form-label" for="loginEmail">Email</label>
									</div>
									<!-- Password input -->
									<div class="p-rel mb-3">
										<input type="password" id="loginPassword" name="loginPassword" class="form-control" />
										<label class="form-label" for="loginPassword">Password</label>
									</div>
									<!-- Submit button -->
									<button type="button" class="btn btn-primary btn-block mb-3" onclick="SignIn()">Sign in</button>
									<!-- Register buttons -->
								</form>
							</div>
							<div class="tab-pane fade" id="signup" role="tabpanel" aria-labelledby="signup-tab">
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
		<div co>

		<div class="row m-0">
			<div class="col-12 mb-2" style="text-align: center;">
				<button class="btn btn-warning" onclick="ExportJSON()">Descargar JSON</button>
				<button class="btn btn-info" onclick="ExportPDF()">Descargar PDF</button>
			</div>
			<div id="richtext" class="col-md-6 col-12">
				<div id="editor"></div>
			</div>
			<div id="previewContainer" class="col-md-6 col-12 p-0">
				<div id="container"></div>	
			</div>
		</div>
		<a class="DownloadJson" href="./db/canvas.json" download target="_blank"></a>
		<!-- JS CDN's Start -->
		<script src="https://code.jquery.com/jquery-3.5.1.js" integrity="sha256-QWo7LDvxbWT2tbbQ97B53yJnYU3WhH/C8ycbRAkjPDc=" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js" integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.min.js" integrity="sha384-0pUGZvbkm6XF6gxjEnlmuGrJXVbNuzT9qBBavbLwCsOGabYfZo0T0to5eqruptLy" crossorigin="anonymous"></script>
		<script src="https://unpkg.com/konva@9/konva.min.js"></script>
		<script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
		<script src="https://html2canvas.hertzen.com/dist/html2canvas.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jspdf/1.5.3/jspdf.debug.js" integrity="sha384-NaWTHo/8YCBYJ59830LTz/P4aQZK1sS0SneOgAvhsIl3zBu8r9RevNg5lHCHAuQ/" crossorigin="anonymous"></script>
		<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
		<!-- JS CDN's End -->
		<!-- your custom JavaScript from addition file-->
		<script type="text/javascript" src="./js/mainjs.js"></script>
		<script type="text/javascript" src="./js/convas.js"></script>
	</body>
</html>