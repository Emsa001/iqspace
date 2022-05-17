<?php
	session_start();

	require_once "./connect.php";

	$connect = @new mysqli($host, $db_user, $db_password, $db_name);
	mysqli_query($connect, "SET CHARSET utf8");
	mysqli_query($connect, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");

	// Check connection
	if (!$connect) {
		die("Connection failed: " . mysqli_connect_error());
	}

	$user_school = $_SESSION['school'];				// user school
	$user_school_code = $_SESSION['school_code'];		// user school code
	$user_login = $_SESSION['login'];				// user login
	$user_current_pass = $_SESSION['password'];		// user current password
	$user_rank = $_SESSION['rank'];					// user rank
	$current_pass = $_POST['current_pass'];			// user Form write current password
	$new_pass = md5($_POST['new_pass']);					// user Form write new password
	$new_repeat_pass = $_POST['new_repeat_pass'];	// user Form write repeat new password

	if($user_rank != "teacher"){
		$table = "users";
	}else{
		$table = "teachers";
	}

	if($user_current_pass != md5($current_pass)){
		$_SESSION['new_password'] = "wrong";
		header('Location: ../szkola.php');
	}else if($_POST['new_pass'] != $new_repeat_pass){
		echo'Nie te same hasła';
	}

	else{
		$sql = "UPDATE $table SET password = '$new_pass' WHERE `login` = '$user_login';";
		if ($connect->query($sql) === TRUE) {
			$_SESSION['new_password'] = "changed";
			header('Location: ../szkola.php');
		} else {
			echo "<b>BŁĄD SKONAKTUJ SIĘ Z:</b><br /><br />email: <b>emikscura123@gmail.com</b><br />TEL: <b>+48 795-406-209</b>";
			//echo "<br /><br /> <b>PRZYCZYNA BŁĘDU: </b>" . $sql . "<br>" . $connect->error;
		}
	}
?>