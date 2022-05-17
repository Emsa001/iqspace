<?php

	session_start();
	if (!isset($_SESSION['teacher']))
	{
		header('Location: ./index.php');
		exit();
	}

	require_once "../../../database/connect.php";

	$connect = @new mysqli($host, $db_user, $db_password, $db_name);
	mysqli_query($connect, "SET CHARSET utf8");
	mysqli_query($connect, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");

	// Check connection
	if (!$connect) {
		die("Connection failed: " . mysqli_connect_error());
	}
	


	$class = $_GET['class'];

	$sql_monday = "SELECT * FROM `lesson_plan` WHERE `day` = 'Poniedziałek' AND `class` = '$class'";
	$sql_tuseday = "SELECT * FROM `lesson_plan` WHERE `day` = 'Wtorek' AND `class` = '$class'";
	$sql_wednesday = "SELECT * FROM `lesson_plan` WHERE `day` = 'Środa' AND `class` = '$class'";
	$sql_thursday = "SELECT * FROM `lesson_plan` WHERE `day` = 'Czwartek' AND `class` = '$class'";
	$sql_friday = "SELECT * FROM `lesson_plan` WHERE `day` = 'Piątek' AND `class` = '$class'";

	$result_monday = $connect->query($sql_monday);
	$result_tuseday = $connect->query($sql_tuseday);
	$result_wednesday = $connect->query($sql_wednesday);
	$result_thursday = $connect->query($sql_thursday);
	$result_friday = $connect->query($sql_friday);

?>


<!doctype html>
<html lang="pl">
	<head>
		<title>Plan lekcji klasy: <?php echo $class;?></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
		<link rel="stylesheet" href="css/style.css">
		<link rel="stylesheet" href="css/schoolmain.css">
		<link rel="stylesheet" href="css/class.css">
		<link rel="stylesheet" href="css/media.css">
		<link rel="stylesheet" href="./css/animation-content.css">		 
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
		<link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@3/dark.css" rel="stylesheet">
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
		<script src="//cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.js"></script>
	</head>
<body>
<?php
	
echo<<<END

<nav aria-label="breadcrumb">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="../../../szkola.php">Panel użytkownika</a></li>
    <li class="breadcrumb-item"><a href="../../../szkola.php?data=lesson_plan" onclick="lesson_plan()">Plan lekcji</a></li>
    <li class="breadcrumb-item active" aria-current="page">Klasa $class</li>
  </ol>
</nav>

END;
echo '<div class="container-fluid animate-bottom"><hr><h4>Plan Lekcji klasy '.$class.'</h4><hr><div class="row">';

if ($result_monday->num_rows > 0) {
echo <<<END
	<div class="col-12" style="width: 18rem">
	<h4>Poniedziałek</h4>
	<form action="../../../database/delete_plan.php" method="POST" style="margin-bottom:10px;">
		<input type="text" value="Poniedziałek" name="day" style="display:none">
		<button type="submit" class="btn btn-primary">Usuń plan lekcji</button>
	</form>
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
      <p align="center">Brak planu</p>
    </blockquote>
  </div>
</div>

END;
	}
if ($result_tuseday->num_rows > 0) {
echo <<<END
	<div class="col-12" style="width: 18rem;margin-top:20px">
	<h4>Wtorek</h4>
	<form action="../../../database/delete_plan.php" method="POST" style="margin-bottom:10px;">
		<input type="text" value="Wtorek" name="day" style="display:none">
		<button type="submit" class="btn btn-primary">Usuń plan lekcji</button>
	</form>
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
      <p align="center">Brak planu</p>
    </blockquote>
  </div>
</div>

END;
}
if ($result_wednesday->num_rows > 0) {
echo <<<END
	<div class="col-12" style="width: 18rem;margin-top:100px;">
	<h4>Środa</h4>
	<form action="../../../database/delete_plan.php" method="POST" style="margin-bottom:10px;">
		<input type="text" value="Środa" name="day" style="display:none">
		<button type="submit" class="btn btn-primary">Usuń plan lekcji</button>
	</form>
	
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
      <p align="center">Brak planu</p>
    </blockquote>
  </div>
</div>

END;
}
if ($result_thursday->num_rows > 0) {
echo <<<END
	<div class="col-12" style="width: 18rem;margin-top:100px;">
	<h4>Czwartek</h4>
	<form action="../../../database/delete_plan.php" method="POST" style="margin-bottom:10px;">
		<input type="text" value="Czwartek" name="day" style="display:none">
		<button type="submit" class="btn btn-primary">Usuń plan lekcji</button>
	</form>
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
      <p align="center">Brak planu</p>
    </blockquote>
  </div>
</div>

END;
}
if ($result_friday->num_rows > 0) {
echo <<<END
	<div class="col-12" style="width: 18rem;margin-top:100px;">
	<h4>Piątek</h4>
	<form action="../../../database/delete_plan.php" method="POST" style="margin-bottom:10px;">
		<input type="text" value="Piątek" name="day" style="display:none">
		<button type="submit" class="btn btn-primary">Usuń plan lekcji</button>
	</form>
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
      <p align="center">Brak planu</p>
    </blockquote>
  </div>
</div>

END;
}
echo'</div</div>';
?>
</body>