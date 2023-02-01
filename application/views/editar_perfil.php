	<!-- Title Page -->
	<section class="bg-title-page p-t-40 p-b-50 flex-col-c-m" style="background-color: black;">
		<h2 class="l-text2 t-center">
			Editar Perfil
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
					<form id="edit-profile" class="edit-your-profile" method="post" action="<?php echo base_url(); ?>usuarios/actualizar">
						<div class="form-group">
							<label for="nombre">Nombres</label>
							<input type="text" class="form-control" name="nombre" aria-describedby="emailHelp" placeholder="" value="<?php echo $this->session->Nombres; ?>" required=true>
						</div>

						<div class="form-group">
							<label for="apellido">Apellidos</label>
							<input type="text" class="form-control" name="apellido" aria-describedby="emailHelp" placeholder="" value="<?php echo $this->session->Apellidos; ?>" required=true>
						</div>

						<div class="form-group">
							<label for="cc">Cédula de Ciudadanía</label>
							<input type="number" class="form-control" name="cc" aria-describedby="emailHelp" placeholder="" value="<?php echo $this->session->CodClie; ?>" required=true>
						</div>

						<div class="form-group">
							<label for="correo">Correo Electrónico</label>
							<input type="email" class="form-control" name="correo" aria-describedby="emailHelp" placeholder="Email" value="<?php echo $this->session->Email; ?>" required=true>
						</div>

						<div class="form-group">
							<label for="celular">Teléfono celular</label>
							<input type="number" class="form-control" name="celular" aria-describedby="emailHelp" placeholder="" value="<?php echo $this->session->telefonoEnvio; ?>">
						</div>

						<div class="form-group">
							<label for="pais">Pa&iacute;s</label>
							<select class="form-control" name="pais" id="paisUsuario" aria-describedby="emailHelp">
								<?php foreach(lista_paises() as $pais) : ?>
									<option value="<?php echo $pais->IDPais; ?>" <?php if ($pais->IDPais == $this->session->paisEnvio) : ?>selected<?php endif; ?>><?php echo $pais->Descrip; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						
						<div class="form-group">
							<label for="departamento">Estado</label>
							<select class="form-control" name="estado" id="estadoUsuario" aria-describedby="emailHelp">
								<?php foreach(lista_estados($this->session->paisEnvio) as $estado) : ?>
									<option value="<?php echo $estado->IDEstado; ?>" <?php if ($estado->IDEstado == $this->session->estadoEnvio) : ?>selected<?php endif; ?>><?php echo $estado->Descrip; ?></option>
								<?php endforeach; ?>
							</select>
						</div>

						<div class="form-group">
							<label for="direccion">Ciudad</label>
							<select class="form-control" name="ciudad" id="ciudadUsuario" aria-describedby="emailHelp">
								<?php foreach(lista_ciudades($this->session->estadoEnvio,$this->session->paisEnvio) as $ciudad) : ?>
									<option value="<?php echo $ciudad->IDCiudad; ?>" <?php if ($ciudad->IDCiudad == $this->session->ciudadEnvio) : ?>selected<?php endif; ?>><?php echo $ciudad->Descrip; ?></option>
								<?php endforeach; ?>
							</select>
						</div>

						<div class="form-group">
							<label for="direccion">Dirección</label>
							<input type="adress" class="form-control" name="direccion" aria-describedby="emailHelp" placeholder="" value="<?php echo $this->session->direccionEnvio; ?>">
						</div>

						<div class="w-size25 margin-center">
							<button type="submit" class="flex-c-m size2 bo1 bo-rad-23 hov1 m-text3 trans-0-4">Editar</button>
						</div>
					</form>
				</div>
			</div>
		</div>
	</section>