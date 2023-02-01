<?php 
class Contactos_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
	}
	
	public function agregar_mensaje($nombre,$email,$telefono,$mensaje)
	{
		$data = array(
			'Nombre'   => $nombre,
			'Email'    => $email,
			'Telefono' => $telefono,
			'Mensaje'  => $mensaje
		);
		
		$insert = $this->db->insert('contacto', $data);
	}
}