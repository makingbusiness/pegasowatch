<!DOCTYPE html>
<html lang="en">
<head>
	<title>MB - Login</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1">
<!--===============================================================================================-->
	<link rel="icon" type="image/png" href="<?php echo base_url(); ?>images/icons/favicon.png"/>
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
<!--===============================================================================================-->
</head>
<body class="animsition login">
	<img class="bg-login" src="<?php echo base_url(); ?>images/bg-pegaso.jpg">
	<div class="container">
		<div class="logo-login">
			<a href="<?php echo base_url(); ?>">
				<img src="<?php echo base_url(); ?>images/icons/logo-white.png">
			</a>
		</div>

		<div class="row">
			<div class="login-form col-sm-12 col-md-5">
				<h3>Inicia sesión</h3>
				<form method="post" action="<?php base_url(); ?>usuarios/login">
					<div class="input">
						<input type="email" name="email" placeholder="Correo electronico">
					</div>
					<div class="input">
						<input type="password" name="password" placeholder="Contraseña">
					</div>
					<div>
						<a href="<?php echo base_url(); ?>login/recuperar_pwd" class="forgot">
							<small>Recuperar contraseña</small>
						</a>
					</div>
					<button type="submit">Ingresar</button>
				</form>
				<div class="social">
					<p>Siguenos en: </p>
					<a href="https://www.facebook.com/MakingBusiness2014/" class="topbar-social-item fa fa-facebook"></a>
					<a href="#" class="topbar-social-item fa fa-instagram"></a>
					<a href="#" class="topbar-social-item fa fa-pinterest-p"></a>
					<a href="#" class="topbar-social-item fa fa-snapchat-ghost"></a>
				</div>
			</div>
			<div class="register-form col-sm-12 col-md-6">
				<h3>Registrate ahora!</h3>
				<form method="post" action="<?php echo base_url(); ?>usuarios/registrar">
					<div class="input">
						<input type="text" name="name" placeholder="Nombres">
					</div>
					<div class="input">
						<input type="text" name="lastname" placeholder="Apellidos">
					</div>
					<div class="input">
						<input type="number" name="idNumber" placeholder="N° de identidad">
					</div>
					<div class="input">
						<input type="email" name="email" placeholder="Correo electronico">
					</div>
					<div class="input">
						<input type="password" name="password" placeholder="Contraseña">
					</div>
					<div class="input">
						<input type="password" name="passConfirm" placeholder="Confirmar contraseña">
					</div>
					<button type="submit">Registrar</button>
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
	<script src="js/main.js"></script>

</body>
</html>
