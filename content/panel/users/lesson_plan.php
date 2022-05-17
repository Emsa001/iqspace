<?php
	session_start();

    if (!isset($_SESSION['zalogowany']))
	{
		header('Location: ../../../index.php');
		exit();
	}

	error_reporting(0);
	ini_set('display_errors', 0);

	require_once "../../../database/connect.php";
	// Create connection
	$connect = new mysqli($host, $db_user, $db_password, $db_name);
	mysqli_query($connect, "SET CHARSET utf8");
	mysqli_query($connect, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");

	$user_name = $_SESSION['login'];
	$user_class = $_SESSION['class'];

	// Check connection
	$sql_monday = "SELECT * FROM `lesson_plan` WHERE `class` = '$user_class' AND `day` = 'Poniedziałek'";
	$sql_tuseday = "SELECT * FROM `lesson_plan` WHERE `class` = '$user_class' AND `day` = 'Wtorek'";
	$sql_wednesday = "SELECT * FROM `lesson_plan` WHERE `class` = '$user_class' AND `day` = 'Środa'";
	$sql_thursday = "SELECT * FROM `lesson_plan` WHERE `class` = '$user_class' AND `day` = 'Czwartek'";
	$sql_friday = "SELECT * FROM `lesson_plan` WHERE `class` = '$user_class' AND `day` = 'Piątek'";

	$result_monday = $connect->query($sql_monday);
	$result_tuseday = $connect->query($sql_tuseday);
	$result_wednesday = $connect->query($sql_wednesday);
	$result_thursday = $connect->query($sql_thursday);
	$result_friday = $connect->query($sql_friday);

echo '<div class="container-fluid animate-bottom"><div class="row">';
if ($result_monday->num_rows > 0) {
echo <<<END
	<div class="col-12" style="width: 18rem">
	<h4>Poniedziałek</h4>
		<table class="table table-hover">
		  <thead>
			<tr>
			  <th style="background-color:#c4c4c4;width:300px;">Godzina</th>
			  <th style="background-color:#c4c4c4">Lekcja</th>
			  <th style="background-color:#c4c4c4;width:600px;">Nauczyciel</th>
			</tr>
		  </thead>
		  <tbody>
END;
		// output data of each row
		while($row = $result_monday->fetch_assoc()) {	
			//day
			$lesson = $row['lesson'];
			$teacher = $row['teacher'];
			$time = $row['time'];
			
echo <<<END
		  
			<tr>
			  <th>$time</th>
			  <td>$lesson</td>
			  <td>$teacher</td>
			</tr>
END;
		}
echo <<<END
	
		</tbody>
	</table>
</div>
	
END;
}	else{
echo<<<END

<div class="card col-12">
  <div class="card-body">
    <blockquote class="blockquote mb-0">
      <p align="center">Brak planu <br /> Ten poniedziałek nie będzie taki zły</p>
    </blockquote>
  </div>
</div>

END;
	}
if ($result_tuseday->num_rows > 0) {
echo <<<END
	<div class="col-12" style="width: 18rem;margin-top:100px;">
	<h4>Wtorek</h4>
		<table class="table table-hover">
		  <thead>
			<tr>
			  <th style="background-color:#c4c4c4;width:300px;">Godzina</th>
			  <th style="background-color:#c4c4c4">Lekcja</th>
			  <th style="background-color:#c4c4c4;width:600px;">Nauczyciel</th>
			</tr>
		  </thead>
		  <tbody>
END;
		// output data of each row
		while($row = $result_tuseday->fetch_assoc()) {	
			//day
			$lesson = $row['lesson'];
			$teacher = $row['teacher'];
			$time = $row['time'];
			
echo <<<END
		  
			<tr>
			  <th>$time</th>
			  <td>$lesson</td>
			  <td>$teacher</td>
			</tr>
END;
		}
echo <<<END
	
		</tbody>
	</table>
</div>
	
END;
}	else{
echo<<<END

<div class="card col-12">
  <div class="card-body">
    <blockquote class="blockquote mb-0">
      <p align="center">Brak planu <br /> Wtorek wolny!</p>
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
			  <th style="background-color:#c4c4c4;width:600px;">Nauczyciel</th>
			</tr>
		  </thead>
		  <tbody>
END;
		// output data of each row
		while($row = $result_wednesday->fetch_assoc()) {	
			//day
			$lesson = $row['lesson'];
			$teacher = $row['teacher'];
			$time = $row['time'];
			
echo <<<END
		  
			<tr>
			  <th>$time</th>
			  <td>$lesson</td>
			  <td>$teacher</td>
			</tr>
END;
		}
echo <<<END
	
		</tbody>
	</table>
</div>
	
END;
}	else{
echo<<<END

<div class="card col-12">
  <div class="card-body">
    <blockquote class="blockquote mb-0">
      <p align="center">Brak planu <br /> W Środę zajęć nie będzie!</p>
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
			  <th style="background-color:#c4c4c4;width:600px;">Nauczyciel</th>
			</tr>
		  </thead>
		  <tbody>
END;
		// output data of each row
		while($row = $result_thursday->fetch_assoc()) {	
			//day
			$lesson = $row['lesson'];
			$teacher = $row['teacher'];
			$time = $row['time'];
			
echo <<<END
		  
			<tr>
			  <th>$time</th>
			  <td>$lesson</td>
			  <td>$teacher</td>
			</tr>
END;
		}
echo <<<END
	
		</tbody>
	</table>
</div>
	
END;
}	else{
echo<<<END

<div class="card col-12">
  <div class="card-body">
    <blockquote class="blockquote mb-0">
      <p align="center">Brak planu <br /> Czwartek czysty</p>
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
			  <th style="background-color:#c4c4c4;width:600px;">Nauczyciel</th>
			</tr>
		  </thead>
		  <tbody>
END;
		// output data of each row
		while($row = $result_friday->fetch_assoc()) {	
			//day
			$lesson = $row['lesson'];
			$teacher = $row['teacher'];
			$time = $row['time'];
			
echo <<<END
		  
			<tr>
			  <th>$time</th>
			  <td>$lesson</td>
			  <td>$teacher</td>
			</tr>
END;
		}
echo <<<END
	
		</tbody>
	</table>
</div>
	
END;
}	else{
echo<<<END

<div class="card col-12">
  <div class="card-body">
    <blockquote class="blockquote mb-0">
      <p align="center">Brak planu <br />Piątek -  Impreza u mnie</p>
    </blockquote>
  </div>
</div>

END;
	}
echo'</div</div>';
?>