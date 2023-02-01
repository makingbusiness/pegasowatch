	<!-- Suscripcion -->
	<!--section class="subscribe">
		<form id="form_suscripcion" class="container" method="post" action="<?php echo base_url(); ?>usuarios/suscripcion">
			<div class="form-content">
				<input type="text" class="form-control col-xs-3" placeholder="Nombre" name="nombre_suscrip" id="nombre_suscrip" required=true>
				<input type="email" class="form-control col-xs-3" placeholder="Correo electronico" name="email_suscrip" id="email_suscrip" required=true>
				<button type="submit" class="btn">Suscribirse</button>
				<div id="resultado"></div>
			</div>
		</form>
	</section-->

	<!-- Footer -->
	<footer class="bgblack p-t-45 p-b-43 p-l-45 p-r-45">
		<div class="flex-w p-b-90">
			<div class="w-size6 p-t-30 p-l-15 p-r-15 respon3 m-l-80">
				<!--h4 class="s-text1 p-b-30">
					Encu&eacute;ntranos
				</h4-->

				<div>
					<p class="s-text10 w-size27">
						L&iacute;nea de contacto: <?php echo ($this->session->moneda_usuario == 'USD' ? $this->config->item('telefono_contacto') : $this->config->item('telefono_contacto2')); ?>
					</p>
				</div>
				<img class="logo-footer" src="<?php echo base_url(); ?>imagenes/icons/logo-gray.png">
			</div>

			<div class="w-size7 p-t-30 p-l-15 p-r-15 respon4 m-r-80 m-l-80">
				<h4 class="s-text1 p-b-30">
					Categorias
				</h4>

				<ul>
					<li class="p-b-9">
						<a href="<?php echo base_url() ;?>productos/tipo/<?php echo $this->config->item('instancia_ppal_reloj'); ?>/1" class="m-text1">
							Relojes
						</a>
					</li>

					<?php if ($this->session->IDTipoUsuario!='1' || $this->config->item('instancias_todas') == 'N') : ?>
						<li class="p-b-9">
							<a href="<?php echo base_url() ;?>productos/tipo/<?php echo $this->config->item('instancia_base_pulso'); ?>/1" class="m-text1">
								Pulsos
							</a>
						</li>
					<?php endif; ?>

					<?php if ($this->config->item('instancias_todas') == 'S') : ?>
						<li class="p-b-9">
							<a href="<?php echo base_url() ;?>productos/tipo/<?php echo $this->config->item('instancia_ppal_calculadora'); ?>/1" class="m-text1">
								Calculadoras
							</a>
						</li>

						<li class="p-b-9">
							<a href="<?php echo base_url() ;?>productos/tipo/<?php echo $this->config->item('instancia_base_bateria'); ?>/1" class="m-text1">
								Baterias
							</a>
						</li>

						<li class="p-b-9">
							<a href="<?php echo base_url() ;?>productos/tipo/<?php echo $this->config->item('instancia_base_herramienta'); ?>/1" class="m-text1">
								Herramientas
							</a>
						</li>
					<?php endif; ?>
				</ul>
			</div>

			<div class="w-size7 p-t-30 p-l-15 p-r-15 respon4">
				<h4 class="s-text1 p-b-30">
					Links
				</h4>

				<ul>
					<!--li class="p-b-9">
						<a href="#" class="s-text10">
							Buscar
						</a>
					</li-->

					<li class="p-b-9">
						<a href="<?php echo base_url(); ?>contacto" class="s-text10">
							Cont&aacute;ctenos
						</a>
					</li>
				</ul>
			</div>
		</div>

		<div class="t-center p-l-15 p-r-15">
			<a href="#">
				<img class="h-size2" src="<?php echo base_url(); ?>imagenes/icons/visa.png" alt="IMG-VISA">
			</a>

			<a href="#">
				<img class="h-size2" src="<?php echo base_url(); ?>imagenes/icons/mastercard.png" alt="IMG-MASTERCARD">
			</a>

			<a href="#">
				<img class="h-size2" src="<?php echo base_url(); ?>imagenes/icons/express.png" alt="IMG-EXPRESS">
			</a>

			<div class="t-center s-text8 p-t-20">
				Copyright © <?php echo date('Y'); ?> All rights reserved. | Made by <a href="https://colorlib.com" target="_blank">CX Agency</a>
			</div>
		</div>
	</footer>

	<?php $mostrar = false;
	if ($mostrar) : ?>
	<!-- Redes y Ofertas -->
	<div id="off-slide">
		<div class="container">
			<div class="row">
				<div class="col-md-1"></div>
				<div class="col-md-5 col-sm-6">
					<!-- Block2 -->
					<div class="block2">
						<div class="block2-img wrap-pic-w of-hidden pos-relative block2-labelsale">
							<img src="<?php echo base_url(); ?>imagenes/item-07.jpg" alt="IMG-PRODUCT">

							<div class="block2-overlay trans-0-4">
								<a href="#" class="block2-btn-addwishlist hov-pointer trans-0-4">
									<i class="icon-wishlist icon_heart_alt" aria-hidden="true"></i>
									<i class="icon-wishlist icon_heart dis-none" aria-hidden="true"></i>
								</a>

								<div class="block2-btn-addcart w-size1 trans-0-4">
									<!-- Button -->
									<button class="flex-c-m size1 bg4 bo-rad-23 hov1 s-text14 trans-0-4">
										Añadir al carrito
									</button>
								</div>
							</div>
						</div>

						<div class="block2-txt p-t-20">
							<a href="<?php echo base_url(); ?>product-detail" class="block2-name dis-block s-text3 p-b-5">
								Reloj Cassio 1
							</a>

							<span class="block2-oldprice m-text7 p-r-5">
								$98.500
							</span>

							<span class="block2-newprice m-text8 p-r-5">
								$81.900
							</span>
						</div>
					</div>
				</div>
				<div class="col-md-5 col-sm-6">
					<!-- Block2 -->
					<div class="block2">
						<div class="block2-img wrap-pic-w of-hidden pos-relative block2-labelsale">
							<img src="<?php echo base_url(); ?>imagenes/item-07.jpg" alt="IMG-PRODUCT">

							<div class="block2-overlay trans-0-4">
								<a href="#" class="block2-btn-addwishlist hov-pointer trans-0-4">
									<i class="icon-wishlist icon_heart_alt" aria-hidden="true"></i>
									<i class="icon-wishlist icon_heart dis-none" aria-hidden="true"></i>
								</a>

								<div class="block2-btn-addcart w-size1 trans-0-4">
									<!-- Button -->
									<button class="flex-c-m size1 bg4 bo-rad-23 hov1 s-text14 trans-0-4">
										Añadir al carrito
									</button>
								</div>
							</div>
						</div>

						<div class="block2-txt p-t-20">
							<a href="<?php echo base_url(); ?>product-detail" class="block2-name dis-block s-text3 p-b-5">
								Reloj Cassio 2
							</a>

							<span class="block2-oldprice m-text7 p-r-5">
								$129.850
							</span>

							<span class="block2-newprice m-text8 p-r-5">
								$95.900
							</span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="dark-off">
			<div class="banner">
				<p>Lleva</p>
				<p>hasta</p>
				<p>10%</p>
				<p>Dcto</p>
				<p></p>
				<a href="#">Ver mas ofertas</a>
			</div>
		</div>
	</div>
	<div class="dark-curtain"></div>
	<div class="btn-off" id="myOff">
		<ul>
			<li>
				<a
				target="_blank"
				rel="noopener noreferrer"
				class="fs-20 color1 p-r-20 fa fa-facebook"
				href="https://www.facebook.com/MakingBusiness2014/" >
				</a>
			</li>
			<li><a href="#" class="fs-20 color1 p-r-20 fa fa-instagram"></a></li>
			<li><a href="#" class="fs-20 color1 p-r-20 fa fa-pinterest-p"></a></li>
			<li><a href="#" class="fs-18 color1 p-r-20 fa fa-snapchat-ghost"></a></li>
			<li><a href="#" class="m-text6 bg0-hov" id="ofertas">OFERTAS</a></li>
		</ul>
	</div>

	<!-- Boton top -->
	<div class="btn-back-to-top bg0-hov" id="myBtn">
		<span class="symbol-btn-back-to-top">
			<i class="fa fa-angle-double-up" aria-hidden="true"></i>
		</span>
	</div>

	<!-- Container Selection1 -->
	<div id="dropDownSelect1"></div>
	<?php endif; ?>

