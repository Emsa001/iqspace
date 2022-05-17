<?php
	session_start();

	$login = $_POST['login'];

	$_SESSION['school_code'] = substr($login, 0, 3);
	$school_code = $_SESSION['school_code'];
   
/*
    switch($school_code){
       case '100':
          $db_password = 'Ko2Y93gnySxYW';
       break;
       case '105':
          $db_password = 'Kp9DDcZ*qXC*8';
       break;
    }*/

	/*$host = "localhost";
	$db_user = "root";
	$db_password = "";
	$_SESSION['db_name'] = $school_code."_school";*/

	$host = "evelinka99.atthost24.pl";
	$db_user = "5795";
    $db_password = 'Hy44#AB@xqQWg';
	$_SESSION['db_name'] = "5795_".$school_code."school";
	
	if ((!isset($_POST['login'])) || (!isset($_POST['password'])))
	{
		header('Location: ../index.php');
		exit();
	}

	$connect = mysqli_connect($host, $db_user, $db_password, $_SESSION['db_name']);
    if(!$connect){
      $_SESSION['newlogin'] = 1;
      header('Location: ../index.php?data=login');
    }
   
	$connect->query("SET NAMES 'utf8'");

	if ($connect->connect_errno!=0)
	{
		$_SESSION['newlogin'] = 1;
		header('Location: ../index.php?data=login');
	}
	else
	{
		$password = md5($_POST['password']);
		$whois = $_POST['whois'];
		$_SESSION['whois'] = $whois;
		
		if($whois == "student"){
			$db_table = "users";
		}
		else{
			$db_table = "teachers";
		}
		$login = htmlentities($login, ENT_QUOTES, "UTF-8");
		$password = htmlentities($password, ENT_QUOTES, "UTF-8");
		if ($result = @$connect->query(
		sprintf("SELECT * FROM $db_table WHERE login='%s' AND password='%s'",
		mysqli_real_escape_string($connect,$login),
		mysqli_real_escape_string($connect,$password))))
		{
			$sql_settings = "SELECT * FROM `settings` WHERE `school_code` = '$school_code'";
			$result_settings = $connect->query($sql_settings);	

			if ($result_settings->num_rows > 0) {
				 // output data of each row
				while($row_settings = $result_settings->fetch_assoc()) {
					$_SESSION['mark_settings'] = $row_settings['marks_type'];
				}
			}
			$ilu_userow = $result->num_rows;
			if($ilu_userow>0)
			{
				$_SESSION['zalogowany'] = true;
				if($whois != "student"){
					$_SESSION['teacher'] = true;
				}
				
				$row = $result->fetch_assoc();
				$_SESSION['id'] = $row['id'];				// id
				$_SESSION['login'] = $row['login'];			// login
				$_SESSION['password'] = $row['password'];	// password
				$_SESSION['name'] = $row['name'];			// name
				$_SESSION['surname'] = $row['surname'];		// surname
				//$_SESSION['school'] = $row['school_name'];// school name
				$_SESSION['lastlog'] = $row['lastlogin'];	// user lastlogin
				$_SESSION['class'] = $row['class'];			// user class
				$_SESSION['rank'] = $row['rank'];			// user rank
				$_SESSION['sex'] = $row['sex'];			    // user sex
				$_SESSION['group'] = $row['class_group'];   // user group

				
				$currentDate = date("d.m.Y : h:i");
				$logintime = "UPDATE $db_table SET `lastlogin` = '$currentDate' where login = '$login'";
				mysqli_query($connect, $logintime);
				
				$result->free_result();
				$_SESSION['newlogin'] = 0;
				header('Location: ../szkola.php');
			}else {
				$_SESSION['newlogin'] = 1;
				header('Location: ../index.php?data=login');
			}
		}else {
			$_SESSION['newlogin'] = 1;
			header('Location: ../index.php?data=login');
		}
		
		$connect->close();
	}
	
?>