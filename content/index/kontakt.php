<!--Section: Contact v.2-->
<div class="container animate-bottom">
	<section class="mb-4">
		<!--Section heading-->
		<h1 class="h1-responsive text-center my-4">Kontakt</h1>
		<!--Section description-->
		<p class="text-center w-responsive mx-auto mb-5">Masz jakieś pytania? Potrzebujesz pomocy? Napisz na naszego e-maila, lub uzupełnij poniższy formularz, a odpiszemy do ciebie jak najszybciej </p>

		<div class="row">

			<!--Grid column-->
			<div class="col-md-9 mb-md-0 mb-5">
				<form id="contact-form" name="contact-form" action="./database/mail.php" method="POST">

					<!--Grid row-->
					<div class="row">

						<!--Grid column-->
						<div class="col-md-6">
							<div class="md-form mb-0">
								<input type="text" id="name" name="name" class="form-control" placeholder="Imię i nazwisko">
							</div>
						</div>
						<!--Grid column-->

						<!--Grid column-->
						<div class="col-md-6">
							<div class="md-form mb-0">
								<input type="text" id="email" name="email" class="form-control" placeholder="E-mail">
							</div>
						</div>
						<!--Grid column-->

					</div>
					<!--Grid row-->

					<!--Grid row-->
					<div class="row">
						<div class="col-md-12">
							<div class="md-form mb-0">
								<input type="text" id="subject" name="subject" class="form-control" placeholder="Tytuł">
							</div>
						</div>
					</div>
					<!--Grid row-->

					<!--Grid row-->
					<div class="row">

						<!--Grid column-->
						<div class="col-md-12">

							<div class="md-form">
								<textarea type="text" id="message" name="message" rows="2" class="form-control md-textarea" placeholder="Wiadomość"></textarea>
							</div>

						</div>
					</div>
					<!--Grid row-->

				</form>

				<div class="text-center text-md-left">
					<a class="btn btn-primary" onclick="document.getElementById('contact-form').submit();">Wyślij</a>
				</div>
				<div class="status"></div>
			</div>
			<!--Grid column-->

			<!--Grid column-->
			<div class="col-md-3 text-center">
				<ul class="list-unstyled mb-0">
					<li><i class="fas fa-phone mt-4 fa-2x"></i>
						<p><a href="tel:+48795406209">+ 795-406-209</a></p>
					</li>

					<li><i class="fas fa-envelope mt-4 fa-2x"></i>
						<p><a href="mailto:emikscura123@gmail.com">IQspace.kontakt@gmail.com</a></p>
					</li>
				</ul>
			</div>
			<!--Grid column-->

		</div>

	</section>
	<hr style="width:100%; marign:auto;">
	<div class="container my-5 z-depth-1">
	<!--Section: Content-->
	<section class="dark-grey-text p-5">
		<!-- Grid row -->
		<div class="row">
		  <!-- Grid column -->
		  <div class="col-md-5 mb-4 mb-md-0">
			<div class="view">
			  <img src="https://mdbootstrap.com/img/illustrations/undraw_Group_chat_unwm.svg" class="img-fluid" alt="smaple image">
			</div>
		  </div>
		  <!-- Grid column -->
		  <div class="col-md-7 mb-lg-0 mb-4">
			<!-- Form -->
			<form action="#" method="POST">
			  <!-- Section heading -->
			  <h3 class="font-weight-bold my-3">Zapisz się na nasz newsletter</h3>
			  <p class="text-muted mb-4 pb-2">Lorem ipsum dolor sit amet consectetur adipisicing elit. Quibusdam vitae, fuga similique quos aperiam tenetur quo ut rerum debitis.</p>
			  <div class="input-group">
				<input id="email" type="email" class="form-control" placeholder="Chwilowo niedostępne" name="email">
				<div class="input-group-append">
				  <button type="button" class="btn btn-md btn-primary rounded-right m-0 px-3 py-2 z-depth-0 waves-effect" disabled>Zapisz się</button>
				</div>
			  </div>
			  <small class="form-text black-text"><strong>* Zapisz się na newsletter, aby zostać powiadomionym o wszystkich nowościachzz.</strong></small>
			</form>
			<!-- Form -->
		  </div>
		  <!-- Grid column -->
		</div>
		<!-- Grid row -->
	  </section>
	<!--Section: Content-->


</div>
</div>
<!--Section: Contact v.2-->