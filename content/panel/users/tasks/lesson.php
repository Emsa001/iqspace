<?php
	$what_lesson = $_GET['data'];
	session_start();


	require_once "../../../../database/connect.php";
	// Create connection
	$connect = new mysqli($host, $db_user, $db_password, $db_name);
	mysqli_query($connect, "SET CHARSET utf8");
	mysqli_query($connect, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");

	
	$user_name = $_SESSION['login'];
	$user_class = $_SESSION['class'];

	if($what_lesson == "Edukacjadlabezpieczenstwa"){
		$lesson_name = "Edukacja dla bezpieczeństwa";
	} else if($what_lesson == "JezykAngielski"){
		$lesson_name = "Język Angielski";
	} else if($what_lesson == "JezykFrancuski"){
		$lesson_name = "Język Francuski";
	} else if($what_lesson == "JezykHiszpanski"){
		$lesson_name = "Język Hiszpański";
	} else if($what_lesson == "JezykNiemiecki"){
		$lesson_name = "Język Niemiecki";
	} else if($what_lesson == "JezykPolski"){
		$lesson_name = "Język Polski";
	} else if($what_lesson == "JezykRosyjski"){
		$lesson_name = "Język Rosyjski";
	} else if($what_lesson == "JezykLacinski"){
		$lesson_name = "Język Łaciński";
	} else if($what_lesson == "JezykWloski"){
		$lesson_name = "Język Włoski";
	} else if($what_lesson == "LekcjaCzytania"){
		$lesson_name = "Lekcja Czytania";
	} else if($what_lesson == "LekcjaPisania"){
		$lesson_name = "Lekcja Pisania";
	} else if($what_lesson == "Podstawyprzedsiepiorczosci"){
		$lesson_name = "Podstawy przedsiębiorczości";
	} else if($what_lesson == "Wiedzaospoleczenstwie"){
		$lesson_name = "Wiedza o społeczeństwie";
	} else if($what_lesson == "Wychowaniefizyczne"){
		$lesson_name = "Wychowanie fizyczne";
	}else{
		$lesson_name = $what_lesson;
	}
	// Check connection
	$sql_tasks = "SELECT * FROM `tasks` WHERE `lesson` = '$lesson_name' AND `class` = '$user_class' ORDER BY `id` DESC ";
	$sql_tasks_teachers = "SELECT * FROM `tasks` WHERE `lesson` = '$lesson_name' ORDER BY `id` DESC";
	$result = $connect->query($sql_tasks);
	$result_teachers = $connect->query($sql_tasks_teachers);

echo "<div id='task-content' class='container animate-bottom'><div class='row'><h4>$lesson_name - zadania domowe</h4><hr style='width:100%;'>";
if($_SESSION['rank'] == "student"){	
	if ($result->num_rows > 0) {
		// output data of each row
		$i = 0;
		while($row = $result->fetch_assoc()) {	
			$title = $row['title'];
			$content = $row['content'];
			$lesson = $row['lesson'];
			$teacher = $row['teacher'];
			$date = $row['date'];
			$i++;
echo <<<END
	<div class="col-sm" style="margin-bottom:50px;"">
		<div class="card" style="width: 18rem;">
			<div class="card-body">
				<h5 class="card-title">$title<h5>
				<hr>
				<p class="card-text task-content" style="font-size:13px;">$content</p>
				<hr>	
				<p style="margin-left:auto;margin-top:10px;float:right;font-size:13px;">$date</p>
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#task$i">Zobacz zadanie</button>
			</div>
		</div>
	</div>
	
	<!-- Modal -->
	<div class="modal fade" id="task$i" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">$title</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			$content
		  </div>
		  <div class="modal-footer">
		  	<p style="margin-right:auto;font-size:13px;">$date</p>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
		  </div>
		</div>
	  </div>
	</div>
	
END;
		}
	}
	else {
		
	$empty = array("Chyba masz farta", "Masz wolne", "Obyś się nie nudził", "Znowu bez pracy domowej ?", "Chyba muszę przypomnieć nauczycielą o tej zakładce");
	
	$random = $empty[array_rand($empty)];
		
echo <<<END

<div class="card col-12">
  <div class="card-body">
    <blockquote class="blockquote mb-0">
      <p align="center">Moja baza danych jest pusta <i class="far fa-frown"></i><br /> $random </p>
    </blockquote>
  </div>
</div>

END;
	}
}
else{
	if ($result_teachers->num_rows > 0) {
		// output data of each row
		$i = 0;
		while($row = $result_teachers->fetch_assoc()) {	
			$id = $row['id'];
			$title = $row['title'];
			$content = $row['content'];
			$lesson = $row['lesson'];
			$teacher = $row['teacher'];
			$date = $row['date'];
			$i++;
echo <<<END
	<div class="col-4" style="margin-bottom:50px;"">
		<div class="card" style="width: 18rem;">
			<div class="card-body">
				<h5 class="card-title">$title<h5>
				<hr>
				<p class="card-text task-content" style="font-size:13px;">$content</p>
				<hr>	
				<button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#task$i">Zobacz</button>
				<button type="button" class="btn btn-sm btn-outline-secondary" data-toggle="modal" data-target="#task_edit$i">Edytuj</button>
				<p style="margin-left:auto;margin-top:10px;float:right;font-size:13px;">$date</p>
			</div>
		</div>
	</div>
	
	<!-- Modal -->
	<div class="modal fade" id="task$i" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">$title</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			$content
		  </div>
		  <div class="modal-footer">
		  	<p style="margin-right:auto;font-size:13px;">$date</p>
			<button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
		  </div>
		</div>
	  </div>
	</div>
	
	<!--TASK EDIT-->
	<div id="task_edit$i" class="modal fade bd-example-modal-lg" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">
	  <div class="modal-dialog modal-lg" role="document">
		<div class="modal-content">
		<form action="./database/savetask.php" method="POST" id="savetask$i">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">EDYCJA</h5>
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
			<input type="text" name="task_id" value="$id" style="display:none;">
		  </div>
		  <div class="modal-body">
			<label for="exampleFormControlSelect1">Wybierz klasę</label>
			<select class="form-control" name="task_class$id">
END;
	$sql_classes = "SELECT class FROM `classes`";
	$result_classes = $connect->query($sql_classes);

	if ($result_classes->num_rows > 0) {
		// output data of each row
		while($row = $result_classes->fetch_assoc()) {
			$class = $row['class'];
			echo "<option id='$class'>$class</option>";
		}
	} else {
		echo "<option>Brak klas w bazie danych</option>";
	}
echo <<<END
			</select>
			<label for="message-text" class="col-form-label">Tytuł zadania:</label>
			<input type="text" class="form-control" name="task_title$id" maxlength="100" placeholder="max 100 znaków" value="$title">
			<label for="message-text" class="col-form-label">Treść zadania:</label>
			<textarea class="form-control" aria-label="With textarea" name="task_content$id" style="height:200px !important;">$content</textarea>
		  </div>
		</form>
		<form id="deltaskform" action="./database/removetask.php" method="POST">
		<input type="text" name="task_id" value="$id" style="display:none;">
		  <div class="modal-footer">
			<input type="text" name="remove_task_id" value="$id" style="display:none;">
			<button type="button" class="btn btn-danger" id="btn-submit" onclick="deltask()">Usuń zadnaie</button>
			<script>
				function deltask(){
					Swal.fire({
					  title: 'Czy jesteś pewny?',
					  text: "Tego nie będzie można cofnąć",
					  icon: 'warning',
					  showCancelButton: true,
					  confirmButtonColor: '#d33',
					  cancelButtonColor: '#3085d6',
					  cancelButtonText: 'Cofnij',
					  confirmButtonText: 'Tak, usuń to zadanie!'
					}).then((result) => {
					  if (result.value) {
						Swal.fire(
						  'Usunięto!',
						  'Zadanie zostało usunięte',
						  'success',
						  submitform()
						)
					  }
					})
				}
				function submitform(){
					setTimeout(function(){document.getElementById("deltaskform").submit();}, 1000);
				}
			</script>
			<button type="submit" class="btn btn-primary" data-dismiss="modal" onclick="savetask$i()">Zapisz</button>
			<script>
				function savetask$i(){
					document.getElementById("savetask$i").submit();
				}
			</script>
		  </div>
		</form>
		</div>
	  </div>
	</div>
	
END;
		}
	}
	else {
		
	$empty = array("Nie dodałeś żadnej pracy domowej", "Dodaj coś bo uczniom się już nudzi", "Narzekają, bo nic nie mają", "Znowu im odpuścisz?", "Przypomnij sobię jak ciebie denerwowali na poprzedniej lekcji");
	
	$random = $empty[array_rand($empty)];
		
echo <<<END

<div class="card col-12">
  <div class="card-body">
    <blockquote class="blockquote mb-0">
      <p align="center">Moja baza danych jest pusta <i class="far fa-frown"></i><br /> $random </p>
    </blockquote>
  </div>
</div>

END;
	}
}

echo '<hr style="width:100%;"></div></div></div>';

	$connect->close();
?>