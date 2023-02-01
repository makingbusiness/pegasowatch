<?php 
	$esManilla = false; 
	$codigoImp = '';
	$rutaImp = '';
?>
<!DOCTYPE html>
<html lang="en">
<head>
	<title><?php echo $this->config->item('titulo_pagina'); ?></title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="<?php echo base_url(); ?>imagenes/icons/favicon.png"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>vendor/bootstrap/css/bootstrap.min.css">
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>fonts/fontawesome-free-5.15.4-web/css/fontawesome.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>fonts/fontawesome-free-5.15.4-web/css/brands.min.css">	
	<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>fonts/font-awesome-4.7.0/css/font-awesome.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>fonts/themify/themify-icons.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>fonts/Linearicons-Free-v1.0.0/icon-font.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>fonts/elegant-font/html-css/style.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>vendor/animate/animate.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>vendor/css-hamburgers/hamburgers.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>vendor/animsition/css/animsition.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>vendor/select2/select2.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>vendor/daterangepicker/daterangepicker.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>vendor/slick/slick.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>vendor/noui/nouislider.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>vendor/lightbox2/css/lightbox.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>vendor/owlcarousel/owl.carousel.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>vendor/owlcarousel/owl.theme.default.min.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/varios.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/util.css">	
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/main.css">
<!--===============================================================================================-->

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=G-TSJ3T85K2W"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'G-TSJ3T85K2W');
</script>

