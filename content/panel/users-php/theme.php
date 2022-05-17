<?php
	session_start();
	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: ../../../index.php');
		exit();
	}

	require_once "../../../database/connect.php";

	$connect = @new mysqli($host, $db_user, $db_password, $db_name);
	mysqli_query($connect, "SET CHARSET utf8");
	mysqli_query($connect, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");

	// Check connection
	if (!$connect) {
		die("Connection failed: " . mysqli_connect_error());
	}
    $whois = $_SESSION['whois'];
    if($whois == "student"){
       $db_table = "users";
    }
    else{
       $db_table = "teachers";
    }

    $login = $_SESSION['login'];
	$profil = $_POST['profil'];
	$sql = "UPDATE `$db_table` SET theme = '$profil' WHERE login = '$login'";
	if ($connect->query($sql) === TRUE) {
		header('Location: ../../../szkola.php?data=myaccount');
	} else {
		echo "<b>BŁĄD SKONAKTUJ SIĘ Z:</b><br /><br />email: <b>emikscura123@gmail.com</b><br />TEL: <b>+48 795-406-209</b>";
		echo "<br /><br /> <b>PRZYCZYNA BŁĘDU: </b>" . $sql . "<br>" . $connect->error;
	}
?>
