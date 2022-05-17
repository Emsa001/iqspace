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

	$user = $_POST['mark_user'];
	$user_class = $_POST['mark_user_class'];
	$user_name = $_POST['mark_user_name'];

	$mark = $_POST['mark'];
	$mark_points = $_POST['mark_get_points'];
	$mark_max = $_POST['mark_max'];
	$mark_type = $_POST['mark_type'];
	if($mark_type == "Kartkówka"){
		$mark_type = "Kartkowka";
	}else if($mark_type == "Odpowiedź ustna"){
		$mark_type = "Odpowiedzustna";
	}else if($mark_type == "Praca domowa"){
		$mark_type = "Pracadomowa";
	}else if($mark_type == "Praca Klasowa"){
		$mark_type = "PracaKlasowa";
	}else if($mark_type == "Praca na lekcji"){
		$mark_type = "Pracanalekcji";
	}

    if(strpos($mark, ',') == true){
        $mark = str_replace(",",".", $mark);
        echo "jest , zamieniam na . : ";
        echo $mark;
    } 
    if(strpos($mark_points, ',') == true){
        $mark_points = str_replace(",",".", $mark_points);
        echo "jest , zamieniam na . : ";
        echo $mark_points;
    }

    if(strpos($mark_max, ',') == true){
        $mark_max = str_replace(",",".", $mark_max);
        echo "jest , zamieniam na . : ";
        echo $mark_max;
    }


	$mark_waga = $_POST['mark_waga'];
	$mark_lesson = $_POST['mark_lesson'];
	$mark_content = $_POST['mark_content'];
	$date = date("d/m/Y");

	$sql = "INSERT INTO marks (user, mark, mark_get_points, max_mark, waga, typ, lesson, mark_content, date)
			VALUES ('$user', '$mark', '$mark_points', '$mark_max', '$mark_waga', '$mark_type', '$mark_lesson', '$mark_content', '$date')";
	if ($connect->query($sql) === TRUE) {
		$_SESSION['mark_added'] = 1;
		header("Location: ../content/panel/teachers/showmarks.php?login=$user&class=$user_class&user=$user_name");
	} else {
		echo "<b>BŁĄD SKONAKTUJ SIĘ Z:</b><br /><br />email: <b>emikscura123@gmail.com</b><br />TEL: <b>+48 795-406-209</b>";
		echo "<br /><br /> <b>PRZYCZYNA BŁĘDU: </b>" . $sql . "<br>" . $connect->error;
	}
?>