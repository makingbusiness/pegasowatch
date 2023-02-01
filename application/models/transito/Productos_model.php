<?php
class Productos_model extends CI_Model{
	
	public function __construct()
	{
		parent::__construct();
	}

	public function lista_productos()
	{
		$this->db->select('p.ID,p.Code,p.Description,p.Brand,p.Refere,p.GTIN,p.Created');
		$this->db->from('tabProducts p');
		$this->db->order_by('p.Description');

		$query = $this->db->get();
		return $query->result();
	}

	public function existe_producto($codigo)
	{
		$this->db->where('p.Code',$codigo);
		$this->db->from('tabProducts p');

		return $this->db->count_all_results();
	}

	public function insertar_producto($producto)
	{
		$datos = array(
			"Code"          => $producto->Code,
			"Description"   => $producto->Description,
			"Brand"         => $producto->Brand,
			"Refere"        => $producto->Refere,
			"GTIN"          => $producto->GTIN
		);

		$result = $this->db->insert('tabProducts', $datos);
		return $result;
	}

	public function actualizar_producto($producto)
	{
		$datos = array(
			"Code"         => $producto->Code,
			"Description"  => $producto->Description,
			"Brand"        => $producto->Brand,
			"Refere"       => $producto->Refere,
			"GTIN"         => $producto->GTIN
		);

		$this->db->where('ID',$producto->ID);

		$result = $this->db->update('tabProducts', $datos);
		return $result;
	}

	public function eliminar_producto($producto)
	{
		$this->db->where('ID', $producto);
		$result = $this->db->delete('tabProducts');

		return $result;
	}
}