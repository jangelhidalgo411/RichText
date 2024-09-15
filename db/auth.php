<?php
require('connection.php');

session_start();

$Message = [];

if(!isset($_POST['loginEmail'])) 
    $Message['loginEmail'] = 'Email es requerido.';

if(!isset($_POST['loginPassword']))
    $Message['loginPassword'] = 'Password es requerido.';

$User =  mysqli_query($Conn,"SELECT Email,Password,Name,Role,Active FROM users WHERE email = '".$_POST['loginEmail']."'");
$Row = $User->fetch_row();

if($User->num_rows < 1) {
    $Message['loginEmail'] = 'Email no valido.';
}
else{
    $UserEmail = $Row[0];
    $UserPassword = $Row[1];
    $UserName = $Row[2];
    $UserRole = $Row[3];
    $UserActive = $Row[4];

    if($UserActive == 0)
        $Message['active'] = 'Usuario Inactivo.';
    else
        if($UserPassword !== hash('sha256', md5($_POST['loginPassword'])))
            $Message['loginPassword'] = 'Password Incorrecto';

    if(count($Message) < 1) {
        session_regenerate_id();
        $_SESSION['Logger'] = TRUE;
        $_SESSION['Name'] = $UserName;
        $_SESSION['Role'] = $UserRole;
        $_SESSION['Active'] = $UserRole;
        $_SESSION['Email'] = $_POST['loginEmail'];
    }
}

$User->close();


echo json_encode($Message);