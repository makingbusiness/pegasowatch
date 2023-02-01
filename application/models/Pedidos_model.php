<?php 
class Pedidos_model extends CI_Model{
	public $num_pedido = '';
	public function __construct()
	{
		parent::__construct();
		$this->load->model('pedidos_model');
		$this->load->model('varios_model');
		$this->load->model('clientes_model');
		$this->load->model('usuarios_model');
		$this->load->model('productos_model');
		$this->load->library('session');
		$this->load->library('email');
        $this->load->library('elibom');
	}
	
	public function guardar_pedido($tipo,$observaciones = ''){

		/*if (isset($this->session->obsEnvio))
		{
			$observaciones .= ' '.$this->session->obsEnvio;
		}*/

		 $data = array(
            'Usuario'       => $this->session->Email,
			'Valor'         => $this->cart->total(),//this->session->total_pedido,
			'Impuesto'      => $this->session->totalImpuesto,
            'IDPlan'        => 1,
            'Observaciones' => $observaciones,
			'Pais'          => $this->session->paisEnvio,
			'Departamento'  => $this->session->estadoEnvio,
			'Ciudad'        => $this->session->ciudadEnvio,
			'Direccion'     => $this->session->direccionEnvio,
			'Telefono'      => $this->session->telefonoEnvio,
			'CodClie'       => $this->session->CodClie,
			'Estado'        => 0
        );
		
		$nombreTabla = 'pedidos';//$tipo == 0 ? 'pedidos_temp' : 'pedidos';
		
		$basura = array(
			'qty'    => 1,
			'rowid'  => 'Guardando en '.$nombreTabla
		);

		$this->db->insert('basura', $basura);

		$insert = $this->db->insert($nombreTabla, $data);
		$this->num_pedido = $this->db->insert_id();
		
		$basura = array(
			'qty'    => 1,
			'rowid'  => 'Guardando detalle '.$this->num_pedido
		);

		$this->db->insert('basura', $basura);

		$this->guardar_detalle($tipo);
		
		//if ($tipo == 1)
		{
			$this->guardar_pedido_archivo($this->num_pedido);

			if ($this->config->item('esProduccion') == 'S')
			{
				$this->enviar_pedido_correo();
			}
			//catch(Exception $e) { $this->enviar_pedido_correo_texto();$this->varios_model->registrarError('Pedidos',$e->getMessage());}

			$basura = array(
				'qty'    => 1,
				'rowid'  => 'Destruyendo carro...'
			);
	
			$this->db->insert('basura', $basura);
			$this->cart->destroy();
		}
		
		return $insert;
	}
	
	private function guardar_detalle($tipo){
		foreach($this->cart->contents() as $items) 
		{
			$data = array(
				'IDPedido'     => $this->num_pedido,
				'CodProd'      => $items['id'],
				'Cantidad'     => $items['qty'],
				'Valor'        => $items['price'],
				'Impuesto'     => $items['impuesto'],
				'Descripcion'  => $items['name']
			);
			
			$nombreTabla = 'items_pedido';//$tipo ==0 ? 'items_pedido_temp' : 'items_pedido';
			$this->db->insert($nombreTabla, $data);
		}
	}

	public function guardar_pedido_archivo($id)
	{
		$pedido = $this->pedidos_model->consulta_pedido_numero($id);
		$detalle = $this->pedidos_model->consulta_detalle_pedido($id);

		$fichero = fopen("./pedidos/".$pedido->CodClie.'_'.$pedido->IDPedido.".csv", "w");
 
		fputs($fichero, $pedido->IDPedido.';'.$pedido->FechaPedido.';'.$pedido->CodClie.';'.$pedido->Valor.';'.$pedido->Impuesto.';'.$pedido->Observaciones.PHP_EOL);
		
		foreach($detalle as $item)
		{
    		fputs($fichero, $item->IDItem.';'.$item->IDPedido.';'.$item->CodProd.';'.$item->Descripcion.';'.$item->Cantidad.';'.$item->Valor.';'.$item->Impuesto.PHP_EOL);
		}

    	fclose($fichero);
	}