<!--===============================================================================================-->
	<script type="text/javascript" src="<?php echo base_url(); ?>vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script type="text/javascript" src="<?php echo base_url(); ?>vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script type="text/javascript" src="<?php echo base_url(); ?>vendor/bootstrap/js/popper.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>vendor/bootstrap/js/bootstrap.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>vendor/bootstrap/js/bootstrap.bundle.min.js"></script>	
<!--===============================================================================================-->
	<script type="text/javascript" src="<?php echo base_url(); ?>vendor/select2/select2.min.js"></script>
<!--===============================================================================================-->
	<script type="text/javascript" src="<?php echo base_url(); ?>vendor/daterangepicker/moment.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>vendor/daterangepicker/daterangepicker.js"></script>	
<!--===============================================================================================-->
	<script type="text/javascript" src="<?php echo base_url(); ?>vendor/slick/slick.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/slick-custom.js"></script>
<!--===============================================================================================-->
	<script type="text/javascript" src="<?php echo base_url(); ?>vendor/countdowntime/countdowntime.js"></script>
<!--===============================================================================================-->
	<script type="text/javascript" src="<?php echo base_url(); ?>vendor/lightbox2/js/lightbox.min.js"></script>
<!--===============================================================================================-->
	<script type="text/javascript" src="<?php echo base_url(); ?>vendor/sweetalert/sweetalert.min.js"></script>
