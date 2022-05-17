<?php
	session_start();
    if (!isset($_SESSION['teacher']))
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

	$user_login = $_GET['login'];
	$user_class = $_GET['class'];
	$user_name = $_GET['user'];


	$teacher_login = $_SESSION['login'];


	$sql_lessons = "SELECT * FROM `lessons` WHERE `$user_class` = '1' ORDER BY lesson;";
	$result = $connect->query($sql_lessons);

	$mark_settings = $_SESSION['mark_settings'];
    $clesson = $_GET['lesson'];
?>
<!doctype html>
<html lang="pl">
	<head>
		<title>Panel użytkownika: <?php echo $_SESSION['name'];?></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
		<link rel="stylesheet" href="../../../css/style.css">
		<link rel="stylesheet" href="../../../css/schoolmain.css">
		<link rel="stylesheet" href="../../../css/class.css">
		<link rel="stylesheet" href="../../../css/media.css">
		<link rel="stylesheet" href="../../../css/animation-content.css">		 
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
		<link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@3/dark.css" rel="stylesheet">
		
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
		<script src="//cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.js"></script>

	</head>
<body>
<nav aria-label="breadcrumb" class="animate-bottom">
  <ol class="breadcrumb">
    <li class="breadcrumb-item"><a href="../../../szkola.php">Strona Główna</a></li>
    <li class="breadcrumb-item"><a href="../../../szkola.php?data=marks">Oceny</a></li>
    <li class="breadcrumb-item active" aria-current="page"><?php echo $user_name?></li>
  </ol>
</nav>
<div class="container-fluid marks-content animate-bottom">
<h2 style="margin-bottom:50px;">Oceny ucznia <?php echo $user_name ?>:</h2>
<button type="button" class="btn btn-primary" data-toggle="modal" data-target=".add_mark" style="margin-bottom:20px;">Dodaj nową ocenę</button>

<?php
echo<<<END
<form action='../../../database/addmark.php' method='post'>
	<div class="modal fade bd-example-modal-lg add_mark" tabindex="-1" role="dialog" aria-labelledby="myLargeModalLabel" aria-hidden="true">	
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Dodaj nową ocenę dla <b>$user_name</b></h5>
			<input type="text" value="$user_login" name="mark_user" style="display:none">
            <input type="text" value="$user_name" name="mark_user_name" style="display:none">
            <input type="text" value="$user_class" name="mark_user_class" style="display:none">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
			<div class="container-fluid">
				<label for="exampleFormControlSelect1" style="margin-top:20px">Przedmiot</label>
					<select class="form-control" name="mark_lesson">
