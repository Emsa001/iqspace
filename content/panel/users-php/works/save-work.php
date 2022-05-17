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

    $title = preg_replace('/[^A-Za-z0-9. -]/', '', $_POST['title']);
    $contentx = $_POST['content'];
    $content = str_replace("'","`","$contentx");

    $sql = "UPDATE works SET content = '$content', title = '$title' WHERE id = $id";

    if ($connect->query($sql) === TRUE) {
      header('Location: ./works-edit.php?id='.$id.'');
    } else {
      echo "Error: " . $sql . "<br>" . $connect->error;
    }
?>
