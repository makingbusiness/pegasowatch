<main class="main">
                <nav aria-label="breadcrumb" class="breadcrumb-nav">
                    <div class="container-fluid">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="<?php echo base_url(); ?>category/lista_fabrica">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Chekout</li>
                        </ol>
                    </div><!-- End .container-fluid -->
                </nav>

                <div class="page-header">
                    <div class="container">
                        <h1>Checkout</h1>
                    </div><!-- End .container -->
                </div><!-- End .page-header -->

                <div class="container">
                    <ul class="checkout-progress-bar">
                        <li class="active">
                            <span>Envío</span>
                        </li>
                        <li>
                            <span>Pago</span>
                        </li>
                    </ul>
                    <div class="row">
                        <div class="col-lg-8 padding-right-lg">
                            <ul class="checkout-steps">
                                <?php if(!$this->session->has_userdata('correo_usuario')) : ?>
                                <li>
                                    <h2 class="step-title">Dirección de envío</h2>

                                    <form method="post" action="<?php echo base_url(); ?>usuariosf/login/1">
                                        <div class="form-group required-field">
                                            <label>Correo Electrónico </label>
                                            <div class="form-control-tooltip">
                                                <input type="email" class="form-control" name="login-email" required>
                                                <span class="input-tooltip" data-toggle="tooltip" title="We'll send your order confirmation here." data-placement="right"><i class="icon-question-circle"></i></span>
                                            </div><!-- End .form-control-tooltip -->
                                        </div><!-- End .form-group -->

                                        <div class="form-group required-field">
                                            <label>Contraseña </label>
                                            <input type="password" class="form-control" name="login-password" required>
                                        </div><!-- End .form-group -->

                                        <?php if ($this->session->flashdata('error_registro')) : ?>
                                        <div class="alert alert-danger alert-dismissible" role="alert">
                                            <?php echo $this->session->flashdata('error_registro'); ?>
                                            <button type="button" class="close" data-dismiss="alert" aria-label="close">
                                                <span aria-hidden="true">&times;</span>
                                            </button>
                                        </div>
                                        <?php endif; ?>

                                        <p> <a href="<?php echo base_url(); ?>usuariosf/forgot">¿Olvidaste tu contraseña?</a></p>
                                        <div class="form-footer">
                                            <button type="submit" class="btn btn-primary">Iniciar sesión</button>
                                            <a href="<?php echo base_url(); ?>usuariosf/registrarse" class="forget-pass btn btn-primary">Registrarse</a>
                                        </div><!-- End .form-footer -->
                                    </form>
                                  </li>
                                <?php else : ?>
                                  <li>

                                    <form method="post" action="<?php echo base_url(); ?>pedidosf/guardar_pedido">
                                        <div class="form-group required-field">
                                            <label>Nombre </label>
                                            <input type="text" class="form-control" name="nombres"" value="<?php echo $this->session->userdata('nombre_usuario'); ?>" required>
                                        </div><!-- End .form-group -->

                                        <div class="form-group required-field">
                                            <label>Apellidos </label>
                                            <input type="text" class="form-control" name="apellidos" value="<?php echo $this->session->userdata('apellido_usuario'); ?>" required>
                                        </div><!-- End .form-group -->

                                        <!--div class="form-group">
                                            <label>Company </label>
                                            <input type="text" class="form-control">
                                        </div--><!-- End .form-group -->

                                        <div class="form-group required-field">
                                            <label>Direcci&oacute;n </label>
                                            <input type="text" class="form-control" name="direccion_envio" required>
                                            <input type="text" class="form-control" name="direccion2_envio" id="direccion2_envio">
                                        </div><!-- End .form-group -->

                                        <div class="form-group">
                                        <label>Pa&iacute;s</label>
                                            <div class="select-custom">
                                                <select class="form-control" id="paisCheck" name="pais_envio">
                                                  <?php foreach(lista_paises() as $pais) : ?>
                                                      <option value="<?php echo $pais->IDPais; ?>" <?php if ($pais->IDPais == $this->session->Pais) : ?>selected<?php endif; ?>><?php echo $pais->Descrip; ?></option>
                                                  <?php endforeach; ?>
                                                </select>
                                            </div><!-- End .select-custom -->
                                        </div><!-- End .form-group -->

                                        <div class="form-group">
                                            <label>Estado</label>
                                            <div class="select-custom">
                                                <select class="form-control" id="estadoCheck" name="estado_envio">
                                                  <?php foreach(lista_estados($this->session->Pais) as $estado) : ?>
                                                       <option value="<?php echo $estado->IDEstado; ?>" <?php if ($estado->IDEstado == $this->session->Estado) : ?>selected<?php endif; ?>><?php echo $estado->Descrip; ?></option>
                                                  <?php endforeach; ?>
                                                </select>
                                            </div><!-- End .select-custom -->
                                        </div><!-- End .form-group -->

                                        <div class="form-group required-field">
                                            <label>Ciudad</label>
                                            <div class="select-custom">
                                                <select class="form-control" id="ciudadCheck" name="ciudad_envio">
                                                  <?php foreach(lista_ciudades($this->session->Estado,$this->session->Pais) as $ciudad) : ?>
                                                       <option value="<?php echo $ciudad->IDCiudad; ?>" <?php if ($ciudad->IDCiudad == $this->session->Ciudad) : ?>selected<?php endif; ?>><?php echo $ciudad->Descrip; ?></option>
                                                  <?php endforeach; ?>
                                                </select>
                                            </div><!-- End .select-custom -->
                                        </div><!-- End .form-group -->

                                        <!--div class="form-group required-field">
                                            <label>Zip/Postal Code </label>
                                            <input type="text" class="form-control" required>
                                        </div--><!-- End .form-group -->

                                        <div class="form-group required-field">
                                            <label>Tel&eacute;fono </label>
                                            <div class="form-control-tooltip">
                                                <input type="tel" class="form-control" name="telefono_envio" required>
                                                <span class="input-tooltip" data-toggle="tooltip" title="For delivery questions." data-placement="right"><i class="icon-question-circle"></i></span>
                                            </div><!-- End .form-control-tooltip -->
                                        </div><!-- End .form-group -->

                                        <div class="form-group">
                                            <label>Observaciones </label>
                                            <div class="form-control-tooltip">
                                                <input type="text" class="form-control" name="observaciones_envio">
                                                <span class="input-tooltip" data-toggle="tooltip" title="For delivery questions." data-placement="right"><i class="icon-question-circle"></i></span>
                                            </div><!-- End .form-control-tooltip -->
                                        </div><!-- End .form-group -->

                                        <div class="row">
                                            <div class="col-lg-8">
                                                <div class="checkout-steps-action">
                                                    <button type="submit" class="btn btn-primary float-right">SIGUIENTE</button>
                                                </div><!-- End .checkout-steps-action -->
                                            </div><!-- End .col-lg-8 -->
                                        </div><!-- End .row -->
                                    </form>
                                </li>

                              <?php endif; ?>
                            </ul>
                        </div><!-- End .col-lg-8 -->

                        <div class="col-lg-4">
                            <div class="order-summary">
                                <h3>Resumen</h3>

                                <h4 class='py-4'>
                                    <?php echo $this->cart->total_items(); ?> productos en el carrito
                                </h4>

                                <div  id="order-cart-section">
                                    <table class="table table-mini-cart">
                                        <tbody>
                                           <?php foreach($this->cart->contents() as $items): ?>
                                            <tr>
                                                <td class="product-col">
                                                    <figure class="product-image-container">
                                                        <a href="<?php echo base_url(); ?>category/product/<?php echo $items['id']; ?>" class="product-image">
                                                            <img src="<?php echo base_url(); ?><?php echo imagen_producto_fabrica($items['id']); ?>" alt="product">
                                                        </a>
                                                    </figure>
                                                    <div>
                                                        <h2 class="product-title">
                                                            <a href="#"><?php echo $items['name']; ?></a>
                                                        </h2>

                                                        <span class="product-qty">Cant: <?php echo $items['qty']; ?></span>
                                                    </div>
                                                </td>
                                                <td class="price-col">$<?php echo round(($items['price']+$items['impuesto'])*$items['qty']); ?></td>
                                            </tr>
                                          <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div><!-- End #order-cart-section -->
                            </div><!-- End .order-summary -->
                        </div><!-- End .col-lg-4 -->
                    </div><!-- End .row -->

                <div class="mb-6"></div><!-- margin -->
            </main><!-- End .main -->
