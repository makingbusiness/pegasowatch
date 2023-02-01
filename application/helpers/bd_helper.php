<?php
	function leer_ubicacion()
	{
		$CI = get_instance();

		//if (!$CI->session->has_userdata('pais_usuario'))
		{
			$ip = $CI->input->server('REMOTE_ADDR');
			if ($ip == '::1') $ip = '181.58.38.15';//'201.218.95.102';// '181.58.38.15';
			$geoPlugin_array = unserialize( file_get_contents('http://www.geoplugin.net/php.gp?ip='.$ip) );
	
			$pais = $geoPlugin_array['geoplugin_countryName'];
			$CI->session->set_userdata('pais_usuario', $pais);
			$CI->session->set_userdata('moneda_usuario', $pais == 'Colombia' ? 'COP' : 'USD');
			//echo $pais.' = '.$CI->session->moneda_usuario;
		}
	}
/*
 *	Get Categories
 */
	function lista_categorias($idioma,$padre)
	{
		$CI = get_instance();
		$categorias = $CI->productos_model->lista_categorias($idioma,$padre);
			
		return $categorias;
	}
	
	function lista_marcas_h($instancia)
	{
		$CI = get_instance();
		$marcas = $CI->productos_model->lista_marcas($instancia);
		
		return $marcas;
	}
	
	function lista_productos_dest()
	{
		$CI = get_instance();
		$lista = $CI->productos_model->lista_productos_destacados();
		
		return $lista;
	}
	
	function existeProducto($codigo)
	{
		$CI = get_instance();
		$total = $CI->productos_model->existeProducto($codigo);
		
		return $total;
	}

	function existeManilla($codigo)
	{
		$CI = get_instance();
		$total = $CI->productos_model->existeManilla($codigo);
		
		return $total;
	}	

	function consulta_producto($codigo)
	{
		$CI = get_instance();
		$resultado = $CI->productos_model->consulta_producto($codigo);

		return $resultado;
	}

	function consulta_precio_promocion($codigo)
	{
		$CI = get_instance();
		$resultado = $CI->productos_model->consulta_precio_promocion($codigo);

		return $resultado;
	}

	function total_productos_promocion()
	{
		$CI = get_instance();
		$resultado = $CI->productos_model->total_productos_promocion();

		return $resultado;
	}

	function consulta_manilla($codigo)
	{
		$CI = get_instance();
		$resultado = $CI->productos_model->consulta_manilla($codigo);

		return $resultado;
	}

	function consulta_precio_producto($codigo)
	{
		$CI = get_instance();
		$precio = $CI->productos_model->consulta_precio_producto($codigo);

		return $precio;
	}

	/*function lista_calibres_manilla($codigo)
	{
		$CI = get_instance();
		$lista = $CI->productos_model->lista_productos_parte($codigo);

		if ($CI->session->has_userdata('Calibre')) $CI->session->unset_userdata('Calibre');
		
		$calibres = array();
		$pos = 0;
		
		foreach($lista as $l)
		{
			$partes = explode('.',$l->CodProd);
			if (count($partes) > 2)
			{
				if (!in_array($partes[1],$calibres))
				{
					if ($pos ==0 ) $CI->session->set_userdata('Calibre',$partes[1]);
					$calibres[$pos] = $partes[1];
					$pos++;
				}
			}
		}
						
		return $calibres;
	}*/

	function lista_calibres_manilla($codigo)
	{
		$CI = get_instance();
		$lista = $CI->productos_model->consulta_manilla($codigo);

		return $lista->ListaCalibres;
	}

	function imagen_adicional($codigo,$esManilla = false)
	{
		$imgAdicionales = array();

		$buscar = $codigo;//$esManilla ? explode('.',$codigo)[0] : $codigo;

		$CI = get_instance();
		$imagenes = $esManilla ? $CI->productos_model->consulta_imagen_manilla($buscar) : $CI->productos_model->consulta_imagen_producto($buscar);

		if (strlen($imagenes->ImgAdicionales) > 0)
		{
			if ($esManilla)
			{
				$ruta = $CI->config->item('base_imagenes').'manilla/';

				$adicionales = explode(';', $imagenes->ImgAdicionales);
	
				foreach($adicionales as $adicional)
				{
					if (strpos($adicional,'-'))
					{
						array_push($imgAdicionales, $ruta.'adicionales/'.$adicional);
					}
					else
					{
						array_push($imgAdicionales, $ruta.$adicional);
					}
				}				
			}
			else
			{
				$ruta = $CI->config->item('base_imagenes').'adicionales/';

				$adicionales = explode(';', $imagenes->ImgAdicionales);
	
				foreach($adicionales as $adicional)
				{
					array_push($imgAdicionales, $ruta.$adicional);
				}
			}
		}

		return $imgAdicionales;
	}

	function imagen_texturas($codigo)
	{
		$imgTexturas = array();

		$buscar = explode('.',$codigo)[0];

		$CI = get_instance();
		$imagenes = $CI->productos_model->consulta_imagen_textura($buscar);

		if (count($imagenes) > 0)
		{
			$ruta = $CI->config->item('base_imagenes').'manilla/texturas/';

			foreach($imagenes as $textura)
			{
				array_push($imgTexturas, $ruta.$textura->ImgTexturas);
			}				
		}

		return $imgTexturas;
	}	

	function imagen_producto($codigo,$esManilla = false, $adicional = false)//,$tipo){
	{
		$CI = get_instance();
		
		$imagen = $codigo;
				
		if (!$esManilla)
		{
			$imagenes = $CI->productos_model->consulta_imagen_producto($codigo);
			if ($imagenes)
			{
				if (strlen($imagenes->ImgStatur) != 0)
				{
					$imagen = 'statur/'.$imagenes->ImgStatur;
				}
				else
				{
					$imagen = $imagenes->ImgPrincipal;
				}
			}
		}		
		else
		{	
			$imagenes = $CI->productos_model->consulta_imagen_manilla($codigo);//buscar[0]);

			if ($imagenes)
			{			
				if (strpos($imagenes->ImgPrincipal,'-A'))
				{
					$imagen = 'adicionales/'.$imagenes->ImgPrincipal;
				}
				else
				{
					$imagen = $imagenes->ImgPrincipal;
				}
			}
			else
			{
				$imagen = $codigo;
			}
		}
		
		return $imagen;
	}

	function lista_pedidos_usuario()
	{
		$CI = get_instance();
		$pedidos = $CI->pedidos_model->lista_pedidos_usuario();
		
		return $pedidos;
	}
	
	function lista_paises()
	{
		$CI = get_instance();
		$paises  = $CI->varios_model->lista_paises();
		
		return $paises;
	}
	
	function consulta_pais_codigo($pais)
	{
		$CI = get_instance();
		$pais = $CI->varios_model->consulta_pais_codigo($pais);
		
		return $pais[0]->Descrip;
	}
	
	function lista_estados($pais = '')
	{
		$CI = get_instance();
		$estados = $CI->varios_model->lista_estados($pais);
		
		return $estados;
	}
	
	function consulta_estado_codigo($estado)
	{
		$CI = get_instance();
		$estado = $CI->varios_model->consulta_estado_codigo($estado);
		
		return $estado[0]->Descrip;
	}
	
	function lista_ciudades($estado = '',$pais = '')
	{
		$CI = get_instance();
		$ciudades = $CI->varios_model->lista_ciudades($estado,$pais);
		
		return $ciudades;
	}
	
	function consulta_ciudad_codigo($ciudad)
	{
		$CI = get_instance();
		$ciudad = $CI->varios_model->consulta_ciudad_codigo($ciudad);
		
		return $ciudad[0]->Descrip;
	}

	function esManilla($codigo)
	{
		$CI = get_instance();

		return $CI->productos_model->esManilla($codigo);
	}

	function lista_menu()
	{
		$CI = get_instance();

		return $CI->varios_model->lista_menu();
	}

	/*********************************** Productos de fábrica ******************* */
	function imagen_producto_fabrica($codigo)//,$tipo){
		{
			$extensiones = array('png','jpg','gif','tif');
			$existe = false;
			$imagen = $codigo;
			$ruta = "assets/fabrica/";
	
			for($i=0;$i<count($extensiones) && !$existe;$i++)
			{
				if (file_exists($ruta.$codigo.'.'.$extensiones[$i]))
				{
					$imagen = $ruta.$imagen.'.'.$extensiones[$i];
					$existe = true;
				}
			}
	
			return $imagen;
		}