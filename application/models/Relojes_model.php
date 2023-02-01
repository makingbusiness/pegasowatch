<?php
class Relojes_model extends CI_Model{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
	}
	/*
	 *	Get All Products
	 */
	 public function lista_productos($instancia,$porpagina,$segmento){
		$this->db->select('p.CodProd,p.Impuesto,p.Marca,pi.Descrip,pi.Descrip2,pi.Descrip3,pp.Precio');
		$this->db->from('productos AS p');
		$this->db->join('productos_idioma AS pi','p.CodProd=pi.CodProd','INNER');
		$this->db->join('precios_producto AS pp','p.CodProd=pp.CodProd','INNER');
		$this->db->where('pi.IDIdioma',$this->session->idioma);
		$this->db->where('p.CodInst',$instancia);
		$this->db->where('pp.IDTipoUsuario',$this->session->tipo_usuario);
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
	 
	 public function lista_productos_filtro($porpagina,$segmento){
		$this->db->select('p.CodProd,p.Impuesto,p.Marca,pi.Descrip,pi.Descrip2,pi.Descrip3,pp.Precio');
		$this->db->from('productos AS p');
		$this->db->join('productos_idioma AS pi','p.CodProd=pi.CodProd','INNER');
		$this->db->join('precios_producto AS pp','p.CodProd=pp.CodProd','INNER');
		$this->db->where('pi.IDIdioma',$this->session->idioma);
		$this->db->where('pp.IDTipoUsuario',$this->session->tipo_usuario);

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
	 
	public function total_productos_filtro(){
		$this->db->from('productos AS p');
		$this->db->join('productos_idioma AS pi','p.CodProd=pi.CodProd','INNER');
		$this->db->join('precios_producto AS pp','p.CodProd=pp.CodProd','INNER');
		$this->db->where('pi.IDIdioma',$this->session->idioma);
		$this->db->where('pp.IDTipoUsuario',$this->session->tipo_usuario);
		
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
	
	public function lista_productos_clave($porpagina,$segmento)
	{
		$this->db->select('p.CodProd,p.Impuesto,p.Marca,pi.Descrip,pi.Descrip2,pi.Descrip3,pp.Precio');
		$this->db->from('productos AS p');
		$this->db->join('productos_idioma AS pi','p.CodProd=pi.CodProd','INNER');
		$this->db->join('precios_producto AS pp','p.CodProd=pp.CodProd','INNER');
		$this->db->where('pi.IDIdioma',$this->session->idioma);
		$this->db->group_start();
		$this->db->or_like('p.CodProd',$this->session->clave,'both');
		$this->db->or_like('p.Marca',$this->session->clave,'both');
		$this->db->or_like('pi.Descrip',$this->session->clave,'both');
		$this->db->or_like('pi.Descrip2',$this->session->clave,'both');
		$this->db->or_like('pi.Descrip3',$this->session->clave,'both');
		$this->db->group_end();
		$this->db->order_by('p.CodProd','ASC');
		$this->db->limit($porpagina,$segmento);
		
		$query = $this->db->get();
		
		return $query->result();
	}
	
	public function total_productos_clave(){
		$this->db->from('productos AS p');
		$this->db->join('productos_idioma AS pi','p.CodProd=pi.CodProd','INNER');
		$this->db->join('precios_producto AS pp','p.CodProd=pp.CodProd','INNER');
		$this->db->where('pi.IDIdioma',$this->session->idioma);
		$this->db->group_start();
		$this->db->or_like('p.CodProd',$this->session->clave,'both');
		$this->db->or_like('p.Marca',$this->session->clave,'both');		
		$this->db->or_like('pi.Descrip',$this->session->clave,'both');
		$this->db->or_like('pi.Descrip2',$this->session->clave,'both');
		$this->db->or_like('pi.Descrip3',$this->session->clave,'both');
		$this->db->group_end();
		
		return $this->db->count_all_results();
	}	
	 
	 public function lista_marcas()
	 {
		 $this->db->select('p.marca');
		 $this->db->distinct(TRUE);
		 $this->db->from('productos AS p');
		 $this->db->order_by('p.marca');
		 
		 $query = $this->db->get();
		 return $query->result();
	 }
	 
	 /*
	  *	Get Single Product
	  */
	  public function consulta_producto($codigo){
		$this->db->select('p.CodProd,pi.Descrip,pi.Descrip2,pi.Descrip3,pi.DescAmpliada,p.Marca,ROUND(pp.Precio*(1+p.Impuesto/100),0) AS Precio');
		$this->db->from('productos AS p');
		$this->db->join('productos_idioma AS pi','p.CodProd=pi.CodProd','INNER');
		$this->db->join('precios_producto AS pp','p.CodProd=pp.CodProd','INNER');		
		$this->db->where('p.CodProd', $codigo);
		$this->db->where('pi.IDIdioma',$this->session->idioma);
		$this->db->where('pp.IDTipoUsuario',1);
		
		$query = $this->db->get();
		return $query->row();
	  }

	  /*
	  * Consulta precios del producto
	  */
	  public function consulta_precio_producto($codigo){
	  	$this->db->select('p.CodProd,pp.Precio,pp.IDTipoUsuario');
	  	$this->db->from('productos AS p');
	  	$this->db>join('precios_producto AS pp','p.CodProd=pp.CodProd','INNER');
	  	$this->db->where('p.CodProd',$codigo);
		$this->db->where('IDTipoUsuario',$this->session->tipo_usuario);

	  	$query = $this->db->get();
	  	return $query->result();
	  }
	  
	  public function lista_precios_producto($codigo){
	  	$this->db->select('p.CodProd,pp.Precio,pp.IDTipoUsuario');
	  	$this->db->from('productos AS p');
	  	$this->db>join('precios_producto AS pp','p.CodProd=pp.CodProd','INNER');
	  	$this->db->where('p.CodProd',$codigo);

	  	$query = $this->db->get();
	  	return $query->result();
	  }
	  
	public function lista_categorias(){
		$this->db->select('c.CodInst,ci.Descrip,c.InsPadre');
		$this->db->from('categorias AS c');
		$this->db->join('categorias_idioma ci','c.CodInst=ci.CodInst','INNER');
		$this->db->where('ci.IDIdioma',$this->session->idioma);
		$this->db->where('c.Nivel',1);
		
		$query = $this->db->get();
		return $query->result();
    }	  
	
	public function total_productos($categoria){
		$this->db->from('productos AS p');
		$this->db->join('productos_idioma AS pi','p.CodProd=pi.CodProd','INNER');
		$this->db->where('pi.IDIdioma',$this->session->idioma);
		$this->db->where('p.CodInst',$categoria);
		
		return $this->db->count_all_results();
	}
	
	public function lista_productos_destacados(){
		$hoy = date('Y/m/d');
		
		$this->db->select('pd.CodProd');
		$this->db->from('productos_destacados AS pd');
		$this->db->join('productos AS p','pd.CodProd=p.CodProd','INNER');
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
	
	public function actualizar_producto($producto)
	{
		
	}
}