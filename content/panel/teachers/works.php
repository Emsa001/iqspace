<?php
    session_start();
    $teacher_login = $_SESSION['login'];
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

	$sql_lessons = "SELECT class_teaching FROM `lessons` WHERE `login` = '$teacher_login'";
	$result = $connect->query($sql_lessons);
	if ($result->num_rows > 0) {
	  while($row = $result->fetch_assoc()) {
         $classes = $row['class_teaching'];
	  }
	}	
?>

<div class="col-12 animate-bottom">
   <div class="table">
      <table style="width:100%">
         <tr>
            <th>Id</th>
            <th>Uczeń</th>
            <th>Klasa</th>
            <th>Ilość prac</th>
            <th>Akcje</th>
         </tr>
         <?php 
       
         
$sql = "SELECT * FROM `users` WHERE `class` IN ($classes)";
$result = $connect->query($sql);          

if ($result->num_rows > 0) {
   $i = 0;
  // output data of each row
  while($row = $result->fetch_assoc()) {
     $i++;
     $works_count = mysqli_num_rows($result); 

     $works = $row['works'];
     if($works != 0){$works = "<b>".$row['works']."</b>";}
     $id = $row['id'];
     $login = $row['login'];
     $username = $row['name']." ". $row['surname'];
    echo "<tr class=".'class'.$row['class'].">
            <td>".$i."</td>
            <td>".$username."</td>
            <td>".$row['class']."</td>
            <td>"; 
    $sql_x = "SELECT * FROM works WHERE teachercode = '$teacher_login' AND user = $login AND NOT `status` = 'private'"; 
    $resultt = mysqli_query($connect, $sql_x); 
    if ($resultt) 
    { 
        $rows = mysqli_num_rows($resultt); 
           if ($rows){printf("<b>".$rows."</b>");}else{printf("0");}
        mysqli_free_result($resultt); 
    } 
    echo"</td>
            <td data-toggle='modal' data-target='#x".$id.$login."' style='cursor:pointer'>Zobacz</td>
         </tr>";
echo<<<END

<div class="modal fade" id="x$id$login" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog modal-xl">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">$username | <small>Prac: <b>$rows</b></small></h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">
      <div class="row">
END;
$result_x = $connect->query($sql_x);

if ($result_x->num_rows > 0) {
  while($row = $result_x->fetch_assoc()){
     $title = $row['title'];
     $content = $row['content'];
     $date = $row['date'];
     $work_id = $row['id'];
     if($row['status'] == "checked"){
        $bg = "style='background-color:#b2b2b2;'";
        $checktext = "Wysłane";
     }else{$bg = "";$checktext="";}
echo<<<END
      <div class="col-4" style="margin-bottom:30px;">
         <div class="card" $bg>
           <div class="card-body">
             <h5 class="card-title">$title</h5>
             <small style="float:right">$date</small><br/>
             <small style="float:right">$checktext</small>
             <a href="?date=workpreview&user=$login&id=$work_id" class="btn btn-primary" style="float:left">Zobacz</a>
           </div>
         </div>
      </div>
END;
  }
}
echo<<<END
      </div>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
      </div>
    </div>
  </div>
</div>

END;
  }
}
?>
      </table>
   </div>
</div>
