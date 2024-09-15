function SignIn() {
	$(".InputError").removeClass("InputError");
	var Errors = '';

	if($('#loginEmail').val() == '') {
		$('#loginEmail').addClass("InputError");
		Errors += "Email es requerido.</br>";
	}
	if($('#loginPassword').val() == '') {
		$('#loginPassword').addClass("InputError");
		Errors += "Password es requerido.</br>";
	}

	if(Errors == '') {
		let Users = {
			loginEmail: $('#loginEmail').val(),
			loginPassword: $('#loginPassword').val()
		}

		SignInSubmit("./db/auth.php",Users,'Login Incorrecto','PageRefresh');
	}
	else {
		swal('Login Incorrecto',Errors);		
	}
}

function SignUp() {
	$(".InputError").removeClass("InputError");
	var Errors = '';

	if($('#registerName').val() == '') {
		$('#registerName').addClass("InputError");
		Errors += "Nombre es requerido.</br>";
	}
	if($('#registerEmail').val() == '') {
		$('#registerEmail').addClass("InputError");
		Errors += "Email es requerido.</br>";
	}
	if($('#registerPassword').val() == '') {
		$('#registerPassword').addClass("InputError");
		Errors += "Password es requerido.</br>";
	}
	if($('#registerRepeatPassword').val() == '') {
		$('#registerRepeatPassword').addClass("InputError");
		Errors += "Password es requerido.</br>";
	}
	if($('#registerPassword').val() !== $('#registerRepeatPassword').val()) {
		$('#registerRepeatPassword').addClass("InputError");
		Errors += "Passwords no coinciden.</br>";
	}

	if(Errors == '') {
		let Users = {
			registerName: $('#registerName').val(),
			registerEmail: $('#registerEmail').val(),
			registerPassword: $('#registerPassword').val(),
			registerRepeatPassword: $('#registerRepeatPassword').val()
		}

		SignInSubmit("./db/register.php",Users,'Registro Incorrecto','PageRefresh');
	}
	else {
		swal('Registro Incorrecto',Errors);		
	}
}

function EditUp() {
	$(".InputError").removeClass("InputError");
	var Errors = '';

	if($('#editName').val() == '') {
		$('#editName').addClass("InputError");
		Errors += "Nombre es requerido.</br>";
	}
	if($('#editEmail').val() == '') {
		$('#editEmail').addClass("InputError");
		Errors += "Email es requerido.</br>";
	}
	if($('#editPassword').val() !== $('#editRepeatPassword').val()) {
		$('#editRepeatPassword').addClass("InputError");
		Errors += "Passwords no coinciden.</br>";
	}

	if(Errors == '') {
		let Users = {
			editID: $('#editID').val(),
			editName: $('#editName').val(),
			editEmail: $('#editEmail').val(),
			editPassword: $('#editPassword').val(),
			editRole: $('#editRole').val(),
			editActive: $("#editActive").is(":checked"),
			editRepeatPassword: $('#editRepeatPassword').val()
		}

		SignInSubmit("./db/edituser.php",Users,'Registro Incorrecto','TableReload');
	}
	else {
		swal('Registro Incorrecto',Errors);		
	}
}

function Delete(UserId) {
	let Users = {
		UserId: UserId
	}

	SignInSubmit("./db/deleteuser.php",Users,'No se Pudo Borrar','TableReload');
}

function Edit(editID,editName,editEmail,editRole,editActive) {
	$('#editID').val(editID);
	$('#editName').val(editName);
	$('#editEmail').val(editEmail);
	$('#editRole').val(editRole);
	$("#editActive").prop("checked", editActive)
}

function swal(Title,Errors) {
	Swal.fire({
		title: Title,
		html: Errors,
		confirmButtonText: 'Ok'
	});
}

function ExportJSON() {
	let Users = {
		Json: stage.toJSON()
	}

	SignInSubmit("./db/downloadfile.php",Users,'No se Pudo descargar','Redirect');
}


function SignInSubmit(Url,Users,Title,Action) {
	$.post(Url, Users)
	.then((res) => {
		let Obj = Object.entries(JSON.parse(res));
		var Errors = '';

		if(Obj.length > 0) {
			Obj.map(function(item,key){
				Errors += item[1]+"</br>";
				$("#"+item[0]).addClass("InputError");
			});

			swal(Title,Errors);
		}
		else {
			if(Action == 'TableReload' && typeof(DT) !== 'undefined') {
				DT.draw();
				$('.modal.show').modal('hide')
			}
			else if(Action == 'PageRefresh') {
				window.location.reload();
			}
			else if (Action == 'Redirect') {
                setTimeout(function() {
					$('.DownloadJson')[0].click();
                }, 1000);
			}
		}
	});
}