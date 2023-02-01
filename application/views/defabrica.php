<?php
    if (!isset($esLista)) $esLista = 0;

    $baseMarcas = $this->config->item('instancia_base_reloj');

    $total_mostrar = $this->config->item('img_por_pagina');
    $paginacion = $this->config->item('paginacion');
    $total_imprimir = ceil($total_productos / $total_mostrar);

    if ($pagina_activa <= ($total_imprimir - $paginacion + 1))
    {
        $inicio_pag = $pagina_activa;
        $fin_pag = $inicio_pag + $paginacion - 1;
    }

    $mostrar_regreso = false;
    $mostrar_avance = false;

    if ($total_imprimir > $paginacion && $pagina_activa < ($total_imprimir - $paginacion + 1)) $mostrar_avance = true;
    if ($pagina_activa > 1) $mostrar_regreso = true;

    $this->session->set_userdata('inicio_pag',$inicio_pag);
    $this->session->set_userdata('fin_pag',$fin_pag);
?>
 <main class="main">

            <div class="container-fluid">
                <div class="row">
                    <div class="col-lg-9 col-xl-10 padding-left-lg mt-2">
                        <!--nav class="toolbox">
                            <div class="toolbox-left">

                                <div class="layout-modes">
                                    <a href="<?php echo base_url(); ?>category/lista_productos_fabrica/1/0" class="layout-btn btn-grid active" title="Grid">
                                        <i class="icon-mode-grid"></i>
                                    </a>
                                    <a href="<?php echo base_url(); ?>category/lista_productos_fabrica/1/1" class="layout-btn btn-list" title="List">
                                        <i class="icon-mode-list"></i>
                                    </a>
                                </div>
                            </div>
                        </nav-->

                        <form id="form-detalle" method="post" action="<?php echo base_url(); ?>cartf/add">
                        <div class="row row-sm">
                          <?php if ($productos):
                            $pos = 0;
              				foreach($productos as $prod) : ?>
                            <div class="col-xl-3 col-md-4 col-sm-12">
                                <div class="product">
                                    <figure class="product-image-container">
                                    <button type="button" class="boton-detalle" data-toggle="modal" data-target="#modal<?php echo $prod->CodProd; ?>">Detalle</button>
                                        <!--a href="<?php echo base_url(); ?>category/product/<?php echo $prod->CodProd; ?>" class="product-image"-->
                                            <img loading="lazy" class="lazyload" data-src="<?php echo base_url(); ?><?php echo imagen_producto_fabrica($prod->CodProd); ?>" alt="product">
                                        <!--/a-->
                                        <!--a href="<?php echo base_url(); ?>ajax/category/product-quick-view" class="btn-quickview">Ver Detalle</a-->
                                    </figure>
                                    <div class="product-details">

                                        <h3 class="product-title">
                                            <?php echo $prod->CodProd; ?>
                                        </h3>
                                        <h4 class="product-descripcion">
                                            <?php echo $prod->Descrip; ?>
                                        </h4>                                        
                                        <div class="price-box">
                                            US$ <span class="product-price"><?php echo number_format($prod->Precio * (1+$prod->Impuesto/100),2,',','.'); ?></span>
                                        </div><!-- End .price-box -->
                                        <div class="form-row align-items-center mt-2">
                                            <label for="txtPedir" class="col-3">Pedir</label>
                                            <input type="number" name="txtPedir" min="20" class=" form-control col-3 m-1 item-cart" required>
                                            <button type="button" class="btn btn-dark btn-sm col-4 m-3 btn-addcart">Agregar</button>
                                        </div>
                                    </div><!-- End .product-details -->
                                </div><!-- End .product -->
                            </div><!-- End .col-xl-3 -->

                            <input type="hidden" name="cantidad" value="1" />
											<input type="hidden" name="coditem" value="<?php echo $prod->CodProd; ?>" />
											<input type="hidden" name="precio" value="<?php echo $prod->Precio; ?>" />
											<input type="hidden" name="impuesto" value="<?php echo $prod->Precio * $prod->Impuesto/100; ?>" />
											<input type="hidden" name="descripcion" value="<?php echo $prod->Descrip; ?>" /><br>											

                            <!-- Modal -->
                            <div class="modal fade" id="modal<?php echo $prod->CodProd; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modeal-dialog-centered modal-dialog-scrollable">
                                <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="exampleModalLabel"><?php echo $prod->CodProd; ?></h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                    <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <div class="modal-body">
                                    <!--?php echo str_replace("\r","'<br>",$prod->DescAmpliada); ?-->
                                    <?php echo $prod->DescAmpliada; ?>
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-dismiss="modal">Cerrar</button>
                                </div>
                                </div>
                            </div>
                            </div>
                          <?php $pos++; ?>
                          <?php endforeach; ?>
            						<?php endif; ?>
                        </div><!-- End .row -->
                        </form>

                        <?php if ($total_productos > $this->config->item('img_por_pagina_fab')) : ?>
                        <nav class="toolbox toolbox-pagination">
                            <ul class="pagination">
                              <?php if($mostrar_regreso) : ?>
                                <li class="page-item">
                                    <a class="page-link page-link-btn" href="<?php echo base_url(); ?>category/lista_productos_fabrica/<?php echo $pagina_activa - 1; ?>/<?php echo $esLista; ?>">
                                        <i class="icon-angle-left"></i>
                                    </a>
                                </li>
                              <?php endif; ?>
                                <?php foreach(range($inicio_pag,$fin_pag) as $p) : ?>
                                    <li class="page-item <?php if ($p == $pagina_activa) : ?>active<?php endif; ?>">
                                        <a class="page-link" href="<?php echo base_url(); ?>category/lista_productos_fabrica/<?php echo $p; ?>/<?php echo $esLista; ?>"><?php echo $p; ?>
                                            <?php if ($p == $pagina_activa) : ?><span class="sr-only">(current)</span><?php  endif; ?>
                                        </a>
                                  </li>
                                <?php endforeach; ?>
                              <!--li class="page-item"><span class="page-link">...</span></li-->
                              <?php if($mostrar_avance) : ?>
                                <li class="page-item">
                                    <a class="page-link page-link-btn" href="<?php echo base_url(); ?>category/lista_productos_fabrica/<?php echo $pagina_activa + 1; ?>/<?php echo $esLista; ?>">
                                        <i class="icon-angle-right"></i>
                                    </a>
                                </li>
                              <?php endif; ?>
                            </ul>
                        </nav>
                        <?php endif; ?>
                    </div><!-- End .col-lg-9 -->

                </div><!-- End .row -->
            </div><!-- End .container-fluid -->

            <div class="mb-3"></div><!-- margin -->
        </main><!-- End .main -->
