<?php 
$ruta = 'imagenes/banner/home/slider/*.*';
$archivos = glob($ruta);

$rutaLogos = './imagenes/logos/*.*';
$logos = glob($rutaLogos);
//echo 'Total imagenes en '.$ruta.'='.count($archivos);
 ?>
	<!-- Slide -->
	<section class="slide1">
		<div class="wrap-slick1">
			<div class="slick1">
				<?php foreach($archivos as $archivo) : ?>
				<div class="item-slick1 item1-slick1 img-fluid" style="background-image: url(<?php echo $this->config->item('base_url').$archivo; ?>);">
					<div class="wrap-content-slide1 sizefull flex-col-c-m p-l-15 p-r-15 p-t-150 p-b-170">
						<?php if (strpos($archivo,strval($this->config->item('instancia_ppal_reloj')))) : ?>
						<span class="caption1-slide1 m-text1 t-center animated visible-false m-b-15" data-appear="fadeInDown">
							A un clic de distancia
						</span>

						<hidden id="hidBanner" value="<?php echo $archivo; ?>"></hidden>

						<h2 class="caption2-slide1 xl-text1 t-center animated visible-false m-b-37" data-appear="fadeInUp">
							Relojería Original
						</h2>
						<?php endif; ?>
						<div class="wrap-btn-slide1 w-size1 animated visible-false" data-appear="zoomIn">
							<!-- Button -->
							<?php 
								$instancia = explode('_', pathinfo($archivo, PATHINFO_FILENAME))[1];
							?>
							<a href="<?php echo base_url(); ?>productos/tipo/<?php echo $instancia; ?>/1" class="flex-c-m size2 bo-rad-23 s-text2 bgwhite hov1 trans-0-4">
								Ver mas
							</a>
						</div>
					</div>
				</div>
				<?php endforeach; ?>
			</div>
		</div>
	</section>

	<!-- Marcas manejadas -->
	<?php if ($this->config->item('instancias_todas') == 'S') : ?>
		<section class="brands">
			<?php foreach($logos as $logo): ?>
				<div>
					<img src="<?php echo base_url().$logo; ?>">
				</div>
			<?php endforeach; ?>
		</section>
	<?php endif; ?>
	<br>	

	<!-- Categorias1 -->
	<section class="banner1 bg5 p-t-55 p-b-55">
		<div class="container">
			<div class="row">
				<div class="col-sm-10 col-md-8 col-lg-6 m-l-r-auto p-t-15 p-b-15">
					<div class="hov-img-zoom pos-relative">
						<img src="<?php echo base_url(); ?>imagenes/banner/home/pegaso_reloj.jpg" alt="IMG-BANNER">

						<div class="ab-t-l sizefull flex-col-c-m p-l-15 p-r-15">


							<a href="<?php echo base_url() ?>productos/tipo/<?php echo $this->config->item('instancia_ppal_reloj'); ?>/1" class="s-text4 p-t-20 ">
								<h3 class="l-text1 fs-35-sm">
									Relojes
								</h3>
							</a>
						</div>
					</div>
				</div>

				<?php if ($this->config->item('instancias_todas') == 'N') : ?>
				<div class="col-sm-10 col-md-8 col-lg-6 m-l-r-auto p-t-15 p-b-15">
					<div class="bgwhite hov-img-zoom pos-relative p-b-20per-ssm">
						<img src="<?php echo base_url(); ?>imagenes/banner/home/pulso.jpg" alt="IMG-BANNER-PULSOS">
						<div class="ab-t-l sizefull flex-col-c-m p-l-15 p-r-15">
							<a href="<?php echo base_url(); ?>productos/tipo/<?php echo $this->config->item('instancia_base_pulso'); ?>/1" class="m-text4 p-t-20 ">
								<h3 class="l-text1 fs-35-sm">
									Pulsos
								</h3>
							</a>
						</div>
					</div>
				</div>
				<?php endif; ?>
			</div>
		</div>
	</section>

	<!-- Shipping -->
	<section class="shipping bgblack p-t-62 p-b-46">
		<div class="flex-w p-l-15 p-r-15">
			<div class="flex-col-c w-size5 p-l-15 p-r-15 p-t-16 p-b-15 respon1">
				<h4 class="m-text13 t-center">
					Entregas en 24 horas
				</h4>
				<span class="s-text23 t-center">
					Rastrea tu producto mientras llega
				</span>
			</div>

			<div class="flex-col-c w-size5 p-l-15 p-r-15 p-t-16 p-b-15 bo2 respon2">
				<h4 class="m-text13 t-center">
					Hasta 3 meses de garantía
				</h4>
				<span class="s-text23 t-center">
					Aplican restricciones
				</span>
			</div>

			<div class="flex-col-c w-size5 p-l-15 p-r-15 p-t-16 p-b-15 respon1">
				<h4 class="m-text13 t-center">
					Compras al por mayor
				</h4>
				<span class="m-text13 t-center w-size1">
					<a class="flex-c-m size2 bo-rad-23 s-text2 bgwhite hov1 trans-0-4" href="<?php echo base_url(); ?>contacto">Contáctanos</a>
				</span>
			</div>
		</div>
	</section>

	<!-- Categorias2 -->
	<?php if ($this->config->item('instancias_todas') == 'S') : ?>
		<section class="banner2 bg5 p-t-55 p-b-55">
			<div class="container">
				<div class="row">
					<div class="col-sm-10 col-md-8 col-lg-6 m-l-r-auto p-t-15 p-b-15">
						<div class="bgwhite hov-img-zoom pos-relative p-b-20per-ssm">
							<img src="<?php echo base_url(); ?>imagenes/banner/home/calculadoras.jpg" alt="IMG-BANNER">
							<div class="ab-t-l sizefull flex-col-c-m p-l-15 p-r-15">
								<a href="<?php echo base_url(); ?>productos/tipo/<?php echo $this->config->item('instancia_ppal_calculadora'); ?>/1" class="m-text4 p-t-20 ">
									<h3 class="l-text1 fs-35-sm">
										Calculadoras
									</h3>
								</a>
							</div>
						</div>
					</div>

					<div class="col-sm-10 col-md-8 col-lg-6 m-l-r-auto p-t-15 p-b-15">
						<div class="hov-img-zoom pos-relative">
							<img src="<?php echo base_url(); ?>imagenes/banner/home/pilas.gif" alt="IMG-BANNER">
							<div class="ab-t-l sizefull flex-col-c-m p-l-15 p-r-15">
								<a href="<?php echo base_url(); ?>productos/tipo/<?php echo $this->config->item('instancia_base_bateria'); ?>/1" class="s-text4 p-t-20 ">
									<h3 class="l-text1 fs-35-sm">
										Baterias
									</h3>
								</a>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
	<?php endif; ?>