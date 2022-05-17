<?php
	session_start();

	require_once "connect.php";

	$connect = @new mysqli($host, $db_user, $db_password, $db_name);
	mysqli_query($connect, "SET CHARSET utf8");
	mysqli_query($connect, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");

	// Check connection
	if (!$connect) {
		die("Connection failed: " . mysqli_connect_error());
	}

	$user = $_POST['name'];
	$email = $_POST['email'];
	$title = $_POST['subject'];
	$content = $_POST['message'];
	$date = date("d/m/Y");

	if($user == "" or $email == "" or $title == "" or $content == ""){
		$_SESSION['Blad'] = 1;
		header('Location: ../index.php');
	}

	$sql = "INSERT INTO contact_us (user, email, title, content, date) VALUES ('$user','$email', '$title', '$content', '$date')";
	if ($connect->query($sql) === TRUE) {
		$_SESSION['mail'] = 1;
		header('Location: ../index.php');
	} else {
		echo "<b>BŁĄD SKONAKTUJ SIĘ Z:</b><br /><br />email: <b>emikscura123@gmail.com</b><br />TEL: <b>+48 795-406-209</b>";
		echo "<br /><br /> <b>PRZYCZYNA BŁĘDU: </b>" . $sql . "<br>" . $connect->error;
	}
?>