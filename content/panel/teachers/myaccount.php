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
   <p class="whologged" align="center">Zalogowano na konto: <b><?php echo $name_surname; ?></b></p>

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
