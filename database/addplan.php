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

$class = $_POST['class'];
$day = $_POST['day'];
for($i = 1; $i <= 10; $i++){

	$time = $_POST['time'.$i];
	$teacher = $_POST['teacher'.$i];
	$lesson = $_POST['lesson'.$i];
					 
	echo $time.' '.$teacher.' '.$lesson;

	$sql = "INSERT INTO lesson_plan (lesson, time, class, teacher, day)
			VALUES ('$lesson', '$time', '$class', '$teacher', '$day')";
	
	if($time != "" || $teacher != "" || $lesson != ""){
		if ($connect->query($sql) === TRUE) {
			$_SESSION['plan_added'] = 1;
			header('Location: ../szkola.php');
		} else {
			echo "<b>BŁĄD SKONAKTUJ SIĘ Z:</b><br /><br />email: <b>emikscura123@gmail.com</b><br />TEL: <b>+48 795-406-209</b>";
			echo "<br /><br /> <b>PRZYCZYNA BŁĘDU: </b>" . $sql . "<br>" . $connect->error;
		}
	}
}
?>