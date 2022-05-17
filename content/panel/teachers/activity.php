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
	$sql_lessons = "SELECT class_teaching, lesson FROM `lessons` WHERE `login` = '$user_login'";
	$result = $connect->query($sql_lessons);
	if ($result->num_rows > 0) {
	  while($row = $result->fetch_assoc()) {
         $classes = $row['class_teaching'];
         $_SESSION['lesson'] = $row['lesson'];
	  }
	}	

?> 
<div class="container-fluid animate-bottom">
   <h1>Lekcja: <b><?php echo $_SESSION['lesson']; ?></b></h1>
   <form action="./database/activity-save.php" method="POST">
      <table class="table table-striped table-dark table-bordered">
        <tr>
          <th>Uczeń</th>
          <th>Klasa</th>
          <th width="200px">Obecność ( <b>-</b> \ <b>+</b> )</th>
          <th>Akcje</th>
        </tr>
   <?php
      $sql = "SELECT * FROM `users` WHERE `class` IN ($classes)";

       $result_2 = $connect->query($sql);
       if ($result_2->num_rows > 0) {
          $i =0;
          while($row = $result_2->fetch_assoc()) {  
               $pon = '';
               $wt = '';
               $sr = '';
               $czw = '';
               $pt = '';
               $userlg = $row['login'];
               $user = $row['name']." ".$row['surname'];
               $class = $row['class'];
               $login = $row['login'];
               $sql_less = "SELECT * FROM lessons";
               $sql3 = "SELECT * FROM `activity` WHERE `user` = '$login'";  
               $result_3 = $connect->query($sql3);
                if ($result_3->num_rows > 0) {
                   while($row = $result_3->fetch_assoc()) {
                      switch($row['day']){
                        case 'poniedziałek':
                            $pon = $row['activity'];
                        break;
                        case 'wtorek':
                            $wt = $row['activity'];
                        break;
                        case 'środa':
                            $sr = $row['activity'];
                        break;
                        case 'czwartek':
                            $czw = $row['activity'];
                        break;
                        case 'piątek':
                            $pt = $row['activity'];
                        break;
                      }
                   }
                }

echo<<<END
                <tr>
                  <td>$user</td>
                  <td><input type="text" value="$class" name="class" style="display:none">$class</td>
                  <td style="text-align:center"><input type="text" maxlength="1" onkeypress="return check(event)" value="" name="user$userlg"></td>
                  <td>Zobacz</td>
                </tr>
END;
          }
       }
   ?>
      </table>
      <button type="submit" style="margin-left:90%;">Zatwierdź</button>
   </form>
</div>

<script>
function check(evt) {
   console.log(evt);
   if(evt.key == "+" || evt.key == "-"){
      return true;
   }else{
      return false;
   }
   /*
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
   */
}
</script>