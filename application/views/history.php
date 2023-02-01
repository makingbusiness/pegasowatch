
	<!-- Title Page -->
	<section class="bg-title-page p-t-40 p-b-50 flex-col-c-m" style="background-color: black;">
		<h2 class="l-text2 t-center">
			Historial de pedidos
		</h2>
	<div class="text-center profile-img">
	  <img src="<?php echo base_url(); ?>imagenes/banner/profile-image.png"  alt="profile-image">
	</div>
	</section>

	<!-- content page -->
	<section class="bgwhite p-t-66 p-b-60">
		<div class="container">
			<div class="row justify-content-md-center">
				<div class="col-md-11 p-b-30 wrap-table-shopping-cart">
					<table class="table-historial table table-sm table-borderless table-hover table-striped table-responsive">
					  <thead>
						<tr>
						  <th width="11%" scope="col">#Pedido</th>
						  <th width="16%" scope="col">Fecha</th>
						  <th width="35%" scope="col">Producto</th>
						  <th width="12%" scope="col">Cantidad</th>
						  <th>Valor unitario</th>
						  <th>Impuesto</th>
						  <th width="15%" scope="col">Total</th>
						  <!--th width="11%" scope="col">Estado</th-->
						</tr>
					  </thead>
					  <tbody>
						<?php foreach(lista_pedidos_usuario() as $pedido) : ?>				  
						<tr>
						  <td><?php echo $pedido->IDPedido; ?></td>
						  <td><?php echo $pedido->FechaPedido; ?></td>
						  <td><?php echo $pedido->Descripcion; ?></td>
						  <td><?php echo $pedido->Cantidad; ?></td>
						  <td><?php echo $pedido->Valor; ?></td>
						  <td><?php echo $pedido->Impuesto; ?></td>
						  <td>$<?php echo $pedido->Cantidad * ($pedido->Valor + $pedido->Impuesto); ?></td>
						  <!--td><span class="entregado"></span>Entregado</td-->
						</tr>
						<?php endforeach; ?>
					  </tbody>
					</table>
				</div>
			</div>
		</div>
	</section>