	public function guardar_pedido_archivo_app($id)
	{
		$pedido = $this->pedidos_model->consulta_pedido_numero($id);
		$detalle = $this->pedidos_model->consulta_detalle_pedido($id);

		$fichero = fopen("./pedidosApp/".$pedido->CodClie.'_'.$pedido->IDPedido.".csv", "w");
 
		fputs($fichero, $pedido->IDPedido.';'.$pedido->FechaPedido.';'.$pedido->CodClie.';'.$pedido->Valor.';'.$pedido->Impuesto.';'.$pedido->Observaciones.PHP_EOL);
		
		foreach($detalle as $item)
		{
    		fputs($fichero, $item->IDItem.';'.$item->IDPedido.';'.$item->CodProd.';'.$item->Descripcion.';'.$item->Cantidad.';'.$item->Valor.';'.$item->Impuesto.PHP_EOL);
		}

    	fclose($fichero);
	}

	public function guardar_pedido_espera_app($pedido)
	{
		$fichero = fopen("./espera/".mt_rand(111111,999999).".csv", "w");
 
		fputs($fichero, date("Y/m/d").';'.$pedido->CodClie.';'.$pedido->Descrip.PHP_EOL);
		
		foreach($pedido->Productos as $item)
		{
    		fputs($fichero, $item->CodItem.';'.$item->Descrip1.';'.$item->Cantidad.';'.$item->Precio.PHP_EOL);
		}

    	fclose($fichero);
	}

	public function consulta_pedido_numero($id)
	{
		$this->db->select('p.IDPedido,p.FechaPedido,p.Usuario,p.CodClie,p.Valor,p.Impuesto,p.Observaciones');
		$this->db->from('pedidos AS p');
		$this->db->where('p.IDPedido',$id);

		$query = $this->db->get();
		return $query->row();
	}

	public function consulta_detalle_pedido($id)
	{
		$this->db->select('i.IDItem,i.IDPedido,i.CodProd,i.Descripcion,i.Cantidad,i.Valor,i.Impuesto');
		$this->db->from('items_pedido AS i');
		$this->db->where('i.IDPedido',$id);

		$query = $this->db->get();
		return $query->result();
	}

	public function consulta_pedido($id)
	{
		$this->db->select('p.IDPedido,p.FechaPedido,i.Descripcion,i.Cantidad,i.Valor,i.Impuesto,p.Estado');
		$this->db->from('pedidos p');
		$this->db->join('items_pedido AS i','p.IDPedido=i.IDPedido','INNER');
		$this->db->where('p.Usuario',$this->session->Email);
		
		$query = $this->db->get();
	}
	
	public function lista_pedidos_usuario()
	{
		$this->db->select('p.IDPedido,p.FechaPedido,i.Descripcion,i.Cantidad,i.Valor,i.Impuesto,p.Estado');
		$this->db->from('pedidos p');
		$this->db->join('items_pedido AS i','p.IDPedido=i.IDPedido','INNER');
		$this->db->where('p.Usuario',$this->session->Email);
		
		$query = $this->db->get();
		return $query->result();
	}

