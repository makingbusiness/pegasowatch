<?php
class Cart extends CI_Controller{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('productos_model');
		$this->load->model('varios_model');
		$this->load->library('session');
	}
	

	/*
	 *	Cart Index
	 */
	 public function index(){
		leer_ubicacion();
		//Load View
		$data['main_content'] = 'cart';
		
		$this->load->view('templates/header');
		$this->load->view('cart', $data);
		$this->load->view('templates/footer');
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
	  
	  /*
	 * Update Cart
	 */
	public function update(){
		if ($this->cart->contents())
		{
			$data = array(
				'rowid'   => $this->input->post('rowid'),
				'qty'     => $this->input->post('qty')
			);
			
	//		$this->db->insert('basura',$data);

			$this->cart->update($data);
			redirect('cart','refresh');
			//echo $this->imprimirCarro();//$this->input->post('coditem'),$this->input->post('descripcion'),$this->input->post('qty'),$this->input->post('precio'));
		}
		else
		{
			$this->load->view('templates/header');
		   	$this->load->view('home');
		   	$this->load->view('templates/footer');
		}
	}
	
	public function removeCartItem($rowid) {   
        $data = array(
            'rowid'   => $rowid,
            'cantidad'     => 0
        );

        $this->cart->update($data);
		
		//redirect('cart','refresh');
	}

	public function actualizarCarro(){
		foreach ($this->cart->contents() as $items)
		{
			if ($items['qty'] == 0)
			{
				$this->removeCartItem($items['rowid']);
			}
			else
			{
				$this->update($items['rowid'],$items['qty']);
			}
		}
		
		redirect('cart','refresh');
	}
	
	public function imprimirCarro()
	{
		/*$lista = "<img src=\"".$this->config->item('base_url')."imagenes/icons/icon-header-02.png\" class=\"header-icon1 js-show-header-dropdown\" alt=\"ICON\">
					<span id=\"items-cart\" class=\"header-icons-noti\">".$this->cart->total_items()."</span>
					<div class=\"header-cart header-dropdown\"><ul class=\"header-cart-wrapitem\">";*/

		$lista = "";
		$impuesto = 0;
		$codigoImp = '';
		$esManilla = false;
		$rutaImp = '';

		foreach ($this->cart->contents() as $items)
		{
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

			$lista.="<li class=\"header-cart-item\">
							<div class=\"header-cart-item-img\">
								<img src=\"".$rutaImp.imagen_producto($codigoImp,$esManilla)."\" alt=\"IMG\">
							</div>
							<div class=\"header-cart-item-txt\">
								<a href=\"#\" class=\"header-cart-item-name\">".$items['name']."</a>
								<span class=\"header-cart-item-info\">".$items['qty']." x $".round($items['price']+$items['impuesto'],0)."</span>
							</div>
						</li>";

			$impuesto += $items['qty'] * $items['impuesto'];
		}
						
		return $lista.'___'.(round($this->cart->total() + $impuesto,0));
	}	
}