<script src="//cdn.jsdelivr.net/npm/sweetalert2@9/dist/sweetalert2.min.js"></script>
<link href="//cdn.jsdelivr.net/npm/@sweetalert2/theme-dark@3/dark.css" rel="stylesheet">
<div class="container animate-bottom">
	<div class="row justify-content-md-center">
		<div class="col-12">
			<!--Logowanie Modal-->
			<div class="modal-dialog login-content">
				<div class="modal-content">
				  <div class="modal-header">
					<h5 class="modal-title" id="exampleModalLabel">Zaloguj się na swoje konto</h5>
				  </div>
				  <div class="modal-body">
					<div id="login-form" class="container" style="max-width:500px">
						<form action="./database/login.php" method="post" id="nameform">
							<input type="text" id="inputEmail" name="login" class="form-control" placeholder="Login" required="" autofocus="" style="margin-bottom:5px">
							<input type="password" id="inputPassword" name="password" class="form-control" placeholder="Hasło" required="">
							<br />				
							  <select class="custom-select" id="inputGroupSelect01" name="whois">
								<option selected value="student">Uczeń</option>
								<option value="teacher">Nauczyciel</option>
							  </select>
						</form>
						<br /><a href="#" onclick="forgot()">Nie pamiętam hasła</a>
					</div>
				  </div>
				  <div class="modal-footer">
					<button type="submit" class="btn btn-primary" form="nameform">Zaloguj się</button>
				  </div>
				</div>
			</div>
		</div>
	</div>
	<!-- Horizontal Steppers -->
	<div class="row tut121">
	  <div class="col-md-12">
		<!-- Stepers Wrapper -->
		<ul class="stepper stepper-horizontal">
		  <!-- First Step -->
		  <li class="completed">
			<a href="#!">
			  <span class="circle">1</span>
			  <span class="label">Zaloguj się na swoje konto</span>
			</a>
		  </li>
		  <!-- Second Step -->
		  <li class="active">
			<a href="#!">
			  <span class="circle">2</span>
			  <span class="label">Możesz zmienić hasło</span>
			</a>
		  </li>
		  <!-- Third Step -->
		  <li class="active">
			<a href="#!">
			  <span class="circle"><i class="fas fa-check"></i></span>
			  <span class="label">Zacznij korzystać z librusa</span>
			</a>
		  </li>
		</ul>
		<!-- /.Stepers Wrapper -->
	  </div>
	</div>
	<!-- /.Horizontal Steppers -->
	<div class="container my-5 py-5 z-depth-1">
  <!--Section: Content-->
  <section class="dark-grey-text text-center">
    
    <h3 class="font-weight-bold pt-5 pb-2">Nowa generacje e-dziennika</h3>

    <div class="row mx-3">
      <div class="col-md-4 px-4 mb-4">

        <div class="view">
          <img src="https://mdbootstrap.com/img/illustrations/drawkit-drawing-man-colour.svg" class="img-fluid" alt="smaple image">
        </div>

      </div>
     <div class="col-md-4 px-4 mb-4">

        <div class="view">
          <img src="https://mdbootstrap.com/img/illustrations/drawkit-phone-conversation-colour.svg" class="img-fluid" alt="smaple image">
        </div>

      </div>
      <div class="col-md-4 px-4 mb-4">

        <div class="view">
          <img src="https://mdbootstrap.com/img/illustrations/app-user-colour.svg" class="img-fluid" alt="smaple image">
        </div>

      </div>
    </div>

  </section>
  <!--Section: Content-->


</div>
</div>

<script>
function forgot(){
	Swal.fire('Ta funkcja jest wyłączona dla twojej szkoły. <br />-----<br /> Jeżeli zapomoniałeś hasła zgłoś się do wychowawcy lub dyrektora szkoły')
}

</script>