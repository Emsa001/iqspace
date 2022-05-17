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
	// CONNECTED
    $usclass = '2c';//$_POST['class'];
    $lesson = $_SESSION['lesson'];
    $date = date("Y-m-d");
    $datedat = date("l");
    $sql = "SELECT * FROM `users` WHERE `class` = '$usclass'";
       $result = $connect->query($sql);
       if ($result->num_rows > 0) {
          while($row = $result->fetch_assoc()) {
             $user = $row['login'];
             $activity = $_POST['user'.$user];
             if($activity == ''){
                $activity = '-';
             }
             $sql2 = "INSERT INTO activity (lesson, user, activity, date, day) VALUES ('$lesson', '$user', '$activity', '$date', '$datedat')";
             if ($connect->query($sql2) === TRUE) {
               echo "New record created successfully";
             } else {
               echo "Error: " . $sql2 . "<br>" . $connect->error;
             }

          }
       }
?>