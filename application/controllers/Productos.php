<?php
class Productos extends CI_Controller{
	public $base = '';
	public $nombre_pagina = '';
	public $esPromocion = false;
	
	public function __construct()
	{
		parent::__construct();
		$this->load->helper('url');
		$this->load->model('productos_model');
		$this->load->model('varios_model');
		$this->load->library('session');
		
		leer_ubicacion();
		
		if (!$this->session->has_userdata('idioma')) $this->session->set_userdata('idioma', '1');
		if (!$this->session->has_userdata('IDTipoUsuario')) $this->session->set_userdata('IDTipoUsuario', '1');
	}
	
	public function tipo($categoria,$pagina)
	{
		$this->session->set_userdata('instancia_producto',$categoria);
		$this->session->unset_userdata('instancia_pulsos',$categoria);
		$this->session->unset_userdata('filtro_productos');

		$this->session->unset_userdata('prod_continuar');

		$this->session->set_userdata('nombre_instancia', $this->productos_model->consulta_categoria('1', $categoria)->Descrip);
		
		$this->base = $this->productos_model->consulta_base_categoria($categoria);

		if ($this->base != $categoria)
		{
			$nivel = $this->productos_model->consulta_nivel_categoria($categoria);

			for($p = $nivel;$p<=6;$p++){
				$this->session->unset_userdata('instancia_n'.$p);
			}
		}

		switch($this->base)
		{
			case $this->config->item('instancia_base_reloj'):
				case $this->config->item('instancia_ppal_reloj'):				
				$this->nombre_pagina = 'relojes';
				break;
			case $this->config->item('instancia_base_calculadora'):
				$this->nombre_pagina = 'calculadoras';
				break;
			case $this->config->item('instancia_base_bateria'):
				$this->nombre_pagina = 'baterias';
				break;
			case $this->config->item('instancia_base_medios'):
				$this->nombre_pagina = 'medios';
				break;
			case $this->config->item('instancia_base_herramienta'):
				$this->nombre_pagina = 'herramientas';
				break;				
			case $this->config->item('instancia_base_pulso'):
				$this->session->set_userdata('instancia_pulsos',$categoria);
				$this->session->unset_userdata('instancia_producto',$categoria);
				$this->nombre_pagina = 'pulsos';
				break;
		}

		$this->mostrar($pagina,$categoria);
	}

	public function promocion()
	{
		$this->esPromocion = true;
		$this->session->unset_userdata('filtro_productos');

		$this->session->unset_userdata('prod_continuar');

		$this->nombre_pagina = 'relojes';

		$this->mostrar_promocion();
	}

	public function tipo_f($filtro,$pagina)
	{
		$this->session->set_userdata('filtro_productos',$this->input->post('search-product'));

		$this->base = $this->productos_model->consulta_base_categoria($this->session->instancia_producto);

		switch($this->base)
		{
			case $this->config->item('instancia_base_reloj'):
				$this->nombre_pagina = 'relojes';
				break;
			case $this->config->item('instancia_base_calculadora'):
				$this->nombre_pagina = 'calculadoras';
				break;
			case $this->config->item('instancia_base_bateria'):
				$this->nombre_pagina = 'baterias';
				break;
			case $this->config->item('instancia_base_herramienta'):
				$this->nombre_pagina = 'herramientas';
				break;
			case $this->config->item('instancia_base_pulso'):
				$this->session->set_userdata('instancia_pulsos',$categoria);
				$this->nombre_pagina = 'pulsos';
				break;
		}

		//$buscar = $filtro == 'f' ? $this->input->post('search-product') : $filtro;
		$buscar = $filtro == 'f' ? $this->session->filtro_productos : $filtro;
		$this->lista_productos_clave($pagina,$buscar);
	}
	
