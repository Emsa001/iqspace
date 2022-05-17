<?php
	session_start();
	error_reporting(0);
	ini_set('display_errors', 0);
	require_once "./database/connect.php";

	if (!isset($_SESSION['zalogowany']))
	{
		header('Location: ./index.php');
		exit();
	}

	
	$login = $_SESSION['login'];
	$connect = new mysqli($host, $db_user, $db_password, $db_name);
	mysqli_query($connect, "SET CHARSET utf8");
	mysqli_query($connect, "SET NAMES 'utf8' COLLATE 'utf8_polish_ci'");

    $whois = $_SESSION['whois'];
    if($whois == "student"){
       $db_table = "users";
    }
    else{
       $db_table = "teachers";
    }

	$sql = "SELECT theme FROM $db_table WHERE login = '$login'";
	$result = $connect->query($sql);

	if ($result->num_rows > 0) {
	// output data of each row
		while($row = $result->fetch_assoc()) {
			$theme = $row['theme'];
		}
	}
	$data = $_GET['data'];
    $_SESSION['sort'] = $_GET['sort'];
	if ($_SESSION['rank'] == "student"){$rank = "users";}else{$rank = "teachers";}
	$status = $_GET['status'];

   
    $work_id = $_GET['id'];
    $work_edit = $_GET['edit'];

?>
<!doctype html>
<html lang="pl">
	<head>
		<title>Panel użytkownika: <?php echo $_SESSION['name'];?></title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

		<link href="https://fonts.googleapis.com/css?family=Poppins:300,400,500,600,700,800,900" rel="stylesheet">

		<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
		<link rel="stylesheet" href="./css/style.css">
		<link rel="stylesheet" href="./css/schoolmain.css">
		<link rel="stylesheet" href="./css/classes.css">
		<link rel="stylesheet" href="./css/media.css">
		<link rel="stylesheet" href="./css/animation-content.css">		 
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
		<link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@3/dark.css" rel="stylesheet">
		
		
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
		<script src="//cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.js"></script>

		<style>
