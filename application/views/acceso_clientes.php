	<!-- Title Page -->
	<section class="bg-title-page p-t-40 p-b-50 flex-col-c-m" style="background-color: black; min-height: 150px;">
		<h2 class="l-text3 t-center">
			Ingreso para clientes
		</h2>
	</section>

	<!-- content page -->
	<section class="bgwhite p-t-66 p-b-60">
		<div class="container">
			<div class="row justify-content-md-center">
				<div class="col-md-6 p-b-30 text-center">
					<form id="form_codigo" class="edit-your-profile" method="post" action="<?php echo base_url(); ?>login/ingreso_cliente">
						<div class="form-group">
							<label for="nombre">Ingrese su n&uacute;mero de documento, correo electr&oacute;nico o n&uacute;mero celular</label>
							<input type="text" class="form-control" id="datos_codigo" name="datos_codigo" aria-describedby="emailHelp" placeholder="" required>
						</div>

						<div class="form-group mt-5">
							<label for="nombre">Ingrese su c&oacute;digo de acceso. Si no lo tiene, presione el bot&oacute;n solicitar</label>
							<input type="text" class="form-control" id="codigo_acceso" name="codigo_acceso" aria-describedby="emailHelp" placeholder="" required>							
						</div>
						<div>
							<div class="w-size25 margin-center mt-3 dis-inline-block">
								<button id="btn-codigo" type="submit" class="flex-c-m size2 bo1 bo-rad-23 hov1 m-text3 trans-0-4">Ingresar</button>							
							</div>
							<div class="w-size25 margin-center mt-3 dis-inline-block">
								<button id="btn-solicitar" type="button" class="flex-c-m size2 bo1 bo-rad-23 hov1 m-text3 trans-0-4">Solicitar</button>
							</div>
						</div>
						<?php if ($this->session->flashdata('error_acceso')!=null) : ?>
							<div class="alert alert-warning alert-dismissible mt-4">
								<button type="button" class="close" data-dismiss="alert">&times;</button>
								<?php echo $this->session->flashdata('error_acceso'); ?>
							</div>
						<?php endif; ?>

					</form>
				</div>
			</div>
		</div>
	</section>
