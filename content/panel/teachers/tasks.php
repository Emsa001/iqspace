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

	
	$user_name = $_SESSION['name']." ".$_SESSION['surname'];
	$user_login = $_SESSION['login'];
	$user_class = $_SESSION['class'];
	// Check connection
	$sql_lessons = "SELECT * FROM `lessons` WHERE `login` = '$user_login'";
	$result = $connect->query($sql_lessons);
echo '<script type="text/javascript" src="./content/panel/users/var.js"></script>';
echo '<div id="task-content" class="container animate-bottom"><div class="row"><hr style="width:100%;">';
	if ($result->num_rows > 0) {
		// output data of each row
		$i = 0;
		while($row = $result->fetch_assoc()) {	
			$lesson = $row['lesson'];
			$lesson_function = $lesson;
           $i++;
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
echo <<<END
	<div class="col-4 task" style="margin-bottom:50px;"">
		<div class="card" style="width: 18rem;">
			<div class="card-body">
				<h5 class="card-title">$lesson<h5>
				<hr>		
				<button type="button" class="btn btn-sm btn-outline-secondary" onclick='$lesson_function()'>Zobacz</button>
				<button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target=".add_task$i">Wstaw nowe</button>
			</div>
		</div>
	</div>

	<div class="modal fade bd-example-modal-lg add_task$i" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg">
	  <form action="./database/addtask.php" method="POST">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Wstaw nowe zadanie z <b>$lesson</b></h5>
			<input type="text" class="form-control" name="task_lesson" value="$lesson" style="display:none;">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<form>
			  <div class="form-group">
				<label for="exampleFormControlInput1">Temat zadania</label>
				<input id="" type="text" class="form-control" name="task_title">
			  </div>
			  <div class="form-group">
				<label for="exampleFormControlSelect1">Wybierz klasę</label>
			<select class="form-control" name="task_class">
END;
	$sql_lessons = "SELECT class_teaching FROM `lessons` WHERE `login` = '$user_login'";
	$result_classes = $connect->query($sql_lessons);
	if ($result_classes->num_rows > 0) {
		while($row = $result_classes->fetch_assoc()) {
			$class = str_replace("'","",$row['class_teaching']);
            $pieces = explode(",", $class);
            for($x = 0; $x < count($pieces); $x++){
               echo "<option id='$pieces[$x]'>$pieces[$x]</option>";  
            }
        }
	} else {
		echo "<option>Brak klas w bazie danych</option>";
	}
echo <<<END
			</select>
			  </div>
			  <div class="form-group">
				<label for="exampleFormControlTextarea1">Treść zadania</label>
				<textarea class="form-control" aria-label="With textarea" name="task_content" style="height:200px !important;"></textarea>
			  </div>
			</form>
		  </div>
		  <div class="modal-footer">
			<button type="submit" class="btn btn-success">Wstaw</button>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
		  </div>
		</div>
		</form>
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