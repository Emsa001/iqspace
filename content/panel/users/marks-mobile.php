<?php
	session_start();
    if (!isset($_SESSION['zalogowany']))
	{
		header('Location: ../../../index.php');
		exit();
	}
	require_once "../../../database/connect.php";
	
	// Create connection
	$connect = new mysqli($host, $db_user, $db_password, $db_name);
	mysqli_query($connect, "SET CHARSET utf8");
	mysqli_query($connect, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");

	
	$user_login = $_SESSION['login'];
	$user_class = $_SESSION['class'];
?>

<div class="container-fluid marks-content">
<h2 >Moje oceny:</h2>
<table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col">Przedmiot</th>
      <th scope="col" style="width:80%;">Oceny</th>
    </tr>
  </thead>
  <tbody>	
<?php
	  
//Lekcja
	  
	$user_name = $_SESSION['login'];
	$user_class = $_SESSION['class'];

	// write lessons
	$sql_lessons = "SELECT * FROM `lessons` WHERE `$user_class` = '1' ORDER BY lesson;";
	$result = $connect->query($sql_lessons);

	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {
			$lesson = $row['lesson'];
echo '<tr><td>'.$lesson.'</td>';
//Ocena
echo'<td>';
			
	$sql_marks = "SELECT * FROM `marks` WHERE `user` = '$user_name' AND `lesson` = '$lesson' ";
	$result_marks = $connect->query($sql_marks);

	if ($result_marks->num_rows > 0) {
		while($row_marks = $result_marks->fetch_assoc()) {
			$mark = $row_marks['mark'];
			echo '<div class="mark border border-success bg-success text-white"><span>'.$mark.'</span></div>';
			
		}
	}
		
echo'</td>';
echo'</tr>';
		}
	}
 
	
	$connect->close();
?>
  </tbody>
</table>
</div>