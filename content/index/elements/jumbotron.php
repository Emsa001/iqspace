<?php session_start(); ?>
		  <div class="jumbotron p-4 p-md-5 text-white rounded bg-dark startpage-bigbanner">
<?php 
   if($_SESSION['admin_logged'] == true){
    echo"<a href='#'>Edytuj element</a>";     
   }        
?>
			<div class="col-md-6 px-0">
			  <h1 class="display-4 font-italic">Nowa generacja E-dziennika</h1>
			  <p class="lead my-3">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Phasellus in erat felis. Curabitur sed congue libero, non venenatis eros. Cras elit nisl.</p>
			  <p class="lead mb-0"><a href="#" class="text-white font-weight-bold" onclick="onas()" style="text-decoration:underline">Kim jesteśmy?</a></p>
			</div>
		  </div>