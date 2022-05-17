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
?> 


<div class="container-fluid animate-bottom">
	<h1 class="display-4">Ogłoszenia
		<?php if($_SESSION['rank'] == "head_teacher"){
echo<<<END

<button type="button" class="btn btn-success" data-toggle="modal" data-target="#add_news" style="margin-top:10px;">
  Dodaj nowe
</button>

END;
}
		?>
	</h1>
<?php if($_SESSION['rank'] == "head_teacher"){
echo<<<END

<!-- Button trigger modal -->


<!-- Modal -->
<div class="modal fade" id="add_news" tabindex="-1" role="dialog" aria-hidden="true">
  <div class="modal-dialog" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">Dodaj ogłoszenie</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
	  <form action="./database/add_news.php" method="POST">
		<div class="modal-body">
		  <div class="form-group">
			<label for="exampleFormControlInput1">Tytuł ogłoszenia</label>
			<input type="text" class="form-control" name="news_title">
		  </div>
		  <div class="form-group">
		  	<label for="exampleFormControlTextarea1">Treść ogłoszenia</label>
			<textarea class="form-control"" aria-label="With textarea" name="news_content"" style="min-height:200px !important;" />
		  </div>
		</div>
		<div class="modal-footer">
	      <button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
		  <button type="submit" class="btn btn-primary">Dodaj ogłoszenie</button>
		</div>
	  </form>
    </div>
  </div>
</div>

END;
}	?>
	<hr class="my-4">
	<div class="row">
	<?php

		
		$sql_news = "SELECT * FROM `news` ORDER BY `id` DESC";
		$result = $connect->query($sql_news);		

		
		if ($result->num_rows > 0) {
			$i = 0;
			while($row = $result->fetch_assoc()) {
				$news_title = $row['title'];
				$news_content = $row['content'];
				$news_date = $row['date'];
				$id = $row['id'];
				$i++;
				
echo <<<END
	<div class="col-sm-4" style="margin-bottom:20px;">
		<div class="card news">
			<div class="card-body">
				<h5 class="card-title">$news_title</h5>
				<p class="card-text news-content-desc">$news_content</p>
				<p style="text-align:right;float:right;">$news_date</p>
				<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#news_modal$i" style="float:left">Zobacz ogłoszenie</a>
END;
	if($_SESSION['rank'] == "head_teacher"){
echo<<<END
	<form action="./database/delete_news.php" method="POST" id="delete_news">
		<input type="text" value="$id" name="id" style="display:none">
		<a href="#" onclick="delete_news()" class="btn btn-danger" style="margin-left:5px;">Usuń</a>
	</form>
END;
	}
echo<<<END
			</div>
		</div>
	</div>		  
	<div class="modal fade" id="news_modal$i" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
		<div class="modal-dialog" role="document">
			<div class="modal-content">
				<div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">$news_title</h5>
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
				</div>
				<div class="modal-body">$news_content</div>
				<div class="modal-footer">$news_date<button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button></div>
			</div>
		</div>
	</div>
END;
			}

		}
		else{
echo <<<END

<div class="card col-12">
  <div class="card-body">
    <blockquote class="blockquote mb-0">
      <p align="center">Moja baza danych jest pusta <i class="far fa-frown"></i><br />Twoja szkoła nie wstawiła żadnych ogłoszeń</p>
    </blockquote>
  </div>
</div>

END;
		}
		
		?>
	</div>
</div>


<script>
function delete_news(){
	Swal.fire({
	  title: 'Jesteś pewny?',
	  text: "Tego nie będzie można cofnąć!",
	  icon: 'warning',
	  showCancelButton: true,
	  confirmButtonColor: '#3085d6',
	  cancelButtonColor: '#d33',
	  cancelButtonText: 'Anuluj',
	  confirmButtonText: 'Tak usuń!'
	}).then((result) => {
	  if (result.value) {
		Swal.fire(
		  'Usunięto!',
		  'Ogłoszenie zostało usunięte',
		  'success'
		)
		setTimeout(function () {document.getElementById("delete_news").submit();}, 1000);
	  }
	})
}

</script>