	public function lista_productos_parte()
	{
		$this->session->set_userdata('CodManilla',$this->input->post('parte'));
		$lista = $this->productos_model->lista_productos_parte($this->input->post('parte'));
		
		$cadena = '';//<select name="calibre" id="opt-calibre">';
		$total = 0;
		
		if ($this->session->has_userdata('Calibre')) $this->session->unset_userdata('Calibre');
		
		foreach($lista as $l)
		{
			$partes = explode('.',$l->CodProd);
			if (count($partes) > 2)
			{
				if (!strpos($cadena,$partes[1]))
				{
					if ($total ==0 ) $this->session->set_userdata('Calibre',$partes[1]);
					$cadena.='<option value="'.$partes[1].'">'.$partes[1].'</option>';
					$total++;
				}
			}
		}
					
		//$cadena.='</select>';
		
		echo $cadena;
	}

	public function mostrar_tabla_calibres()
	{
		echo $this->productos_model->mostrar_tabla_calibres($this->input->post('parte'));
	}
	
	public function mostrar($pagina,$categoria)
	{
		$productos_por_pagina = $this->config->item('img_por_pagina');
		
		$total_registros = 0;
		
		if ($this->nombre_pagina == 'pulsos')
		{
			$total_registros = $this->productos_model->total_manillas($categoria);
		}
		else
		{
			$total_registros = $this->productos_model->total_productos($categoria);
		}
				
		$data['basura'] = "Idioma: ".$this->session->idioma." Tipo usuario: ".$this->session->tipo_usuario;
		$data['por_pagina'] = $productos_por_pagina;
		$data['total_productos'] = $total_registros;
		$data['total_numeros'] = ceil($total_registros / $productos_por_pagina);
		$data['pagina_activa'] = $pagina;
		$data['instancia'] = $this->base;
		$data['sufijo_pag'] = ''; //$this->base == $categoria ? '' : 'c';
		$data['marca_pag'] = $categoria;// $this->base == $categoria ? '': $categoria;
		
		if ($this->base == $categoria)
		{
			$this->session->unset_userdata('instancia_n2');
			$this->session->unset_userdata('instancia_n3');
			$this->session->unset_userdata('instancia_n4');
		}
		else
		{
			$nivel = $this->productos_model->consulta_nivel_categoria($categoria);

			if (!$this->session->has_userdata('instancia_n'.$nivel))
			{
				$this->session->set_userdata('instancia_n'.$nivel,$categoria);
			}
		}

		$resultado;
		if ($this->nombre_pagina == 'pulsos')
		{
			$resultado = $this->productos_model->lista_manillas($categoria,'0',$productos_por_pagina,$pagina);//$config_pag['per_page'], $page);			
		}
		else
		{
			$resultado = $this->productos_model->lista_productos($categoria,$productos_por_pagina,$pagina);//$config_pag['per_page'], $page);			
		}
		
		$data['productos'] = $resultado;
		
		//Load View
		$this->session->set_userdata('instancia_base', $this->base);
		$this->session->set_userdata('nombre_pagina',$this->nombre_pagina);
 
		$this->load->view('templates/header',$data);
		$this->load->view('productos', $data);
		$this->load->view('templates/footer');
	}
		
	public function lista_productos_clave($pagina,$clave)
	{
		$productos_por_pagina = $this->config->item('img_por_pagina');
		//$filtros = explode(';',$clave);
		
		$total_registros = 0;
		
		if ($this->nombre_pagina == 'pulsos')
		{
			$total_registros = $this->productos_model->total_manillas_clave($this->base,$clave);
		}
		else
		{
			$total_registros = $this->productos_model->total_productos_clave($this->base,$clave);
		}
				
		$data['basura'] = $clave;//"Idioma: ".$this->session->idioma." Tipo usuario: ".$this->session->tipo_usuario;
		$data['por_pagina'] = $productos_por_pagina;
		$data['total_productos'] = $total_registros;
		$data['total_numeros'] = ceil($total_registros / $productos_por_pagina);
		$data['pagina_activa'] = $pagina;
		$data['instancia'] = $this->base;
		$data['sufijo_pag'] = 'f';
		$data['marca_pag'] = $clave;//filtros[0];//.'_'.$filtros[1].'_'.$filtros[2];
		
		$this->session->unset_userdata('instancia_n2');
		$this->session->unset_userdata('instancia_n3');
		$this->session->unset_userdata('instancia_n4');
			
		$resultado;
		if ($this->nombre_pagina == 'pulsos')
		{
			$resultado = $this->productos_model->lista_manillas_clave($this->base,$clave,$productos_por_pagina,$pagina);//$config_pag['per_page'], $page);			
		}
		else
		{
			$resultado = $this->productos_model->lista_productos_clave($this->base,$clave,$productos_por_pagina,$pagina);//$config_pag['per_page'], $page);
		}
		
		$data['productos'] = $resultado;
		
		//Load View
		$this->session->set_userdata('nombre_pagina',$this->nombre_pagina);
 
		$this->load->view('templates/header',$data);
		$this->load->view('productos', $data);
		$this->load->view('templates/footer');
	}	

