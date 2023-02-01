<?php
class Cartf extends CI_Controller
{
     public function __construct()
     {
         parent::__construct();
         $this->load->model('usuarios_model');
         $this->load->model('varios_model');
		 $this->load->model('pedidos_model');
		 $this->load->model('productos_model');
         $this->load->library('session');
     }

     public function index()
     {
		if ($this->cart->contents())
		{
			$this->mostrarCarro();
		}
		else
		{
			$this->mostrar_productos();
		}
     }

     public function checkout()
     {
		 if ($this->cart->contents())
		 {
			 $data['nombre_pagina'] = 'checkout';
			 $data['estilo_header'] = '';
  
			 $this->load->view('templates/headerf',$data);
			 $this->load->view('checkoutf');
			 $this->load->view('templates/footerf');
		 }
		 else
		 {
			 $this->mostrar_productos();
		 }
     }

     public function checkout2()
     {
           $data['nombre_pagina'] = 'checkout2';
           $data['estilo_header'] = '';

           $this->session->set_userdata('direccion_envio',$this->input->post('direccion_envio'));
           $this->session->set_userdata('direccion2_envio',$this->input->post('direccion2_envio'));
           $this->session->set_userdata('pais_envio',$this->input->post('pais_envio'));
           $this->session->set_userdata('estado_envio',$this->input->post('estado_envio'));
           $this->session->set_userdata('ciudad_envio',$this->input->post('ciudad_envio'));
           $this->session->set_userdata('telefono_envio',$this->input->post('telefono_envio'));
           $this->session->set_userdata('observaciones_envio',$this->input->post('observaciones_envio'));

           $this->load->view('templates/header',$data);
           $this->load->view('checkout2');
           $this->load->view('templates/footer');
     }

     public function mostrarCarro()
     {
           $data['nombre_pagina'] = 'cart';
           $data['estilo_header'] = '';
           $data['main_content'] = 'cart';

		   $this->load->view('templates/headerf',$data);
		   $this->load->view('cartf',$data);
           $this->load->view('templates/footerf');
	 }
	 
	 public function mostrar_productos()
	 {
		$data['nombre_pagina'] = 'defabrica';
		$data['estilo_header'] = '';
		$data['main_content'] = 'productos';

		$productos['pagina_activa'] = '1';
		$productos['inicio_pag'] = '1';
		$productos['fin_pag'] = $this->config->item('paginacion');

		$productos['total_productos'] = $this->productos_model->total_productos_fabrica();

		$productos['productos'] = $this->productos_model->lista_productos_fabrica($this->config->item('img_por_pagina_fab'),'1');

		$this->load->view('templates/headerf',$data);
	    $this->load->view('defabrica',$productos);
		$this->load->view('templates/footerf');
	 }

   	 /*
     	  * Add To Cart
     	  */
	 
	 public function add(){
		//Item Data
		$coditem = $this->input->post('coditem');
		
		$precio = $this->input->post('precio');
		$impuesto = $this->input->post('impuesto');
		$descripcion = quotemeta(str_replace('+',' ',str_replace('#',' ',str_replace('.',' ',str_replace(',',' ',str_replace('/',' ',str_replace('&','y',$this->input->post('descripcion'))))))));

		$basura = '';
		if (strpos($coditem,'_'))
		{
			$partesPedido = explode('_',$coditem);
			$partesCodigo = explode('.',$partesPedido[0]);
			$pedir = explode(';',$partesPedido[1]);			

			$partesRef = explode(';',$this->input->post('frmPartesManilla'));
			$totalCalibres = $partesRef[0];
			$totalColores = $partesRef[1];

/*			$basura = array(
				'rowid'   => $totalColores,
				'qty'     => $totalCalibres
			);

			$this->db->insert('basura',$basura);
*/			
			for($s=0;$s<count($pedir);$s++)
			{
				$datosPedido = explode('.',$pedir[$s]);

				$refPedir = $partesCodigo[0];

				if ($totalCalibres != '0')
				{
					$refPedir .= '.'.$datosPedido[0];

					if ($totalColores != '0')
					{
						$refPedir .='.'.$partesCodigo[1];
					}
				}
				else
				{
					$refPedir .= '.'.$partesCodigo[1];
				}

				$data = array(
					'id' => $refPedir,// count($partesCodigo) == 1 ? $partesCodigo[0].'.'.$datosPedido[0] : $partesCodigo[0].'.'.$datosPedido[0].'.'.$partesCodigo[1],
					'qty' => $datosPedido[count($datosPedido)-1],
					'price' => $precio,
					'impuesto' => $impuesto,
					'name' => $descripcion
				);
				//Insert Into Cart
				$this->cart->insert($data);
			}
		}
		else
		{
			$basura.=' '.$coditem;
			$data = array(
					'id' => $coditem,//this->input->post('coditem'),
					'qty' => $this->input->post('cantidad'),
					'price' => $precio,
					'impuesto' => $impuesto,
					'name' => $descripcion
			);
			//Insert Into Cart
			$this->cart->insert($data);		
		}

		echo $this->imprimirCarro();
		//redirect('cart');
	  }

