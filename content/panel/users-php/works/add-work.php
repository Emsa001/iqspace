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
      
    $user = $_SESSION['login'];
    $title = preg_replace('/[^A-Za-z0-9. -]/', '', $_POST['title']);

    if($title == ""){
       $title = "Praca bez tytułu";
    }

    $sql = "INSERT INTO works (user, title) VALUES ('$user', '$title')";

    if ($connect->query($sql) === TRUE) {
      $id = $connect->insert_id;
      header('Location: ./works-edit.php?id='.$id.'');
    }
?>