<!--===============================================================================================-->
	<script type="text/javascript" src="<?php echo base_url(); ?>vendor/parallax100/parallax100.js"></script>
<!--===============================================================================================-->
	<script type="text/javascript" src="<?php echo base_url(); ?>vendor/owlcarousel/owl.carousel.min.js"></script>
	
	<script type="text/javascript" src="<?php echo base_url(); ?>vendor/noui/nouislider.min.js"></script>
	<script type="text/javascript">
		/*[ No ui ]
	    ===========================================================*/
	    var filterBar = document.getElementById('filter-bar');

	    noUiSlider.create(filterBar, {
	        start: [ 1000, 2000000 ],
	        connect: true,
	        range: {
	            'min': 1000,
	            'max': 2000000
	        }
	    });

	    var skipValues = [
	    document.getElementById('value-lower'),
	    document.getElementById('value-upper')
	    ];

	    filterBar.noUiSlider.on('update', function( values, handle ) {
	        skipValues[handle].innerHTML = Math.round(values[handle]) ;
	    });	
	</script>
	<!--Start of Tawk.to Script-->
		<script type="text/javascript">
		var Tawk_API=Tawk_API||{}, Tawk_LoadStart=new Date();
		(function(){
		var s1=document.createElement("script"),s0=document.getElementsByTagName("script")[0];
		s1.async=true;
		s1.src='https://embed.tawk.to/5bbbd680b8198a041048b956/default';
		s1.charset='UTF-8';
		s1.setAttribute('crossorigin','*');
		s0.parentNode.insertBefore(s1,s0);
		})();
		</script>
	<!--End of Tawk.to Script-->

	<!-- Llamar Recaptcha de Google -->
	<script src="https://www.google.com/recaptcha/api.js?render=6LeobMYZAAAAAHFQarovUsW5bB3x9K_whthxLS6Q"></script>
	
	<script src="<?php echo base_url(); ?>js/varios.js"></script>
	<script src="<?php echo base_url(); ?>js/main.js"></script>

	<script>
		var BASE_URL = "<?php echo base_url();?>";
		var BASE_IMG = "<?php echo $this->config->item('base_imagenes');?>";		
	</script>

	<script>
		if ('loading' in HTMLImageElement.prototype) {
			// Si el navegador soporta lazy-load, tomamos todas las imágenes que tienen la clase
			// `lazyload`, obtenemos el valor de su atributo `data-src` y lo inyectamos en el `src`.
			const images = document.querySelectorAll("img.lazyload");
			images.forEach(img => {
				img.src = img.dataset.src;
			});
		} else {
			// Importamos dinámicamente la libreria `lazysizes`
			let script = document.createElement("script");
			script.async = true;
			script.src = "https://cdnjs.cloudflare.com/ajax/libs/lazysizes/5.2.0/lazysizes.min.js";
			document.body.appendChild(script);
		}
	</script>

	<!-- Facebook Pixel Code -->
	<script>
		!function(f,b,e,v,n,t,s)
		{if(f.fbq)return;n=f.fbq=function(){n.callMethod?
		n.callMethod.apply(n,arguments):n.queue.push(arguments)};
		if(!f._fbq)f._fbq=n;n.push=n;n.loaded=!0;n.version='2.0';
		n.queue=[];t=b.createElement(e);t.async=!0;
		t.src=v;s=b.getElementsByTagName(e)[0];
		s.parentNode.insertBefore(t,s)}(window, document,'script',
		'https://connect.facebook.net/en_US/fbevents.js');
		fbq('init', '2271490889650330');
		fbq('track', 'PageView');
	</script>
	<noscript>
		<img height="1" width="1" style="display:none" src="https://www.facebook.com/tr?id=2271490889650330&ev=PageView&noscript=1" />
	</noscript>
	<!-- End Facebook Pixel Code -->
</body>
</html>
