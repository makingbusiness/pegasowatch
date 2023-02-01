<?php 
class Clientes_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
    }

    public function consulta_cliente($dato)
    {
        $this->db->select('c.CodClie,c.Nombre,c.Direc1,c.Departamento,c.Municipio,c.Telef,c.Email,c.Movil');
        $this->db->from('clientes c');
        $this->db->where('c.CodClie',$dato);
        $this->db->or_where('c.Email',$dato);
        $this->db->or_where('c.Movil',$dato);

        $query = $this->db->get();
        return $query->row();
    }

    public function guardar_codigo_temp($cliente,$codigo)
    {
        $info = array(
            'ClaveUsuario' => $codigo
        );

        $this->db->where('CodClie',$cliente);
        $this->db->update('clientes',$info);
    }

    public function consultar_acceso_cliente($cliente,$codigo)
    {
        $this->db->select('c.CodClie');
        $this->db->from('clientes AS c');
        $this->db->where('c.CodClie',$cliente);
        $this->db->where('c.ClaveUsuario',$codigo);

        $result = $this->db->get();

        return $result->row();
    }
}