</head>
<body class="animsition">

	<!-- Header -->
	<header class="header1">
		<!-- Header desktop -->
		<div class="container-menu-header">
			<div class="topbar"-->
				<div class="topbar-social">
					<a href="https://www.facebook.com/pegasowatch" class="topbar-social-item fa fa-facebook"></a>
					<a href="https://www.instagram.com/relojespegaso.colombia/" class="topbar-social-item fa fa-instagram"></a>
					<a href="https://api.whatsapp.com/send?phone=+573104767568" class="topbar-social-item fa fa-whatsapp"></a>
					<!--a href="#" class="topbar-social-item fa fa-snapchat-ghost"></a-->
						

				</div>

				<!--div>
					<a href="<?php echo base_url(); ?>ubicacion/pais/2"><img src="<?php echo base_url(); ?>imagenes/icons/colombia.png" class="bandera"></a>
					<a href="<?php echo base_url(); ?>ubicacion/pais/1"><img src="<?php echo base_url(); ?>imagenes/icons/panama.png" class="bandera"></a>
				</div-->

				<!--a href="<?php echo base_url(); ?>offers" class="s-text24">
					Lleva nuestras <strong>OFERTAS</strong> hasta con el <strong>20%</strong> de descuento
				</a>

				<div class="topbar-child2">
					<span class="topbar-email">
						ejemplo@mail.com
					</span>
				</div-->
			</div>

			<div class="wrap_header">
				<!-- Logo -->
				<a href="<?php echo base_url(); ?>" class="logo">
					<img src="<?php echo base_url(); ?>imagenes/icons/logo.png" alt="IMG-LOGO">
				</a>

				<!-- Menu -->
				<div class="wrap_menu">
					<nav class="menu">
						<ul class="main_menu">
							<li><a href="<?php echo base_url(); ?>productos/tipo/<?php echo $this->config->item('instancia_ppal_reloj'); ?>/1">Relojes</a></li>
							<li><a href="<?php echo base_url(); ?>productos/tipo/<?php echo $this->config->item('instancia_base_pulso'); ?>/1">Pulsos</a></li>
							<?php if ($this->config->item('instancias_todas') == 'S') : ?>
								<li><a href="<?php echo base_url(); ?>productos/tipo/<?php echo $this->config->item('instancia_ppal_calculadora'); ?>/1">Calculadoras</a></li>
								<li><a href="<?php echo base_url(); ?>productos/tipo/<?php echo $this->config->item('instancia_base_bateria'); ?>/1">Baterias</a></li>
								<li><a href="<?php echo base_url(); ?>productos/tipo/<?php echo $this->config->item('instancia_base_medios'); ?>/1">Tecnolog&iacute;a</a></li>
								<li><a href="<?php echo base_url(); ?>productos/tipo/<?php echo $this->config->item('instancia_base_herramienta'); ?>/1">Herramientas</a></li>								
							<?php endif; ?>

							<?php if (total_productos_promocion() > 0) : ?>
								<li><a href="<?php echo base_url(); ?>productos/promocion">Promoción</a></li>
							<?php endif; ?>

							<li><a href="<?php echo base_url(); ?>contacto">Contacto</a></li>
						</ul>
					</nav>
				</div>

				<!-- Header Icon -->
				<div class="header-icons">

					<div class="header-wrapicon1">
						<div class="text-center">
							<img src="<?php echo base_url(); ?>imagenes/icons/icon-header-01.png" class="header-icon1 js-show-header-dropdown" alt="ICON">
							<br>
							<?php if (!$this->session->has_userdata('registrado')) : ?>
								<a href="<?php echo base_url(); ?>login">Iniciar</a>
							<?php endif; ?>

							<!-- Header cart noti -->
							<div class="header-user header-dropdown">
								<ul>
									<?php if($this->session->has_userdata('registrado')) : ?>
										<li class="header-cart-item">
											<a href="<?php echo base_url(); ?>pedidos/historia">Historial</a>
										</li>

										<li class="header-cart-item">
											<a href="<?php echo base_url(); ?>usuarios/editar_perfil">Editar perfil</a>
										</li>

										<?php if ($this->session->IDTipoUsuario == '1') : ?>
											
											<li class="header-cart-item">
												<a href="<?php echo base_url(); ?>usuarios/modificarClave">Cambio clave</a>
											</li>
										<?php endif; ?>
										
										<li class="header-cart-item">
											<a href="<?php echo base_url(); ?>usuarios/logout">Cerrar sesión</a>
										</li>
									<?php else : ?>
										<li class="header-cart-item">
											<a href="<?php echo base_url(); ?>login">Iniciar sesión</a>
										</li>
									<?php endif; ?>

								</ul>
							</div>
						</div>
					</div>

					<span class="linedivide1"></span>

					
					<?php $i = 0;
						$totalPedido = 0;
						$totalImpuesto = 0;
					?>
					<div class="header-wrapicon2">
						<img src="<?php echo base_url(); ?>imagenes/icons/cart.png" class="header-icon1 js-show-header-dropdown" alt="ICON">
						<span class="header-icons-noti"><?php echo $this->cart->total_items(); ?></span>

						<!-- Header cart noti -->

						<?php $impuesto = 0; ?>
						<div class="header-cart header-dropdown">
							<ul class="header-cart-wrapitem">

								<?php foreach ($this->cart->contents() as $items): ?>
									<?php 
										$rutaImp = $this->config->item('base_imagenes');
										if (esManilla($items['id']))
										{
											$codigoImp = esManilla($items['id'])->CodigoAux;
											$esManilla = true; 
											$rutaImp .= 'manilla/';
										}
										else
										{
											$codigoImp = $items['id'];
											$esManilla = false; 
										}
									?>
									<li class="header-cart-item">
										<div class="header-cart-item-img">
											<img src="<?php echo $rutaImp.imagen_producto($codigoImp,$esManilla); ?>" alt="IMG">
										</div>

										<div class="header-cart-item-txt">
											<a href="#" class="header-cart-item-name">
												<?php echo $items['name']; ?>
											</a>

											<span class="header-cart-item-info">
												<?php echo $items['qty'];?> x $<?php echo round($items['price']+$items['impuesto'],0); ?>
											</span>
										</div>
									</li>
								<?php $impuesto += $items['qty'] * $items['impuesto']; ?>
								<?php endforeach; ?>
							</ul>			

							<div class="header-cart-total">
								<?php if (!$this->cart->contents()) : ?>
									No hay ítems en el carro
								<?php else : ?>
									Total: $<?php echo round($this->cart->total() + $impuesto,0); ?>
								<?php endif; ?>
							</div>

							<div class="header-cart-buttons">
								<div class="header-cart-wrapbtn">
									<!-- Button -->
									<?php if ($this->cart->contents()) : ?>
										<a href="<?php echo base_url(); ?>cart" class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text14 trans-0-4">
											Ir al carrito
										</a>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>

		<!-- Header Mobile -->
		<div class="wrap_header_mobile">
			<!-- Logo moblie -->
			<a href="<?php echo base_url(); ?>" class="logo-mobile">
				<img src="<?php echo base_url(); ?>imagenes/icons/logo.png" alt="IMG-LOGO">
			</a>

			<!-- Button show menu -->
			<div class="btn-show-menu">
				<!-- Header Icon mobile -->
				<div class="header-icons-mobile">
					<div class="header-wrapicon1">
						<img src="<?php echo base_url(); ?>imagenes/icons/icon-header-01.png" class="header-icon1 js-show-header-dropdown" alt="ICON">

						<!-- Header cart noti -->
						<div class="header-user header-dropdown">
							<ul>
								<?php if ($this->session->has_userdata('registrado')) : ?>
									<li class="header-cart-item">
										<a href="<?php echo base_url(); ?>pedidos/historia">Historial</a>
									</li>
									<li class="header-cart-item">
										<a href="<?php echo base_url(); ?>usuarios/editar_perfil">Editar perfil</a>
									</li>
									
									<li class="header-cart-item">
											<a href="<?php echo base_url(); ?>usuarios/modificarClave">Cambio clave</a>
									</li>
									<li class="header-cart-item">
										<a href="<?php echo base_url(); ?>usuarios/logout">Cerrar sesión</a>
									</li>
								<?php else : ?>
									<li class="header-cart-item">
										<a href="<?php echo base_url(); ?>login">Iniciar sesión</a>
									</li>								
								<?php endif; ?>
							</ul>
						</div>
					</div>

					<span class="linedivide1"></span>

					<div class="header-wrapicon2">
						<img src="<?php echo base_url(); ?>imagenes/icons/icon-header-02.png" class="header-icon1 js-show-header-dropdown" alt="ICON">
						<span class="header-icons-noti"><?php echo $this->cart->total_items(); ?></span>

						<!-- Header cart noti -->
						<?php $impuesto = 0; ?>
						<div class="header-cart header-dropdown">
							<ul class="header-cart-wrapitem">						
								<?php foreach ($this->cart->contents() as $items): ?>
									<?php
										$rutaImp = $this->config->item('base_imagenes');
										if (esManilla($items['id']))
										{
											$codigoImp = esManilla($items['id'])->CodigoAux;
											$esManilla = true; 
											$rutaImp .= 'manilla/';
										}
										else
										{
											$codigoImp = $items['id'];
											$esManilla = false; 
										}
									?>
									<li class="header-cart-item">
										<div class="header-cart-item-img">
											<img src="<?php echo $rutaImp.imagen_producto($codigoImp,$esManilla); ?>" alt="IMG">
										</div>

										<div class="header-cart-item-txt">
											<a href="#" class="header-cart-item-name">
												<?php echo $items['name']; ?>
											</a>

											<span class="header-cart-item-info">
												<?php echo $items['qty'];?> x $<?php echo round($items['price']+$items['impuesto'],0); ?>
											</span>
										</div>
									</li>
								<?php $impuesto += $items['qty'] * $items['impuesto']; ?>
								<?php endforeach; ?>
							</ul>

							<div class="header-cart-total">
								<?php if ($this->cart->contents()) : ?>
									Total: $<?php echo round($this->cart->total() + $impuesto,0); ?>
								<?php else : ?>
									No hay ítems en el carro
								<?php endif; ?>
							</div>

							<div class="header-cart-buttons">
								<div class="header-cart-wrapbtn">
									<!-- Button -->
									<?php if ($this->cart->contents()) : ?>
										<a href="<?php echo base_url(); ?>cart" class="flex-c-m size1 bg1 bo-rad-20 hov1 s-text14 trans-0-4">
											Ir al carrito
										</a>
									<?php endif; ?>
								</div>
							</div>
						</div>
					</div>
				</div>

				<div class="btn-show-menu-mobile hamburger hamburger--squeeze">
					<span class="hamburger-box">
						<span class="hamburger-inner"></span>
					</span>
				</div>
			</div>
		</div>

		<!-- Menu Mobile -->
		<div class="wrap-side-menu" >
			<nav class="side-menu">
				<ul class="main-menu">
					<!--li class="item-topbar-mobile p-l-20 p-t-8 p-b-8 bgblack t-center">
						<a href="<?php echo base_url(); ?>offers" class="s-text24">
							Lleva nuestras <strong>OFERTAS</strong> hasta con el <strong>20%</strong> de descuento
						</a>
					</li-->

					<li class="item-topbar-mobile p-l-10">
						<div class="topbar-social-mobile">						
							<a href="https://www.facebook.com/pegasowatch" class="topbar-social-item fa fa-facebook"></a>
							<a href="https://www.instagram.com/relojespegaso.colombia/" class="topbar-social-item fa fa-instagram"></a>
							<a href="https://api.whatsapp.com/send?phone=+573104767568" class="topbar-social-item fa fa-whatsapp"></a>							
						</div>
					</li>

					<li class="item-menu-mobile">
						<a href="<?php echo base_url(); ?>productos/tipo/<?php echo $this->config->item('instancia_ppal_reloj'); ?>/1">Relojes</a>
					</li>

					<li class="item-menu-mobile">
						<a href="<?php echo base_url(); ?>productos/tipo/<?php echo $this->config->item('instancia_base_pulso'); ?>/1">Pulsos</a>
					</li>

					<?php if ($this->config->item('instancias_todas') == 'S') : ?>
						<li class="item-menu-mobile">
							<a href="<?php echo base_url(); ?>productos/tipo/<?php echo $this->config->item('instancia_ppal_calculadora'); ?>/1">Calculadoras</a>
						</li>

						<li class="item-menu-mobile">
							<a href="<?php echo base_url(); ?>productos/tipo/<?php echo $this->config->item('instancia_base_bateria'); ?>/1">Baterias</a>
						</li>

						<li class="item-menu-mobile">
							<a href="<?php echo base_url(); ?>productos/tipo/<?php echo $this->config->item('instancia_base_medios'); ?>/1">Memorias</a>
						</li>

						<li class="item-menu-mobile">
							<a href="<?php echo base_url(); ?>productos/tipo/<?php echo $this->config->item('instancia_base_herramienta'); ?>/1">Herramientas</a>
						</li>						
					<?php endif; ?>

					<?php if (total_productos_promocion() > 0) : ?>
								<li class="item-menu-mobile"><a href="<?php echo base_url(); ?>productos/promocion">Promoción</a></li>
							<?php endif; ?>

					<li class="item-menu-mobile">
						<a href="<?php echo base_url(); ?>contacto">Contacto</a>
					</li>
				</ul>
			</nav>
		</div>
		<script type="text/javascript">
      		var onloadCallback = function() {
        		grecaptcha.render('form_contacto', {
         		 'sitekey' : '6LfXraEUAAAAAGDE28O_RHUDXh--0JG9nTxaTXGH'
        	});
      	};
    </script>
	</header>