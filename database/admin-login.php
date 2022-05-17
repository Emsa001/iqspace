<?php
	session_start();


	$host = "";
	$db_user = "";
	$db_password = "";
	$db_name = "";
	
	if ((!isset($_POST['login'])) || (!isset($_POST['password'])))
	{
		header('Location: ../admin.php?log=failed');
		exit();
	}

	$connect = @new mysqli($host, $db_user, $db_password, $db_name);
	$connect->query("SET NAMES 'utf8'");
	
	if ($connect->connect_errno!=0)
	{
		//header('Location: ../index.php');
        echo"blad";
	}
	else
	{
        $login = $_POST['login'];
		$password = md5(md5($_POST['password'])."b3701j21".md5($_POST['password'])."01ehnc90783gt08dg".md5("pass"));
        echo $password;
		if ($result = @$connect->query(
		sprintf("SELECT * FROM users WHERE login='%s' AND password='%s'",
		mysqli_real_escape_string($connect,$login),
		mysqli_real_escape_string($connect,$password))))
		{
			$ilu_userow = $result->num_rows;
			if($ilu_userow>0)
			{
				$_SESSION['admin_logged'] = true;
				
				$row = $result->fetch_assoc();
				$_SESSION['id'] = $row['id'];				// id
				$_SESSION['login'] = $row['login'];			// login
				$_SESSION['password'] = $row['password'];	// password
				$_SESSION['name'] = $row['name'];			// name
				$_SESSION['surname'] = $row['surname'];		// surname
				$_SESSION['lastlog'] = $row['lastlogin'];	// user lastlogin

				
				$currentDate = date("d.m.Y : h:i");
				$logintime = "UPDATE `users` SET `lastlogin` = '$currentDate' WHERE 1";
				mysqli_query($connect, $logintime);
                
				
				$result->free_result();
				header('Location: ../index.php');
			}else {
				header('Location: ../admin.php?log=failed');
			}
		}else {
			header('Location: ../admin.php?log=failed');
		}
		
		$connect->close();
	}
	
?>
