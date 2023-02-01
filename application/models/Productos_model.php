<?php
class Productos_model extends CI_Model{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
	}
	/*
	 *	Get All Products
	 */
	 public function lista_productos($instancia,$porpagina,$segmento){
    	$lista = explode(",",$this->lista_subcategorias($instancia));
		 
		$precio = $this->session->IDTipoUsuario != '1' ? "1" : "Internet";
		//$precio.=$this->session->precio_idioma;

		$tabla_productos = $this->session->moneda_usuario == 'USD' ? 'productos_ingles' : 'productos';
		$tabla_precios = $this->session->moneda_usuario == 'USD' ? 'precios_producto_ingles' : 'precios_producto';

		$this->db->distinct();
		$this->db->select('p.CodigoAux As CodProd');
		$this->db->from($tabla_productos.' AS p');
		$this->db->join($tabla_precios.' AS pp','p.CodProd=pp.CodProd','INNER');
		$this->db->where_in('p.CodInst',$lista);
		$this->db->where('p.Activo','S');
		$this->db->where('pp.Precio'.$precio.'>',0);
		$this->db->order_by('p.CodigoAux','ASC');
		$this->db->limit($porpagina,$porpagina*($segmento-1));
		
		$query = $this->db->get();
		
		return $query->result();
	 }

	 public function lista_productos_promocion()//$porpagina,$segmento)
	 {
		if ($this->session->moneda_usuario == 'COP')
		{
			$hoy = Date('Y/m/d');
	
			$precio = $this->session->IDTipoUsuario != '1' ? "1" : "Internet";
			//$precio.=$this->session->precio_idioma;
	
			$tabla_productos = $this->session->moneda_usuario == 'USD' ? 'productos_ingles' : 'productos_promocion';
			//$tabla_precios = $this->session->moneda_usuario == 'USD' ? 'precios_producto_ingles' : 'precios_producto';
	
			$this->db->select('p.CodProd As CodProd');
			$this->db->from($tabla_productos.' AS p');
			$this->db->where('p.Desde<=',$hoy);
			$this->db->where('p.Hasta>=',$hoy);
			$this->db->order_by('p.CodProd','ASC');
			
			$query = $this->db->get();
			
			return $query->result();
		}
		else
		{
			return 0;
		}
	 }	 

	 public function lista_productos_api($instancia,$id,$porpagina,$segmento)
	 {
		$lista = explode(",",$this->lista_subcategorias($instancia));
		 
		/*$precio = $this->session->IDTipoUsuario != '1' ? "1" : "Internet";
		$precio.=' AS Precio';
*/
		$tabla_productos = $this->session->moneda_usuario == 'USD' ? 'productos_ingles' : 'productos';

		$this->db->distinct();
		$this->db->select('p.CodigoAux As CodProd');//,p.Impuesto,p.Marca,p.Precio'.$precio.',p.CodInst,p.EsNuevo,a.ListaProductos');
		$this->db->from($tabla_productos.' AS p');
		$this->db->join('auxiliares_producto AS a','p.codigoAux=a.CodigoAux','INNER');
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

		$lista = '';
		if ($clave == '0')
		{
			$lista = explode(",",$this->lista_subcategorias($instancia));
		}
		
		$precio = $this->session->IDTipoUsuario != '1' ? "1" : "Internet";
		$tabla_precios = $this->session->moneda_usuario == 'USD' ? 'precios_producto_ingles' : 'precios_producto';
		$tabla_pulsos = $this->session->moneda_usuario == 'USD' ? 'referencias_manilla_ingles' : 'referencias_manilla';
		$tabla_productos = $this->session->moneda_usuario == 'USD' ? 'productos_ingles' : 'productos';
		 
		$this->db->distinct();
		$this->db->select('r.CodProd,r.Impuesto,r.Descrip,0 AS Precio,r.ListaCalibres,r.ListaColores,r.CodInst');
		$this->db->from($tabla_pulsos.' AS r');
		$this->db->join($tabla_productos.' AS p','r.CodProd=p.RefBase','INNER');
		//$this->db->join($tabla_precios.' AS pp','pp.CodProd=p.CodProd','INNER');

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
		
		//$this->db->where('pp.Precio'.$precio.'>',0);
		$this->db->where('r.Activo','S');
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
	 
 	 public function lista_productos_categoria($instancia,$porpagina,$segmento){
		$lista = explode(",",$this->lista_subcategorias($instancia));
		
		$tabla_productos = $this->session->moneda_usuario == 'USD' ? 'productos_ingles' : 'productos';

		$this->db->distinct();
		$this->db->select('p.CodigoAux AS CodProd');
		$this->db->from($tabla_productos.' AS p');
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

		$tabla_productos = $this->session->moneda_usuario == 'USD' ? 'productos_ingles' : 'productos';
		
		$this->db->distinct();
		$this->db->select('p.CodigoAux AS CodProd');//,p.Impuesto,p.Marca,pi.Descrip,pi.Descrip2,pi.Descrip3,pp.Precio');
		$this->db->from($tabla_productos.' AS p');
		$this->db->join('productos_idioma AS pi','p.CodProd=pi.CodProd','INNER');
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
		 
		$tabla_pulsos = $this->session->moneda_usuario == 'USD' ? 'referencias_manilla_ingles' : 'referencias_manilla';
		
		$this->db->distinct();
		$this->db->select('r.CodProd,r.Impuesto,r.Descrip,0 AS Precio,r.ListaCalibres,r.ListaColores');
		$this->db->from($tabla_pulsos.' AS r');
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
		$tabla_categorias = $this->session->moneda_usuario == 'USD' ? 'categorias_ingles' : 'categorias';		
		$tabla_productos = $this->session->moneda_usuario == 'USD' ? 'productos_ingles' : 'productos';

		$this->db->distinct();
		$this->db->select('p.CodigoAux AS CodProd');
		$this->db->from($tabla_productos.' AS p');
		$this->db->join($tabla_categorias.' AS c','p.CodInst=c.CodInst','INNER');
		$this->db->where('p.Marca',$marca);
		$this->db->where('p.Activo','S');
		$this->db->order_by('p.CodigoAux','ASC');
		$this->db->limit($porpagina,$porpagina*($segmento-1));
		
		$query = $this->db->get();
		
		return $query->result();
	 }
	 
	 public function lista_productos_promocion_revisar(){
		$precio = $this->session->IDTipoUsuario != '1' ? "1" : "Internet";
		//$precio.=$this->session->precio_idioma.' AS Precio';
		$precio.=' AS Precio';
		
		$tabla_precios = $this->session->moneda_usuario == 'USD' ? 'precios_producto_ingles' : 'precios_producto';
		$tabla_productos = $this->session->moneda_usuario == 'USD' ? 'productos_ingles' : 'productos';

		$this->db->select('p.CodProd,p.Impuesto,p.Marca,pi.Descrip,pi.Descrip2,pi.Descrip3,pi.DescAmpliada,pp.Precio'.$precio.',p.EsNuevo');
		$this->db->from($tabla_productos.' AS p');
		$this->db->join('productos_idioma AS pi','p.CodProd=pi.CodProd','INNER');
		$this->db->join($tabla_precios.' AS pp','p.CodProd=pp.CodProd','INNER');
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
		$precio = $this->session->IDTipoUsuario != '1' ? "1" : "Internet";
		$precio.=' AS Precio';

		$tabla_productos = $this->session->moneda_usuario == 'USD' ? 'productos_ingles' : 'productos';
		$tabla_categorias = $this->session->moneda_usuario == 'USD' ? 'categorias_ingles' : 'categorias';
		$tabla_precios = $this->session->moneda_usuario == 'USD' ? 'precios_producto_ingles' : 'precios_producto';

		$this->db->select('p.CodProd,p.Impuesto,p.Marca,pi.Descrip,pi.Descrip2,pi.Descrip3,pi.DescAmpliada,pp.Precio'.$precio);
		$this->db->from($tabla_productos.' AS p');
		$this->db->join('productos_idioma AS pi','p.CodProd=pi.CodProd','INNER');
		$this->db->join($tabla_precios.' AS pp','p.CodProd=pp.CodProd','INNER');
		$this->db->join($tabla_categorias.' AS c','p.CodInst=c.CodInst','INNER');
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
		$tabla_categorias = $this->session->moneda_usuario == 'USD' ? 'categorias_ingles' : 'categorias';

		$tabla_productos = $this->session->moneda_usuario == 'USD' ? 'productos_ingles' : 'productos';

		$this->db->from($tabla_productos.' AS p');
		$this->db->join('productos_idioma AS pi','p.CodProd=pi.CodProd','INNER');
		//$this->db->join('precios_producto AS pp','p.CodProd=pp.CodProd','INNER');
		$this->db->join($tabla_categorias.' AS c','p.CodInst=c.CodInst','INNER');
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
		
		$tabla_productos = $this->session->moneda_usuario == 'USD' ? 'productos_ingles' : 'productos';

		$this->db->from($tabla_productos.' AS p');
		$this->db->join('productos_idioma AS pi','p.CodProd=pi.CodProd','INNER');
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
		 
		$tabla_pulsos = $this->session->moneda_usuario == 'USD' ? 'referencias_manilla_ingles' : 'referencias_manilla';

		$this->db->from($tabla_pulsos.' AS r');
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

		 $tabla_categorias = $this->session->moneda_usuario == 'USD' ? 'categorias_ingles' : 'categorias';
		 $tabla_productos = $this->session->moneda_usuario == 'USD' ? 'productos_ingles' : 'productos';

		 $this->db->select('p.marca');
		 $this->db->distinct(TRUE);
		 $this->db->from($tabla_productos.' AS p');
		 $this->db->join($tabla_categorias.' AS c','p.CodInst=c.CodInst','INNER');
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
		//$precio.=$this->session->precio_idioma.' AS Precio';
		$precio.=' AS Precio';

		$tabla_precios = $this->session->moneda_usuario == 'USD' ? 'precios_producto_ingles' : 'precios_producto';
		$tabla_productos = $this->session->moneda_usuario == 'USD' ? 'productos_ingles' : 'productos';

		$this->db->select('p.CodProd,pi.Descrip,pi.Descrip2,pi.Descrip3,pi.DescAmpliada,p.Marca,pp.Precio'.$precio.',p.Impuesto,p.CodigoAux,p.RefBase,a.ListaProductos,p.CodInst,p.EsNuevo,p.ImgPrincipal,p.ImgAdicionales,p.ImgStatur');
		$this->db->from($tabla_productos.' AS p');
		$this->db->join('productos_idioma AS pi','p.CodProd=pi.CodProd','INNER');
		$this->db->join($tabla_precios.' AS pp','p.CodProd=pp.CodProd','INNER');
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
		//$precio.=$this->session->precio_idioma.' AS Precio';
		$precio.=' AS Precio';

		$tabla_precios = $this->session->moneda_usuario == 'USD' ? 'precios_producto_ingles' : 'precios_producto';
		$tabla_productos = $this->session->moneda_usuario == 'USD' ? 'productos_ingles' : 'productos';

		$this->db->select('p.CodProd,pi.Descrip,pi.Descrip2,pi.Descrip3,pi.DescAmpliada,p.Marca,pp.Precio'.$precio.',p.Impuesto,p.CodigoAux,p.RefBase,a.ListaProductos,p.CodInst,p.EsNuevo');
		$this->db->from($tabla_productos.' AS p');
		$this->db->join('productos_idioma AS pi','p.CodProd=pi.CodProd','INNER');
		$this->db->join($tabla_precios.' AS pp','p.CodProd=pp.CodProd','INNER');
		$this->db->join('auxiliares_producto a','p.CodProd=a.CodigoAux','LEFT');
		$this->db->where('pi.IDIdioma',$idioma);
		//$this->db->where('pp.IDTipoUsuario',$this->session->IDTipoUsuario);
		$this->db->where('p.Activo','S');
		$this->db->like('p.CodProd', $codigo,'after');

		
		$query = $this->db->get();
		return $query->result();
	  }	  

	  public function consulta_precio_promocion($codigo)
	  {
		 if ($this->session->moneda_usuario == 'COP')
		 {
			$hoy = date('Y/m/d');

			$this->db->select('p.Precio');
			$this->db->from('productos_promocion p');
			$this->db->where('p.CodProd',$codigo);
			$this->db->where('p.Desde<=',$hoy);
			$this->db->where('p.Hasta>=',$hoy);

			$query = $this->db->get();
			return $query->row();
		 }

		 return 0;
	  }
	  
	  public function consulta_manilla($codigo)
	  {
		$precio = $this->session->IDTipoUsuario != '1' ? "1" : "Internet";
		//$precio.=$this->session->precio_idioma.' AS Precio';
		$precio.=' AS Precio';

		$tabla_precios = $this->session->moneda_usuario == 'USD' ? 'precios_producto_ingles' : 'precios_producto';

		$tabla_pulsos = $this->session->moneda_usuario == 'USD' ? 'referencias_manilla_ingles' : 'referencias_manilla';
		$tabla_productos = $this->session->moneda_usuario == 'USD' ? 'productos_ingles' : 'productos';

		$this->db->select('r.RefIni,r.CodProd,p.Impuesto,r.Descrip,pp.Precio'.$precio.',pi.Descrip,pi.Descrip2,pi.Descrip3,pi.DescAmpliada,p.Marca,r.ListaCalibres,r.ListaColores,p.CodigoAux,r.CodProd AS RefBase,p.CodInst,p.EsNuevo,p.ImgPrincipal,p.ImgAdicionales,p.ImgStatur');
		$this->db->from($tabla_pulsos.' AS r');
		$this->db->join($tabla_productos.' AS p','r.CodProd=SUBSTRING(p.CodProd,1,CHAR_LENGTH(r.CodProd))','INNER');
		$this->db->join('productos_idioma AS pi','p.CodProd=pi.CodProd','INNER');		
		$this->db->join($tabla_precios.' AS pp','p.CodProd=pp.CodProd','INNER');
		$this->db->where('r.CodProd',$codigo);
		$this->db->where('pi.IDIdioma',$this->session->idioma);
		//$this->db->where('pp.IDTipoUsuario',$this->session->IDTipoUsuario);
		$this->db->where('r.Activo','S');
		$this->db->where('p.Activo','S');
		$this->db->where('pp.Activo','S');
		$this->db->limit(1);
		
		$query = $this->db->get();
		return $query->row();
	  }

	  public function consulta_manilla_aux($codigo)
	  {
		$precio = $this->session->IDTipoUsuario != '1' ? "1" : "Internet";
		//$precio.=$this->session->precio_idioma.' AS Precio';
		$precio.=' AS Precio';

		$tabla_precios = $this->sesson->moneda_usuario == 'USD' ? 'precios_producto_ingles' : 'precios_producto';
		$tabla_pulsos = $this->session->moneda_usuario == 'USD' ? 'referencias_manilla_ingles' : 'referencias_manilla';
		$tabla_productos = $this->session->moneda_usuario == 'USD' ? 'productos_ingles' : 'productos';

		$this->db->select('r.RefIni,p.CodigoAux AS CodProd,p.Impuesto,r.Descrip,pp.Precio'.$precio.',pi.Descrip,pi.Descrip2,pi.Descrip3,pi.DescAmpliada,p.Marca,r.ListaCalibres,r.ListaColores,p.CodigoAux,r.CodProd AS RefBase,p.CodInst');
		$this->db->from($tabla_pulsos.' AS r');
		$this->db->join($tabla_productos.' AS p','r.CodProd=SUBSTRING(p.CodProd,1,CHAR_LENGTH(r.CodProd))','INNER');
		$this->db->join($tabla_precios.' AS pp','p.CodProd=pp.CodProd','INNER');
		$this->db->join('productos_idioma AS pi','p.CodProd=pi.CodProd','INNER');		
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
		//$precio.=$this->session->precio_idioma.' AS Precio';
		$precio.=' AS Precio';
		
		$tabla_precios = $this->session->moneda_usuario == 'USD' ? 'precios_producto_ingles' : 'precios_producto';
		$tabla_pulsos = $this->session->moneda_usuario == 'USD' ? 'referencias_manilla_ingles' : 'referencias_manilla';
		$tabla_productos = $this->session->moneda_usuario == 'USD' ? 'productos_ingles' : 'productos';

		$this->db->select('r.RefIni,r.CodProd,p.Impuesto,r.Descrip,pp.Precio'.$precio.',pi.Descrip,pi.Descrip2,pi.Descrip3,pi.DescAmpliada,p.Marca,r.ListaCalibres,r.ListaColores,p.CodigoAux,r.CodProd AS RefBase');
		$this->db->from($tabla_pulsos.' AS r');
		$this->db->join($tabla_productos.' AS p','r.CodProd=SUBSTRING(p.CodProd,1,CHAR_LENGTH(r.CodProd))','INNER');
		$this->db->join('productos_idioma AS pi','p.CodProd=pi.CodProd','INNER');		
		$this->db->join($tabla_precios.' AS pp','p.CodProd=pp.CodProd','INNER');
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
		  //$precio.=$this->session->precio_idioma.' AS Precio';
		  $precio.=' AS Precio';

		  $tabla_precios = $this->session->moneda_usuario == 'USD' ? 'precios_producto_ingles' : 'precios_producto';

		  $this->db->select('p.Precio'.$precio);
		  $this->db->from($tabla_precios.' AS p');
		  //$this->db->where('pp.IDTipoUsuario',$this->session->IDTipoUsuario);
		  $this->db->where('p.Activo','S');
		  $this->db->like('p.CodProd',$buscar,'after');
		  $this->db->limit(1);

	  	  $query = $this->db->get();
	  	  return $query->row();
	  }
	  
	  public function lista_precios_producto($codigo)
	  {
			$precio = $this->session->IDTipoUsuario != '1' ? "1" : "Internet";
			$precio.=' AS Precio';

			$tabla_precios = $this->session->moneda_usuario == 'USD' ? 'precios_producto_ingles' : 'precios_producto';
			$tabla_productos = $this->session->moneda_usuario == 'USD' ? 'productos_ingles' : 'productos';

			$this->db->select('p.CodProd,pp.Precio'.$precio.','.$this->session->IDTipoUsaurio.' AS IDTipoUsuario');
			$this->db->from($tabla_productos.' AS p');
			$this->db>join($tabla_precios.' AS pp','p.CodProd=pp.CodProd','INNER');
			$this->db->where('p.CodProd',$codigo);
			$this->db->where('p.Activo','S');

			$query = $this->db->get();
			return $query->result();
	  }
	  
	public function lista_categorias($idioma,$padre){
		$tabla_categorias = $this->session->moneda_usuario == 'USD' ? 'categorias_ingles' : 'categorias';

		$this->db->select('c.CodInst,ci.Descrip,c.InsPadre,c.EsPulso,c.InstanciaBase');
		$this->db->from($tabla_categorias.' AS c');
		$this->db->join('categorias_idioma ci','c.CodInst=ci.CodInst','INNER');
		$this->db->where('ci.IDIdioma',$idioma);
		$this->db->where('c.InsPadre',$padre);
		
		$query = $this->db->get();
		return $query->result();
	}
	
	public function consulta_categoria($idioma,$codigo)
	{
		$tabla_categorias = $this->session->moneda_usuario == 'USD' ? 'categorias_ingles' : 'categorias';

		$this->db->select('c.CodInst,ci.Descrip,c.InsPadre,c.EsPulso,c.InstanciaBase');
		$this->db->from($tabla_categorias.' AS c');
		$this->db->join('categorias_idioma ci','c.CodInst=ci.CodInst','INNER');
		$this->db->where('ci.IDIdioma',$idioma);
		$this->db->where('c.CodInst',$codigo);
		
		$query = $this->db->get();
		return $query->row();		
	}
	
	public function lista_subcategorias($padre)
	{
		if (!isset($padre)) return "";

		$tabla_categorias = $this->session->moneda_usuario == 'USD' ? 'categorias_ingles' : 'categorias';

		$this->db->select('c.InstanciaBase AS lista');
		$this->db->from($tabla_categorias.' AS c');
		$this->db->where('c.CodInst',$padre);
		
		$query = $this->db->get();
		$row = $query->row();
		
		return $row->lista;
	}
	
	public function total_productos($categoria){
		$lista = explode(",",$this->lista_subcategorias($categoria));
		
		$tabla_productos = $this->session->moneda_usuario == 'USD' ? 'productos_ingles' : 'productos';

		$this->db->distinct();
		$this->db->select('p.CodigoAux AS CodProd');
		$this->db->from($tabla_productos.' AS p');
		//$this->db->join('productos_idioma AS pi','p.CodProd=pi.CodProd','INNER');
		//$this->db->where('pi.IDIdioma',$this->session->idioma);
		$this->db->where_in('p.CodInst',$lista);
		$this->db->where('p.Activo','S');
		
		return $this->db->count_all_results();
	}

	public function total_productos_promocion()
	{
		if ($this->session->moneda_usuario == 'COP')
		{
			$hoy = Date('Y/m/d');
			$tabla_productos = $this->session->moneda_usuario == 'USD' ? 'productos_ingles_promocion' : 'productos_promocion';
	
			$this->db->distinct();
			$this->db->select('p.CodProd AS Total');
			$this->db->from($tabla_productos.' AS p');
			$this->db->where('p.Desde<=',$hoy);
			$this->db->where('p.Hasta>=',$hoy);
			
			return $this->db->count_all_results();
		}
		else
		{
			return 0;
		}
	}
	
	public function total_productos_marca($categoria,$marca){
		$this->db->distinct();
		
		$tabla_categorias = $this->session->moneda_usuario == 'USD' ? 'categorias_ingles' : 'categorias';
		$tabla_productos = $this->session->moneda_usuario == 'USD' ? 'productos_ingles' : 'productos';

		$this->db->select('p.CodigoAux AS CodProd');
		$this->db->from($tabla_productos.' AS p');
		//$this->db->join('productos_idioma AS pi','p.CodProd=pi.CodProd','INNER');
		$this->db->join($tabla_categorias.' AS c','p.CodInst=c.CodInst','INNER');
		//$this->db->where('pi.IDIdioma',$this->session->idioma);
		$this->db->where('p.Marca',$marca);
		$this->db->where('p.Activo','S');
		$this->db->where('c.InstanciaBase',$categoria);
		
		return $this->db->count_all_results();
	}

	public function total_productos_categoria($categoria){
		$lista = explode(",",$this->lista_subcategorias($categoria));
		
		$tabla_productos = $this->session->moneda_usuario == 'USD' ? 'productos_ingles' : 'productos';

		$this->db->distinct();
		$this->db->select('p.CodigoAux AS CodProd');
		$this->db->from($tabla_productos.' AS p');
		//$this->db->join('productos_idioma AS pi','p.CodProd=pi.CodProd','INNER');
		//$this->db->where('pi.IDIdioma',$this->session->idioma);
		$this->db->where_in('p.CodInst',$lista);
		$this->db->where('p.Activo','S');
		
		return $this->db->count_all_results();
	}
	
	public function total_manillas($categoria)
	{
		$lista = explode(",", $this->lista_subcategorias($categoria));
		
		$tabla_pulsos = $this->session->moneda_usuario == 'USD' ? 'referencias_manilla_ingles' : 'referencias_manilla';
		
		$this->db->from($tabla_pulsos.' AS r');
		$this->db->where_in('r.CodInst',$lista);
		$this->db->where('r.Activo','S');
		
		return $this->db->count_all_results();
	}

	public function existeProducto($codigo)
	{
		$tabla_productos = $this->session->moneda_usuario == 'USD' ? 'productos_ingles' : 'productos';

		$this->db->from($tabla_productos.' AS p');
		$this->db->where('p.CodProd',$codigo);
		$this->db->where('p.Activo','S');

		return $this->db->count_all_results();
	}
	
	public function existeManilla($codigo)
	{	
		$tabla_pulsos = $this->session->moneda_usuario == 'USD' ? 'referencias_manilla_ingles' : 'referencias_manilla';
		$tabla_productos = $this->session->moneda_usuario == 'USD' ? 'productos_ingles' : 'productos';

		if (strpos($codigo,'.'))
		{
			$this->db->from($tabla_productos.' AS p');

			$partes = explode('.',$codigo);
			$this->db->where('p.Activo','S');
			$this->db->like('p.CodProd',$partes[0].'.','after');
			$this->db->like('p.CodProd','.'.$partes[count($partes)-1],'before');
			$this->db->where('p.Activo','S');

			return $this->db->count_all_results();
		}
		else
		{
			$this->db->from($tabla_pulsos.' AS p');
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
		$tabla_productos = $this->session->moneda_usuario == 'USD' ? 'productos_ingles' : 'productos';

		$this->db->distinct();
		$this->db->select('p.CodProd,p.CodInst');
		$this->db->from($tabla_productos.' AS p');
		$this->db->join('productos_idioma AS pi','p.CodProd=pi.CodProd','INNER');
		$this->db->where('p.Activo','S');
		$this->db->like('p.CodProd',$parte,'after');
		$this->db->not_like('pi.Descrip','PULSO','after');
		
		$query = $this->db->get();
		return $query->result();
	}

	public function lista_productos_parte($parte)
	{
		$tabla_productos = $this->session->moneda_usuario == 'USD' ? 'productos_ingles' : 'productos';

		$partes = explode('.',$parte);
		$this->db->select('p.CodProd,p.CodInst');
		$this->db->from($tabla_productos.' AS p');
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
		
		$tabla_productos = $this->session->moneda_usuario == 'USD' ? 'productos_ingles' : 'productos';

		$this->db->select('pd.CodProd');
		$this->db->from('productos_destacados AS pd');
		$this->db->join($tabla_productos.' AS p','pd.CodProd=p.CodProd','INNER');
		$this->db->where('pd.FechaInicio <=',$hoy);
		$this->db->where("IFNULL(pd.fechafin,'".$hoy."')>=",$hoy);
		
		$query = $this->db->get();
		return $query->result();
	}
	  
	   /*
	 * Get Most Popular Products
	*/
	public function get_popular(){
		$this->db->select('P.*, COUNT(O.product_id) as total');
		$this->db->from('orders AS O');
		$this->db->join('products AS P', 'O.product_id = P.id', 'INNER');
		$this->db->group_by('O.product_id');
		$this->db->order_by('total', 'desc');
		$query = $this->db->get();
		return $query->result();
	}
	
	/*
	 *	Add Order To Database
	 */
	 public function add_order($order_data){
		$insert = $this->db->insert('orders', $order_data);
        return $insert;
	}
	
	public function consulta_base_categoria($categoria)
	{
		$tabla_categorias = $this->session->moneda_usuario == 'USD' ? 'categorias_ingles' : 'categorias';

		$this->db->select('c.CodInst');
		$this->db->from($tabla_categorias.' AS c');
		
		if ($this->config->item('usarNivel1') == 'S')
		{
			$this->db->where('c.Nivel','1');
		}
		
		$this->db->like('c.InstanciaBase',$categoria,'both');
		
		$result = $this->db->get();
		$row = $result->row();
		return $row->CodInst;		
	}
	
	public function consulta_nivel_categoria($categoria)
	{
		$tabla_categorias = $this->session->moneda_usuario == 'USD' ? 'categorias_ingles' : 'categorias';

		$this->db->select('c.Nivel');
		$this->db->from($tabla_categorias.' AS c');
		$this->db->where('c.CodInst',$categoria);
		
		$result = $this->db->get();
		$row = $result->row();
		return $row->Nivel;
	}

	public function consulta_producto_siguiente($codigo)
	{	
		$lista = explode(",",$this->lista_subcategorias($this->session->instancia_producto));
		$precio = $this->session->IDTipoUsuario != '1' ? "1" : "Internet";

		$tabla_productos = $this->session->moneda_usuario == 'USD' ? 'productos_ingles' : 'productos';
		$tabla_precios = $this->session->moneda_usuario == 'USD' ? 'precios_producto_ingles' : 'precios_producto';

		$this->db->select('p.CodigoAux As CodProd');
		$this->db->from($tabla_productos.' AS p');
		$this->db->join('productos_idioma AS pi','pi.CodProd=p.CodProd','INNER');
		$this->db->join($tabla_precios.' AS pp','p.CodProd=pp.CodProd','INNER');
		$this->db->where('p.RefBase > ',$codigo);
		$this->db->where('pp.Precio'.$precio.'>',0);
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

		$precio = $this->session->IDTipoUsuario != '1' ? "1" : "Internet";

		$tabla_productos = $this->session->moneda_usuario == 'USD' ? 'productos_ingles' : 'productos';
		$tabla_precios = $this->session->moneda_usuario == 'USD' ? 'precios_producto_ingles' : 'precios_producto';

		$this->db->select('p.CodigoAux AS CodProd');
		 $this->db->from($tabla_productos.' AS p');
		 $this->db->join('productos_idioma AS pi','pi.CodProd=p.CodProd','INNER');
		 $this->db->join($tabla_precios.' AS pp','p.CodProd=pp.CodProd','INNER');
		 $this->db->where('p.RefBase < ',$codigo);
		 $this->db->where('pp.Precio'.$precio.'>',0);
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

	  public function consulta_promocion_siguiente($codigo)
	  {	
		  $hoy = Date('Y/m/d');
		  $tabla_productos = $this->session->moneda_usuario == 'USD' ? 'productos_ingles_promocion' : 'productos_promocion';
  
		  $this->db->select('p.CodProd As CodProd');
		  $this->db->from($tabla_productos.' AS p');
		  $this->db->where('p.CodProd > ',$codigo);
		  $this->db->where('p.Desde<=',$hoy);
  		  $this->db->where('p.Hasta>=',$hoy);
  
		  $this->db->order_by('p.CodProd','ASC');
		  $this->db->limit(1);
		  
		  $query = $this->db->get();
		  
		  return $query->row();
	   }
  
	   public function consulta_promocion_anterior($codigo)
	   {	 
		  $hoy = Date('Y/m/d');
  
		  $tabla_productos = $this->session->moneda_usuario == 'USD' ? 'productos_ingles_promocion' : 'productos_promocion';
  
		  $this->db->select('p.CodProd AS CodProd');
		   $this->db->from($tabla_productos.' AS p');
		   $this->db->where('p.CodProd > ',$codigo);		   
		   $this->db->where('p.Desde <= ',$hoy); 
		   $this->db->where('p.Hasta >= ',$hoy);
		   $this->db->order_by('p.CodProd','DESC');
		   $this->db->limit(1);
		   
		   $query = $this->db->get();
		   
		   return $query->row();
		}

	  public function consulta_manilla_siguiente($codigo)
	  {	
		  $instancia = $this->session->has_userdata('instancia_pulsos') ? $this->session->instancia_pulsos : $this->config->item('instancia_base_pulso');
		  $lista = explode(",",$this->lista_subcategorias($instancia));
  
		  $tabla_pulsos = $this->session->moneda_usuario == 'USD' ? 'referencias_manilla_ingles' : 'referencias_manilla';
		  
		  $this->db->select('r.CodProd,r.Impuesto,r.Descrip,0 AS Precio,r.ListaCalibres,r.ListaColores');
		  $this->db->from($tabla_pulsos.' AS r');
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
			$instancia = $this->session->has_userdata('instancia_pulsos') ? $this->session->instancia_pulsos : $this->config->item('instancia_base_pulso');
			$lista = explode(",",$this->lista_subcategorias($instancia));
		
			$tabla_pulsos = $this->session->moneda_usuario == 'USD' ? 'referencias_manilla_ingles' : 'referencias_manilla';
			
			$this->db->select('r.CodProd,r.Impuesto,r.Descrip,0 AS Precio,r.ListaCalibres,r.ListaColores');
			$this->db->from($tabla_pulsos.' AS r');
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
			$tabla_productos = $this->session->moneda_usuario == 'USD' ? 'productos_ingles' : 'productos';

			$this->db->select('p.ImgPrincipal,p.ImgAdicionales,p.ImgStatur');
			$this->db->from($tabla_productos.' AS p');
			$this->db->where('p.CodProd',$codigo);

			$query = $this->db->get();
			return $query->row();
		}

		public function consulta_imagen_manilla($codigo)
		{
			$tabla_productos = $this->session->moneda_usuario == 'USD' ? 'productos_ingles' : 'productos';

			$this->db->select('p.ImgPrincipal,p.ImgAdicionales,p.ImgStatur');
			$this->db->from($tabla_productos.' AS p');
			$this->db->where('p.codigoAux', $codigo);
			$this->db->limit(1);

			$query = $this->db->get();

			return $query->row();
		}

		public function consulta_imagen_textura($codigo)
		{
			$tabla_productos = $this->session->moneda_usuario == 'USD' ? 'productos_ingles' : 'productos';

			$this->db->distinct();
			$this->db->select('p.ImgTexturas');
			$this->db->from($tabla_productos.' AS p');
			$this->db->where('p.refBase', $codigo);
			$this->db->where('p.Activo','S');

			$query = $this->db->get();

			return $query->result();
		}

		public function esManilla($codigo)
		{
			$tabla_pulsos = $this->session->moneda_usuario == 'USD' ? 'referencias_manilla_ingles' : 'referencias_manilla';
			$tabla_productos = $this->session->moneda_usuario == 'USD' ? 'productos_ingles' : 'productos';

			$this->db->select('p.CodigoAux');
			$this->db->from($tabla_productos.' AS p');
			$this->db->join($tabla_pulsos.' AS r','p.RefBase=r.CodProd','INNER');
			$this->db->where('p.CodProd',$codigo);

			$query = $this->db->get();
			return $query->row();
		}

		public function consulta_pulso_base($base)
		{
			$tabla_pulsos = $this->session->moneda_usuario == 'USD' ? 'referencias_manilla_ingles' : 'referencias_manilla';

			$this->db->select('r.CodProd,r.Descrip,r.ListaCalibres,r.ListaColores,r.ListaPartes,r.CodInst');
			$this->db->from($tabla_pulsos.' AS r');
			$this->db->where('r.CodProd',$base);
			$this->db->where('r.Activo','S');

			$query = $this->db->get();
			return $query->row();
		}

		public function lista_pulsos_base($base,$precio = '-1')
		{
			if ($precio == '-1') $precio = $this->session->IDTipoUsuario != '1' ? "1" : "Internet";
			//$precio.=$this->session->precio_idioma;
						
			$tabla_precios = $this->session->moneda_usuario == 'USD' ? 'precios_producto_ingles' : 'precios_producto';
			$tabla_productos = $this->session->moneda_usuario == 'USD' ? 'productos_ingles' : 'productos';

			$this->db->select('p.CodProd,r.Descrip,r.DescAmpliada,pp.Precio'.$precio.' AS Precio,p.Impuesto,p.ImgPrincipal,p.ImgAdicionales,p.ImgTexturas');
			$this->db->from($tabla_productos.' AS p');
			$this->db->join($tabla_precios.' AS pp','p.CodProd=pp.CodProd','INNER');
			$this->db->join('productos_idioma AS r','p.CodProd=r.CodProd','INNER');
			$this->db->where('p.RefBase',$base);
			$this->db->where('p.Activo','S');

			$query = $this->db->get();
			return $query->result();
		}

		public function consulta_imagen_manilla_app($codigo)
		{
			$tabla_productos = $this->session->moneda_usuario == 'USD' ? 'productos_ingles' : 'productos';

			$this->db->select('p.ImgPrincipal,p.ImgAdicionales,p.ImgStatur');
			$this->db->from($tabla_productos.' AS p');
			$this->db->where('p.RefBase', $codigo);
			$this->db->limit(1);

			$query = $this->db->get();

			return $query->row();
		}

		public function buscar_productos_api($clave,$porpagina,$segmento)
		{		
		   //$precio = $this->session->IDTipoUsuario != '1' ? "1" : "Internet";
		   //$precio.=$this->session->idioma.' AS Precio';
   
		   $tabla_productos = $this->session->moneda_usuario == 'USD' ? 'productos_ingles' : 'productos';

		   $this->db->distinct();
		   $this->db->select('p.CodigoAux As CodProd');//,p.Impuesto,p.Marca,p.Precio'.$precio.',p.CodInst,p.EsNuevo,a.ListaProductos');
		   $this->db->from($tabla_productos.' AS p');
		   //$this->db->join('auxiliares_producto AS a','p.codigoAux=a.CodigoAux','INNER');
		   $this->db->join('productos_idioma AS pi','pi.CodProd=p.CodProd','INNER');
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

/*********************** Productos de fábrica ************************* */
public function lista_productos_fabrica($porpagina,$segmento)
{
   $this->db->select('p.CodProd,p.Impuesto,p.Descrip,p.DescAmpliada,p.Precio,p.CodInst');
   $this->db->from('productos_fabrica AS p');
   $this->db->order_by('p.CodProd','ASC');

   $this->db->limit($porpagina,$porpagina*($segmento-1));

   $query = $this->db->get();
   return $query->result();
}

public function total_productos_fabrica()
{
	$this->db->from('productos_fabrica AS p');

	return $this->db->count_all_results();
}		
}