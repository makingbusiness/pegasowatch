<?php
class Pedidos extends CI_Controller
{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('pedidos_model');
		$this->load->model('productos_model');
		$this->load->model('varios_model');
		$this->load->library('session');
	}
	
	// $tipo = 1: pedido de cliente (no se hace pago por el sitio)
	public function guardar_pedido($tipoPedido = 100, $observaciones = '')
	{
		if ($this->cart->total() == 0)
		{
			redirect('cart');
		}
		else
		{

			if ($tipoPedido == 100)
			{
				$tipo = $this->input->post('tipo');
				$observaciones = $this->input->post('observaciones') ? $this->input->post('observaciones') : '';
			}
			else
			{
				$tipo = $tipoPedido;
				$observaciones = '';
			}
	
			$datosEnvio = array(
				'CodClie'           => $this->input->post('documentoEnvio') ? $this->input->post('documentoEnvio') : $this->session->CodClie,
				'nombreEnvio'       => $this->input->post('nombreEnvio') ? $this->input->post('nombreEnvio') : $this->session->Nombres,
				'apellidoEnvio'     => $this->input->post('apellidoEnvio') ? $this->input->post('apellidoEnvio') : $this->session->Apellidos,
				'Email'             => $this->input->post('correoEnvio') ? $this->input->post('correoEnvio') : $this->session->Email,
				'paisEnvio'         => $this->input->post('paisEnvio') ? $this->input->post('paisEnvio') : $this->session->paisEnvio,
				'estadoEnvio'       => $this->input->post('estadoEnvio') ? $this->input->post('estadoEnvio') : $this->session->estadoEnvio,
				'ciudadEnvio'       => $this->input->post('ciudadEnvio') ? $this->input->post('ciudadEnvio') : $this->session->ciudadEnvio,
				'direccionEnvio'    => $this->input->post('direccionEnvio') ? $this->input->post('direccionEnvio') : $this->session->direccionEnvio,
				'telefonoEnvio'     => $this->input->post('telefonoEnvio') ? $this->input->post('telefonoEnvio') : $this->session->telefonoEnvio,
				'obsEnvio'          => $observaciones
			);
		
			$this->session->set_userdata($datosEnvio);
	
			$basura = array(
				'qty'    => 1,
				'rowid'  => 'El tipo es '.$tipo
			);
	
			$this->db->insert('basura', $basura);
			
			if ($tipo == 1)
			{
				$this->pedidos_model->guardar_pedido($tipo,$observaciones);
			}
		
			$this->load->view('templates/header');
			$this->load->view('finalizaCompra');
			$this->load->view('templates/footer');
		}
	}
	
	public function historia()
	{
		$data['historia'] = $this->pedidos_model->lista_pedidos_usuario();
		
		$this->load->view('templates/header');
		$this->load->view('history',$data);
		$this->load->view('templates/footer');
	}
	
	public function confirmacion()
	{
		/*En esta página se reciben las variables enviadas desde ePayco hacia el servidor.
		Antes de realizar cualquier movimiento en base de datos se deben comprobar algunos valores
		Es muy importante comprobar la firma enviada desde ePayco
		Ingresar  el valor de p_cust_id_cliente lo encuentras en la configuración de tu cuenta ePayco
		Ingresar  el valor de p_key lo encuentras en la configuración de tu cuenta ePayco
		*/
		$p_cust_id_cliente = $this->config->item('id_epayco');
		$p_key             = $this->config->item('key_epayco');
		$x_ref_payco      = $this->input->post('x_ref_payco');
		$x_transaction_id = $this->input->post('x_transaction_id');
		$x_amount         = $this->input->post('x_amount');
		$x_currency_code  = $this->input->post('x_currency_code');
		$x_signature      = $this->input->post('x_signature');
		$signature = hash('sha256', $p_cust_id_cliente . '^' . $p_key . '^' . $x_ref_payco . '^' . $x_transaction_id . '^' . $x_amount . '^' . $x_currency_code);
		$x_response     = $this->input->post('x_response');
		$x_motivo       = $this->input->post('x_response_reason_text');
		$x_id_invoice   = $this->input->post('x_id_invoice');
		$x_autorizacion = $this->input->post('x_approval_code');
		//Validamos la firma
		if ($x_signature == $signature) 
		{
			/*Si la firma esta bien podemos verificar los estado de la transacción*/
			$x_cod_response = $this->input->post('x_cod_response');
			$resultado = '';
			switch ((int) $x_cod_response) 
			{
				case 1:
					// code transacción aceptada
					$resultado = "transacción aceptada";
					$mensaje = "Procederemos a enviar su pedido";
					$this->guardar_pedido(1);
					break;
				case 2:
					// code transacción rechazada
					$resultado = "transacción rechazada";
					break;
				case 3:
					// code transacción pendiente
					$resultado = "transacción pendiente";
					$mensaje = "Su pedido ser&aacute; despachado una vez que recibamos confirmaci&oacute;n del pago."; 
					$this->guardar_pedido(2);
					break;
				case 4:
					// code transacción fallida
					$resultado = "transacción fallida";
					break;
			}
		} 
		else 
		{
			$resultado = "Firma no valida";
		}
		
		$data['resultado_epayco'] = $resultado;
			
		$this->load->view('templates/header');
		$this->load->view('finalizaCompra',$data);
		$this->load->view('templates/footer');
	}
		
	public function prueba_pedido()
	{
		$data = array(
            'rowid'   => 'No llega nada pero eso no importa',
            'qty'     => 50
        );
		
		$this->db->insert('basura',$data);
	}
}