<?php 
if($theme == "profil2"){
echo<<<END
			#sidebar, .profil, .progress-bar{background-color: #c756db !important;}
            #sidebar i, .fa, .smallheadtext{color:#fff !important;}
            .submit-form-newsletter{background-color: #841a96 !important;}
            a{color:#c756db;}
            a:hover{color:#620072;}
END;
}if($theme == "profil3"){
echo<<<END
			#sidebar, .profil, .progress-bar{background-color: #17a2b8 !important;}
            #sidebar i, .fa, .smallheadtext{color:#fff !important;}
            .submit-form-newsletter{background-color: #4fc1d3 !important;}
            a{color:#17a2b8;}
            a:hover{color:#24707c;}
END;
}if($theme == "profil4"){
echo<<<END
			#sidebar, .profil, .progress-bar{background-color: #dc3545 !important;}
            #sidebar i, .fa, .smallheadtext{color:#fff !important;}
            .submit-form-newsletter{background-color: #9a434b !important;}
            a{color:#dc3545;}
            a:hover{color:#f57684;}
END;
}if($theme == "profil5"){
echo<<<END
			#sidebar, .profil, .progress-bar{background-color: #6f42c1 !important;}
            #sidebar i, .fa, .smallheadtext{color:#fff !important;}
            .submit-form-newsletter{background-color: #8f6ecc !important;}
            a{color:#6f42c1;}
            a:hover{color:#46326a;}
END;
}else if($theme == "default" or $theme == ""){echo<<<END
			#sidebar, .profil, .progress-bar{background-color: #3445b4 !important;}
            #sidebar i, .fa, .smallheadtext{color:#fff !important;}
            .submit-form-newsletter{background-color: #3445b4 !important;}
            a{color:#3445b4;}
            a:hover{color:#1b2983;}
END;
}

?>
		</style>

	</head>
	<body>
		<div class="wrapper d-flex align-items-stretch">
			<nav id="sidebar">
				<div class="custom-menu">
					<button type="button" id="sidebarCollapse" class="btn <?php echo $profil_default?> profil">
					  <i class="fa fa-bars"></i>
					  <span class="sr-only">Otwóz menu</span>
					</button>
				</div>
				<div class="p-4">
					<h1><a href="./index.php" class="logo"><text style="color:#338bf2;">IQ</text><text>space</text><span class="smallheadtext">Panel użytkownika</span></a></h1>
				<ul class="list-unstyled components mb-5">
				  <li id="mainpage">
					<a href="?data="><span class="fa fa-home mr-3"></span> Strona główna</a>
				  </li>
				  <li id="marks">
					<a href="?data=marks"><span class="mr-3"><i class="fas fa-graduation-cap"></i></span> Oceny</a>
				  </li>
				  <li id="news">
					<a href="?data=news"><span class="mr-3"><i class="fas fa-bell"></i></span> Ogłoszenia</a>
				  </li>
				  <li id="tasks">
					<a href="?data=tasks"><span class="mr-3"><i class="fas fa-tasks"></i></span> Zadania domowe</a>
				  </li>
				  <li id="works">
					<a href="?data=works"><span class="fa fa-sticky-note mr-3"></span><?php if($whois == "student"){echo "Moje prace";}else{echo"Prace uczniów";} ?></a>
				  </li>
				  <li id="messages">
					<a href="?data=messages"><span class="mr-3"><i class="fas fa-comment-dots"></i></span> Wiadomości</a>
				  </li>	
				  <li id="plan">
					<a href="?data=lesson_plan"><span class="mr-3"><i class="fas fa-table"></i></span> Plan lekcji</a>
				  </li>
				  <li id="timetable">
					<a href="?data=timetable"><span class="mr-3"><i class="fas fa-calendar-alt"></i></span> Terminarz</a>
				  </li>	
				  <li id="nb">
					<a href="?data=activity"><span class="mr-3"><i class="fas fa-calendar-minus"></i></span> Frekwencja</a>
				  </li>
					<?php 
						if($_SESSION['rank'] != "student"){
							echo '<li id="lastlogin"><a href="?data=lastlogin"><span class="mr-3"><i class="fas fa-coins"></i></span> Ostatnie logowania</a></li>';
						}
					?>
				  <li id="mainpage" class="dropbtn">
					<a href="?data=myaccount"><span class="fa fa-user mr-3"></span> Moje konto</a>
				  </li>
				</ul>

			<!--Footer and newsletter-->
	        <div class="mb-5">
				<h3 class="h6 mb-3">Przypomnij o każdym zadaniu</h3>
				<form action="#" class="subscribe-form">
					<div class="form-group d-flex">
						<div class="icon"><span class="icon-paper-plane"></span></div>
						<input type="text" class="form-control" placeholder="Tymczasowo nieaktywne" style="color:#fff" disabled>
					</div>
					<input type="submit" class="form-control submit-form-newsletter" value="Zaakceptuj" style="color:#fff">
	          	</form>
			</div>
	        <div class="footer">
				<hr style="background-color:#fff;">
					<p class="credits-text"><!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
						Copyright &copy;<script>document.write(new Date().getFullYear());</script> All rights reserved | This template is made with <i class="icon-heart" aria-hidden="true"></i> by <a href="https://colorlib.com" target="_blank" >Colorlib.com</a>
						<!-- Link back to Colorlib can't be removed. Template is licensed under CC BY 3.0. -->
					</p>
	        </div>
	      </div>
    	</nav>
			<div id="content" class="p-4 p-md-5 pt-5"></div>
	</div>
<?php
		
if($data != ""){
echo<<<END
	<script>
		$("#content").load("./content/panel/$rank/$data.php");
		if(screen.width < 800){
			$('#sidebar').toggleClass('active');
		}
	</script>
END;
}else{
echo<<<END
	<script>
		$("#content").load("./content/panel/$rank/mainpage.php");
		if(screen.width < 800){
			$('#sidebar').toggleClass('active');
		}
	</script>
END;
	}
require "./alerts.php";	
?>
		<script>
         const queryString = window.location.search;
         const urlParams = new URLSearchParams(queryString);
         const date = urlParams.get('date');
         const user = urlParams.get('user');
         const id = urlParams.get('id');
         if(date == "workpreview"){location.href = "./content/panel/teachers/works/preview.php?&user="+ user +"&id="+ id +"";}
		
		function wrongpass(){
			swal.fire({
				title: "OOPS Coś poszło nie tak",
				text: "Sprawdź wpisane dane i spróbuj ponownie",
				type: "error"
			}).then(function() {
				account();
			});
		}
		</script>		
	<!--Scripts - do not touch-->
    <script src="js/main.js"></script>
  </body>
</html>