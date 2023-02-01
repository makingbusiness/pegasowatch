	<!-- Title Page -->
	<section class="bg-title-page p-t-40 p-b-50 flex-col-c-m" style="background-color: black; min-height: 150px;">
		<h2 class="l-text3 t-center">
			Recuperar contraseña
		</h2>
		<p class="s-text1">Enviaremos los pasos a tu correo</p>
	</section>

	<!-- content page -->
	<section class="bgwhite p-t-66 p-b-60">
		<div class="container">
			<div class="row justify-content-md-center">
				<div class="col-md-6 p-b-30 text-center">
					<form id="form_recuperar" class="edit-your-profile" method="post" action="<?php echo base_url(); ?>usuarios/consulta_usuario_correo">
						<div class="form-group">
							<label for="nombre">Ingrese su correo</label>
							<input type="text" class="form-control" id="nombre_recuperar" name="email" aria-describedby="emailHelp" placeholder="">
						</div>

						<div class="w-size25 margin-center">
							<button type="submit" class="flex-c-m size2 bo1 bo-rad-23 hov1 m-text3 trans-0-4">Enviar</button>
						</div>


					</form>
				</div>
			</div>
		</div>
	</section>