	public function enviar_pedido_correo(){
		$mensaje = '';
		
		$config['mailtype'] = 'html';
		$config['charset'] = 'iso-8859-1';
		
		$this->email->initialize($config);
		
		$this->email->from($this->config->item('correo_contacto2'), 'Pegaso');
		$this->email->to($this->config->item('correo_contacto'));//$this->input->post('email'));
		$this->email->bcc($this->config->item('correo_contacto2'));

		$this->email->subject('Compra desde el sitio web');
					
		$mensaje='<html><body><p>Pedido por: '.$this->session->Nombres.' '.$this->session->Apellidos.'</p><p>Direccion: '.$this->session->direccionEnvio.'</p><p>Telefono: '.$this->session->telefonoEnvio.'</p><p>Correo: '.$this->session->Email.'</p><p>Observaciones: '.$this->session->obsEnvio.'</p><br>';
		$mensaje.='<table border="1"><tr><th>Referencia</th><th></th><th>Cantidad</th><th>Precio</th><th>Total</th></tr>';

		$precio = 0;
		$subtotal = 0;
		$total=0;
		foreach($this->cart->contents() as $items) 
		{
			$precio = round($items['price']+$items['impuesto'],0);
			$subtotal = round( $items['qty'] * $precio,0);
			$total += $subtotal;
			
			$mensaje.='<tr><td>'.$items['id'].'</td><td><img src="'.$this->config->item('base_imagenes').imagen_producto($items['id']).'" width="90px"></td>
			               <td>'.$items['qty'].'</td><td>'.$precio.'</td><td>'.$total.'</td></tr>';				
		}
			
		$mensaje.='<tr><td></td><td></td><td></td><td>Total</td><td>'.$total.'</td></tr></table></body></html>';
						
		$this->email->message($mensaje);
	
		$this->email->send();
	}
	
	public function enviar_pedido_correo_texto()
	{
		$asunto = 'Compra desde el sitio web';
		
		$mensaje.=$this->session->Nombres.' '.$this->session->Apellidos.''.PHP_EOL;
		$mensaje.=$this->session->direccionEnvio.' '.PHP_EOL;
		$mensaje.=$this->session->telefonoEnvio.' '.PHP_EOL;
		$mensaje.=$this->session->Email.'' .PHP_EOL;
		$mensaje.=$this->session->obsEnvio.' '.PHP_EOL;
		$mensaje.='Producto        Cantidad  Precio  Total'.PHP_EOL;
		$mensaje.='------------------------------------------'.PHP_EOL;
		
		$precio = 0;
		$subtotal = 0;
		$total=0;
		foreach($this->cart->contents() as $items) 
		{
			$precio = round($items['price']+$items['impuesto'],0);
			$subtotal = round( $items['qty'] * $precio,0);
			$total += $subtotal;
			
			$mensaje.=$items['id'].' '.$items['qty'].' '.$precio.' '.$subtotal.PHP_EOL;				
		}
		
		$mensaje.=PHP_EOL.'Total: '.$total;
		
		enviarCorreo($this->config->item('correo_contacto'),$asunto,$mensaje);
	}

	/****************** App **************** */
	public function registrarApp($pedido,$detalle){

		 $data = array(
            'Usuario'       => $pedido->Email,
			'Valor'         => $pedido->Valor,
			'Impuesto'      => $pedido->Impuesto,
            'Observaciones' => $pedido->Observaciones,
			'Pais'          => $pedido->Pais,
			'Departamento'  => $pedido->Estado,
			'Ciudad'        => $pedido->Ciudad,
			'Direccion'     => $pedido->Direccion,
			'Telefono'      => $pedido->Telefono,
			'CodClie'       => $pedido->CodClie,
			'Estado'        => 0
        );
		
		$nombreTabla = 'pedidos';//$tipo == 0 ? 'pedidos_temp' : 'pedidos';
		
		$insert = $this->db->insert($nombreTabla, $data);
		$this->num_pedido = $this->db->insert_id();
		
		$this->detalleApp($detalle);
		
		//if ($tipo == 1)
		{
			$this->guardar_pedido_archivo_app($this->num_pedido);

			$datos = $this->usuarios_model->consulta_usuario_valor($pedido->CodClie);

			if ($this->config->item('esProduccion') == 'S')
			{
				$this->enviar_pedido_correo_app($datos,$pedido,$detalle);
			}
		}
		
		return $insert;
	}
	
