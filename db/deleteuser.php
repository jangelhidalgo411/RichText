<?php
require('connection.php');
session_start();

$Message = $array = [];


if($_SESSION['Role'] < 2 || !isset($_POST['UserId']))
    $Message[] = 'No Tiene Permiso para borrar.';


if(isset($_POST['UserId'])) {
    $User =  mysqli_query($Conn,"SELECT Email FROM users WHERE id = '".$_POST['UserId']."'");

    while($data = mysqli_fetch_array($User)){
        $array[] = array_map("utf8_encode", $data);
    }

    if($_SESSION['Email'] == $array[0]['Email'])
        $Message[] = 'No Tiene Permiso para borrarse a si mismo.';
    else
        $Message[] = 'se borro.';

    if(count($Message) < 1) {
        mysqli_query($Conn,"DELETE FROM users WHERE id = ".$_POST['UserId']);
    }    

    $User->close();
}


echo json_encode($Message);