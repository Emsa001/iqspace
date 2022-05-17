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
		die("Connection failed");
	}
	// CONNECTED
	$id = $_POST['id'];
	$comment = $_POST['comment'];
	$teacher_code = $_POST['teacher_c'];

    $comment = preg_replace('/[^A-Za-z0-9. -]/', '', $comment);

    $login = $_SESSION['login'];

    $sql = "SELECT * FROM lessons WHERE login = '$teacher_code'";
    $result = $connect->query($sql);

    if ($result->num_rows > 0) {
      // output data of each row
      while($row = $result->fetch_assoc()) {
        $teacher_name = $row['teacher'];
      }
    }

    $sql = "UPDATE works SET status='wyslane', comment = '$comment', teachername='$teacher_name', teachercode='$teacher_code' WHERE id=$id";
    $sql_2 = "UPDATE users SET works = works + 1 WHERE login = '$login'";


    if ($connect->query($sql) === TRUE && $connect->query($sql_2) === TRUE) {
      header('Location: ../../../../szkola.php?data=works');
    } else {
      echo "BŁĄD, spróbuj ponownie późnej";
    }
?>