	public function mostrar_promocion()
	{
		$productos_por_pagina = $this->config->item('img_por_pagina');
		//$filtros = explode(';',$clave);
		
		$total_registros = 0;
		
		/*if ($this->nombre_pagina == 'pulsos')
		{
			$total_registros = $this->productos_model->total_manillas_promocion();
		}
		else*/
		{
			$total_registros = $this->productos_model->total_productos_promocion();
		}
				
		$data['basura'] = 'Promocion';//"Idioma: ".$this->session->idioma." Tipo usuario: ".$this->session->tipo_usuario;
		$data['por_pagina'] = $productos_por_pagina;
		$data['total_productos'] = $total_registros;
		$data['total_numeros'] = ceil($total_registros / $productos_por_pagina);
		$data['pagina_activa'] = '1';
		$data['instancia'] = 0;//$this->base;
		$data['sufijo_pag'] = '';
		$data['marca_pag'] = 'promocion';//filtros[0];//.'_'.$filtros[1].'_'.$filtros[2];
		
		$this->session->unset_userdata('instancia_n2');
		$this->session->unset_userdata('instancia_n3');
		$this->session->unset_userdata('instancia_n4');
			
		$resultado;
		/*if ($this->nombre_pagina == 'pulsos')
		{
			$resultado = $this->productos_model->lista_manillas_clave($this->base,$clave,$productos_por_pagina,$pagina);//$config_pag['per_page'], $page);			
		}
		else*/
		{
			$resultado = $this->productos_model->lista_productos_promocion();//$config_pag['per_page'], $page);
		}
		
		$data['productos'] = $resultado;
		
		//Load View
		$this->session->set_userdata('nombre_pagina',$this->nombre_pagina);
 
		$this->load->view('templates/header',$data);
		$this->load->view('productos', $data);
		$this->load->view('templates/footer');
	}

	public function detalle($id){
		//Get Product Details

		$resultado;

		$this->session->set_userdata('prod_continuar',$id);

		if ($this->session->nombre_pagina == 'pulsos')
		{
			$resultado = $this->productos_model->consulta_manilla($id);
		}
		else
		{
			$resultado = $this->productos_model->consulta_producto($id);
		}

		$producto_anterior = "";
		$producto_siguiente = "";		

		if ($this->session->nombre_pagina == 'pulsos')
		{
			$anterior =  $this->productos_model->consulta_manilla_anterior($resultado->RefBase);
			$siguiente = $this->productos_model->consulta_manilla_siguiente($resultado->RefBase);

			if ($anterior ) $producto_anterior = $anterior->CodProd;
			if ($siguiente) $producto_siguiente = $siguiente->CodProd;
		}
		else
		{
			$anterior =  $this->productos_model->consulta_producto_anterior($resultado->RefBase);
			$siguiente = $this->productos_model->consulta_producto_siguiente($resultado->RefBase);

			if ($anterior ) $producto_anterior = $anterior->CodProd;
			if ($siguiente) $producto_siguiente = $siguiente->CodProd;
		}

		$data['producto'] = $resultado;
		$data['marca_pag'] = '';
		$data['producto_anterior'] = $producto_anterior;
		$data['producto_siguiente'] = $producto_siguiente;
		
		//Load View
		$this->load->view('templates/header');
		
		if ($this->session->nombre_pagina == 'pulsos')
		{
			$this->load->view('pulsos_detail', $data);
		}
		else
		{
			$data['listaRef'] = $this->productos_model->lista_productos_base($resultado->RefBase);		

			$this->load->view('product_detail', $data);
		}
		$this->load->view('templates/footer');
	}

