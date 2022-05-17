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

	$user_login = $_SESSION['login'];
    $mark_settings = $_SESSION['mark_settings'];
       
	$classes = '';
	$sql_lessons = "SELECT class_teaching FROM `lessons` WHERE `login` = '$user_login'";
	$result = $connect->query($sql_lessons);
    $classteaching = array();
	if ($result->num_rows > 0) {
       $i = 0;
	  while($row = $result->fetch_assoc()) {
         $classes = $classes.''.$row['class_teaching'];
	  }
	}	

?>

<div class="container-fluid marks-content animate-bottom">
	<h2 style="margin-bottom:50px;">Oceny uczniów:</h2>
	<table class="table table-dark">
		<thead>
			<tr>
				<th scope="col">Uczeń</th>
				<th scope="col">klasa</th>
				<th scope="col">Oceny</th>
				<th scope="col">Średnia (niedostępne)</th>
				<th scope="col">Akcje</th>
			</tr>
		</thead>
		<tbody>
<?php    
	$sql = "SELECT * FROM `users` WHERE `class` IN ($classes) ORDER by `class`";

	$result_2 = $connect->query($sql);
	if ($result_2->num_rows > 0) {
		$i =0;
		// output data of each row
		while($row = $result_2->fetch_assoc()) {
			$i++;
			$user = $row['name']." ".$row['surname'];
			$class = $row['class'];
			$login = $row['login'];
			$sql_less = "SELECT * FROM lessons";
			$result_less = $connect->query($sql_less);
			
echo<<<END
	<tr class="class$class">
      <td>$user</td>
      <td>$class</td>
      <td><a href="./content/panel/teachers/showmarks.php?login=$login&class=$class&user=$user"><button type="button" class="btn btn-secondary">Zobacz oceny</button></a></td>
      <td>-</td>
      <td><button type="button" class="btn btn-primary" data-toggle="modal" data-target=".add_mark$i">Dodaj nową ocenę</button></td>
	</tr>
END;
		}
	}
			
?>
		</tbody>
	</table>
<?php

	$result = $connect->query($sql);
	if ($result->num_rows > 0) {
		$i =0;
		// output data of each row
		while($row = $result->fetch_assoc()) {
		$i++;
		$user_name = $row['name']." ".$row['surname'];
		$loginn = $row['login'];
	
echo<<<END
<form action='./database/addmark.php' method='post'>
	<div class="modal fade bd-example-modal-lg add_mark$i" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">	
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Dodaj nową ocenę dla <b>$user_name</b></h5>
			<input type="text" value="$loginn" name="mark_user" style="display:none">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<div class="container-fluid">
				<label for="exampleFormControlSelect1" style="margin-top:20px">Przedmiot</label>
					<select class="form-control" name="mark_lesson">
END;
	$sql_lessons_teachers = "SELECT * FROM `lessons` WHERE `login` = '$user_login'";
	$result_lessons_teachers = $connect->query($sql_lessons_teachers);

	if ($result_lessons_teachers->num_rows > 0) {
		while($row = $result_lessons_teachers->fetch_assoc()) {
			$lesson = $row['lesson'];
			echo "<option>$lesson</option>";
		}
	} else {
		echo "<option>Nie masz przypisanych żadnych przedmiotów</option>";
	}
echo <<<END
					</select>
				<div class="row" style="margin-top:20px">
END;
if($mark_settings == "punkty"){
echo <<<END
					<div class="col-sm-6">
						<label for="exampleFormControlSelect1">Zdobyte punkty</label>
						<input type="text" class="form-control" name="mark_get_points" required onkeypress='validate(event)'>
					</div>
					<div class="col-sm-6">
						<label for="exampleFormControlSelect1">Max punkty</label>
						<input type="text" class="form-control" name="mark_max" required onkeypress='validate(event)'>
					</div>
END;
}else{
echo <<<END
					<div class="col-sm-4">
						<label for="exampleFormControlSelect1">Ocena</label>
						<input type="text" class="form-control" name="mark" required onkeypress='validate(event)'>
					</div>
					<div class="col-sm-4">
						<label for="exampleFormControlSelect1">Zdobyte punkty</label>
						<input type="text" class="form-control" name="mark_get_points" required onkeypress='validate(event)'>
					</div>
					<div class="col-sm-4">
						<label for="exampleFormControlSelect1">Max punkty</label>
						<input type="text" class="form-control" name="mark_max" required onkeypress='validate(event)'>
					</div>
END;
}
echo<<<END
				</div>
				<div class="row" style="margin-top:20px;">
					<div class="col-sm">
						<label for="exampleFormControlSelect1">Typ ocecny</label>
						<select class="form-control" name="mark_type">
							<option>Kartkówka</option>
							<option>Sprawdzian</option>
                            <option>Wypracowanie</option>
							<option>Test</option>
							<option>Wypracowanie</option>
							<option>Odpowiedź ustna</option>
							<option>Praca domowa</option>
							<option>Praca Klasowa</option>
							<option>Praca na lekcji</option>
							<option>Zachowanie</option>
							<option>Inna</option>
						</select>
					</div>
					<div class="col-sm">
						<label for="exampleFormControlSelect2">Waga <small>(Opcjonalne)</small></label>
						<select class="form-control" name="mark_waga">
							<option>1</option>
							<option>2</option>
							<option>3</option>
							<option>4</option>
							<option>5</option>
							<option>6</option>
							<option>7</option>
							<option>8</option>
							<option>9</option>
							<option>10</option>
						</select>
					</div>
				</div>
				<div class="row" style="margin-top:20px;">
					<div class="col-sm">
						<label for="exampleFormControlTextarea1">Komentarz</label>
						<textarea class="form-control" aria-label="With textarea" name="mark_content" style="min-height:100px !important;" /></textarea>
					</div>
				</div>
			</div>
		  	<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
				<button type="submit" class="btn btn-success">Dodaj ocenę</button>
		  	</div>
		</div>
	  </div>
	</div>
  </div>
</form>
		
END;
	}
}
		
?>
</div>


<script>

	$(document).ready(function() {
		$('[data-toggle="popover"]').popover();
	});

</script>

