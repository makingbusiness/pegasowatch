<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">

    <title>Pegaso Watches</title>

    <meta name="keywords" content="Pegaso Watches" "Relojes" "Relojes para hombre" "Relojes Deportivos" />
    <meta name="description" content="Pegaso Watches - Somos fabricantes de relojes y distribuidores de relojes en latinoamérica">
    <meta name="" content="">

    <!-- Favicon -->
    <link rel="icon" type="image/x-icon" href="<?php echo base_url(); ?>assets/images/icons/favicon.ico">

    <!-- Plugins CSS File -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.min.css">

    <!-- Main CSS File -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/style.css">
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/varios.css">

    <!-- Font AWESOME CSS File -->
    <link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/all.css">
</head>
<body id='page-<?php if (isset($nombre_pagina_fabrica)) echo $nombre_pagina_fabrica; ?>'>
    <div class="page-wrapper">
        <header class="header<?php echo $estilo_header; ?>">
            <div class="header-middle sticky-header">
                <div class="container-fluid">
                    <div class="header-left">
                        <a href="<?php echo base_url(); ?>productos/lista_fabrica" class="logo">
                            <img src="<?php echo base_url(); ?>assets/img/logo.png" width="135">
                        </a>
                    </div><!-- End .header-left -->

                    <div class="header-right">


                        <!--button class="mobile-menu-toggler" type="button">
                            <i class="icon-menu"></i>
                        </button-->

                        <div class="dropdown cart-dropdown">
                            <a href="#" class="dropdown-toggle" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false" data-display="static">
                                <span class="cart-count"><?php echo $this->cart->total_items(); ?></span>
                            </a>

                            <?php $impuesto = 0; ?>
                            <div class="dropdown-menu" >
                                <div class="dropdownmenu-wrapper">
                                    <div class="dropdown-cart-products">
                                        <?php foreach ($this->cart->contents() as $items): ?>
                                        <div class="product">
                                            <div class="product-details">
                                                <h4 class="product-title">
                                                    <?php echo $items['id']; ?>
                                                </h4>

                                                <span class="cart-product-info">
                                                    <span class="cart-product-qty"><?php echo $items['qty']; ?></span>
                                                    x $<?php echo round($items['price'] + $items['impuesto'],2); ?>
                                                </span>
                                            </div><!-- End .product-details -->

                                            <figure class="product-image-container">
                                                <img src="<?php echo base_url(); ?><?php echo imagen_producto_fabrica($items['id']); ?>" alt="product">
                                                <a href="<?php echo base_url(); ?>cartf/removeCartItem/<?php echo $items['rowid']; ?>" title="Remove product" class="btn-remove"><i class="icon-cancel"></i></a>
                                            </figure>
                                        </div><!-- End .product -->
                                        <?php $impuesto += $items['qty'] * $items['impuesto']; ?>
                                      <?php endforeach; ?>
                                    </div><!-- End .cart-product -->

                                    <div class="dropdown-cart-total">
                                        <span>Total</span>

                                        <span class="cart-total-price">$<?php echo round($this->cart->total() + $impuesto,2); ?></span>
                                    </div><!-- End .dropdown-cart-total -->

                                    <div class="dropdown-cart-action">
                                        <a href="<?php echo base_url(); ?>cartf" class="btn">Ver Carro</a>
                                        <a href="<?php echo base_url(); ?>cartf/checkout" class="btn">Checkout</a>
                                    </div><!-- End .dropdown-cart-total -->
                                </div><!-- End .dropdownmenu-wrapper -->
                            </div><!-- End .dropdown-menu -->
                        </div><!-- End .dropdown -->

                        <div class="header-dropdowns">

                            <div class="header-dropdown user-menu">
                                <a href="#">
                                    <i class="far fa-user user-icon"></i>
                                </a>
                                <div class="header-menu">
                                    <ul>
                                        <?php if (!$this->session->has_userdata('correo_usuario')) : ?>
                                            <li><a href="#" data-toggle="modal" data-target="#loginModalf">Acceder</a></li>
                                            <li><a href="<?php echo base_url() ?>usuariosf/registrarse">Crear cuenta</a></li>
                                        <?php else : ?>
                                            <li><a href="<?php echo base_url(); ?>usuariosf/my_account">Mi perfil</a></li>
                                            <li><a href="<?php echo base_url(); ?>usuariosf/logout">Cerrar sesión</a></li>
                                        <?php endif; ?>
                                    </ul>
                                </div><!-- End .header-menu -->
                            </div><!-- End .header-dropown -->
                        </div><!-- End .header-dropdowns -->

                    </div>
                </div><!-- End .container-fluid -->
            </div><!-- End .header-middle -->
        </header><!-- End .header -->
