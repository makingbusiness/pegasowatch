<?php
	if ($this->session->IDTipoUsuario == null ) $this->session->IDTipoUsuario = '1';
	$mostrar = $this->config->item('paginacion');
    if ($total_numeros > $mostrar)
	{
		if ($pagina_activa + $mostrar >= $total_numeros)
		{
			$dif = $pagina_activa+$mostrar-$total_numeros;
			if ($dif == 0) $dif = ceil($mostrar/2)+1;
			if ($total_numeros - $pagina_activa <= ($mostrar/2)+1) $inicio = $total_numeros - $mostrar + 1;
			else $inicio = (($pagina_activa - $dif) <= 0) ? 1 : ($pagina_activa-$dif);
		}
		else
		{
			if ($pagina_activa < $mostrar - 1)
			{
				$inicio = 1;
			}
			else
			{
				$inicio = $pagina_activa - ceil($mostrar / 2) + 1;
			}									
		}

		//$fin = $total_numeros;
		$total_por_pagina = $mostrar - 1;							
	}
	else
	{
		$inicio = 1;
		$total_por_pagina = $total_numeros - 1;
		//$fin = 0;
	}
	
	$fin = $total_numeros;
	
	// Mostrar mensaje pag # - # de #
	$cont_ini = 1 + $por_pagina * ($pagina_activa - 1);
	$cont_fin = $cont_ini + ($pagina_activa * $por_pagina <= $total_productos ? $por_pagina : $total_productos - $por_pagina * ($pagina_activa - 1)) - 1;

	$esManilla = $this->session->nombre_pagina == 'pulsos' ? true : false;

	$rutaImagenes = $this->config->item('base_imagenes');
	$rutaManillas = $rutaImagenes.'manilla/';

/*	$tipo_imagen = 0;
	if ($this->session->userdata('nombre_pagina') == 'pulsos')
	{
		$tipo_imagen = 1;
	}
*/

