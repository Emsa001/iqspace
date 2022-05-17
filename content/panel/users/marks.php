<?php
	session_start();

	require_once "../../../database/connect.php";
	
	// Create connection
	$connect = new mysqli($host, $db_user, $db_password, $db_name);
	mysqli_query($connect, "SET CHARSET utf8");
	mysqli_query($connect, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");


	$user_name = $_SESSION['login'];
	$user_class = $_SESSION['class'];

    $lesson1 = "'x'";
	$sql_lessons = "SELECT * FROM `lessons` WHERE `class_teaching` LIKE '%$user_class%'";
	$result = $connect->query($sql_lessons);
    $classteaching = array();
	if ($result->num_rows > 0) {
	  while($row = $result->fetch_assoc()) {
         $lesson1 = $lesson1." ,'".$row['lesson']."'";
	  }
	}	

	$sql_lessons = "SELECT * FROM `lessons` WHERE `lesson` IN ($lesson1) ORDER BY lesson";
	$result = $connect->query($sql_lessons);

	$mark_settings = $_SESSION['mark_settings'];

?>

<div class="container-fluid marks-content animate-bottom">
<h2 style="margin-bottom:50px;">Moje oceny:</h2>
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

	if ($result->num_rows > 0) {
		$lessonsarr = array();
		while($row = $result->fetch_assoc()) {
			$lesson = $row['lesson'];
            if (!in_array($lesson, $lessonsarr)){
                array_push($lessonsarr, $lesson);

echo '<tr><td>'.$lesson.'</td>';
//Ocena
echo'<td>';
			
	$sql_marks = "SELECT * FROM `marks` WHERE `user` = '$user_name' AND `lesson` = '$lesson' AND NOT `typ` = 'Semestralna'";
	$result_marks = $connect->query($sql_marks);

	if ($result_marks->num_rows > 0) {
		$i = 0;
		while($row_marks = $result_marks->fetch_assoc()) {
			$i++;
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
			
			$mark_type_text = $mark_type_id;
			if($mark_type_id == "Kartkowka")
			{$mark_type_text = "Kartkówka";}
			else if($mark_type_id == "Odpowiedzustna"){$mark_type_text = 'Odpowiedź ustna';}
			else if($mark_type_id == "Pracadomowa"){$mark_type_text = 'Praca domowa';}
			else if($mark_type_id == "Pracanalekcji"){$mark_type_text = 'Praca na lekcji';}
			$mark_text = 'Ilość punktów: '.$mark_points.' / '.$max_mark;
			if($mark_settings == "punkty"){
echo<<<END
			<div id='$mark_type_id' class="mark border text-white" data-container="body" data-toggle="popover" data-placement="top" data-trigger="hover" title='$mark_type_text' data-content="$mark_text" onclick="$('#$randomString').modal('toggle');"> <span>$mark_points</span></div>

END;
			}else{
echo<<<END
			<div id='$mark_type_id' class="mark border text-white" data-container="body" data-toggle="popover" data-placement="top" data-trigger="hover" title='$mark_type_text' data-content="$mark_text" onclick="$('#$randomString').modal('toggle');"><span>$mark</span></div>

END;
			}
echo<<<END
<div class="modal fade" id="$randomString" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">$mark_type_text - $mark_lesson</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
        $mark_content
      </div>
      <div class="modal-footer">
	  	<text style="margin-right:auto;">$mark_date</text>
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
      </div>
    </div>
  </div>
</div>
END;
			
		}
	}
		
echo'</td>';
if($mark_settings == "punkty"){
echo'<td>';
	
	$sql_marks_points = "SELECT SUM(`mark_get_points`) AS sum, SUM(`max_mark`) AS sum2 FROM `marks` WHERE `user` = '$user_name' AND `lesson` = '$lesson' AND NOT `typ` = 'Semestralna'";
	$result_marks_points= $connect->query($sql_marks_points);

	if ($result_marks_points->num_rows > 0) {
		$points_count =0;
		$points_count_max =0;
		while($row_marks_points = $result_marks_points->fetch_assoc()) {
			$points_count += $row_marks_points['sum'];
			$points_count_max += $row_marks_points['sum2'];
			if($points_count != 0 && $points_count_max != 0){
				$procent = floor($points_count / $points_count_max * 100)."%";
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
			
	$sql_marks_end = "SELECT * FROM `marks` WHERE `user` = '$user_name' AND `lesson` = '$lesson' AND `typ` = 'Semestralna' ";
	$result_marks_end = $connect->query($sql_marks_end);

	if ($result_marks_end->num_rows > 0) {
		while($row_marks = $result_marks_end->fetch_assoc()) {
			$mark = $row_marks['mark'];
			echo '<div class="mark border border-success bg-success text-white"><span>'.$mark.'</span></div>';
			
		}
	}
		
echo'</td>';
echo'</tr>';
        }
		}
	}
 
	
	$connect->close();
?>
  </tbody>
</table>
</div>
<script>
$(document).ready(function(){
  $('[data-toggle="popover"]').popover();   
});
</script>