<?php	
session_start();
if($_SESSION['new_password'] == "changed"){
   $_SESSION['new_password'] = "";
		echo"<script>			
            let timerInterval
			Swal.fire({
			title: 'Udało się!',
			html: 'Za chwilę zostaniesz wylogowany',
			timer: 2000,
			timerProgressBar: true,
			onClose: () => {
				clearInterval(timerInterval)
				location.href = './database/logout.php';
			}
			}).then((result) => {
				if (result.dismiss === Swal.DismissReason.timer) {
					location.href = './database/logout.php';
				}
			})
            </script>";
   }else if($_SESSION['new_password'] == "wrong"){
        $_SESSION['new_password'] = "";
		echo"<script>			
            Swal.fire({
				title: 'OOPS Coś poszło nie tak',
				text: 'Sprawdź wpisane dane i spróbuj ponownie',
				icon: 'error'
			}).then(function() {
				location.href = '?data=myaccount';
			});
            </script>";
   }
   if($_SESSION['task_edited'] == 1){
echo <<<END
		<script>
			swal.fire({
				title: "Udało się",
				text: "Zadanie zostało pomyślnie zedytowane",
				type: "success"
			}).then(function() {			
               location.href = '?data=tasks';
			});
		</script>
END;
		$_SESSION['task_edited'] = 0;
	}
	if($_SESSION['task_added'] == 1){
echo <<<END
		<script>
			swal.fire({
				title: "Udało się",
				text: "Zadanie zostało pomyślnie dodane",
				type: "success"
			}).then(function() {			
				$("#content").load("./content/panel/teachers/tasks.php");
               location.href = '?data=tasks';
			});
		</script>
END;
		$_SESSION['task_added'] = 0;
	}
	if($_SESSION['plan_added'] == 1){
echo <<<END
		<script>
			swal.fire({
				title: "Udało się",
				text: "Plan lekcji został dodany",
				type: "success"
			}).then(function() {			
               location.href = '?data=lesson_plan';
			});
		</script>
END;
		$_SESSION['plan_added'] = 0;
	}
	if($_SESSION['deleted_plan'] == 1){
echo <<<END
		<script>
			swal.fire({
				title: "Udało się",
				text: "Plan lekcji został usunięty",
				type: "success"
			}).then(function() {			
               location.href = '?data=lesson_plan';
			});
		</script>
END;
		$_SESSION['deleted_plan'] = 0;
	}
	if($_SESSION['news_added'] == 1){
echo <<<END
		<script>
			swal.fire({
				title: "Udało się",
				text: "Ogłoszenie zostało dodane",
				type: "success"
			}).then(function() {			
               location.href = '?data=news';
			});
		</script>
END;
		$_SESSION['news_added'] = 0;
	}
	if($_SESSION['deleted_news'] == 1){
echo <<<END
		<script>
			swal.fire({
				title: "Udało się",
				text: "Ogłoszenie zostało usunięte",
				type: "success"
			}).then(function() {			
               location.href = '?data=news';
			});
		</script>
END;
		$_SESSION['deleted_news'] = 0;
	}
		
	if($_SESSION['mark_added'] == 1){
echo <<<END
	<script>
      Swal.fire({
        width: 300,
        position: 'bottom-start',
        text: 'Udało się',
        showConfirmButton: false,
        timer: 3000,
        backdrop:  'rgba(255, 255, 255, 0)'
      })
	</script>
END;
		$_SESSION['mark_added'] = 0;
	}   
       
?>