<?php 
    $valorEnvio = 0; //$this->session->totalPedido + $this->session->totalImpuesto < 100000 ? 12000 : 0; 
    $esPrueba = $this->config->item('esProduccion') == 'S' ? "false" : "true";
?>
	<!-- Title Page -->
	<section class="bg-title-page p-t-40 p-b-50 flex-col-c-m" style="background-color: black; min-height: 150px;">
		<h2 class="l-text3 t-center">
		<?php if ($this->cart->contents()) : ?>Resumen compra<?php else : ?>Recibimos su pedido<?php endif; ?>
		</h2>
		<p class="s-text1">
			<?php if ($this->cart->contents()) : ?>
				<table class="m-text13" width="60%">
					<tr><td colspan="2">&nbsp;</td></tr>
					<tr><td>Pa&iacute;s</td><td><?php echo consulta_pais_codigo($this->session->paisEnvio); ?></td></tr>
					<tr><td>Departamento</td><td><?php echo consulta_estado_codigo($this->session->estadoEnvio); ?></td></tr>
					<tr><td>Ciudad</td><td><?php echo consulta_ciudad_codigo($this->session->ciudadEnvio); ?></td></tr>
					<tr><td>Direcci&oacute;n</td><td><?php echo $this->session->direccionEnvio; ?></td></tr>
					<tr><td>Tel&eacute;fono</td><td><?php echo $this->session->telefonoEnvio; ?></td></tr>
					<tr><td>Observaciones</td><td><?php echo $this->session->obsEnvio; ?></td></tr>
					<tr><td>Valor pedido</td><td><?php echo $this->session->totalPedido+$this->session->totalImpuesto; ?></td></tr>
					<?php if ($valorEnvio != 0) : ?>
						<tr><td>Valor env&iacute;o</td><td><?php echo $valorEnvio; ?></td></tr>
						<tr><td>Total</td><td><?php echo $this->session->totalPedido+$this->session->totalImpuesto+$valorEnvio; ?></td></tr>
					<?php endif; ?>
				</table>
			<?php endif; ?>
		</p>
	</section>

	<?php
		$nombre = $this->session->Nombres.' '.$this->session->Apellidos;
	?>
	<!-- content page -->
	<section class="bgwhite p-t-66 p-b-60">
		<div class="container">
			<div class="row justify-content-md-center">
				<div class="col-md-6 p-b-30 text-center">
					<?php if($this->cart->contents()) : ?>
						<form id="form-pago" method="post" action="<?php echo base_url(); ?>pedidos/guardar_pedido/1">
							<button id="btn-pago" type="submit">
							<script
								src="https://checkout.epayco.co/checkout.js" class="epayco-button"
								data-epayco-key="75e293272d5223157f4fc707944f4df9"
								data-epayco-amount="<?php echo $this->session->totalPedido + $this->session->totalImpuesto+$valorEnvio; ?>"
								data-epayco-tax="<?php echo $this->session->totalImpuesto; ?>"
								data-epayco-tax-base="<?php echo $this->session->totalPedido; ?>"
								data-epayco-name="Compra Pegaso Watch"
								data-epayco-description="Compra Web Pegaso Watch"
								data-epayco-currency="cop"
								data-epayco-country="co"
								data-epayco-email-billing="<?php echo $this->session->Email; ?>"
								data-epayco-name-billing="<?php echo $nombre; ?>"
								data-epayco-address-billing="<?php echo $this->session->direccionEnvio; ?>"
								data-epayco-name-mobilephone-billing="<?php echo $this->session->telefonoEnvio; ?>"
								data-epayco-number-doc-billing="<?php echo $this->session->CodClie; ?>"
								data-epayco-test="<?php echo $esPrueba; ?>"
								data-epayco-external="true"
								data-epayco-response="<?php echo base_url(); ?>pedidos/confirmacion"
								data-epayco-confirmation="<?php echo base_url(); ?>pedidos/confirmacion">
							</script>
							</button>
						</form>
					<?php else : ?>
						Para ciudades principales, el pedido se entrega en 2 d&iacute;as h&aacute;biles.<br>
						Para ciudades intermedias, el pedido se entrega m&aacute;ximo en 5 d&iacute;as h&aacute;biles
					<?php endif; ?>
				</div>
			</div>
		</div>
	</section>