END;
	$sql_lessons = "SELECT * FROM `lessons` WHERE `login` = '$teacher_login'";
	$result_lessons_teachers = $connect->query($sql_lessons);
			
    $lessons = array();
    $all = '';
	if ($result_lessons_teachers->num_rows > 0) {
		while($row = $result_lessons_teachers->fetch_assoc()) {
			$lesson = $row['lesson'];
           if(!in_array($lessons, $lesson)){
              array_push($lessons, $lesson);
              $all = $all.' '.$lesson; 
			  echo "<option>$lesson</option>";
              if($clesson == ''){
               $clesson = $lessons[0];  
              }
           }
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
?>
<div class="form-group">
    <label for="exampleFormControlSelect1">Wybierz przedmiot</label>
    <select class="form-control" id="lessonSubj" onchange="clesson();">
<?php
   echo"<option>$clesson</option>";
   for($i = 0; $i < count($lessons);$i++){
      if($lessons[$i] != $clesson){
        echo"<option>$lessons[$i]</option>";  
      }
   }
?>
    </select>
</div>
<script>
function clesson(){
   var url = location.href;
   window.location.replace(url + '&lesson=' + document.getElementById('lessonSubj').value);
}   
</script>
   
<table class="table table-bordered">
  <thead>
    <tr>
      <th scope="col" style="width:20%;">Przedmiot</th>
      <th scope="col" style="width:70%;">Oceny</th>
	<?php if($mark_settings == "punkty"){echo"<th scope='col' style='width:75%;'>Punkty</th>";}?>
      <th scope="col" style="width:15%;">Ocena semestralna</th>
    </tr>
  </thead>
  <tbody>	
<?php
echo '<tr><td>'.$clesson.'</td>';
//Ocena
echo'<td>';
	$sql_marks = "SELECT * FROM `marks` WHERE `user` = '$user_login' AND `lesson` = '$clesson' AND NOT `typ` = 'Semestralna'";
	$result_marks = $connect->query($sql_marks);

	if ($result_marks->num_rows > 0) {
		$i = 0;
		while($row_marks = $result_marks->fetch_assoc()) {
			$i++;
			$mark_id = $row_marks['id'];
			$mark = $row_marks['mark'];
			$mark_points = $row_marks['mark_get_points'];
			$max_mark = $row_marks['max_mark'];
			$mark_type_id = $row_marks['typ'];
			$mark_content = $row_marks['mark_content'];
			$mark_lesson = $row_marks['lesson'];
			$mark_date = $row_marks['date']; 
			
			$characters = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
			$charactersLength = strlen($characters);
			$randomString = '';
			for ($c = 0; $c < 10; $c++) {
				$randomString .= $characters[rand(0, $charactersLength - 1)];
			}
            
            $random_class = $i.$randomString;
			$mark_type_text = $mark_type_id;
			if($mark_type_id == "Kartkowka")
			{$mark_type_text = "Kartkówka";}
			else if($mark_type_id == "Odpowiedzustna"){$mark_type_text = 'Odpowiedź ustna';}
			else if($mark_type_id == "Pracadomowa"){$mark_type_text = 'Praca domowa';}
			else if($mark_type_id == "Pracanalekcji"){$mark_type_text = 'Praca na lekcji';}
			$mark_text = 'Ilość punktów: '.$mark_points.' / '.$max_mark;
			if($mark_settings == "punkty"){
echo<<<END
			<div id='$mark_type_id' class="mark border text-white" data-container="body" data-toggle="popover" data-placement="top" data-trigger="hover" title='$mark_type_text'data-content="$mark_text" onclick="openmark$random_class()">

END;
    if(strlen($mark) > 3 or strlen($mark_points) > 3 ){
echo<<<END
			<span style="font-size:12px;">$mark_points</span></div>

END;
    }else{
        echo "<span>$mark_points</span></div>";
    }

			}else{
echo<<<END
			<div id='$mark_type_id' class="mark border text-white" data-container="body" data-toggle="popover" data-placement="top" data-trigger="hover" title='$mark_type_text' data-content="$mark_text" onclick="openmark$random_class()" <span id="usermark">$mark</span></div>

END;
			}
echo<<<END
<script>

function openmark$random_class(){
$('#$randomString').modal('toggle');
}
			
</script>
			
<!-- Modal -->
<form action='../../../database/savemark.php' method='post'>
	<div class="modal fade" id="$randomString" tabindex="-1" role="dialog" aria-hidden="true">
	  <div class="modal-dialog" role="document">
		<div class="modal-content">
		  <div class="modal-header">
			<h5 class="modal-title" id="exampleModalLabel">Edytuj ocenę <b>$user_name</b></h5>
			<input type="text" value="$user_login" name="user_login" style="display:none">
            <input type="text" value="$user_class" name="user_class" style="display:none">
            <input type="text" value="$user_name" name="user_name" style="display:none">
			<input type="text" value="$mark_id" name="mark_id" style="display:none">
			<button type="button" class="close" data-dismiss="modal" aria-label="Close">
			  <span aria-hidden="true">&times;</span>
			</button>
		  </div>
		  <div class="modal-body">
		  <small>Pozostaw puste, żeby usunąć ocenę</small>
			<div class="container-fluid">
				<div class="row" style="margin-top:20px">
END;
if($mark_settings == "punkty"){
echo <<<END
					<div class="col-sm-6">
						<label for="exampleFormControlSelect1">Zdobyte punkty</label>
						<input type="text" class="form-control" name="mark_get_points2" value="$mark_points">
					</div>
					<div class="col-sm-6">
						<label for="exampleFormControlSelect1">Max punkty</label>
						<input type="text" class="form-control" name="mark_max2" value="$max_mark">
					</div>
END;
}else{
echo <<<END
					<div class="col-sm-4">
						<label for="exampleFormControlSelect1">Ocena</label>
						<input type="text" class="form-control" name="mark2" value="$mark">
					</div>
					<div class="col-sm-4">
						<label for="exampleFormControlSelect1">Zdobyte punkty</label>
						<input type="text" class="form-control" name="mark_get_points2" value="$mark_points">
					</div>
					<div class="col-sm-4">
						<label for="exampleFormControlSelect1">Max punkty</label>
						<input type="text" class="form-control" name="mark_max2" value="$max_mark">
					</div>
END;
}
echo<<<END
				</div>
				<div class="row" style="margin-top:20px;">
					<div class="col-sm">
						<label for="exampleFormControlSelect1">Typ ocecny</label>
						<select class="form-control" name="mark_type2">
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
						<label for="exampleFormControlSelect2">Waga</label>
						<select class="form-control" name="mark_waga2">
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
						<textarea class="form-control" aria-label="With textarea" name="mark_content2" style="min-height:100px !important;">$mark_content</textarea>
					</div>
				</div>
			</div>
		  	<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
				<button type="submit" class="btn btn-success">Zapisz</button>
		  	</div>
		</div>
	  </div>
	</div>
  </div>
</form>
END;
			
		}
	}
		
echo'</td>';
if($mark_settings == "punkty"){
echo'<td>';

	
	$sql_marks_points = "SELECT SUM(`mark_get_points`) AS sum, SUM(`max_mark`) AS sum2 FROM `marks` WHERE `user` = '$user_login' AND `lesson` = '$clesson' AND NOT `typ` = 'Semestralna'";
	$result_marks_points= $connect->query($sql_marks_points);

	if ($result_marks_points->num_rows > 0) {
		$points_count =0;
		$points_count_max =0;
		while($row_marks_points = $result_marks_points->fetch_assoc()) {
			$points_count += $row_marks_points['sum'];
			$points_count_max += $row_marks_points['sum2'];
			if($points_count != 0 && $points_count_max != 0){
				$procent = round($points_count / $points_count_max * 100)."%";
echo<<<END

<div class="border text-center" data-container="body" data-toggle="popover" data-placement="top" data-trigger="hover" title='Procenty z $lesson' data-content="Zdobyte punkty: $points_count / $points_count_max" style="cursor:pointer;" <span>$procent</span></div>

END;
			}
		}
	};
	
echo'</td>';
}
//Semsetralna
echo'<td>';
			
	$sql_marks_end = "SELECT * FROM `marks` WHERE `user` = '$user_name' AND `lesson` = '$lesson`' AND `typ` = 'Semestralna' ";
	$result_marks_end = $connect->query($sql_marks_end);

	if ($result_marks_end->num_rows > 0) {
		while($row_marks = $result_marks_end->fetch_assoc()) {
			$mark = $row_marks['mark'];
			echo '<div class="mark border border-success bg-success text-white"><span>'.$mark.'</span></div>';
			
		}
	}
		
echo'</td>';
echo'</tr>';
 
	
	$connect->close();
?>
  </tbody>
</table>
</div>
</body>
<script>
$(document).ready(function(){
  $('[data-toggle="popover"]').popover();   
});
   
   function validate(evt) {
  var theEvent = evt || window.event;

  // Handle paste
  if (theEvent.type === 'paste') {
      key = event.clipboardData.getData('text/plain');
  } else {
  // Handle key press
      var key = theEvent.keyCode || theEvent.which;
      key = String.fromCharCode(key);
  }
  var regex = /[0-9]|\./;
  if( !regex.test(key) ) {
    theEvent.returnValue = false;
    if(theEvent.preventDefault) theEvent.preventDefault();
  }
}
</script>