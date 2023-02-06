<?php 
	$esManilla = false; 
	$codigoImp = '';
	$rutaImp = '';
?>
	<!-- Cart -->
	<section class="cart bgwhite p-t-70 p-b-100">
		<?php if($this->cart->contents()) : ?>
		<div class="container">
			<!-- Cart item -->
			<form id="forma_carro" method="post" action="<?php echo base_url(); ?>cart/update">
			<div class="container-table-cart pos-relative">
				<div class="wrap-table-shopping-cart bgwhite">
					<table class="table-shopping-cart">
						
						<?php $i = 0;
							$totalPedido = 0;
							$totalImpuesto = 0;
						?>
						<tr class="table-head">
							<th class="column-1"></th>
							<th class="column-2">Producto</th>
							<th class="column-3">Precio</th>
							<th class="column-4 p-l-70">Cantidad</th>
							<th class="column-5">Total</th>
						</tr>
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
						<tr class="table-row">
							<td class="column-1">
								<div class="cart-img-product b-rad-4 o-f-hidden">
									<img src="<?php echo $rutaImp.imagen_producto($codigoImp,$esManilla); ?>" alt="IMG-PRODUCT">
								</div>
							</td>
							<td class="column-2 id-product"><?php echo $items['id']; ?></td>
							<td class="column-3 precio-unit">$<?php echo round($items['price'] + $items['impuesto'],0); ?></td>
							<td class="column-4">
								<div class="flex-w bo5 of-hidden w-size17">
									<button class="btn-num-product-down color1 flex-c-m size7 bg8 eff2">
										<i class="fs-12 fa fa-minus" aria-hidden="true"></i>
									</button>

									<input class="size8 m-text18 t-center num-product" type="number" name="num-product<?php echo $i; ?>" value="<?php echo $items['qty']; ?>">

									<button class="btn-num-product-up color1 flex-c-m size7 bg8 eff2">
										<i class="fs-12 fa fa-plus" aria-hidden="true"></i>
									</button>
								</div>

							<?php echo '<input type="hidden" name="item_impuesto['.$i.']" value="'.$items['impuesto'].'" />';?>
							<?php echo '<input class="row-cart" type="hidden" name="item_rowid['.$i.']" value="'.$items['rowid'].'" />';?>
							<?php echo '<input type="hidden" name="item_name['.$i.']" value="'.$items['name'].'" />';?>
							<?php echo '<input type="hidden" name="item_code['.$i.']" value="'.$items['id'].'" />';?>
							<?php echo '<input class="qty-cart" type="hidden" name="item_qty['.$i.']" value="'.$items['qty'].'" />';?>
							<?php $totalPedido += round($items['qty'] * $items['price'],0)	; ?>
							<?php $totalImpuesto += round($items['qty'] * $items['impuesto'],0); ?>	
							<?php $i++; ?>
							</td>
							<td class="column-5 subtotal-unit">$<?php echo round($items['qty']*($items['price']+$items['impuesto']),0); ?></td>
					
						</tr>
						<?php endforeach;
							$this->session->set_userdata('totalPedido',$totalPedido);
							$this->session->set_userdata('totalImpuesto',$totalImpuesto);
						?>
					</table>
				</div>
			</div>

			<div class="flex-w flex-sb-m p-t-25 p-b-25 bo8 p-l-35 p-r-60 p-lr-15-sm">
				<!--div class="flex-w flex-m w-full-sm">
					<div class="size11 bo4 m-r-10">
						<input class="sizefull s-text7 p-l-22 p-r-22" type="text" name="coupon-code" placeholder="Coupon Code">
					</div>

					<div class="size12 trans-0-4 m-t-10 m-b-10 m-r-10">
						<button class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4">
							Usar cupón
						</button>
					</div>
				</div-->

				<div class="size10 trans-0-4 m-t-10 m-b-10">
					<button class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4" type="submit" id="btnActualizarCarro">
						Actualizar
					</button>
				</div>

				<?php if ($this->session->has_userdata('prod_continuar')) : ?>
					<div class="size10 trans-0-4 m-t-10 m-b-10">
						<a class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4" 
							href="<?php echo base_url(); ?>productos/detalle/<?php echo $this->session->prod_continuar; ?>">
							Regresar
						</a>
					</div>
				<?php endif; ?>
			</div>
			</form>

			<!-- Total -->
			<form method="post" id="frmFinPedido" action="<?php echo base_url(); ?>pedidos/guardar_pedido/0">
			<div class="bo9 w-size18 p-l-40 p-r-40 p-t-30 p-b-38 m-t-30 m-r-0 m-l-auto p-lr-15-sm">

				<h5 class="m-text20 p-b-24">
					Compra
				</h5>

				<!--  -->
				<div class="flex-w flex-sb-m p-b-12">
					<span class="s-text18 w-size19 w-full-sm">
						Subtotal:
					</span>

					<span class="m-text21 w-size20 w-full-sm" id="sub-carrito">
						$<?php echo $totalPedido; ?>
					</span>
				</div>

				<div class="flex-w flex-sb-m p-b-12">
					<span class="s-text18 w-size19 w-full-sm">
						Impuesto:
					</span>

					<span class="m-text21 w-size20 w-full-sm" id="imp-carrito">
						$<?php echo $totalImpuesto; ?>
					</span>
				</div>

				<!--  -->
				<div class="flex-w flex-sb bo10 p-t-15 p-b-20">
					<span class="s-text18 w-size19 w-full-sm">
						Envío:
					</span>

					<div class="w-size20 w-full-sm">
						<!--p class="s-text8 p-b-23">
							Para pedidos menores a $100.000 el costo de env&iacute;o es de $12.000
						</p-->

						<!--span class="s-text19">
							Valor de envío
						</span-->

						
						<span class="fs-11">N&uacute;mero de Documento *</span>
						<div class="size13 bo4 m-b-12">
							<input class="sizefull s-text7 p-l-15 p-r-15" type="text" name="documentoEnvio" value="<?php echo $this->session->CodClie; ?>" required>
						</div>

						<span class="fs-11">Nombres *</span>
						<div class="size13 bo4 m-b-12">
							<input class="sizefull s-text7 p-l-15 p-r-15" type="text" name="nombreEnvio" value="<?php echo $this->session->Nombres; ?>" required>
						</div>

						<span class="fs-11">Apellidos</span>
						<div class="size13 bo4 m-b-12">
							<input class="sizefull s-text7 p-l-15 p-r-15" type="text" name="apellidoEnvio" value="<?php echo $this->session->Apellidos; ?>">
						</div>

						<?php if ($this->session->moneda_usuario != 'COP') : ?>
						<span class="fs-11">Pa&iacute;s</span>
						<div class="size13 bo4 m-b-12">
							<select class="sizefull s-text7 p-l-15 p-r-15" name="paisEnvio" id="paisEnvio">
								<option></option>
								<?php foreach(lista_paises() as $pais) : ?>
									<option value="<?php echo $pais->IDPais; ?>" <?php if ($pais->IDPais == $this->session->paisEnvio) : ?>selected<?php endif; ?>><?php echo $pais->Descrip; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						<?php endif; ?>
						
						<span class="fs-11">Departamento *</span>
						<div class="size13 bo4 m-b-12">
							<select class="sizefull s-text7 p-l-15 p-r-15" name="estadoEnvio" id="estadoEnvio">
								<?php 
									if ($this->session->moneda_usuario == 'COP')
									{
										$this->session->set_userdata('paisEnvio',2);
									}
								?>
								<option></option>
								<?php foreach(lista_estados($this->session->paisEnvio) as $estado) : ?>
									<option value="<?php echo $estado->IDEstado; ?>" <?php if ($estado->IDEstado == $this->session->estadoEnvio) : ?>selected<?php endif; ?>><?php echo $estado->Descrip; ?></option>
								<?php endforeach; ?>
							</select>
						</div>
						
						<span class="fs-11">Ciudad *</span>
						<div class="size13 bo4 m-b-12">
							<select class="sizefull s-text7 p-l-15 p-r-15" name="ciudadEnvio" id="ciudadEnvio">
								<option></option>
								<?php foreach(lista_ciudades($this->session->estadoEnvio) as $ciudad) : ?>
									<option value="<?php echo $ciudad->IDCiudad; ?>" <?php if ($ciudad->IDCiudad == $this->session->ciudadEnvio) : ?>selected<?php endif; ?>><?php echo $ciudad->Descrip; ?></option>
								<?php endforeach; ?>
							</select>
						</div>

						<span class="fs-11">Direcci&oacute;n *</span>
						<div class="size13 bo4 m-b-12">
							<input class="sizefull s-text7 p-l-15 p-r-15" type="text" name="direccionEnvio" value="<?php echo $this->session->direccionEnvio; ?>" required>
						</div>

						<span class="fs-11">Email *</span>
						<div class="size13 bo4 m-b-12">
							<input class="sizefull s-text7 p-l-15 p-r-15" type="text" name="correoEnvio" value="<?php echo $this->session->correoEnvio; ?>" required>
						</div>
						
						<span class="fs-11">Tel&eacute;fono</span>
						<div class="size13 bo4 m-b-12">
							<input class="sizefull s-text7 p-l-15 p-r-15" type="text" name="telefonoEnvio" value="<?php echo $this->session->telefonoEnvio; ?>">
						</div>

						<span class="fs-11">Observaciones</span>
						<div class="size13 bo4 m-b-22">
							<input class="s-text7 p-l-15 p-r-15" type="textarea" rows="10" name="obsEnvio" value="<?php echo $this->session->obsEnvio; ?>">
						</div>

						<div class="size19 bo4 m-b-22 fs-11">
							<input type="checkbox" id="chk-datos" name="chk-datos">&nbsp;
							<label for="chk-datos">
								Autorizo Tratamiento de mis datos.
							</label>
							 <br><a href="<?php echo base_url(); ?>ptd" target="_blank"><p class="fs-11" style="font-weight: bold;text-decoration: underline;">Ver aquí</p></a>
						</div>

						<!--div class="size14 trans-0-4 m-b-10">
							<button class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4">
								Actualizar total
							</button>
						</div-->
					</div>
				</div>

				<!--  -->
				<div class="flex-w flex-sb-m p-t-26 p-b-30">
					<span class="m-text22 w-size19 w-full-sm">
						Total:
					</span>

					<span class="m-text21 w-size20 w-full-sm" id="total-carrito">
						$<?php echo $totalPedido + $totalImpuesto; ?>
					</span>
				</div>

				<div class="size15 trans-0-4">
					<?php if (false) : ?>
					<!-- Button -->
						<button class="flex-c-m sizefull bg1 bo-rad-23 hov1 s-text1 trans-0-4 btn-registro-compra">
							Reg&iacute;strese para continuar
						</button>
					<?php else : ?>
						<div class="w-size25 margin-center mt-3 dis-inline-block">
							<button class="flex-c-m size2 bg1 bo-rad-23 hov1 s-text14 trans-0-4" id="btn-finalizar-compra" type="submit" disabled>Finalizar compra</button>
						</div>
	
						<div class="w-size25 margin-center mt-3 dis-inline-block">
							<?php if ($this->session->IDTipoUsuario == '2') : ?>
								<a href="<?php echo base_url(); ?>pedidos/guardar_pedido/1" class="flex-c-m size2 bg1 bo-rad-23 hov1 s-text14 trans-0-4 ml-3" type="submit">Enviar pedido</a>
							<?php endif; ?>
						</div>
					<?php endif; ?>
				</div>
			</div>
			</form>
		</div>
		<?php else : ?>
			<section class="bg-title-page p-t-40 p-b-50 flex-col-c-m" style="background-color: black; min-height: 150px;">
				<h2 class="l-text3 t-center">No hay ítems en el carro</h2>
		</section>
		<?php endif; ?>
	</section>