	public function detalle_promo($id){
		//Get Product Details

		$resultado;

		$this->session->set_userdata('nombre_pagina','relojes');

		$this->session->set_userdata('prod_continuar',$id);

		$resultado = $this->productos_model->consulta_producto($id);

		$producto_anterior = "";
		$producto_siguiente = "";		

/*		if ($this->session->nombre_pagina == 'pulsos')
		{
			$anterior =  $this->productos_model->consulta_manilla_anterior($resultado->RefBase);
			$siguiente = $this->productos_model->consulta_manilla_siguiente($resultado->RefBase);

			if ($anterior ) $producto_anterior = $anterior->CodProd;
			if ($siguiente) $producto_siguiente = $siguiente->CodProd;
		}
		else*/
		{
			$anterior =  $this->productos_model->consulta_promocion_anterior($resultado->CodProd);
			$siguiente = $this->productos_model->consulta_promocion_siguiente($resultado->CodProd);				

			if ($anterior ) $producto_anterior = $anterior->CodProd;
			if ($siguiente) $producto_siguiente = $siguiente->CodProd;
		}

		$data['producto'] = $resultado;
		$data['marca_pag'] = 'promocion';
		$data['producto_anterior'] = $producto_anterior;
		$data['producto_siguiente'] = $producto_siguiente;
		
		//Load View
		$this->load->view('templates/header');
		
		if ($this->session->nombre_pagina == 'pulsos')
		{
			$this->load->view('pulsos_detail', $data);
		}
		else
		{
			$this->load->view('product_detail', $data);
		}

		$this->load->view('templates/footer');
	}	
	
	public function crea_tu_reloj()
	{
		$this->load->view('templates/header');
		$this->load->view('make_clock');
		$this->load->view('templates/footer');
	}

	public function imagen_adicional($codigo)
	{
		$esManilla = $this->session->nombre_pagina == 'pulsos' ? true : false;

		$producto = $esManilla ? $this->productos_model->consulta_manilla_aux($codigo) : $this->productos_model->consulta_producto($codigo);

		$datos = $producto->CodProd.';'.$producto->Descrip.';'.$producto->Precio.';'.$producto->Impuesto.';'.$producto->DescAmpliada;

		echo implode(';',imagen_adicional($producto->CodProd, $esManilla)).'__'.$datos.'__'.$this->productos_model->mostrar_tabla_calibres($codigo);
	}

	/******************** Productos de fabrica */
	public function lista_fabrica()
	{
		$data['nombre_pagina'] = 'defabrica';
		$data['estilo_header'] = '';

		$tipo_listado = 'relojes';

		$productos['pagina_activa'] = '1';
		$productos['inicio_pag'] = '1';
		$productos['fin_pag'] = $this->config->item('paginacion');

		$productos['total_productos'] = $this->productos_model->total_productos_fabrica();

		$productos['productos'] = $this->productos_model->lista_productos_fabrica($this->config->item('img_por_pagina_fab'),'1');

		$this->load->view('templates/headerf',$data);
		$this->load->view('defabrica',$productos);
		$this->load->view('templates/footerf');
	}

	public function lista_productos_fabrica($pagina,$esLista)
	{
		 $tipo_listado = 'relojes';
		 $tipo_base = $this->base_relojes;

		 $data['nombre_pagina'] = 'defabrica';
		 $data['estilo_header'] = '';

		 $productos['inicio_pag'] = $this->session->has_userdata('inicio_pag') ? $this->session->userdata('inicio_pag') : 1;
		 $productos['fin_pag'] = $this->session->has_userdata('fin_pag') ? $this->session->userdata('fin_pag') : $this->config->item('paginacion');
		 $productos['pagina_activa'] = $pagina;
		 $productos['total_productos'] = $this->productos_model->total_productos_fabrica();
		 $productos['esLista'] = $esLista;
		 $productos['productos'] = $this->productos_model->lista_productos_fabrica($this->config->item('img_por_pagina'),$pagina);

		 $this->load->view('templates/header',$data);
		 $this->load->view('defabrica',$productos);
		 $this->load->view('templates/footer');
	}	
}