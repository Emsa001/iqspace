<?php
	session_start();
	if (!isset($_SESSION['teacher']))
	{
		header('Location: ../../../index.php');
		exit();
	}
	require_once "../../../database/connect.php";

	// Create connection
	$connect = new mysqli($host, $db_user, $db_password, $db_name);
	mysqli_query($connect, "SET CHARSET utf8");
	mysqli_query($connect, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");
	// Check connection
	if ($connect->connect_error) {
		die("Connection failed: " . $connect->connect_error);
	}
	
	$user_login = $_SESSION['login'];

	$sql = "SELECT * FROM users ORDER by `class`";
	$result = $connect->query($sql);

	if ($result->num_rows > 0) {
echo<<<END

<table class="table animate-bottom">
  <thead>
    <tr>
      <th scope="col">Imię i nazwisko</th>
      <th scope="col">Klasa</th>
      <th scope="col">Ostatnie logowanie</th>
    </tr>
  </thead>
  <tbody>

END;
		while($row = $result->fetch_assoc()) {
			$user_name = $row['name'];
			$user_surname = $row['surname'];
			$user_class = $row['class'];
			$user_lastlogin = $row['lastlogin'];
			
			if($user_lastlogin == ""){
				$user_lastlogin = "Brak logowań";
			}
			
echo<<<END
		
	<tr class="class$user_class">
      <td>$user_name $user_surname</td>
      <td>$user_class</td>
      <td>$user_lastlogin</td>
    </tr>
		
END;
		}
echo<<<END

  </tbody>
</table>

END;
	} else {
		echo "0 results";
	}
	$connect->close();
?> 