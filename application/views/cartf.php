        <main class="main">

            <div class="page-header">
                <div class="container">
                    <h1>Tu Carrito</h1>
                </div><!-- End .container -->
            </div><!-- End .page-header -->

            <?php if($this->cart->contents()) : ?>
            <?php $impuesto = 0; ?>
            <div class="container">
                <div class="row">
                    <div class="col-lg-8 padding-right-lg">
                        <div class="cart-table-container">
                            <form method="post" action="<?php echo base_url(); ?>cartf/actualizarCarro">
                            <table class="table table-cart">
                                <thead>
                                    <tr>
                                        <th class="product-col">Producto</th>
                                        <th class="price-col">Precio</th>
                                        <th class="qty-col">Cant.</th>
                                        <th>Subtotal</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach ($this->cart->contents() as $items): ?>
                                    <tr class="product-row">
                                        <td class="product-col">
                                            <figure class="product-image-container">
                                                <img src="<?php echo base_url(); ?><?php echo imagen_producto_fabrica($items['id']); ?>" alt="product">
                                            </figure>
                                            <h2 class="product-title">
                                                <?php echo $items['id']; ?>
                                                <input type="hidden" name="producto[]" value="<?php echo $items['id']; ?>" />
                                            </h2>
                                        </td>
                                        <td>$<?php echo round($items['price']+$items['impuesto'],2); ?></td>
                                        <td>
                                            <input class="vertical-quantity form-control" type="text" name="cantidad[]" value="<?php echo $items['qty']; ?>" min="20">
                                        </td>
                                        <td>US$ <?php echo round(($items['price']+$items['impuesto'])*$items['qty'],2); ?></td>
                                        <?php $impuesto = $impuesto + $items['qty'] * $items['impuesto']; ?>
                                    </tr>
                                    <tr class="product-action-row">
                                        <td colspan="4" class="clearfix">
                                            <!--div class="float-left">
                                                <a href="#" class="btn-move">Mover a la lista de deseos</a>
                                            </div--><!-- End .float-left -->

                                            <div class="float-right">
                                                <!--a href="<?php echo base_url(); ?>cartf/update/<?php echo $items['rowid']; ?>/<?php echo $items['qty']; ?>" title="Edit product" class="btn-edit"><span class="sr-only">Edit</span><i class="icon-pencil"></i></a-->
                                                <a href="<?php echo base_url(); ?>cartf/removeCartItem/<?php echo $items['rowid']; ?>" title="Remove product" class="btn-remove"><span class="sr-only">Remove</span></a>
                                            </div><!-- End .float-right -->
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>

                                <tfoot>
                                    <tr>
                                        <td colspan="4" class="clearfix">
                                            <div class="float-left">
                                                <a href="<?php echo base_url(); ?>category/lista_fabrica" class="btn btn-outline-secondary">Continúa Comprando</a>
                                            </div><!-- End .float-left -->

                                            <div class="float-right">
                                                <a href="<?php echo base_url(); ?>cartf/vaciarCarro" class="btn btn-outline-secondary btn-clear-cart">Vacía Tu Carrito de Compra</a>
                                                <!--a href="<?php echo base_url(); ?>cartf/actualizarCarro" class="btn btn-outline-secondary btn-update-cart">Actualiza Tu Carrito</a-->
                                                <button type="submit" class="btn btn-outline-secondary btn-update-cart">Actualiza Tu Carrito</button>
                                            </div><!-- End .float-right -->
                                        </td>
                                    </tr>
                                </tfoot>
                            </table>
                            </form>
                        </div><!-- End .cart-table-container -->

                        <!--div class="cart-discount">
                            <h4>Aplica Código de Descuento</h4>
                            <form action="#">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm" placeholder="Escribe código de descuento"  required>
                                    <div class="input-group-append">
                                        <button class="btn btn-sm btn-primary" type="submit">Aplicar Descuento</button>
                                    </div>
                                </div>
                            </form>
                        </div-->
                    </div><!-- End .col-lg-8 -->

                    <div class="col-lg-4">
                        <div class="cart-summary">
                            <h3>Resumen</h3>

                            <!--h4>
                                <a data-toggle="collapse" href="#total-estimate-section" class="collapsed" role="button" aria-expanded="false" aria-controls="total-estimate-section">Valor de Envío e Impuestos Estimados</a>
                            </h4>

                            <div class="collapse" id="total-estimate-section">
                                <form action="#">
                                    <div class="form-group form-group-sm">
                                        <label>País</label>
                                        <div class="select-custom">
                                            <select class="form-control form-control-sm" id="paisEnvio">
                                                <?php foreach(lista_paises() as $pais) : ?>
                                                    <option value="<?php echo $pais->IDPais; ?>" <?php if ($pais->IDPais == $this->session->Pais) : ?>selected<?php endif; ?>><?php echo $pais->Descrip; ?></option>
                                                <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group form-group-sm">
                                        <label>Estado/Departamento</label>
                                        <div class="select-custom">
                                            <select class="form-control form-control-sm" id="estadoEnvio">
                                                 <?php foreach(lista_estados($this->session->Pais) as $estado) : ?>
                                                      <option value="<?php echo $estado->IDEstado; ?>" <?php if ($estado->IDEstado == $this->session->Estado) : ?>selected<?php endif; ?>><?php echo $estado->Descrip; ?></option>
                                                 <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group form-group-sm">
                                        <label>Ciudad</label>
                                        <div class="select-custom">
                                            <select class="form-control form-control-sm" id="ciudadEnvio">
                                               <?php foreach(lista_ciudades($this->session->Estado) as $ciudad) : ?>
                                                    <option value="<?php echo $ciudad->IDCiudad; ?>" <?php if ($ciudad->IDCiudad == $this->session->Ciudad) : ?>selected<?php endif; ?>><?php echo $ciudad->Descrip; ?></option>
                                               <?php endforeach; ?>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="form-group form-group-sm">
                                        <label>Código Postal</label>
                                        <input type="text" class="form-control form-control-sm">
                                    </div>

                                    <div class="form-group form-group-custom-control">
                                        <label>Flat Way</label>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="flat-rate">
                                            <label class="custom-control-label" for="flat-rate">Fixed $5.00</label>
                                        </div>
                                    </div>

                                    <div class="form-group form-group-custom-control">
                                        <label>Best Rate</label>
                                        <div class="custom-control custom-checkbox">
                                            <input type="checkbox" class="custom-control-input" id="best-rate">
                                            <label class="custom-control-label" for="best-rate">Table Rate $15.00</label>
                                        </div>
                                    </div>
                                </form>
                            </div--><!-- End #total-estimate-section -->

                            <table class="table table-totals">
                                <tbody>
                                    <tr>
                                        <td>Subtotal</td>
                                        <td>$<?php echo round($this->cart->total(),2); ?></td>
                                    </tr>

                                    <tr>
                                        <td>Impuestos</td>
                                        <td>$<?php echo round($impuesto,2); ?></td>
                                    </tr>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <td>Orden Total</td>
                                        <td>$<?php echo round($this->cart->total() + $impuesto,2); ?></td>
                                    </tr>
                                </tfoot>
                            </table>

                            <div class="checkout-methods">
                                <a href="<?php echo base_url(); ?>cartf/checkout" class="btn btn-block btn-sm btn-primary">Ir al Checkout</a>

                            </div><!-- End .checkout-methods -->
                        </div><!-- End .cart-summary -->
                    </div><!-- End .col-lg-4 -->
                </div><!-- End .row -->
            </div><!-- End .container -->
          <?php endif; ?>

            <div class="mb-6"></div><!-- margin -->
        </main><!-- End .main -->
