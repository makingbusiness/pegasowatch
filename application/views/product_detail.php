<?php
   $imagen = $producto->RefBase;
   $primera = true;
   $primeraImg = $producto->CodProd;
   $separador = strpos($imagen,'.') ? '.' : '';
   //$ruta = $this->session->nombre_pagina == 'pulsos' ? "imagenes/manilla/".$imagen.$separador : "imagenes/".$imagen;
   $rutaImagenes = $this->config->item('base_imagenes');;

   $imprimirBoton = true;
   $archivos = array();

   $total_adicionales = 0;
   if (isset($listaRef))
   {
	   foreach($listaRef as $referencia)
	   {
		   //$primeraImg = $referencia->CodProd;
		   array_push($archivos,$rutaImagenes.imagen_producto($referencia->CodProd));
		   $total_adicionales++;
	   }
   }
?>
	<!-- breadcrumb -->
	<a href="<?php echo base_url();?>productos/<?php if ($marca_pag == 'promocion') : ?>promocion/<?php else : ?>tipo/<?php echo $this->session->instancia_base; ?>/1<?php endif; ?>" class="badge badge-dark ml-2 mt-1 mr-2 p-2"><?php echo ucfirst($this->session->nombre_pagina); ?></a>
	<a href="<?php echo base_url();?>productos/detalle<?php if ($marca_pag == 'promocion') : ?>_promo<?php endif; ?>/<?php echo $producto_anterior; ?>" class="badge badge-dark mt-1 mr-2 p-2"><?php if (strlen($producto_anterior) > 0) : ?>Anterior<?php endif; ?></a>
	<a href="<?php echo base_url();?>productos/detalle<?php if ($marca_pag == 'promocion') : ?>_promo<?php endif; ?>/<?php echo $producto_siguiente; ?>" class="badge badge-dark mt-1 p-2"><?php if (strlen($producto_siguiente) > 0) : ?>Siguiente<?php endif; ?></a>
	<!--div class="bread-crumb bgwhite flex-w p-l-52 p-r-15 p-t-30 p-l-15-sm">
		<a href="<?php echo base_url(); ?>" class="s-text16">
			Inicio
			<i class="fa fa-angle-right m-l-8 m-r-9" aria-hidden="true"></i>
		</a>

		<a href="<?php echo base_url(); ?>productos/<?php echo $this->session->userdata('nombre_pagina'); ?>/1" class="s-text16">
			<?php echo $this->session->userdata('nombre_pagina'); ?>
			<i class="fa fa-angle-right m-l-8 m-r-9" aria-hidden="true"></i>
		</a>

		<a href="#" class="s-text16">
		<?php echo $this->session->userdata('nombre_pagina'); ?>
			<i class="fa fa-angle-right m-l-8 m-r-9" aria-hidden="true"></i>
		</a>

		<span class="s-text17">

		</span>
	</div-->

	<!-- Product Detail -->
	<div class="container bgwhite p-t-10 p-b-40">
		<div class="flex-w flex-sb">

			<?php foreach($archivos as $archivo) : ?>
				<?php 
					$listaAdicionales = imagen_adicional($primeraImg);
				?>
			<?php endforeach; ?>

			<input type="hidden" id="tipoMoneda" value="<?php echo $this->session->moneda_usuario; ?>" />

		    <div class="<?php if ($total_adicionales > 0) : ?>caja-img<?php else: ?>caja-img2<?php endif; ?>">
				<?php if ($total_adicionales > 0) : ?>
					<?php if (count($listaAdicionales)>0) : ?>
					<div class="caja-izq">
							<?php foreach($listaAdicionales as $adicional) : ?>
								<img class="img-owl img-adicional" src="<?php echo $adicional; ?>" alt="<?php echo 'img'; ?>">
							<?php endforeach; ?>
			
							<img class="img-owl img-adicional" src="<?php echo $rutaImagenes.imagen_producto($primeraImg); ?>" alt="<?php echo $archivo; ?>">
					</div>
					<?php endif; ?>				
				<?php endif; ?>				

				<?php 
					$precio_prom = consulta_precio_promocion($primeraImg); 
					$etiqueta = '';
					$promocion = '';

					if ($precio_prom)
					{
						$promocion = $precio_prom->Precio;
						$etiqueta = 'block2-labelsale';
					}		
				?>

				<div class="<?php if (count($archivos)>0) : ?>caja-der<?php else: ?>caja-der2<?php endif; ?>">
					<div id="foto-ampliada" class="block2-img wrap-pic-w of-hidden pos-relative <?php echo $etiqueta; ?>">
						<img class="img-ampliada" src="<?php echo $rutaImagenes.imagen_producto($primeraImg); ?>">
					</div>

				</div>

				<?php if (count($archivos) > 1) : ?>
					<div class="owl-carousel owl-theme">
						<?php foreach($archivos as $archivo) : ?>
							<?php 
								$codigo_owl = substr(explode('/',$archivo)[4],0,strlen(explode('/',$archivo)[4])-4); 
								$promocion = '';
								$etiqueta = '';

								if ($marca_pag == 'promocion')
								{
									$precio_prom = consulta_precio_promocion($codigo_owl); 
			
									if ($precio_prom)
									{
										$promocion = $precio_prom->Precio;
										$etiqueta = 'block2-labelsale';
									}		
								}
							?>

							<input type="hidden" id="h_<?php echo $codigo_owl; ?>" value="<?php echo $promocion; ?>" />

							<div class="card-owl">
								<img class="img-owl img-carousel" src="<?php echo $archivo; ?>" alt="<?php echo $archivo; ?>">
								<div class="letra-owl"><?php echo $codigo_owl; ?></div>
							</div>
							<?php 
								if ($primera)
								{
									$primeraImg = explode('/',$archivo)[4];
									//$primeraImg = explode('.',$primeraImg)[0];
									$primeraImg = substr($primeraImg, 0, strlen($primeraImg)-4);
									$primera = false;
								}
							?>
						<?php endforeach; ?>
					</div>
				<?php endif; ?>
			</div>

			<div class="w-size14 p-t-8 respon5">
				<form id="form-detalle" method="post" action="<?php echo base_url(); ?>cart/add">
				<h4 class="product-detail-name m-text16 p-b-4">
					<?php echo $primeraImg; ?>
				</h4>
				<input type="hidden" id="hid-producto" value="<?php echo $this->session->nombre_pagina; ?>" />				

				<span id="span-tachado" class="m-text15 precio-unit <?php if (strlen($promocion) > 0) : ?>precio-unit-tachado<?php endif; ?>">
					$<?php echo number_format(round($producto->Precio * (1 + $producto->Impuesto/100)),0); ?>&nbsp;<?php echo $this->session->moneda_usuario; ?>
				</span>

				<span id="span-promo" class="m-text15 <?php if (strlen($promocion) == 0) : ?>precio-unit-promo<?php else : ?>precio-unit-promo-visible<?php endif; ?>">
					<?php 
						if (strlen($promocion) == 0)
						{
							$precio_carro = $producto->Precio;
						}
						else
						{
							$precio_carro = intval($promocion) / (1 + $producto->Impuesto/100);
						}
					?>
					$<?php echo number_format(round($precio_carro * (1 + $producto->Impuesto/100)),0); ?>&nbsp;<?php echo $this->session->moneda_usuario; ?>
				</span>

				<p class="s-text8 p-t-6 det-item">
					<?php echo $producto->Descrip; ?>
				</p>

				<!--  -->
				<div class="p-t-15 p-b-20">
					<!--div class="flex-m flex-w p-b-10">
						<div class="s-text15 w-size15 t-center">
							Talla
						</div>

						<div class="rs2-select2 rs3-select2 bo4 of-hidden w-size16">
							<select class="selection-2" name="size">
								<option>Seleccione una talla</option>
								<option>Talla S</option>
								<option>Talla M</option>
								<option>Talla L</option>
								<option>Talla XL</option>
							</select>
						</div>
					</div>

					<div class="flex-m flex-w">
						<div class="s-text15 w-size15 t-center">
							Color
						</div>

						<div class="rs2-select2 rs3-select2 bo4 of-hidden w-size16">
							<select class="selection-2" name="color">
								<option>Seleccione un color</option>
								<option>Gris</option>
								<option>Negro</option>
								<option>Blanco</option>
								<option>Dorado</option>
							</select>
						</div>
					</div-->

					<div class="flex-l-m flex-w p-t-6">
						<div class="flex-m flex-w">
							<div class="flex-w bo5 of-hidden m-r-22 m-t-6 m-b-10">
								<?php if ($imprimirBoton) : ?>
									<button class="btn-num-dp-down color1 flex-c-m size7 bg8 eff2">
										<i class="fs-12 fa fa-minus" aria-hidden="true"></i>
									</button>
								<?php endif; ?>

								<input class="size8 m-text18 t-center num-product" type="number" name="cantidad" value="">

								<?php if ($imprimirBoton) : ?>
									<button class="btn-num-dp-up color1 flex-c-m size7 bg8 eff2">
										<i class="fs-12 fa fa-plus" aria-hidden="true"></i>
									</button>
								<?php endif; ?>
							</div>

							<!--input type="hidden" name="cantidad" value="1" /-->
							<input type="hidden" id="frmCodItem" name="coditem" value="<?php echo $primeraImg; ?>" />
							<input type="hidden" id="frmPrecioItem" name="precio" value="<?php echo $precio_carro; ?>" />
							<input type="hidden" id="frmImpuestoItem" name="impuesto" value="<?php echo $precio_carro * ($producto->Impuesto/100); ?>" />
							<input type="hidden" name="descripcion" value="<?php echo $producto->Descrip; ?>" /><br>
							<input type="hidden" name="frmPartesManilla" value="<?php echo ''; ?>" /><br>

							<div class="btn-addcart-product_detail size9 trans-0-4 m-t-10 m-b-10">
							<!-- Button -->
							<button class="btn-addcart flex-c-m sizefull bg1 bo-rad-23 hov1 s-text14 trans-0-4">
								Añadir al carrito
							</button>
							</div>
						</div>
					</div>
				</div>

				<div class="p-b-45">
					<span class="s-text8 m-r-35 ref-item">
						<?php echo $primeraImg; ?>
					</span>

					<!--span class="s-text8">Etiquetas: Formal</span-->

				</div>

				<!--  -->
				<div class="wrap-dropdown-content bo6 p-t-15 p-b-14 active-dropdown-content">
					<h5 class="js-toggle-dropdown-content flex-sb-m cs-pointer m-text19 color0-hov trans-0-4">

						<i class="down-mark fs-12 color1 fa fa-minus dis-none" aria-hidden="true"></i>
						<i class="up-mark fs-12 color1 fa fa-plus" aria-hidden="true"></i>
					</h5>

					<div class="dropdown-content dis-none p-t-15 p-b-23">
						<p class="s-text8 ampl-item">
							<?php 
								if (strlen($producto->DescAmpliada) == 0)
								{
									for($i=0;$i<10;$i++)
									{
										echo str_repeat(' ', 50).'<br>'; 
									}
								}
								else
								{
									echo $producto->DescAmpliada;
								}
							 ?>
						</p>
					</div>
				</div>

				<!--div class="wrap-dropdown-content bo7 p-t-15 p-b-14">
					<h5 class="js-toggle-dropdown-content flex-sb-m cs-pointer m-text19 color0-hov trans-0-4">
						Información adicional
						<i class="down-mark fs-12 color1 fa fa-minus dis-none" aria-hidden="true"></i>
						<i class="up-mark fs-12 color1 fa fa-plus" aria-hidden="true"></i>
					</h5>

					<div class="dropdown-content dis-none p-t-15 p-b-23">
						<p class="s-text8">
							Fusce ornare mi vel risus porttitor dignissim. Nunc eget risus at ipsum blandit ornare vel sed velit. Proin gravida arcu nisl, a dignissim mauris placerat
						</p>
					</div>
				</div-->
				</form>
			</div>
		</div>
	</div>
