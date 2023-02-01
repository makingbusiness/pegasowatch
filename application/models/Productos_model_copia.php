<?php
class Productos_model extends CI_Model{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');		
		
        /*$tabla_productos = $this->session->pais_base == '1' ? 'productos' : 'productos2';
        $datos['tabla_idiomas']. = $this->session->pais_base == '1' ? 'productos_idioma' : 'productos_idioma2';
        $tabla_auxiliar = $this->session->pais_base == '1' ? 'auxiliares_producto' : 'auxiliares_producto2';
        $datos['tabla_pulsos']. = $this->session->pais_base == '1' ? 'referencias_manilla' : 'referencias_manilla2';		*/
	}

	private function valores_inicio()
	{	
		$pais_base = true;

		if ($this->session->has_userdata('pais_base'))
		{
			$pais_base = $this->session->pais_base;
		}

		$tablas['tabla_productos'] = $pais_base ? 'productos' : 'productos2';
        $tablas['tabla_auxiliar'] = $pais_base ? 'auxiliares_producto' : 'auxiliares_producto2';
		$tablas['tabla_idiomas'] = $pais_base ? 'productos_idioma' : 'productos_idioma2';
		$tablas['tabla_pulsos'] = $pais_base ? 'referencias_manilla' : 'referencias_manilla2';

		return $tablas;
	}
	
	/*
	 *	Get All Products
	 */
	 public function lista_productos($instancia,$porpagina,$segmento){
		$lista = explode(",",$this->lista_subcategorias($instancia));
		
		$datos = $this->valores_inicio();
		 
		$precio = $this->session->IDTipoUsuario != '1' ? "1" : "Internet";

		$this->db->distinct();
		$this->db->select('p.CodigoAux As CodProd');
		$this->db->from($datos['tabla_productos'].' AS p');
		$this->db->where_in('p.CodInst',$lista);
		$this->db->where('p.Activo','S');
		$this->db->where('p.Precio'.$precio.'>',0);
		$this->db->order_by('p.CodigoAux','ASC');
		$this->db->limit($porpagina,$porpagina*($segmento-1));
		
		$query = $this->db->get();
		
		return $query->result();
	 }

	 public function lista_productos_api($instancia,$id,$porpagina,$segmento)
	 {
		$lista = explode(",",$this->lista_subcategorias($instancia));

		$datos = $this->valores_inicio();
		 
		/*$precio = $this->session->IDTipoUsuario != '1' ? "1" : "Internet";
		$precio.=' AS Precio';
*/
		$this->db->distinct();
		$this->db->select('p.CodigoAux As CodProd');//,p.Impuesto,p.Marca,p.Precio'.$precio.',p.CodInst,p.EsNuevo,a.ListaProductos');
		$this->db->from($datos['tabla_productos'].' AS p');
		$this->db->join($datos['tabla_auxiliar'].' AS a','p.codigoAux=a.CodigoAux','INNER');
		$this->db->where('p.Activo','S');

		$this->db->where_in('p.CodInst',$lista);

		if ($id != '0')
		{
			$this->db->group_start();
			$this->db->like('p.CodigoAux',$id,'after');
			$this->db->group_end();
		}

		$this->db->order_by('p.CodigoAux','ASC');
		$this->db->limit($porpagina,$porpagina*($segmento-1));
		
		$query = $this->db->get();
		
		return $query->result();
	 }
	 
	 public function lista_manillas($instancia,$clave = '0',$porpagina = 1,$segmento = 1){

		$datos = $this->valores_inicio();

		$lista = '';
		if ($clave == '0')
		{
			$lista = explode(",",$this->lista_subcategorias($instancia));
		}
		
		$precio = $this->session->IDTipoUsuario != '1' ? "1" : "Internet";
		 
		$this->db->distinct();
		$this->db->select('r.CodProd,r.Impuesto,r.Descrip,0 AS Precio,r.ListaCalibres,r.ListaColores,r.CodInst');
		$this->db->from($datos['tabla_pulsos'].' AS r');
		$this->db->join('productos AS p','r.CodProd=p.RefBase','INNER');

		if ($clave == '0')
		{
			$this->db->where_in('r.CodInst',$lista);
		}
		else
		{
			$this->db->group_start();
			$this->db->where('r.CodProd',$clave);
			$this->db->or_like('r.Descrip',$clave,'both');
			$this->db->group_end();
		}
		
		$this->db->where('p.Precio'.$precio.'>',0);
		$this->db->where('r.Activo','S');
		$this->db->order_by('r.CodProd','ASC');
		//$this->db->limit($porpagina,$porpagina*($segmento-1));
		
		$query = $this->db->get();
		
		//if ($query->num_rows > 0){
			return $query->result();
		/*}
		else{
			return FALSE;
		}*/
	 }
	 
 	 public function lista_productos_categoria($instancia,$porpagina,$segmento){
		$lista = explode(",",$this->lista_subcategorias($instancia));

		$datos = $this->valores_inicio();
		
		$this->db->distinct();
		$this->db->select('p.CodigoAux AS CodProd');
		$this->db->from($datos['tabla_productos'].' AS p');
		$this->db->where_in('p.CodInst',$lista);
		$this->db->where('p.Activo','S');
		$this->db->order_by('p.CodigoAux','ASC');
		$this->db->limit($porpagina,$porpagina*($segmento-1));
		
		$query = $this->db->get();
		
		return $query->result();
	 }
	 
	public function lista_productos_clave($instancia,$clave,$porpagina,$segmento)
	{
		$lista = explode(",",$this->lista_subcategorias($instancia));
		//$filtros = explode(';',$clave);

		$datos = $this->valores_inicio();
		
		$this->db->distinct();
		$this->db->select('p.CodigoAux AS CodProd');//,p.Impuesto,p.Marca,pi.Descrip,pi.Descrip2,pi.Descrip3,pp.Precio');
		$this->db->from($datos['tabla_productos'].' AS p');
		$this->db->join($datos['tabla_idiomas'].' AS pi','p.CodProd=pi.CodProd','INNER');
		//$this->db->join('precios_producto AS pp','p.CodProd=pp.CodProd','INNER');
		$this->db->where('pi.IDIdioma',$this->session->idioma);
		$this->db->where_in('p.CodInst',$lista);
		//$this->db->where('pp.IDTipoUsuario',$this->session->IDTipoUsuario);
		$this->db->where('p.Activo','S');
		//$this->db->where('pp.Precio >=',$this->session->userdata('value-lower'));
		//$this->db->where('pp.Precio <=',$this->session->userdata('value-upper'));
		$this->db->group_start();
		$this->db->or_like('p.CodProd',$clave,'both');
		$this->db->or_like('p.Marca',$clave,'both');
		$this->db->or_like('pi.Descrip',$clave,'both');
		$this->db->or_like('pi.Descrip2',$clave,'both');
		$this->db->or_like('pi.Descrip3',$clave,'both');
		$this->db->group_end();
		$this->db->order_by('p.CodigoAux','ASC');
		$this->db->limit($porpagina,$porpagina*($segmento-1));
		
		$query = $this->db->get();
		
		return $query->result();
	}

	public function lista_manillas_clave($instancia,$clave,$porpagina,$segmento){
		$lista = explode(",",$this->lista_subcategorias($instancia));
		
		$datos = $this->valores_inicio();
		 
		$this->db->distinct();
		$this->db->select('r.CodProd,r.Impuesto,r.Descrip,0 AS Precio,r.ListaCalibres,r.ListaColores');
		$this->db->from($datos['tabla_pulsos'].' AS r');
		$this->db->where_in('r.CodInst',$lista);
		$this->db->where('r.Activo','S');

		$this->db->group_start();
		$this->db->or_like('r.CodProd',$clave,'both');
		$this->db->or_like('r.Descrip',$clave,'both');
		$this->db->group_end();

		$this->db->order_by('r.CodProd','ASC');
		$this->db->limit($porpagina,$porpagina*($segmento-1));
		
		$query = $this->db->get();
		
		//if ($query->num_rows > 0){
			return $query->result();
		/*}
		else{
			return FALSE;
		}*/
	 }
	
 	 public function lista_productos_marca($instancia,$marca,$porpagina,$segmento){

		$datos = $this->valores_inicio();

		$this->db->distinct();
		$this->db->select('p.CodigoAux AS CodProd');
		$this->db->from($datos['tabla_productos'].' AS p');
		$this->db->join('categorias AS c','p.CodInst=c.CodInst','INNER');
		$this->db->where('p.Marca',$marca);
		$this->db->where('p.Activo','S');
		$this->db->order_by('p.CodigoAux','ASC');
		$this->db->limit($porpagina,$porpagina*($segmento-1));
		
		$query = $this->db->get();
		
		return $query->result();
	 }
	 
	 public function lista_productos_promocion(){

		$datos = $this->valores_inicio();

		$precio = $this->session->IDTipoUsuario != '1' ? "1" : "Internet";
		$precio.=' AS Precio';
	
		$this->db->select('p.CodProd,p.Impuesto,p.Marca,pi.Descrip,pi.Descrip2,pi.Descrip3,pi.DescAmpliada,p.Precio'.$precio.',p.EsNuevo');
		$this->db->from($datos['tabla_productos'].' AS p');
		$this->db->join($datos['tabla_idiomas'].' AS pi','p.CodProd=pi.CodProd','INNER');
		//$this->db->join('precios_producto AS pp','p.CodProd=pp.CodProd','INNER');
		$this->db->join('productos_promocion AS c','p.CodProd=c.CodProd','INNER');
		$this->db->where('pi.IDIdioma',$this->session->idioma);
		//$this->db->where('pp.IDTipoUsuario',$this->session->IDTipoUsuario);
		$this->db->where('p.Activo','S');
		$this->db->order_by('p.CodProd','ASC');
		$this->db->limit(4);//$porpagina,$porpagina*($segmento-1));
		
		$query = $this->db->get();
		
		return $query->result();
	 }
	 
	 public function lista_productos_filtro($instancia,$porpagina,$segmento){

		$datos = $this->valores_inicio();

		$precio = $this->session->IDTipoUsuario != '1' ? "1" : "Internet";
		$precio.=' AS Precio';

		$this->db->select('p.CodProd,p.Impuesto,p.Marca,pi.Descrip,pi.Descrip2,pi.Descrip3,pi.DescAmpliada,p.Precio'.$precio);
		$this->db->from($datos['tabla_productos'].' AS p');
		$this->db->join($datos['tabla_idiomas'].' AS pi','p.CodProd=pi.CodProd','INNER');
		//$this->db->join('precios_producto AS pp','p.CodProd=pp.CodProd','INNER');
		$this->db->join('categorias c','p.CodInst=c.CodInst','INNER');
		$this->db->where('pi.IDIdioma',$this->session->idioma);
		//$this->db->where('pp.IDTipoUsuario',$this->session->IDTipoUsuario);
		$this->db->where('p.Activo','S');
		$this->db->where('c.InstanciaBase',$instancia);

        if ($this->session->userdata('lista_marcas'))
		{
			$this->db->group_start();
			foreach($this->session->userdata('lista_marcas') as $marca){
				$this->db->or_where('p.Marca',$marca);
			}
			$this->db->group_end();
		}		
		
		if ($this->session->userdata('rango_desde'))
		{
			$this->db->where('pp.Precio*(1+p.Impuesto/100) >= ',$this->session->userdata('rango_desde')*1000);
		}
		
		if ($this->session->userdata('rango_hasta'))
		{
			$this->db->where('pp.Precio*(1+p.Impuesto/100) <= ',$this->session->userdata('rango_hasta')*1000);
		}
		
		if ($this->session->userdata('hombre') || $this->session->userdata('mujer') || $this->session->userdata('ninos'))
		{
			$this->db->group_start();
		
			if ($this->session->userdata('hombre'))
			{
				$this->db->or_where('pi.Uso','HOMBRE');
			}

			if ($this->session->userdata('mujer'))
			{
				$this->db->or_where('pi.Uso','MUJER');
			}
		
			if ($this->session->userdata('ninos'))
			{
				$this->db->or_where('pi.Uso','NIÑO');
			}

			$this->db->group_end();
		}

		$this->db->order_by('p.CodProd','ASC');
		$this->db->limit($porpagina,$segmento);
		
		$query = $this->db->get();
		
		//if ($query->num_rows > 0){
			return $query->result();
		/*}
		else{
			return FALSE;
		}*/
	 }
	 
	public function total_productos_filtro($instancia){

		$datos = $this->valores_inicio();

		$this->db->from($datos['tabla_productos'].' AS p');
		$this->db->join($datos['tabla_idiomas'].' AS pi','p.CodProd=pi.CodProd','INNER');
		//$this->db->join('precios_producto AS pp','p.CodProd=pp.CodProd','INNER');
		$this->db->join('categorias c','p.CodInst=c.CodInst','INNER');
		$this->db->where('pi.IDIdioma',$this->session->idioma);
		//$this->db->where('pp.IDTipoUsuario',$this->session->IDTipoUsuario);
		$this->db->where('p.Activo','S');
		$this->db->where('c.InstanciaBase',$instancia);
		
        if ($this->session->userdata('lista_marcas'))
		{
			$this->db->group_start();
			foreach($this->session->userdata('lista_marcas') as $marca){
				$this->db->or_where('p.Marca',$marca);
			}
			$this->db->group_end();
		}
		
		if ($this->session->userdata('rango_desde'))
		{
			$this->db->where('pp.Precio*(1+p.Impuesto/100) >= ',$this->session->userdata('rango_desde')*1000);
		}
		
		if ($this->session->userdata('rango_hasta'))
		{
			$this->db->where('pp.Precio*(1+p.Impuesto/100) <= ',$this->session->userdata('rango_hasta')*1000);
		}

		if ($this->session->userdata('hombre') || $this->session->userdata('mujer') || $this->session->userdata('ninos'))
		{
			$this->db->group_start();
		
			if ($this->session->userdata('hombre'))
			{
				$this->db->or_where('pi.Uso','HOMBRE');
			}

			if ($this->session->userdata('mujer'))
			{
				$this->db->or_where('pi.Uso','MUJER');
			}
		
			if ($this->session->userdata('ninos'))
			{
				$this->db->or_where('pi.Uso','NIÑO');
			}

			$this->db->group_end();
		}
		
		return $this->db->count_all_results();
	}	 
	
	public function total_productos_clave($instancia,$clave){
		$lista = explode(",",$this->lista_subcategorias($instancia));

		$datos = $this->valores_inicio();
		
		$this->db->from($datos['tabla_productos'].' AS p');
		$this->db->join($datos['tabla_idiomas'].' AS pi','p.CodProd=pi.CodProd','INNER');
		//$this->db->join('precios_producto AS pp','p.CodProd=pp.CodProd','INNER');
		$this->db->where('pi.IDIdioma',$this->session->idioma);
		//$this->db->where('pp.IDTipoUsuario',$this->session->IDTipoUsuario);
		$this->db->where_in('p.CodInst',$lista);
		$this->db->where('p.Activo','S');
		$this->db->group_start();
		$this->db->or_like('p.CodProd',$clave,'both');
		$this->db->or_like('p.Marca',$clave,'both');		
		$this->db->or_like('pi.Descrip',$clave,'both');
		$this->db->or_like('pi.Descrip2',$clave,'both');
		$this->db->or_like('pi.Descrip3',$clave,'both');
		$this->db->group_end();
				
		return $this->db->count_all_results();
	}
	
	public function total_manillas_clave($instancia,$clave){
		$lista = explode(",",$this->lista_subcategorias($instancia));
		
		$datos = $this->valores_inicio();
		 
		$this->db->from($datos['tabla_pulsos'].' AS r');
		$this->db->where_in('r.CodInst',$lista);
		$this->db->where('r.Activo','S');

		$this->db->group_start();
		$this->db->or_like('r.CodProd',$clave,'both');
		$this->db->or_like('r.Descrip',$clave,'both');
		$this->db->group_end();
		
		return $this->db->count_all_results();
	 }

	 
	 public function lista_marcas($instancia)
	 {
		 $lista = explode(",",$this->lista_subcategorias($instancia));

		 $datos = $this->valores_inicio();

		 $this->db->select('p.marca');
		 $this->db->distinct(TRUE);
		 $this->db->from($datos['tabla_productos'].' AS p');
		 $this->db->join('categorias AS c','p.CodInst=c.CodInst','INNER');
		 $this->db->where_in('p.CodInst',$lista);
		 $this->db->order_by('p.marca');
		 $this->db->where('p.Activo','S');
		 
		 $query = $this->db->get();
		 return $query->result();
	 }
	 
	 /*
	  *	Get Single Product
	  */
	  public function consulta_producto($codigo,$precio = '-1')
	  {
		if ($precio == '-1') $precio = $this->session->IDTipoUsuario != '1' ? "1" : "Internet";		
		$precio.=' AS Precio';

		$datos = $this->valores_inicio();

		$this->db->select('p.CodProd,pi.Descrip,pi.Descrip2,pi.Descrip3,pi.DescAmpliada,p.Marca,p.Precio'.$precio.',p.Impuesto,p.CodigoAux,p.RefBase,a.ListaProductos,p.CodInst,p.PrecioUS1,p.PrecioUS2,p.PrecioUS3,p.PrecioUS4,p.PrecioUSInternet,p.EsNuevo,p.ImgPrincipal,p.ImgAdicionales,p.ImgStatur');
		$this->db->from($datos['tabla_productos'].' AS p');
		$this->db->join($datos['tabla_idiomas'].' AS pi','p.CodProd=pi.CodProd','INNER');
		//$this->db->join('precios_producto AS pp','p.CodProd=pp.CodProd','INNER');
		$this->db->join('auxiliares_producto a','p.CodProd=a.CodigoAux','LEFT');
		$this->db->where('p.CodProd', $codigo);
		$this->db->where('pi.IDIdioma',$this->session->idioma);
		//$this->db->where('pp.IDTipoUsuario',$this->session->IDTipoUsuario);
		$this->db->where('p.Activo','S');
		
		$query = $this->db->get();
		return $query->row();
	  }

	  public function consulta_producto_like($idioma,$codigo)
	  {
		$precio = $this->session->IDTipoUsuario != '1' ? "1" : "Internet";
		$precio.=' AS Precio';

		$datos = $this->valores_inicio();

		$this->db->select('p.CodProd,pi.Descrip,pi.Descrip2,pi.Descrip3,pi.DescAmpliada,p.Marca,p.Precio'.$precio.',p.Impuesto,p.CodigoAux,p.RefBase,a.ListaProductos,p.CodInst,p.EsNuevo');
		$this->db->from($datos['tabla_productos'].' AS p');
		$this->db->join($datos['tabla_idiomas'].' AS pi','p.CodProd=pi.CodProd','INNER');
		//$this->db->join('precios_producto AS pp','p.CodProd=pp.CodProd','INNER');
		$this->db->join('auxiliares_producto a','p.CodProd=a.CodigoAux','LEFT');
		$this->db->where('pi.IDIdioma',$idioma);
		//$this->db->where('pp.IDTipoUsuario',$this->session->IDTipoUsuario);
		$this->db->where('p.Activo','S');
		$this->db->like('p.CodProd', $codigo,'after');

		
		$query = $this->db->get();
		return $query->result();
	  }	  
	  
	  public function consulta_manilla($codigo)
	  {
		$precio = $this->session->IDTipoUsuario != '1' ? "1" : "Internet";
		$precio.=' AS Precio';

		$datos = $this->valores_inicio();

		$this->db->select('r.RefIni,r.CodProd,p.Impuesto,r.Descrip,p.Precio'.$precio.',pi.Descrip,pi.Descrip2,pi.Descrip3,pi.DescAmpliada,p.Marca,r.ListaCalibres,r.ListaColores,p.CodigoAux,r.CodProd AS RefBase,p.CodInst,p.EsNuevo,p.ImgPrincipal,p.ImgAdicionales,p.ImgStatur');
		$this->db->from($datos['tabla_pulsos'].' AS r');
		$this->db->join($datos['tabla_productos'].' AS p','r.CodProd=SUBSTRING(p.CodProd,1,CHAR_LENGTH(r.CodProd))','INNER');
		$this->db->join($datos['tabla_idiomas'].' AS pi','p.CodProd=pi.CodProd','INNER');		
		//$this->db->join('precios_producto AS pp','p.CodProd=pp.CodProd','INNER');
		$this->db->where('r.CodProd',$codigo);
		$this->db->where('pi.IDIdioma',$this->session->idioma);
		//$this->db->where('pp.IDTipoUsuario',$this->session->IDTipoUsuario);
		$this->db->where('r.Activo','S');
		$this->db->where('p.Activo','S');
		$this->db->limit(1);
		
		$query = $this->db->get();
		return $query->row();
	  }

	  public function consulta_manilla_aux($codigo)
	  {
		$precio = $this->session->IDTipoUsuario != '1' ? "1" : "Internet";
		$precio.=' AS Precio';

		$datos = $this->valores_inicio();

		$this->db->select('r.RefIni,p.CodigoAux AS CodProd,p.Impuesto,r.Descrip,p.Precio'.$precio.',pi.Descrip,pi.Descrip2,pi.Descrip3,pi.DescAmpliada,p.Marca,r.ListaCalibres,r.ListaColores,p.CodigoAux,r.CodProd AS RefBase,p.CodInst');
		$this->db->from($datos['tabla_pulsos'].' AS r');
		$this->db->join($datos['tabla_productos'].' AS p','r.CodProd=SUBSTRING(p.CodProd,1,CHAR_LENGTH(r.CodProd))','INNER');
		$this->db->join($datos['tabla_idiomas'].' AS pi','p.CodProd=pi.CodProd','INNER');		
		$this->db->where('p.CodigoAux',$codigo);
		$this->db->where('pi.IDIdioma',$this->session->idioma);
		$this->db->where('r.Activo','S');
		$this->db->where('p.Activo','S');
		$this->db->limit(1);
		
		$query = $this->db->get();
		return $query->row();
	  }


	  public function consulta_manilla_parte($codigo)
	  {
		$precio = $this->session->IDTipoUsuario != '1' ? "1" : "Internet";
		$precio.=' AS Precio';

		$datos = $this->valores_inicio();
		
		$this->db->select('r.RefIni,r.CodProd,p.Impuesto,r.Descrip,p.Precio'.$precio.',pi.Descrip,pi.Descrip2,pi.Descrip3,pi.DescAmpliada,p.Marca,r.ListaCalibres,r.ListaColores,p.CodigoAux,r.CodProd AS RefBase');
		$this->db->from($datos['tabla_pulsos'].' AS r');
		$this->db->join($datos['tabla_productos'].' AS p','r.CodProd=SUBSTRING(p.CodProd,1,CHAR_LENGTH(r.CodProd))','INNER');
		$this->db->join($datos['tabla_idiomas'].' AS pi','p.CodProd=pi.CodProd','INNER');		
		//$this->db->join('precios_producto AS pp','p.CodProd=pp.CodProd','INNER');
		$this->db->like('r.CodProd',$codigo,'after');
		$this->db->where('pi.IDIdioma',$this->session->idioma);
		//$this->db->where('pp.IDTipoUsuario',$this->session->IDTipoUsuario);
		$this->db->where('r.Activo','S');
		$this->db->where('p.Activo','S');
		$this->db->limit(1);
		
		$query = $this->db->get();
		return $query->row();
	  }

	  /*
	  * Consulta precios del producto
	  */
	  public function consulta_precio_producto($codigo)
	  {
		  $datos = $this->valores_inicio();

		  $pos = strpos($codigo,'.');

		  if ($pos)
		  {
			  $buscar = explode('.',$codigo)[0].'.';
		  }
		  else
		  {
			  $buscar = $codigo;
		  }

		  $precio = $this->session->IDTipoUsuario != '1' ? "1" : "Internet";
		  $precio.=' AS Precio';

		  $this->db->select('p.Precio'.$precio);
          $this->db->from($datos['tabla_productos'].' AS p');
		  //$this->db->where('pp.IDTipoUsuario',$this->session->IDTipoUsuario);
		  $this->db->where('p.Activo','S');
		  $this->db->like('p.CodProd',$buscar,'after');
		  $this->db->limit(1);

	  	  $query = $this->db->get();
	  	  return $query->row();
	  }
	  
	  public function lista_precios_producto($codigo)
	  {
			$datos = $this->valores_inicio();

			$precio = $this->session->IDTipoUsuario != '1' ? "1" : "Internet";
			$precio.=' AS Precio';

			$this->db->select('p.CodProd,p.Precio'.$precio.','.$this->session->IDTipoUsaurio.' AS IDTipoUsuario');
			$this->db->from($datos['tabla_productos'].' AS p');
			//$this->db>join('precios_producto AS pp','p.CodProd=pp.CodProd','INNER');
			$this->db->where('p.CodProd',$codigo);
			$this->db->where('p.Activo','S');

			$query = $this->db->get();
			return $query->result();
	  }
	  
	public function lista_categorias($idioma,$padre){
		$this->db->select('c.CodInst,ci.Descrip,c.InsPadre,c.EsPulso,c.InstanciaBase');
		$this->db->from('categorias AS c');
		$this->db->join('categorias_idioma ci','c.CodInst=ci.CodInst','INNER');
		$this->db->where('ci.IDIdioma',$idioma);
		$this->db->where('c.InsPadre',$padre);
		
		$query = $this->db->get();
		return $query->result();
	}
	
	public function consulta_categoria($idioma,$codigo)
	{
		$this->db->select('c.CodInst,ci.Descrip,c.InsPadre,c.EsPulso,c.InstanciaBase');
		$this->db->from('categorias AS c');
		$this->db->join('categorias_idioma ci','c.CodInst=ci.CodInst','INNER');
		$this->db->where('ci.IDIdioma',$idioma);
		$this->db->where('c.CodInst',$codigo);
		
		$query = $this->db->get();
		return $query->row();		
	}
	
	public function lista_subcategorias($padre)
	{
		if (!isset($padre)) return "";

		$this->db->select('c.InstanciaBase AS lista');
		$this->db->from('categorias AS c');
		$this->db->where('c.CodInst',$padre);
		
		$query = $this->db->get();
		$row = $query->row();
		
		return $row->lista;
	}
	
	public function total_productos($categoria){
		$lista = explode(",",$this->lista_subcategorias($categoria));

		$datos = $this->valores_inicio();
		
		$this->db->distinct();
		$this->db->select('p.CodigoAux AS CodProd');
		$this->db->from($datos['tabla_productos'].' AS p');
		//$this->db->join('productos_idioma AS pi','p.CodProd=pi.CodProd','INNER');
		//$this->db->where('pi.IDIdioma',$this->session->idioma);
		$this->db->where_in('p.CodInst',$lista);
		$this->db->where('p.Activo','S');
		
		return $this->db->count_all_results();
	}
	
	public function total_productos_marca($categoria,$marca){
		$datos = $this->valores_inicio();

		$this->db->distinct();
		$this->db->select('p.CodigoAux AS CodProd');
		$this->db->from($datos['tabla_productos'].' AS p');
		//$this->db->join('productos_idioma AS pi','p.CodProd=pi.CodProd','INNER');
		$this->db->join('categorias AS c','p.CodInst=c.CodInst','INNER');
		//$this->db->where('pi.IDIdioma',$this->session->idioma);
		$this->db->where('p.Marca',$marca);
		$this->db->where('p.Activo','S');
		$this->db->where('c.InstanciaBase',$categoria);
		
		return $this->db->count_all_results();
	}

	public function total_productos_categoria($categoria)
	{
		$datos = $this->valores_inicio();
		$lista = explode(",",$this->lista_subcategorias($categoria));
		
		$this->db->distinct();
		$this->db->select('p.CodigoAux AS CodProd');
		$this->db->from($datos['tabla_productos'].' AS p');
		//$this->db->join('productos_idioma AS pi','p.CodProd=pi.CodProd','INNER');
		//$this->db->where('pi.IDIdioma',$this->session->idioma);
		$this->db->where_in('p.CodInst',$lista);
		$this->db->where('p.Activo','S');
		
		return $this->db->count_all_results();
	}
	
	public function total_manillas($categoria)
	{
		$lista = explode(",", $this->lista_subcategorias($categoria));
		
		$datos = $this->valores_inicio();

		$this->db->from($datos['tabla_pulsos'].' AS r');
		$this->db->where_in('r.CodInst',$lista);
		$this->db->where('r.Activo','S');
		
		return $this->db->count_all_results();
	}

	public function existeProducto($codigo)
	{
		$datos = $this->valores_inicio();

		$this->db->from($datos['tabla_productos'].' AS p');
		$this->db->where('p.CodProd',$codigo);
		$this->db->where('p.Activo','S');

		return $this->db->count_all_results();
	}
	
	public function existeManilla($codigo)
	{	
		$datos = $this->valores_inicio();

		if (strpos($codigo,'.'))
		{
			$this->db->from($datos['tabla_productos'].' AS p');

			$partes = explode('.',$codigo);
			$this->db->where('p.Activo','S');
			$this->db->like('p.CodProd',$partes[0].'.','after');
			$this->db->like('p.CodProd','.'.$partes[count($partes)-1],'before');
			$this->db->where('p.Activo','S');

			return $this->db->count_all_results();
		}
		else
		{
			$this->db->from($datos['tabla_pulsos'].' AS p');
			$this->db->where('p.CodProd',$codigo);

			return $this->db->count_all_results();
		}
		
		/*$info = array(
			'qty' =>$codigo,
			'rowid' => $codigo
		);
		
		$this->db->insert('basura',$info);
		*/
	}
		
	public function lista_productos_base($parte)
	{
		//$partes = explode('.',$parte);

		$datos = $this->valores_inicio();

		$this->db->distinct();
		$this->db->select('p.CodProd,p.CodInst');
		$this->db->from($datos['tabla_productos'].' AS p');
		$this->db->join($datos['tabla_idiomas'].' AS pi','p.CodProd=pi.CodProd','INNER');
		$this->db->where('p.Activo','S');
		$this->db->like('p.CodProd',$parte,'after');
		$this->db->not_like('pi.Descrip','PULSO','after');
		
		$query = $this->db->get();
		return $query->result();
	}

	public function lista_productos_parte($parte)
	{
		$datos = $this->valores_inicio();

		$partes = explode('.',$parte);
		$this->db->select('p.CodProd,p.CodInst');
		$this->db->from($datos['tabla_productos'].' AS p');
		$this->db->where('p.Activo','S');
		$this->db->like('p.CodProd',$partes[0].'.','after');
		$this->db->like('p.CodProd','.'.$partes[count($partes)-1] ,'before');
		
		$query = $this->db->get();
		return $query->result();
	}

	public function mostrar_tabla_calibres($parte)
	{
		$html = $parte;

		if ($this->session->nombre_pagina == 'pulsos')
		{
			$referencias = $this->lista_productos_parte($parte);
			if ($referencias)
			{
				$html = '<input type="hidden" id="totalListaCalibres" value="'.count($referencias).'" />';

				$html.= '<table class="table table-bordered tab-manillas"><tr>';
				$html.= '<th colspan="'.count($referencias).'" class="text-center s-text18 size7">CALIBRES</th></tr><tr>';

				for($i=0;$i<count($referencias);$i++)
				{
					$partes = explode('.',$referencias[$i]->CodProd);

					$html.='<td><div id="calibres'.$i.'" name="calibre[]" class="size s-text18 t-center">'.$partes[1].'</div></td>';
				}

				$html.='</tr><tr>';
				for($i=0;$i<count($referencias);$i++)
				{
					$html.='<td><input class="size7 s-text18 t-center num-product caja-manilla" id="cantidades'.$i.'" type="number" name="cantidad[]" value=""></td>';
				}

				$html.= '</tr><tr><th colspan="'.count($referencias).'" class="text-center size7 s-text18">CANTIDAD</th>';
				$html.='</tr></table>';
			}
		}
		else
		{
			$detalle = $this->consulta_producto($parte);
			if ($detalle)
			$html = $parte.'___'.$detalle->Descrip.'___'.$detalle->Descrip2.'___'.$detalle->DescAmpliada.'___'.$detalle->Precio.'___'.$detalle->Impuesto;
			else $html = 'No se encontró información para '.$parte;
		}

		return $html;
	}
	
	public function lista_productos_destacados(){
		$hoy = date('Y/m/d');

		$datos = $this->valores_inicio();		
		
		$this->db->select('pd.CodProd');
		$this->db->from('productos_destacados AS pd');
		$this->db->join($datos['tabla_productos'].' AS p','pd.CodProd=p.CodProd','INNER');
		$this->db->where('pd.FechaInicio <=',$hoy);
		$this->db->where("IFNULL(pd.fechafin,'".$hoy."')>=",$hoy);
		
		$query = $this->db->get();
		return $query->result();
	}
	  	
	public function consulta_base_categoria($categoria,$nivel = false)
	{		
		if ($nivel)
		{
			$this->db->select('c.CodInst');
			$this->db->from('categorias AS c');
			$this->db->where('c.Nivel','1');
			$this->db->like('c.InstanciaBase',$categoria,'both');
		}
		else
		{
			$this->db->select('c.CodInst');
			$this->db->from('categorias AS c');
			//$this->db->where('c.Nivel','1');
			$this->db->like('c.InstanciaBase',$categoria,'right');
		}
		
		$result = $this->db->get();
		$row = $result->row();
		return $row->CodInst;		
	}
	
	public function consulta_nivel_categoria($categoria){
		$this->db->select('c.Nivel');
		$this->db->from('categorias AS c');
		$this->db->where('c.CodInst',$categoria);
		
		$result = $this->db->get();
		$row = $result->row();
		return $row->Nivel;
	}

	public function consulta_producto_siguiente($codigo)
	{	
		$lista = explode(",",$this->lista_subcategorias($this->session->instancia_producto));

		$datos = $this->valores_inicio();

		$this->db->select('p.CodigoAux As CodProd');
		$this->db->from($datos['tabla_productos'].' AS p');
		$this->db->join($datos['tabla_idiomas'].' AS pi','pi.CodProd=p.CodProd','INNER');
		$this->db->where('p.RefBase > ',$codigo);

		$this->db->where_in('p.CodInst',$lista);

		if ($this->session->has_userdata('filtro_productos'))
		{
			$this->db->group_start();
			$this->db->or_like('p.CodProd',$this->session->filtro_pulsos,'both');
			$this->db->or_like('p.Marca',$codigo,'both');
			$this->db->or_like('pi.Descrip',$codigo,'both');
			$this->db->or_like('pi.Descrip2',$codigo,'both');
			$this->db->or_like('pi.Descrip3',$codigo,'both');
			$this->db->group_end();
		}

		$this->db->where('p.Activo','S');
		$this->db->order_by('p.CodProd','ASC');
		$this->db->limit(1);
		
		$query = $this->db->get();
		
		return $query->row();
	 }

	 public function consulta_producto_anterior($codigo)
	 {	 
		$lista = explode(",",$this->lista_subcategorias($this->session->instancia_producto));	
		
		$datos = $this->valores_inicio();

		$this->db->select('p.CodigoAux AS CodProd');
		 $this->db->from($datos['tabla_productos'].' AS p');
		 $this->db->join($datos['tabla_idiomas'].' AS pi','pi.CodProd=p.CodProd','INNER');
		 $this->db->where('p.RefBase < ',$codigo);

		 $this->db->where_in('p.CodInst',$lista);

		 if ($this->session->has_userdata('filtro_productos'))
		 {
			 $this->db->group_start();
			 $this->db->or_like('p.CodProd',$this->session->filtro_pulsos,'both');
			 $this->db->or_like('p.Marca',$codigo,'both');
			 $this->db->or_like('pi.Descrip',$codigo,'both');
			 $this->db->or_like('pi.Descrip2',$codigo,'both');
			 $this->db->or_like('pi.Descrip3',$codigo,'both');
			 $this->db->group_end();
		 }

		 $this->db->where('p.Activo','S');
		 $this->db->order_by('p.CodProd','DESC');
		 $this->db->limit(1);
		 
		 $query = $this->db->get();
		 
		 return $query->row();
	  }

	  public function consulta_manilla_siguiente($codigo)
	  {	
          $datos = $this->valores_inicio();

		  $instancia = $this->session->has_userdata('instancia_pulsos') ? $this->session->instancia_pulsos : $this->config->item('instancia_base_pulso');
		  $lista = explode(",",$this->lista_subcategorias($instancia));
  
		  $this->db->select('r.CodProd,r.Impuesto,r.Descrip,0 AS Precio,r.ListaCalibres,r.ListaColores');
		  $this->db->from($datos['tabla_pulsos'].' AS r');
		  $this->db->where('r.CodProd > ',$codigo);
  
		  $this->db->where_in('r.CodInst',$lista);
  
		  if ($this->session->has_userdata('filtro_pulsos'))
		  {
			  $this->db->group_start();
			  $this->db->or_like('r.CodProd',$this->session->filtro_pulsos,'both');
			  $this->db->or_like('r.Descrip',$this->session->filtro_pulsos,'both');
			  $this->db->group_end();
		  }
  
		  $this->db->where('r.Activo','S');
		  $this->db->order_by('r.CodProd','ASC');
		  $this->db->limit(1);
		  
		  $query = $this->db->get();
		  
		  return $query->row();
	   }
  
	   public function consulta_manilla_anterior($codigo)
	   {	 
			$datos = $this->valores_inicio();
			
			$instancia = $this->session->has_userdata('instancia_pulsos') ? $this->session->instancia_pulsos : $this->config->item('instancia_base_pulso');
			$lista = explode(",",$this->lista_subcategorias($instancia));
		
			$this->db->select('r.CodProd,r.Impuesto,r.Descrip,0 AS Precio,r.ListaCalibres,r.ListaColores');
			$this->db->from($datos['tabla_pulsos'].' AS r');
			$this->db->where('r.CodProd < ',$codigo);

			$this->db->where_in('r.CodInst',$lista);

			if ($this->session->has_userdata('filtro_pulsos'))
			{
				$this->db->group_start();
				$this->db->or_like('r.CodProd',$this->session->filtro_pulsos,'both');
				$this->db->or_like('r.Descrip',$this->session->filtro_pulsos,'both');
				$this->db->group_end();
			}

			$this->db->where('r.Activo','S');
			$this->db->order_by('r.CodProd','DESC');
			$this->db->limit(1);
			
			$query = $this->db->get();
			
			return $query->row();
		}

		public function consulta_imagen_producto($codigo)
		{
			$datos = $this->valores_inicio();

			$this->db->select('p.ImgPrincipal,p.ImgAdicionales,p.ImgStatur');
			$this->db->from($datos['tabla_productos'].' AS p');
			$this->db->where('p.CodProd',$codigo);

			$query = $this->db->get();
			return $query->row();
		}

		public function consulta_imagen_manilla($codigo)
		{
			$datos = $this->valores_inicio();

			$this->db->select('p.ImgPrincipal,p.ImgAdicionales,p.ImgStatur');
			$this->db->from($datos['tabla_productos'].' AS p');
			$this->db->where('p.codigoAux', $codigo);
			$this->db->limit(1);

			$query = $this->db->get();

			return $query->row();
		}

		public function consulta_imagen_textura($codigo)
		{
			$datos = $this->valores_inicio();

			$this->db->distinct();
			$this->db->select('p.ImgTexturas');
			$this->db->from($datos['tabla_productos'].' AS p');
			$this->db->where('p.refBase', $codigo);
			$this->db->where('p.Activo','S');

			$query = $this->db->get();

			return $query->result();
		}

		public function esManilla($codigo)
		{
			$datos = $this->valores_inicio();

			$this->db->select('p.CodigoAux');
			$this->db->from($datos['tabla_productos'].' AS p');
			$this->db->join($datos['tabla_pulsos'].' AS r','p.RefBase=r.CodProd','INNER');
			$this->db->where('p.CodProd',$codigo);

			$query = $this->db->get();
			return $query->row();
		}

		public function consulta_pulso_base($base)
		{
			$datos = $this->valores_inicio();

			$this->db->select('r.CodProd,r.Descrip,r.ListaCalibres,r.ListaColores,r.ListaPartes,r.CodInst');
			$this->db->from($datos['tabla_pulsos'].' AS r');
			$this->db->where('r.CodProd',$base);
			$this->db->where('r.Activo','S');

			$query = $this->db->get();
			return $query->row();
		}

		public function lista_pulsos_base($base,$precio = '-1')
		{
			if ($precio == '-1') $precio = $this->session->IDTipoUsuario != '1' ? "1" : "Internet";
				
			$datos = $this->valores_inicio();

			$this->db->select('p.CodProd,r.Descrip,r.DescAmpliada,p.Precio'.$precio.' AS Precio,p.Impuesto,p.ImgPrincipal,p.ImgAdicionales,p.ImgTexturas');
			$this->db->from($datos['tabla_productos'].' AS p');
			$this->db->join($datos['tabla_pulsos'].' AS r','p.CodProd=r.CodProd','INNER');
			$this->db->where('p.RefBase',$base);
			$this->db->where('p.Activo','S');

			$query = $this->db->get();
			return $query->result();
		}

		public function consulta_imagen_manilla_app($codigo)
		{
			$datos = $this->valores_inicio();

			$this->db->select('p.ImgPrincipal,p.ImgAdicionales,p.ImgStatur');
			$this->db->from($datos['tabla_productos'].' AS p');
			$this->db->where('p.RefBase', $codigo);
			$this->db->limit(1);

			$query = $this->db->get();

			return $query->row();
		}

		public function buscar_productos_api($clave,$porpagina,$segmento)
		{		
			$datos = $this->valores_inicio();

		   $precio = $this->session->IDTipoUsuario != '1' ? "1" : "Internet";
		   $precio.=' AS Precio';
   
		   $this->db->distinct();
		   $this->db->select('p.CodigoAux As CodProd');//,p.Impuesto,p.Marca,p.Precio'.$precio.',p.CodInst,p.EsNuevo,a.ListaProductos');
		   $this->db->from($datos['tabla_productos'].' AS p');
		   //$this->db->join('auxiliares_producto AS a','p.codigoAux=a.CodigoAux','INNER');
		   $this->db->join($datos['tabla_idiomas'].' AS pi','pi.CodProd=p.CodProd','INNER');
		   $this->db->where('p.Activo','S');
		   
   
		   $this->db->group_start();
				$this->db->like('p.CodigoAux',$clave,'after');
				$this->db->or_group_start();
					$this->db->group_start();
						$this->db->like('pi.Descrip',$clave,'both');
						$this->db->or_like('p.marca',$clave,'both');
					$this->db->group_end();
					$this->db->not_like('pi.Descrip','PULSO','after');
				$this->db->group_end();
		   $this->db->group_end();
	
		   $this->db->order_by('p.CodigoAux','ASC');
		   $this->db->limit($porpagina,$porpagina*($segmento-1));
		   
		   $query = $this->db->get();
		   
		   return $query->result();
		}		
}