	private function detalleApp($detalle){

		foreach($detalle as $items) 
		{
			/*$basura = array(
				'id'     => 8,
				'rowid'  => $items->CodProd,
				'qty'    => $items->Cantidad
			);

			$this->db->insert('basura',$basura);
*/
			$data = array(
				'IDPedido'     => $this->num_pedido,
				'CodProd'      => $items->CodProd,
				'Cantidad'     => $items->Cantidad * $items->Unidad,
				'Valor'        => $items->Valor / $items->Unidad,
				'Impuesto'     => $items->Impuesto / $items->Unidad,
				'Descripcion'  => $items->Descrip
			);
			
			$nombreTabla = 'items_pedido';//$tipo ==0 ? 'items_pedido_temp' : 'items_pedido';
			$this->db->insert($nombreTabla, $data);
		}
	}

	public function lista_pedidos_app($codigo)
	{
		$this->db->select('p.IDPedido,p.FechaPedido,p.Usuario AS Email,p.CodClie,p.Observaciones,p.Valor,p.Impuesto,p.Pais,p.Departamento AS Estado,,p.Ciudad,p.Estado AS EstadoPedido');
		$this->db->from('pedidos p');
		$this->db->where('p.CodClie',$codigo);
		
		$query = $this->db->get();
		return $query->result();
	}

	public function consulta_detalle_pedido_usuario($codigo)
	{
		$this->db->select('i.IDItem,i.IDPedido,i.CodProd,i.Descripcion,i.Cantidad,i.Valor,i.Impuesto,m.ImgPrincipal');
		$this->db->from('items_pedido AS i');
		$this->db->join('pedidos AS p','i.IDPedido=p.IDPedido','INNER');
		$this->db->join('productos AS m','i.CodProd=m.CodProd','INNER');
		$this->db->where('p.CodClie',$codigo);

		$query = $this->db->get();
		return $query->result();
	}	

	public function enviar_pedido_correo_app($info,$pedido,$detalle){
		$mensaje = '';
		
		$config['mailtype'] = 'html';
		$config['charset'] = 'iso-8859-1';
		
		$this->email->initialize($config);
		
		$this->email->from($this->config->item('correo_contacto2'), 'Making Business');
		$this->email->to($this->config->item('correo_contacto'));//$this->input->post('email'));
		$this->email->bcc($this->config->item('correo_contacto2'));

		$this->email->subject('Compra desde App de pedidos');
					
		$mensaje='<html><body><p>Pedido por: '.$info->Nombres.' '.$info->Apellidos.'</p><p>Direccion: '.$pedido->Direccion.'</p><p>Telefono: '.$pedido->Telefono.'</p><p>Correo: '.$pedido->Email.'</p><p>Observaciones: '.$pedido->Observaciones.'</p><br>';
		$mensaje.='<table border="1"><tr><th>Referencia</th><th></th><th>Cantidad</th><th>Precio</th><th>Total</th></tr>';

		$precio = 0;
		$subtotal = 0;
		$total=0;
		foreach($detalle as $items) 
		{
			$precio = round($items->Valor+$items->Impuesto,0);
			$subtotal = round( $items->Cantidad * $precio,0);
			$total += $subtotal;

			$esManilla = $this->productos_model->esManilla($items->CodProd);

			$mensaje.='<tr><td>'.$items->CodProd.'</td><td><img src='.$this->config->item('base_imagenes').imagen_producto($items->CodProd,$esManilla).' width=90px></td>
			               <td>'.$items->Cantidad.'</td><td>'.$precio.'</td><td>'.$total.'</td></tr>';				
		}
			
		$mensaje.='<tr><td></td><td></td><td></td><td>Total</td><td>'.$total.'</td></tr></table></body></html>';
				
		$this->email->message($mensaje);
	
		$this->email->send();

		$this->enviar_sms($this->config->item('movil_pedidos'),'Pedido desde AppMB '.$info->Nombres.' '.$info->Apellidos.' DIR: '.$pedido->Direccion.'Tel: '.$pedido->Telefono.' - '.$pedido->Email);
	}	

	public function enviar_sms($movil,$mensaje)
	{
		$this->elibom->sendMessage($movil,$mensaje);
	}
}