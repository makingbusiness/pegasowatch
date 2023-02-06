	<!-- Title Page -->
	<section class="bg-title-page p-t-40 p-b-50 flex-col-c-m" style="background-image: url(imagenes/banner/heading-pages-06.jpg);">
		<h2 class="l-text2 t-center">
			Cont&aacute;ctanos
		</h2>
	</section>

	<!-- content page -->
	<section class="bgwhite p-t-66 p-b-60">
		<div class="container">
			<div class="row">
				<!--div class="col-md-6 p-b-30">
					<iframe id="map-container" src="https://www.google.com/maps/embed?pb=!1m18!1m12!1m3!1d63457.52241233765!2d-75.6082793208984!3d6.25119220000002!2m3!1f0!2f0!3f0!3m2!1i1024!2i768!4f13.1!3m3!1m2!1s0x8e44296a08ffc7a1%3A0x5a1b47863d44f20a!2sEdificio+Bodegas+De+La+Candelaria!5e0!3m2!1ses-419!2sco!4v1536850527001"></iframe>
				</div-->

				<div class="col-md-6 p-b-30">
					<form id="form_contacto" class="leave-comment" method="post" action="<?php echo base_url(); ?>contacto/agregar_mensaje">
						<?php if ($this->session->flashdata('contacto_sitio')) : ?>
							<div class="alert alert-success" role="alert">
								<?php echo $this->session->flashdata('contacto_sitio'); ?>
							</div>
						<?php endif; ?>

						<h4 class="m-text26 p-b-36 p-t-15">Env&iacute;anos un mensaje</h4>

						<div class="bo4 of-hidden size15 m-b-20">
							<input class="sizefull s-text7 p-l-22 p-r-22" type="text" id="name_contact" name="name" placeholder="Nombre completo" required=true>
						</div>

						<div class="bo4 of-hidden size15 m-b-20">
							<input class="sizefull s-text7 p-l-22 p-r-22" type="number" name="phone" placeholder="Número de telefono" required=true>
						</div>

						<div class="bo4 of-hidden size15 m-b-20">
							<input class="sizefull s-text7 p-l-22 p-r-22" type="email" name="email" placeholder="Correo electronico" required=true>
						</div>

						<textarea class="dis-block s-text7 size20 bo4 p-l-22 p-r-22 p-t-13 m-b-20" name="message" placeholder="Mensaje ..." required=true></textarea>

						<div class="mb-3">
						<small>Este sitio está protegido por reCAPTCHA y se aplican la <a href="https://policies.google.com/privacy">política de privacidad</a> y <a href="https://policies.google.com/terms">términos del servicio</a> de Google.</small>
						</div>

						<div class="w-size25">
							<button type="submit" class="flex-c-m size2 bg1 bo-rad-23 hov1 m-text3 trans-0-4">Enviar</button>
						</div>

					</form>
				</div>
				
				<div class="col-md-6 p-b-30">
					<div class="p-t-50 p-l-100">						
    	                <p>
							<i class="fa fa-phone" aria-hidden="true"></i>
							<a href="tel:" class="p-l-5"><?php echo ($this->session->moneda_usuario == 'USD' ? $this->config->item('telefono_contacto') : $this->config->item('telefono_contacto2')); ?></a>
						</p>
                    </div>
                    <div class="p-t-50 p-l-100">
                        <p>
							<i class="fa fa-envelope-o" aria-hidden="true"></i>
							<a href="mailto:info@makingbusiness.com.co"><?php echo ($this->session->moneda_usuario == 'USD' ? $this->config->item('correo_contacto') : $this->config->item('correo_contacto2')); ?></a>
						</p>
                    </div>
				</div>
			</div>
		</div>
	</section>
