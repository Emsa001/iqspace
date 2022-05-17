<?php
	session_start();

	error_reporting(0);
	ini_set('display_errors', 0);

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
	$sql_monday = "SELECT * FROM `lesson_plan` WHERE `day` = 'Poniedziałek' AND `teacher` = '$user_name'";
	$sql_tuseday = "SELECT * FROM `lesson_plan` WHERE `day` = 'Wtorek' AND `teacher` = '$user_name'";
	$sql_wednesday = "SELECT * FROM `lesson_plan` WHERE `day` = 'Środa' AND `teacher` = '$user_name'";
	$sql_thursday = "SELECT * FROM `lesson_plan` WHERE `day` = 'Czwartek' AND `teacher` = '$user_name'";
	$sql_friday = "SELECT * FROM `lesson_plan` WHERE `day` = 'Piątek' AND `teacher` = '$user_name'";

	$result_monday = $connect->query($sql_monday);
	$result_tuseday = $connect->query($sql_tuseday);
	$result_wednesday = $connect->query($sql_wednesday);
	$result_thursday = $connect->query($sql_thursday);
	$result_friday = $connect->query($sql_friday);
	
	$sql_classes = "SELECT class FROM `classes`";
	$result_class = $connect->query($sql_classes);

echo '<div class="container-fluid animate-bottom"><h4>Plan Lekcji</h4><hr><div class="row">';
if($_SESSION['rank'] == "head_teacher"){
echo<<<END


<button type="button" class="btn btn-success" data-toggle="modal" data-target="#add_plan" style="margin-bottom:50px;">Dodaj plan lekcji</button>

<!-- Modal -->
<div class="modal fade bd-example-modal-xl" id="add_plan" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl" role="document"> 
    <div class="modal-content">
	 <form action="./database/addplan.php" method="POST">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Dodaj plan lekcji</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
			<div class="row">
				<div class="col-9">
					<label>Dzień:</label>
					<select class="form-control" name="day">
						<option>Poniedziałek</option>
						<option>Wtorek</option>
						<option>Środa</option>
						<option>Czwartek</option>
						<option>Piątek</option>
					</select>
				</div>
				<div class="col-3">
					<label>Klasa:</label>
					<input type="text" class="form-control" name="class">
				</div>
			</div>
END;
	for($i = 1; $i <= 10; $i++){
echo<<<END
			<div class="row" style="margin-top:20px;">
				<div class="col-3">
					<hr>
					<label>Czas:</label>
					<input type="text" class="form-control" placeholder="9:20 - 10:05" name="time$i">
				</div>
				<div class="col-4">
					<hr>
					<label>Nauczyciel:</label>
					<input type="text" class="form-control" name="teacher$i">
				</div>
				<div class="col-5">
					<hr>
					<label>Lekcja $i:</label>
					<input type="text" class="form-control" name="lesson$i">
				</div>
			</div>
END;
	}
echo<<<END
	</div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
        <button type="submit" class="btn btn-primary">Dodaj plan</button>
      </div>
	 </form>
    </div>
  </div>
</div>

<form action="./content/panel/teachers/show_class_plan.php" method="GET" class="form-inline" style="margin-bottom:40px;">
  <div class="form-group mx-sm-3 mb-2">
    <select class="form-control" name="class">
END;
	
	if ($result_class->num_rows > 0) {
    // output data of each row
    while($row_class = $result_class->fetch_assoc()) {
        echo "<option>".$row_class['class']."</option>";
    }
	} else {
		echo "<option>Brak klas</option>";
	}
	
echo<<<END
    </select>
  </div>
  <button type="submit" class="btn btn-primary mb-2">Pokaż plan klasy</button>
</form>

END;
}
if ($result_monday->num_rows > 0) {
echo <<<END
	<div class="col-12" style="width: 18rem">
	<h4>Poniedziałek</h4>
		<table class="table table-hover">
		  <thead>
			<tr>
			  <th style="background-color:#c4c4c4;width:300px;">Godzina</th>
			  <th style="background-color:#c4c4c4">Lekcja</th>
			  <th style="background-color:#c4c4c4;width:600px;">Klasa</th>
			</tr>
		  </thead>
		  <tbody>
END;
		// output data of each row
		while($row = $result_monday->fetch_assoc()) {	
			//day
			$lesson = $row['lesson'];
			$class = $row['class'];
			$time = $row['time'];
			
echo <<<END
		  
			<tr>
			  <th>$time</th>
			  <td>$lesson</td>
			  <td>$class</td>
			</tr>
END;
		}
echo <<<END
	
		</tbody>
	</table>
</div>
	
END;
}
else{
echo<<<END

<div class="card col-12">
  <div class="card-body">
    <blockquote class="blockquote mb-0">
      <p align="center">Brak planu <br />Ten poniedziałek nie będzie taki zły</p>
    </blockquote>
  </div>
</div>

END;
	}
