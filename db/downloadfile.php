<?php
session_start();

$Message = [];


if (isset($_POST['Json'])) {
	$_SESSION['JSONInfo'] = json_encode($_POST['Json']);
	file_put_contents("canvas.json", $_SESSION['JSONInfo']);
}

echo json_encode($Message);
