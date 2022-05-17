<?php
	session_start();
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: ../../../index.php');
		exit();
	}

	require_once "../../../../database/connect.php";

	$connect = @new mysqli($host, $db_user, $db_password, $db_name);
	mysqli_query($connect, "SET CHARSET utf8");
	mysqli_query($connect, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");

	// Check connection
	if (!$connect) {
		die("Connection failed: " . mysqli_connect_error());
	}
	// CONNECTED
	$id = $_POST['id'];

	$sql = "DELETE FROM `works` WHERE id = '$id' ";
	if ($connect->query($sql) === TRUE) {
		header('Location: ../../../../szkola.php?data=works');
	} else {
		echo "<b>BŁĄD SKONAKTUJ SIĘ Z:</b><br /><br />email: <b>emikscura123@gmail.com</b><br />TEL: <b>+48 795-406-209</b>";
	}
?>