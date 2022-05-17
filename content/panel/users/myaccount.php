<?php 
	session_start(); 
	error_reporting(0);
	ini_set('display_errors', 0);
    if (!isset($_SESSION['zalogowany']))
	{
		header('Location: ../../../index.php');
		exit();
	}

	require_once "../../../database/connect.php";

	$name_surname = $_SESSION['name']." ".$_SESSION['surname']; 

	$lastlogin = $_SESSION['lastlog'];

	if($lastlogin == ""){
		$lastlogin = "Brak";
	}

	// Create connection
	$connect = new mysqli($host, $db_user, $db_password, $db_name);
	mysqli_query($connect, "SET CHARSET utf8");
	mysqli_query($connect, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");

?>
<div class="content animate-bottom">
   <p align="right" class="logout" style="float:right;" onclick="signout()"><a href="./database/logout.php">Wyloguj się</a></p>
   <p class="lastlogin" align="left" style="float:left;">Ostatnie logowanie: <b><?php echo $lastlogin ?></b></p>
   <p class="whologged" align="center">Zalogowano na konto: <b><?php echo $name_surname; ?></b> || Klasa: <b><?php echo $_SESSION['class']; ?></b></p>
   <hr>
   <div class="container">
      <div class="row">
         <div class="col-sm" style="margin-bottom:10px;">
            <div class="card">
               <div class="card-body">
                  <h5 class="card-title">Moje oceny</h5>
                  <h6 class="card-subtitle mb-2 text-muted">Wszystkie oceny</h6>
                  <p class="card-text"></p>
                  <a href="#!" class="card-link" onclick="marks()">Zobacz wszystkie oceny</a>
               </div>
            </div>
         </div>
         <div class="col-sm" style="margin-bottom:10px;">
            <div class="card">
               <div class="card-body">
                  <h5 class="card-title">Moje Wiadomości</h5>
                  <h6 class="card-subtitle mb-2 text-muted">Wiadomości od nauczycieli</h6>
                  <a href="#!" class="card-link">Zobacz wszystkie zadania</a>
               </div>
            </div>
         </div>
         <div class="col-sm" style="margin-bottom:10px;">
            <div class="card">
               <div class="card-body">
                  <h5 class="card-title">Moje Prace</h5>
                  <h6 class="card-subtitle mb-2 text-muted">Tych prac żaden pies nie zje</h6>
                  <a href="#!" class="card-link">Zobacz wszystkie prace</a>
               </div>
            </div>
         </div>
      </div>

      <hr style="margin-top:50px">

      <?php
if($_SESSION['mark_settings'] != "punkty"){
//Lekcja
	$user_name = $_SESSION['login'];
	$user_class = $_SESSION['class'];

	$sql_lessons = "SELECT * FROM `lessons` WHERE `class_teaching` LIKE '%$user_class%'";
	$result_lessons = $connect->query($sql_lessons);

	if ($result_lessons->num_rows > 0) {
		$rowcount_lessons=mysqli_num_rows($result_lessons);
	}
		
	$sql_marks = "SELECT * FROM `marks` WHERE `user` = '$user_name' AND NOT `typ` = 'Semestralna'";
	$result_marks = $connect->query($sql_marks);
		
	if ($result_marks->num_rows > 0) {
		$rowcount_marks=mysqli_num_rows($result_marks);
	}
		
	$mark_sum_waga= 0;
	$waga_sum= 0;
	while ($num = mysqli_fetch_assoc($result_marks)) {	
		$mark = $num['mark'];
		$waga = $num['waga'];
		
		$waga_sum += $num['waga'];
		$mark_waga = $mark * $waga;
		
		$mark_sum_waga += $mark_waga;
	}
		$average = $mark_sum_waga / $waga_sum;
		$average_procent = number_format((float)$average, 2, '.', '') * 100 / 6 ."%";
		
		if($rowcount_marks == ""){
			$rowcount_marks = "0";
		}
?>
      <div class="row">
         <div class="col-sm">
            <h2>Moja średnia</h2>
            <small>Z wszytskich ocen</small>
            <div class="progress">
               <div class="progress-bar" role="progressbar" style="width: <?php echo $average_procent ?>" aria-valuenow="<?php echo number_format((float)$average, 2, '.', '');?>" aria-valuemin="1" aria-valuemax="6">
                  <?php echo number_format((float)$average, 2, '.', '');?>
               </div>
            </div>
            <p><br />Razem ocen: <b><?php echo $rowcount_marks; ?></b><br />Razem przedmiotów: <b><?php echo $rowcount_lessons; ?></b></p>
         </div>
      </div>
      <?php }else{
	
echo<<<END
		<div class="row">
			<div class="col-sm">
			<center><strong>Ta opcja jest wyłączona dla twojej szkoły</strong></center>
				<h2>Moja średnia</h2>
				<small>Z wszytskich ocen</small>
				<div class="progress">
				  <div class="progress-bar" role="progressbar" style="width: 0%" aria-valuenow="1" aria-valuemin="1" aria-valuemax="6">
				  </div>
				</div>
				<p><br />Razem ocen: <br />Razem przedmiotów: </p>
			</div>
		</div>
END;
		
}?>

      <hr style="margin-bottom:50px">
      <div class="container text-center">
         <h2>Wybierz swój motyw</h2>
         <form action="./content/panel/users-php/theme.php" method="post">
            <div class="custom-control custom-radio custom-control-inline">
               <input type="radio" class="custom-control-input" id="defaultInline1" name="profil" value="default">
               <label class="custom-control-label" for="defaultInline1" style="color: #3445b4">DOMYŚLNY</label>
            </div>

            <div class="custom-control custom-radio custom-control-inline">
               <input type="radio" class="custom-control-input" id="defaultInline2" name="profil" value="profil2">
               <label class="custom-control-label" for="defaultInline2" style="color: #c756db">RÓŻOWY</label>
            </div>

            <div class="custom-control custom-radio custom-control-inline">
               <input type="radio" class="custom-control-input" id="defaultInline3" name="profil" value="profil3">
               <label class="custom-control-label" for="defaultInline3" style="color: #17a2b8">MORSKI</label>
            </div>

            <div class="custom-control custom-radio custom-control-inline">
               <input type="radio" class="custom-control-input" id="defaultInline4" name="profil" value="profil4">
               <label class="custom-control-label" for="defaultInline4" style="color: #dc3545">CZERWONY</label>
            </div>

            <div class="custom-control custom-radio custom-control-inline">
               <input type="radio" class="custom-control-input" id="defaultInline5" name="profil" value="profil5">
               <label class="custom-control-label" for="defaultInline5" style="color: #6f42c1">FIOLETOWY</label>
            </div>
            <br />
            <button class="btn btn-success" type="submit">Zastosuj</button>
         </form>
      </div>
      <hr style="margin-bottom:50px">
      <div class="card card-outline-secondary">
         <div class="card-header">
            <h3 class="mb-0">Zmień hasło</h3>
         </div>
         <div class="card-body">
            <form action="./database/passwordchanged.php" class="form" role="form" autocomplete="off" method="post">
               <div class="form-group">
                  <label for="inputPasswordOld">Obecne hasło</label>
                  <input type="password" class="form-control" id="exampleInputPassword1" name="current_pass" style="border:1px solid #000;" required>
               </div>
               <div class="form-group">
                  <label for="inputPasswordNew">Nowe hasło</label>
                  <input type="password" class="form-control" id="exampleInputPassword1" name="new_pass" minlength="8" style="border:1px solid #000;" required>
                  <span class="form-text small text-muted">
                     Hasło powinno zawierać od 8 do 20 znaków <b>nie</b> może zawierać spacji.
                  </span>
               </div>
               <div class="form-group">
                  <label for="inputPasswordNewVerify">Powtórz nowe hasło</label>
                  <input type="password" class="form-control" id="exampleInputPassword1" name="new_repeat_pass" minlength="8" style="border:1px solid #000;" required>
               </div>
               <div class="form-group">
                  <button type="submit" class="btn btn-success btn-lg float-right">Zresetuj hasło</button>
               </div>
            </form>
         </div>
      </div>
   </div>
</div>
