<?php
class Proveedores_model extends CI_Model{
	
	public function __construct()
	{
		parent::__construct();
	}

	public function lista_proveedores()
	{
		$this->db->select('p.ID,p.Name,p.Address,p.Phone,p.Mobile,p.Contact,p.Email,p.Created');
		$this->db->from('tabProviders p');
		$this->db->order_by('p.Name');

		$query = $this->db->get();
		return $query->result();
	}

	public function existe_proveedor($codigo)
	{
		$this->db->where('p.ID',$codigo);
		$this->db->from('tabProviders p');

		return $this->db->count_all_results();
	}

	public function insertar_proveedor($proveedor)
	{
		$datos = array(
			"ID"       => $proveedor->ID,
			"Name"     => $proveedor->Name,
			"Address"  => $proveedor->Address,
			"Phone"    => $proveedor->Phone,
			"Mobile"   => $proveedor->Mobile,
			"Contact"  => $proveedor->Contact,
			"Email"    => $proveedor->Email
		);

		$result = $this->db->insert('tabProviders', $datos);
		return $result;
	}

	public function actualizar_proveedor($proveedor)
	{
		$datos = array(
			"Name"     => $proveedor->Name,
			"Address"  => $proveedor->Address,
			"Phone"    => $proveedor->Phone,
			"Mobile"   => $proveedor->Mobile,
			"Contact"  => $proveedor->Contact,
			"Email"    => $proveedor->Email
		);

		$this->db->where('ID',$proveedor->ID);

		$result = $this->db->update('tabProviders', $datos);
		return $result;
	}

	public function eliminar_proveedor($proveedor)
	{
		$this->db->where('ID', $proveedor);
		$result = $this->db->delete('tabProviders');

		return $result;
	}

}