	<!-- Title Page -->
	<section class="bg-title-page p-t-40 p-b-50 flex-col-c-m" style="background-color: black;">
		<h2 class="l-text2 t-center">
			Cambio de clave
		</h2>
	<div class="text-center profile-img">
	  <img src="<?php echo base_url(); ?>imagenes/banner/profile-image.png"  alt="profile-image">
	</div>
	</section>

	<!-- content page -->
	<section class="bgwhite p-t-66 p-b-60">
		<div class="container">
			<div class="row justify-content-md-center">
				<div class="col-md-6 p-b-30 text-center">
					<form id="frm-cambioClave" class="edit-your-profile" method="post" action="<?php echo base_url(); ?>usuarios/actualizaClave">
						<div class="form-group">
							<label for="nombre">Contrase&ntilde;a anterior</label>
							<input type="password" class="form-control" name="claveAnt" aria-describedby="emailHelp" placeholder="" value="" required=true>
						</div>

						<div class="form-group">
							<label for="apellido">Contrase&ntilde;a nueva</label>
							<input type="password" class="form-control" id="claveNueva" name="claveNueva" aria-describedby="emailHelp" placeholder="" value="" required=true>
						</div>

						<div class="form-group">
							<label for="cc">Repetir contrase&ntilde;a</label>
							<input type="password" class="form-control" id="verificarClave" name="verificarClave" aria-describedby="emailHelp" placeholder="" value="" required=true>
						</div>

						<div class="w-size25 margin-center">
							<button type="submit" class="flex-c-m size2 bo1 bo-rad-23 hov1 m-text3 trans-0-4">Actualizar</button>
						</div>
						
						<div id="err_cambioClave"></div>
					</form>
				</div>
			</div>
		</div>
	</section>