<?php
	session_start();
	error_reporting(0);
	ini_set('display_errors', 0);
?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<meta charset="utf-8" />
	<meta name="viewport" content="width=device-width,initial-scale=1,maximum-scale=1,user-scalable=no">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<meta name="HandheldFriendly" content="true">
	<meta name="description" content="IQspace - E-dziennika">
	<title>IQspace - E-dziennik</title>
	
	<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
	<!-- Font Awesome -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.8.2/css/all.css">
	<!-- Google Fonts -->
	<link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Roboto:300,400,500,700&display=swap">
	<!-- Material Design Bootstrap -->
	<link href="https://cdnjs.cloudflare.com/ajax/libs/mdbootstrap/4.16.0/css/mdb.min.css" rel="stylesheet">
	
	<link rel="stylesheet" href="./css/main.css">
	<link rel="stylesheet" href="./css/media.css">
	<link rel="stylesheet" href="./css/animation-content.css">
	<link href="https://fonts.googleapis.com/css2?family=Barlow+Condensed:wght@200&family=Mitr:wght@300&display=swap" rel="stylesheet"> 
	<link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@400&display=swap" rel="stylesheet"> 
	
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
	<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
	
	<link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@3/dark.css" rel="stylesheet">
	<script src="//cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.js"></script>
	
	<!-- Global site tag (gtag.js) - Google Analytics -->
	<script async src="https://www.googletagmanager.com/gtag/js?id=UA-161436451-2"></script>
	<script>
	  window.dataLayer = window.dataLayer || [];
	  function gtag(){dataLayer.push(arguments);}
	  gtag('js', new Date());

	  gtag('config', 'UA-161436451-2');

      const queryString = window.location.search;
      const urlParams = new URLSearchParams(queryString);
      const data = urlParams.get('data');

	</script>
	
</head>
<body>   
    <div class="d-flex flex-column flex-md-row align-items-center p-3 px-md-4 mb-3 bg-white border-bottom box-shadow">
		<h5 class="my-0 mr-md-auto font-weight-normal" onclick="location.href = '?data='; " style="cursor:pointer"><span class="text-primary" style="font-family: 'Mitr', sans-serif;font-size:35px">IQ</span><span class="text-info" style="font-family: 'Quicksand', sans-serif;font-size:35px;">space</span></h5>
      <nav class="my-2 my-md-0 mr-md-3">
        <a class="p-2 text-dark" href="?data=">Strona Główna</a>
		<a class="p-2 text-dark" href="?data=o-nas">O nas</a>
		<a class="p-2 text-dark" href="?data=cennik">Cennik</a>
        <a class="p-2 text-dark" href="?data=kontakt">Kontakt</a>
      </nav>
		<?php
			if (!isset($_SESSION['zalogowany']) && !isset($_SESSION['admin_logged']))
			{
				echo'<a class="btn btn-outline-primary" href="?data=login">Zaloguj się</a>';
			}
			else if (isset($_SESSION['zalogowany'])){
				echo'<a class="btn btn-outline-primary" href="./szkola.php">panel uzytkownika</a>';
			}
            else if(isset($_SESSION['admin_logged'])){
                echo'<a class="btn btn-outline-primary" href="./szkola.php">Panel administratora</a>';
            }
		?>	
    </div>
	
	<!--Login wrong password-->
	<div id="wrongpass" class="container alert alert-danger" role="alert">
		 Nieprawidłowy login lub hasło
	</div>
	
	<!--Page Content-->
	<div class="page-content"></div>
	
    <footer class="page-footer font-small blue">
    	<div class="footer-copyright text-center py-3">Wszelkie prawa zastrzeżone, <a href="#" style="font-size:15px;"><span style="font-family: 'Mitr', sans-serif;">IQ</span><span style="font-family: 'Quicksand', sans-serif;">space</span></a></div>
    </footer>

<script>
	if (!data) {
        $(".page-content").load("./content/index/startpage.php");
    } else {
		$(".page-content").load("./content/index/" + data + ".php");
    }
	
	function login(){
		$(".page-content").load("./content/index/login.php");
	}

</script> 
<?php
	
	if($_SESSION['newlogin'] == 1){
		echo"<script>login()</script>";
		echo"<script>document.getElementById('wrongpass').style.display = 'block';</script>";
		$_SESSION['newlogin'] = 0;
	}

	
	if($_SESSION['Blad'] == 1){
echo <<<END
		<script>
			swal.fire({
				title: "Błąd",
				text: "Wiadomość nie została wysłana, sprawdź czy wszystkie pola zostały poprawnie uzupełnione",
				icon: "error"
			}).then(function() {			
				$('.page-content').load('./content/index/kontakt.php');
			});
		</script>
END;
		
	   $_SESSION['Blad'] = 0;
	}
	if($_SESSION['mail'] == 1){
echo <<<END
		<script>
			swal.fire({
				title: "Udało się!",
				text: "Wiadomość została wysłana! Odpowiemy na nią jak najszybciej",
				icon: "success"
			})
		</script>
END;
		
	   $_SESSION['mail'] = 0;
	}
	
	
?>
</body>
</html>