	  public function imprimirCarro()
	  {
		  /*$lista = "<img src=\"".$this->config->item('base_url')."imagenes/icons/icon-header-02.png\" class=\"header-icon1 js-show-header-dropdown\" alt=\"ICON\">
					  <span id=\"items-cart\" class=\"header-icons-noti\">".$this->cart->total_items()."</span>
					  <div class=\"header-cart header-dropdown\"><ul class=\"header-cart-wrapitem\">";*/
  
		  $lista = "";
		  $impuesto = 0;
		  foreach ($this->cart->contents() as $items)
		  {
	
			  $lista.="<div class=\"product\">
				  		<div class=\"product-details\">
					  		<h4 class=\"product-title\">".$items['id']."</h4>

					  		<span class=\"cart-product-info\">
						  	<span class=\"cart-product-qty\">".$items['qty']."</span>
						  	x $".round($items['price'] + $items['impuesto'],2)."</span>
			  	  		 </div><!-- End .product-details -->

						<figure class=\"product-image-container\">
							<img src=\"".$this->config->item('base_url').imagen_producto_fabrica($items['id'])."\" alt=\"product\">
							<a href=\"".$this->config->item('base_url')."cartf/removeCartItem/".$items['rowid']."\" title=\"Remove product\" class=\"btn-remove\"><i class=\"icon-cancel\"></i></a>
						</figure>
		  			   </div><!-- End .product -->";
		  
			  $impuesto += $items['qty'] * $items['impuesto'];
		  }
						  
		  return $lista.'___'.(round($this->cart->total() + $impuesto,0));
	  }	

 	   /*
     	 * Update Cart
     	 */
     public function update($rowid,$qty)
     {
  		 $data = array(
            'rowid'   => $rowid,//this->input->post('rowid'),
            'qty'     => $qty//this->input->post('qty')
         );

         $this->cart->update($data);

     	 //redirect('cartf','refresh');
     }

     public function removeCartItem($rowid)
     {
            $this->cart->remove($rowid);

     		    redirect('cartf','refresh');
     	}

   	public function actualizarCarro()
    {
		$productos = $this->input->post('producto');
		$cantidades = $this->input->post('cantidad');

		/*foreach ($this->cart->contents() as $items)
		{
			if ($items['qty'] == 0)
			{
				$this->removeCartItem($items['rowid']);
			}
			else
			{
				$this->update($items['rowid'], $items['qty']);
			}
		}*/

		$pos = 0;
		foreach($productos as $producto)
		{
			if ($cantidades[$pos] >0 && $cantidades[$pos]<20) continue;
			
			$rowid = $this->buscar_rowid($producto);

			if ($cantidades[$pos] == 0)
			{
				$this->removeCartItem($rowid);
			}
			else
			{
				$this->update($rowid,$cantidades[$pos]);
			}

			$pos++;
		}

   		redirect('cartf','refresh');
   	}

	private function buscar_rowid($codigo)
	{
		$roiwd = '';
		foreach($this->cart->contents() as $item)
		{
			if ($item['id'] == $codigo)
			{
				$rowid = $item['rowid'];
				break;
			}
		}

		return $rowid;
	}

    public function vaciarCarro()
    {
        $this->cart->destroy();
        redirect('defabrica','refresh');
    }
}
