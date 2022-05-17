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

	
	$user_name = $_SESSION['login'];
	$user_class = $_SESSION['class'];
	$user_sex = $_SESSION['sex'];
    $lesson1 = "'x'";
	$sql_lessons = "SELECT * FROM `lessons` WHERE `sex_teach` = '$user_sex' OR `sex_teach` = '2' AND `class_teaching` LIKE '%$user_class%'";
	$result = $connect->query($sql_lessons);
    $classteaching = array();
	if ($result->num_rows > 0) {
	  while($row = $result->fetch_assoc()) {
         $lesson1 = $lesson1." ,'".$row['lesson']."'";
	  }
	}	

	$sql_lessons = "SELECT * FROM `lessons` WHERE `lesson` IN ($lesson1) ORDER BY lesson";
	$result = $connect->query($sql_lessons);

echo '<script type="text/javascript" src="./content/panel/users/var.js"></script>';
echo '<div id="task-content" class="container animate-bottom"><div class="row"><hr style="width:100%;">';
	if ($result->num_rows > 0) {
		// output data of each row
		while($row = $result->fetch_assoc()) {	
           if(strpos($row['class_teaching'], $user_class)){
			$lesson = $row['lesson'];
			$teacher = $row['teacher'];
			$lesson_function = $lesson;
				if(strpos($lesson, 'ą') !== false){
					$lesson_function = str_replace("ą", "a", $lesson_function);
				}			
				if(strpos($lesson, 'ę') !== false){
					$lesson_function = str_replace("ę", "e", $lesson_function);
				}			
				if(strpos($lesson, 'ó') !== false){
					$lesson_function = str_replace("ó", "o", $lesson_function);
				}			
				if(strpos($lesson, 'ś') !== false){
					$lesson_function = str_replace("ś", "s", $lesson_function);
				}			
				if(strpos($lesson, 'ł') !== false){
					$lesson_function = str_replace("ł", "l", $lesson_function);
				}			
				if(strpos($lesson, 'ź') !== false){
					$lesson_function = str_replace("ź", "z", $lesson_function);
				}			
				if(strpos($lesson, 'ż') !== false){
					$lesson_function = str_replace("ż", "z", $lesson_function);
				}			
				if(strpos($lesson, 'ń') !== false){
					$lesson_function = str_replace("ń", "n", $lesson_function);
				}			
				if(strpos($lesson, 'ł') !== false){
					$lesson_function = str_replace("ł", "l", $lesson_function);
				}			
				if(strpos($lesson, ' ') !== false){
					$lesson_function = str_replace(" ", "", $lesson_function);
				}
			
				$sql_tasks = "SELECT * FROM `tasks` WHERE `class` = '$user_class' AND `lesson` = '$lesson'";
				$result_tasks = $connect->query($sql_tasks);
				$rowcount_tasks=mysqli_num_rows($result_tasks);
			
echo <<<END
	<div class="col-sm task" style="margin-bottom:50px;"">
		<div class="card" style="width: 18rem;">
			<div class="card-body">
				<h5 class="card-title">$lesson<h5>
				<hr>
				<p class="card-text" style="font-size:13px;">Nauczyciel: $teacher</p>
				<hr>		
				<button type="button" class="btn btn-sm btn-outline-secondary" onclick='$lesson_function()'>Zobacz</button>
				<p style="font-size:12px;float:right;margin-top:10px;font-weight:normal">Liczba zadań:<b> $rowcount_tasks</b></p>
			</div>
		</div>
	</div>
END;
			
echo <<<END
	<script>
		function $lesson_function(){
			$("#task-content").load('./content/panel/users/tasks/lesson.php?data=$lesson_function');	
		}
	
	</script>
END;
		}
    }
		}
		
	else {
		echo "Brak przedmiotów";
	}
echo '<hr style="width:100%;"></div></div></div>';

	$connect->close();
?>

<script>
$(document).ready(function(){
  $('[data-toggle="popover"]').popover();   
});
</script>