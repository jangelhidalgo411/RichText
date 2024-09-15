<?php
require('connection.php');
session_start();

$Message = [];

if (!isset($_POST['registerName']))
    $Message['loginEmail'] = 'Nombre es requerido.';

if (!isset($_POST['registerEmail']))
    $Message['registerEmail'] = 'Email es requerido.';

if (!isset($_POST['registerPassword'],$_POST['registerRepeatPassword']))
    $Message['registerPassword'] = 'Password es requerido.';

if($_POST['registerPassword'] !== $_POST['registerRepeatPassword'])
        $Message['registerRepeatPassword'] = 'Passwords no coinciden';

$User =  mysqli_query($Conn,"SELECT Email,Password,Name,Role,Active FROM users WHERE email = '".$_POST['registerEmail']."'");

if ($User->num_rows > 0)
    $Message['registerEmail'] = 'Email ya existe.';

if(count($Message) < 1) {
	$UserEmail = $_POST['registerEmail'];
	$UserPassword = hash('sha256', md5($_POST['registerPassword']));
	$UserName = $_POST['registerName'];
	$UserDate = date('Y-m-d H:i:s', time());

	mysqli_query($Conn,"INSERT INTO users(Name, Email, Password, CreatedAt, UpdatedAt) VALUES ('".$UserName."','".$UserEmail."','".$UserPassword."','".$UserDate."','".$UserDate."')");

    if(!isset($_SESSION['Logger'])) {
        session_regenerate_id();
        $_SESSION['Logger'] = TRUE;
        $_SESSION['Name'] = $UserName;
        $_SESSION['Role'] = 1;
        $_SESSION['Active'] = true;
        $_SESSION['Email'] = $UserEmail;
    }
}

$User->close();

echo json_encode($Message);