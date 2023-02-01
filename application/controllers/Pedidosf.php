<?php
class Pedidosf extends CI_Controller
{
    	public function __construct()
    	{
        		parent::__construct();
        		$this->load->model('pedidos_model');
            $this->load->model('varios_model');
        		$this->load->library('session');
    	}

    	public function guardar_pedido($tipo = 0)
    	{
//			if ($tipo == 0)
			{
				$datosEnvio = array(
					'paisEnvio'            => $this->input->post('pais_envio'),
					'estadoEnvio'          => $this->input->post('estado_envio'),
					'ciudadEnvio'          => $this->input->post('ciudad_envio'),
					'direccionEnvio'       => $this->input->post('direccion_envio'),
					'telefonoEnvio'        => $this->input->post('telefono_envio'),
					'obsEnvio'             => $this->input->post('observaciones_envio'),
					'totalPedido'          => $this->cart->total(),
					'totalImpuesto'        => 0,
					'Nombres'              => $this->input->post("nombres"),
					'Apellidos'            => $this->input->post("apellidos")
				);

				$this->session->set_userdata($datosEnvio);
			}

            $data['nombre_pagina'] = 'usuarios';
			$data['estilo_header'] = '';
			
			$info = array(
				'Usuario'          => $this->session->correo_usuario,
				'CodClie'          => $this->session->documento_usuario,
				'Valor'            => $this->cart->total(),
				'Impuesto'         => 0,
				'Observaciones'    => $this->input->post('observaciones_envio'),
				'Pais'             => $this->input->post('pais_envio'),
				'Departamento'     => $this->input->post('estado_envio'),
				'Ciudad'           => $this->input->post('ciudad_envio'),
				'Direccion'        => $this->input->post('direccion_envio'),
				'Telefono'         => $this->input->post('telefono_envio')
			);

			$this->pedidos_model->guardar_fabrica($info);

			$this->load->view('templates/headerf',$data);
			$this->load->view('finalizaCompraf',$datosEnvio);
			$this->load->view('templates/footerf');
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
		
    		$this->load->view('templates/headerf');
    		$this->load->view('finalizaCompraf',$data);
    		$this->load->view('templates/footerf');
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
