<?php
	session_start();
    if (!isset($_SESSION['zalogowany']))
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
	<h1 class="display-4">Ogłoszenia</h1>
	<hr class="my-4">
	<div class="row">
	<?php
		
		$sql_news = "SELECT * FROM `news`";
		$result = $connect->query($sql_news);
		
		if ($result->num_rows > 0) {
			$i = 0;
			while($row = $result->fetch_assoc()) {
				$news_title = $row['title'];
				$news_content = $row['content'];
				$news_date = $row['date'];
				$i++;
				
echo <<<END

				  <div class="col-sm-4" style="margin-bottom:30px;">
					<div class="card news">
					  <div class="card-body">
						<h5 class="card-title">$news_title</h5>
						<p class="card-text news-content-desc">$news_content</p>
						<p style="text-align:right;float:right;">$news_date</p>
						<a href="#" class="btn btn-primary" data-toggle="modal" data-target="#news_modal$i">Zobacz ogłoszenie</a>
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
						  <div class="modal-body">
							$news_content
						  </div>
						  <div class="modal-footer">
						  	$news_date
							<button type="button" class="btn btn-secondary" data-dismiss="modal">Zamknij</button>
						  </div>
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