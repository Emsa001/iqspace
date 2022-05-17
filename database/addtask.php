<?php
	session_start();
	if (!isset($_SESSION['teacher']))
	{
		header('Location: ./index.php');
		exit();
	}

	require_once "connect.php";

	$connect = @new mysqli($host, $db_user, $db_password, $db_name);
	mysqli_query($connect, "SET CHARSET utf8");
	mysqli_query($connect, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");

	// Check connection
	if (!$connect) {
		die("Connection failed: " . mysqli_connect_error());
	}
	


	$task_title = $_POST['task_title'];
	$task_lesson = $_POST['task_lesson'];
	$task_teacher = $_SESSION['name']." ".$_SESSION['surname'];
	$task_content = $_POST['task_content'];
	$task_class = $_POST['task_class'];
	$task_date = date("d/m/Y");

	$sql = "INSERT INTO tasks (title, content, lesson, teacher, class, date)
VALUES ('$task_title', '$task_content', '$task_lesson', '$task_teacher', '$task_class', '$task_date')";
	if ($connect->query($sql) === TRUE) {
		$_SESSION['task_added'] = 1;
		header('Location: ../szkola.php');
	} else {
		echo "<b>BŁĄD SKONAKTUJ SIĘ Z:</b><br /><br />email: <b>emikscura123@gmail.com</b><br />TEL: <b>+48 795-406-209</b>";
		echo "<br /><br /> <b>PRZYCZYNA BŁĘDU: </b>" . $sql . "<br>" . $connect->error;
	}
?>