if ($result_tuseday->num_rows > 0) {
echo <<<END
	<div class="col-12" style="width: 18rem;margin-top:20px">
	<h4>Wtorek</h4>
		<table class="table table-hover">
		  <thead>
			<tr>
			  <th style="background-color:#c4c4c4;width:300px;">Godzina</th>
			  <th style="background-color:#c4c4c4">Lekcja</th>
			  <th style="background-color:#c4c4c4;width:600px;">Klasa</th>
			</tr>
		  </thead>
		  <tbody>
END;
		// output data of each row
		while($row = $result_tuseday->fetch_assoc()) {	
			//day
			$lesson = $row['lesson'];
			$class = $row['class'];
			$time = $row['time'];
			
echo <<<END
		  
			<tr>
			  <th>$time</th>
			  <td>$lesson</td>
			  <td>$class</td>
			</tr>
END;
		}
echo <<<END
	
		</tbody>
	</table>
</div>
	
END;
}
else{
echo<<<END

<div class="card col-12">
  <div class="card-body">
    <blockquote class="blockquote mb-0">
      <p align="center">Brak planu <br /> Wtorek czysty</p>
    </blockquote>
  </div>
</div>

END;
}
if ($result_wednesday->num_rows > 0) {
echo <<<END
	<div class="col-12" style="width: 18rem;margin-top:100px;">
	<h4>Środa</h4>
		<table class="table table-hover">
		  <thead>
			<tr>
			  <th style="background-color:#c4c4c4;width:300px;">Godzina</th>
			  <th style="background-color:#c4c4c4">Lekcja</th>
			  <th style="background-color:#c4c4c4;width:600px;">Klasa</th>
			</tr>
		  </thead>
		  <tbody>
END;
		// output data of each row
		while($row = $result_wednesday->fetch_assoc()) {	
			//day
			$lesson = $row['lesson'];
			$class = $row['class'];
			$time = $row['time'];
			
echo <<<END
		  
			<tr>
			  <th>$time</th>
			  <td>$lesson</td>
			  <td>$class</td>
			</tr>
END;
		}
echo <<<END
	
		</tbody>
	</table>
</div>
	
END;
}
else{
echo<<<END

<div class="card col-12">
  <div class="card-body">
    <blockquote class="blockquote mb-0">
      <p align="center">Brak planu <br /> W środę można spać</p>
    </blockquote>
  </div>
</div>

END;
}
if ($result_thursday->num_rows > 0) {
echo <<<END
	<div class="col-12" style="width: 18rem;margin-top:100px;">
	<h4>Czwartek</h4>
		<table class="table table-hover">
		  <thead>
			<tr>
			  <th style="background-color:#c4c4c4;width:300px;">Godzina</th>
			  <th style="background-color:#c4c4c4">Lekcja</th>
			  <th style="background-color:#c4c4c4;width:600px;">Klasa</th>
			</tr>
		  </thead>
		  <tbody>
END;
		// output data of each row
		while($row = $result_thursday->fetch_assoc()) {	
			//day
			$lesson = $row['lesson'];
			$class = $row['class'];
			$time = $row['time'];
			
echo <<<END
		  
			<tr>
			  <th>$time</th>
			  <td>$lesson</td>
			  <td>$class</td>
			</tr>
END;
		}
echo <<<END
	
		</tbody>
	</table>
</div>
	
END;
}
else{
echo<<<END

<div class="card col-12">
  <div class="card-body">
    <blockquote class="blockquote mb-0">
      <p align="center">Brak planu <br /> Czwartek pusty</p>
    </blockquote>
  </div>
</div>

END;
}
if ($result_friday->num_rows > 0) {
echo <<<END
	<div class="col-12" style="width: 18rem;margin-top:100px;">
	<h4>Piątek</h4>
		<table class="table table-hover">
		  <thead>
			<tr>
			  <th style="background-color:#c4c4c4;width:300px;">Godzina</th>
			  <th style="background-color:#c4c4c4">Lekcja</th>
			  <th style="background-color:#c4c4c4;width:600px;">Klasa</th>
			</tr>
		  </thead>
		  <tbody>
END;
		// output data of each row
		while($row = $result_friday->fetch_assoc()) {	
			//day
			$lesson = $row['lesson'];
			$class = $row['class'];
			$time = $row['time'];
			
echo <<<END
		  
			<tr>
			  <th>$time</th>
			  <td>$lesson</td>
			  <td>$class</td>
			</tr>
END;
		}
echo <<<END
	
		</tbody>
	</table>
</div>
	
END;
}
else{
echo<<<END

<div class="card col-12">
  <div class="card-body">
    <blockquote class="blockquote mb-0">
      <p align="center">Brak planu <br /> Piątek wolny - Weekend będzie dłuższy</p>
    </blockquote>
  </div>
</div>

END;
}
echo'</div</div>';
?>