/*$hoy = getdate();
$fecha = $hoy['year'].'/'.str_pad($hoy['mon'],2,'0',STR_PAD_LEFT).'/'.str_pad($hoy['mday'],2,'0',STR_PAD_LEFT);*/
?>
<!-- Title Page -->
	<?php if ($this->session->nombre_pagina != 'herramientas') : ?>
	<section class="bg-title-page p-t-50 p-b-40 flex-col-c-m" style="background-image: url(<?php echo base_url(); ?>imagenes/banner/productos/<?php echo $this->session->userdata('nombre_pagina'); ?>.png);">
		<!--h2 class="l-text2 t-center">
			<?php echo $this->session->userdata('nombre_pagina'); ?>
		</h2-->
		<?php if ($this->session->userdata('nombre_pagina') == 'relojes' && $this->config->item('instancias_todas') == 'S') : ?>
			<div class="wrap-btn-slide1 w-size1" data-appear="zoomIn">
				<!-- Button -->
				<a href="<?php echo base_url(); ?>productos/crea_tu_reloj" class="flex-c-m size2 bo-rad-23 s-text2 bgwhite hov1 trans-0-4">
					Crea tu reloj
				</a>
			</div>
		<?php endif; ?>
	</section>
	<?php endif; ?>

	<!-- Content page -->
	<section class="bgwhite p-t-55 p-b-65">
		<div class="container">
			<div class="row">
				<div class="col-sm-6 col-md-4 col-lg-3 p-b-50">

					<!-- =================================================================
					*      					MENU LATERAL DE FILTROS
					* ================================================================= -->
					<?php if ($marca_pag != 'promocion') : ?>
						<div class="leftbar p-r-20 p-r-0-sm">
							<?php $this->load->view('templates/filtros'); ?>
						</div>
					<?php endif; ?>
				</div>

				<div class="col-sm-6 col-md-8 col-lg-9 p-b-50">
					<!--  -->
					<div class="flex-sb-m flex-w p-b-35">
						<!--div class="flex-w">
							<div class="rs2-select2 bo4 of-hidden w-size12 m-t-5 m-b-5 m-r-10">
								<select class="selection-2" name="sorting">
									<option>Ordenar por fecha</option>
									<option>Mas populares</option>
									<option>Mayor precio</option>
									<option>Menor precio</option>
								</select>
							</div>

							<div class="rs2-select2 bo4 of-hidden w-size12 m-t-5 m-b-5 m-r-10">
								<select class="selection-2" name="sorting">
									<option>Valor</option>
									<option>$0.00 - $50.000</option>
									<option>$50.000 - $100.000</option>
									<option>$100.000 - $150.000</option>
									<option>$150.000 - $200.000</option>
									<option>$200.000 +</option>

								</select>
							</div>
						</div-->

						<span class="s-text8 p-t-5 p-b-5">
							<?php echo "Mostrando $cont_ini – $cont_fin de $total_productos resultados" ?> de <?php echo $this->session->nombre_instancia; ?>
						</span>
					</div>

					<!-- Product -->
					<div class="row fila-productos">
						<?php if ($productos):
							foreach($productos as $producto) : ?>
							<?php $detalle = $esManilla ? consulta_manilla($producto->CodProd) : consulta_producto($producto->CodProd); ?>
							<?php 
								$precio_prom = consulta_precio_promocion($producto->CodProd); 
							?>
							<?php if ($detalle) : ?>
							<div class="col-sm-12 col-md-6 col-lg-4 p-b-50">
								<!-- Block2 -->
								<div class="block2">
									<form method="post" action="<?php echo base_url(); ?>cart/add">
									<?php $etiqueta = '';
										if ($detalle->EsNuevo == 'S')
										{
											$etiqueta = 'block2-labelnew';
										}
										else 
										{
											if ($precio_prom)
											{
												$etiqueta = 'block2-labelsale';
											}
										}
									?>
									<div class="block2-img wrap-pic-w of-hidden pos-relative <?php echo $etiqueta ?>">
										<img loading="lazy" data-src="<?php echo $esManilla ? 
														   (strpos($detalle->ImgPrincipal,'-') ? $rutaManillas.'adicionales/'.$detalle->ImgPrincipal : $rutaManillas.$detalle->ImgPrincipal) : 
														   $rutaImagenes.$detalle->ImgPrincipal; ?>" alt="IMG-PRODUCT" class="alto-img lazyload">

										<div class="block2-overlay trans-0-4">

											<?php if ($this->session->IDTipoUsuario != '1') : ?>
											<a href="#" class="block2-btn-addwishlist hov-pointer trans-0-4">
												<i class="icon-wishlist icon_heart_alt" aria-hidden="true"></i>
												<i class="icon-wishlist icon_heart dis-none" aria-hidden="true"></i>
											</a>
											<?php endif; ?>
											
											<?php
												$precio_producto = !$esManilla ? $detalle->Precio : consulta_precio_producto($producto->CodProd)->Precio;

												if ($precio_prom)
												{
													$precio_producto = $precio_prom->Precio / (1 + $detalle->Impuesto / 100);
												}
											?>

											<input type="hidden" name="cantidad" value="1" />
											<input type="hidden" name="coditem" value="<?php echo $producto->CodProd; ?>" />
											<input type="hidden" name="precio" value="<?php echo $precio_producto; ?>" />
											<input type="hidden" name="impuesto" value="<?php echo $precio_producto * $detalle->Impuesto/100; ?>" />
											<input type="hidden" name="descripcion" value="<?php echo $detalle->Descrip; ?>" /><br>											

											<?php if ($this->session->nombre_pagina != 'pulsos') : ?>
											<div class="block2-btn-addcart w-size1 trans-0-4">
												<!-- Button -->
												<?php 
													if (!$esManilla)
													{
														if (isset($detalle->ListaProductos))
														{
															if (strlen($detalle->ListaProductos) > 0)
															{
																$imagenes = explode(',',$detalle->ListaProductos);
	
																$colSpan = count($imagenes) > 3 ? 3 : count($imagenes);
																$tabla = '<table class="table table-light"><tr><td colspan="'.$colSpan.'">VARIACIONES<td></tr><tr>';
																$totalImg = 0;
																foreach($imagenes as $img)
																{
																	$totalImg++;
																	$tabla.= '<td><img loading="lazy" data-src="'.$rutaImagenes.imagen_producto($img).'" class="img-variaciones lazyload"></td>';
																	if ($totalImg > 2) break;
																}
																$tabla.= '</tr></table>';
	
																echo $tabla;
															}
														}
													}
												?>
												<!--button class="block2-btn flex-c-m size1 bg4 bo-rad-23 hov1 s-text14 trans-0-4">
													Añadir al carrito
												</button-->
											</div>
											<?php endif; ?>
										</div>
									</div>
									
									</form>

									<div class="block2-txt p-t-20">
										<span class="block2-item m-text6 p-r-5">
											<?php echo $producto->CodProd; ?>
										</span>
										
										<a href="<?php echo base_url(); ?>productos/detalle<?php if (strlen($etiqueta) != 0) : ?>_promo<?php endif; ?>/<?php echo $producto->CodProd; ?>" class="block2-name dis-block s-text3 p-b-5">
											<?php echo $detalle->Descrip; ?>
										</a>

										<?php if ($marca_pag == 'promocion') : ?>
											<span class="block2-price m-text6 p-r-5 precio-unit precio-unit-tachado">
											$<?php echo number_format(round($detalle->Precio * (1+$detalle->Impuesto/100),0),0,',','.'); ?>&nbsp;<?php echo $this->session->moneda_usuario; ?>
										</span>
											<?php endif; ?>

										<span class="block2-price m-text6 p-r-5 <?php if ($marca_pag == 'promocion') : ?> precio-unit-promo-visible<?php endif; ?>">
											$<?php echo number_format(round($precio_producto * (1+$detalle->Impuesto/100),0),0,',','.'); ?>&nbsp;<?php echo $this->session->moneda_usuario; ?>
										</span>
									</div>
								</div>
							</div>
							<?php endif; ?>
							<?php endforeach; ?>
						<?php endif; ?>
					</div>

					<!-- Pagination -->
					<div class="pagination flex-m flex-w p-t-26">
						<!--a href="#" class="item-pagination flex-c-m trans-0-4 active-pagination">1</a-->
						<?php $p = $inicio; ?>
						<?php for(;$p<=$total_por_pagina + $inicio - 1;$p++) : ?>
							<?php if (strlen($marca_pag) == 0 || $marca_pag == 'f') : ?>
								<a href="<?php echo base_url(); ?>productos/tipo<?php if ($marca_pag == 'f') : ?>_f<?php endif;?>/<?php echo $p; ?>" class="item-pagination flex-c-m trans-0-4 <?php if ($p == $pagina_activa) : ?>active-pagination<?php endif;?>"><?php echo $p; ?></a>
							<?php else : ?>
								<a href="<?php echo base_url(); ?>productos/tipo/<?php echo urlencode($marca_pag); ?>/<?php echo $p; ?>" class="item-pagination flex-c-m trans-0-4 <?php if ($p == $pagina_activa) : ?>active-pagination<?php endif;?>"><?php echo $p; ?></a>
							<?php endif; ?>
						<?php endfor; ?>
						<?php if ($p < $fin) : ?>...<?php endif; ?>
						<?php if ($fin != 0) : ?>
							<?php if (strlen($marca_pag) == 0 || $marca_pag == 'f') : ?>
								<a href="<?php echo base_url(); ?>productos/tipo<?php if ($marca_pag == 'f') : ?>_f<?php endif; ?>/<?php echo $fin; ?>" class="item-pagination flex-c-m trans-0-4 <?php if ($fin == $pagina_activa) : ?>active-pagination<?php endif;?>"><?php echo $fin; ?></a>
							<?php else : ?>
								<a href="<?php echo base_url(); ?>productos/tipo/<?php echo urlencode($marca_pag); ?>/<?php echo $fin; ?>" class="item-pagination flex-c-m trans-0-4 <?php if ($fin == $pagina_activa) : ?>active-pagination<?php endif;?>"><?php echo $fin; ?></a>
							<?php endif; ?>
						<?php endif; ?>
					</div>
				</div>
			</div>
		</div>
	</section>