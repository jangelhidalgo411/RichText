<?php
require('connection.php');
session_start();

$Message = [];

if (!isset($_POST['editName']))
    $Message['editil'] = 'Nombre es requerido.';

if (!isset($_POST['editEmail']))
    $Message['editEmail'] = 'Email es requerido.';

if (!isset($_POST['editPassword'],$_POST['editRepeatPassword']))
    $Message['editPassword'] = 'Password es requerido.';

if($_POST['editPassword'] !== $_POST['editRepeatPassword'])
        $Message['editRepeatPassword'] = 'Passwords no coinciden';

if(count($Message) < 1 && isset($_POST['editID'])) {
	$Id = $_POST['editID'];
	$UserEmail = $_POST['editEmail'];
	$UserPassword = ($_POST['editPassword'] != '') ? hash('sha256', md5($_POST['editPassword'])) : '';
	$UserName = $_POST['editName'];
	$editRole = $_POST['editRole'];
	$editActive = $_POST['editActive'];
	$UserDate = date('Y-m-d H:i:s', time());

	if($UserPassword != '')
		mysqli_query($Conn,"UPDATE users SET Name='$UserName',Email='$UserEmail',Password='$UserPassword',Active=$editActive,Role='$editRole',UpdatedAt='$UserDate' WHERE id = $Id");
	else
		mysqli_query($Conn,"UPDATE users SET Name='$UserName',Email='$UserEmail',Active=$editActive,Role='$editRole',UpdatedAt='$UserDate' WHERE id = $Id");
}

echo json_encode($Message);