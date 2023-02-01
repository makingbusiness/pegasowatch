<!DOCTYPE html>
<html lang="en">
<head>
	<title>MB - Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="<?php echo base_url(); ?>imagenes/icons/favicon.png"/>
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>vendor/bootstrap/css/bootstrap.min.css">
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
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>vendor/slick/slick.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>vendor/noui/nouislider.min.css">
<!--===============================================================================================-->
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/util.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/main.css">
	<link rel="stylesheet" type="text/css" href="<?php echo base_url(); ?>css/varios.css">
<!--===============================================================================================-->
</head>

<body class="animsition login">
	<img class="bg-login" src="<?php echo base_url(); ?>imagenes/banner/bg-pegaso.jpg">
	<div class="container">
		<div class="logo-login">
			<a href="<?php echo base_url(); ?>">
				<img src="<?php echo base_url(); ?>imagenes/icons/logo-white.png">
			</a>
		</div>

		<div class="row">
			<div class="login-form col-sm-12 col-md-5">
				<h3>Inicia sesión</h3>
				<form id="form-login" method="post" action="<?php base_url(); ?>usuarios/login">
					<div class="input">
						<input type="email" name="email" placeholder="Correo electr&oacute;nico" required=true>
					</div>
					<div class="input">
						<input type="password" name="password" placeholder="Contraseña" required=true>
					</div>
					<a href="<?php echo base_url(); ?>login/recuperar_pwd" class="forgot">
						<small>Recuperar contraseña</small>
					</a>

					<div class="w-size25 margin-center mt-3 dis-inline-block">
						<button id="btn-login" type="submit" class="flex-c-m size2 bg1 bo-rad-23 hov1 s-text14 trans-0-4">
							Ingresar
						</button>
					</div>
					<div class="w-size25 margin-center mt-3 dis-inline-block">					
						<a href="<?php echo base_url(); ?>login/acceso_clientes" type="button" class="flex-c-m size2 bg3 text-black bo-rad-23 hov1 s-text25 trans-0-4 ml-2" id="btn-codigo">
							Acceso clientes
						</a>
					</div>

					<?php
						if(!isset($login_button))
						{

							$user_data = $this->session->userdata('user_data');
							echo '<div class="panel-heading">Welcome User</div><div class="panel-body">';
							echo '<img src="'.$user_data['profile_picture'].'" class="img-responsive img-circle img-thumbnail" />';
							echo '<h3><b>Name : </b>'.$user_data["first_name"].' '.$user_data['last_name']. '</h3>';
							echo '<h3><b>Email :</b> '.$user_data['email_address'].'</h3>';
							echo '<h3><a href="'.base_url().'login/logout">Logout</h3></div>';
						}
						else
						{
							echo '<!--div align="center">'.$login_button . '</div--!>';
						}
					?>

					<?php if ($this->session->flashdata('error_ingreso')!=null) : ?>
						<div class="alert alert-warning alert-dismissible">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<?php echo $this->session->flashdata('error_ingreso'); ?>
						</div>
					<?php endif; ?>
				</form>
				<div class="social">
					<p>Siguenos en: </p>
					<a href="https://www.facebook.com/pegasowatch" class="topbar-social-item fa fa-facebook"></a>
					<a href="https://www.instagram.com/relojespegaso.colombia/" class="topbar-social-item fa fa-instagram"></a>
					<a href="https://api.whatsapp.com/send?phone=+573104767568" class="topbar-social-item fa fa-whatsapp"></a>

				</div>
			</div>
			<div class="register-form col-sm-12 col-md-6">
				<h3>Reg&iacute;strate ahora!</h3>
				<form method="post" action="<?php echo base_url(); ?>usuarios/registrar">
					<div class="input">
						<input type="text" name="name" placeholder="Nombres" required=true value="<?php if ($this->session->flashdata('error_registro')!=null) : ?><?php echo $name; ?><?php endif; ?>">
					</div>
					<div class="input">
						<input type="text" name="lastname" placeholder="Apellidos" required=true value="<?php if ($this->session->flashdata('error_registro')!=null) : ?><?php echo $lastname; ?><?php endif; ?>">
					</div>
					<div class="input">
						<input type="number" name="idNumber" placeholder="N° de identidad" required=true value="<?php if ($this->session->flashdata('error_registro')!=null) : ?><?php echo $idNumber; ?><?php endif; ?>">
					</div>
					<div class="input">
						<input type="email" name="email" placeholder="Correo electr&oacute;nico" required=true value="<?php if ($this->session->flashdata('error_registro')!=null) : ?><?php echo $email; ?><?php endif; ?>">
					</div>
					<div class="input">
						<input type="password" name="password" placeholder="Contraseña" required=true>
					</div>
					<div class="input">
						<input type="password" name="passConfirm" placeholder="Confirmar contraseña" required=true>
					</div>

					<div class="w-size25 margin-center mt-3 dis-inline-block">
						<button id="btn-login" type="submit" class="flex-c-m size2 bg1 bo-rad-23 hov1 s-text14 trans-0-4">
							Registrar
						</button>
					</div>
					<br />
					<?php if ($this->session->flashdata('error_registro')!=null) : ?>
						<div class="alert alert-warning alert-dismissible">
							<button type="button" class="close" data-dismiss="alert">&times;</button>
							<?php echo $this->session->flashdata('error_registro'); ?>
						</div>
					<?php endif; ?>
				</form>
			</div>
		</div>
	</div>



<!--===============================================================================================-->
	<script type="text/javascript" src="<?php echo base_url(); ?>vendor/jquery/jquery-3.2.1.min.js"></script>
<!--===============================================================================================-->
	<script type="text/javascript" src="<?php echo base_url(); ?>vendor/animsition/js/animsition.min.js"></script>
<!--===============================================================================================-->
	<script type="text/javascript" src="<?php echo base_url(); ?>vendor/bootstrap/js/popper.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>vendor/bootstrap/js/bootstrap.min.js"></script>
<!--===============================================================================================-->
	<script type="text/javascript" src="<?php echo base_url(); ?>vendor/select2/select2.min.js"></script>
	<script type="text/javascript">
		$(".selection-1").select2({
			minimumResultsForSearch: 20,
			dropdownParent: $('#dropDownSelect1')
		});

		$(".selection-2").select2({
			minimumResultsForSearch: 20,
			dropdownParent: $('#dropDownSelect2')
		});
	</script>
<!--===============================================================================================-->
	<script type="text/javascript" src="<?php echo base_url(); ?>vendor/daterangepicker/moment.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>vendor/daterangepicker/daterangepicker.js"></script>
<!--===============================================================================================-->
	<script type="text/javascript" src="<?php echo base_url(); ?>vendor/slick/slick.min.js"></script>
	<script type="text/javascript" src="<?php echo base_url(); ?>js/slick-custom.js"></script>
<!--===============================================================================================-->
	<script type="text/javascript" src="<?php echo base_url(); ?>vendor/sweetalert/sweetalert.min.js"></script>
	<script type="text/javascript">
		$('.block2-btn-addcart').each(function(){
			var nameProduct = $(this).parent().parent().parent().find('.block2-name').html();
			$(this).on('click', function(){
				swal(nameProduct, "fue añadido al carrito!", "success");
			});
		});

		$('.block2-btn-addwishlist').each(function(){
			var nameProduct = $(this).parent().parent().parent().find('.block2-name').html();
			$(this).on('click', function(){
				swal(nameProduct, "fue añadido a su lista de deseos!", "success");
			});
		});
	</script>

<!--===============================================================================================-->
	<script type="text/javascript" src="<?php echo base_url(); ?>vendor/noui/nouislider.min.js"></script>
	<script type="text/javascript">
		/*[ No ui ]
	    ===========================================================*/
	    var filterBar = document.getElementById('filter-bar');

	    noUiSlider.create(filterBar, {
	        start: [ 50, 200 ],
	        connect: true,
	        range: {
	            'min': 50,
	            'max': 200
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
<!--===============================================================================================-->
	<script src="<?php echo base_url(); ?>js/main.js"></script>

</body>
</html>
