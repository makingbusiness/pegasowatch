<?php 
class Clientes_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
        $this->load->library('session');
        $this->load->library('elibom');
    }

    public function consulta_cliente($dato)
    {
        $this->db->select('c.CodClie,c.Nombre,c.Direc1,c.Pais,c.Departamento,c.Municipio,c.Telef,c.Email,c.Movil');
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
        $this->db->group_start();
        $this->db->where('c.CodClie',$cliente);
        $this->db->or_where('c.Email',$cliente);
        $this->db->or_where('c.Movil',$cliente);
        $this->db->group_end();
        $this->db->where('c.ClaveUsuario',$codigo);

        $result = $this->db->get();

        return $result->row();
    }

    public function consultar_acceso_cliente_app($cliente,$codigo)
    {
        $this->db->select('c.CodClie,c.Nombre,c.Apellido,Direc1,Pais,Departamento,Municipio,Telef, Movil,Email,\'1\' as Precio, consPrecios');
        $this->db->from('clientes AS c');
        $this->db->group_start();
        $this->db->where('c.CodClie',$cliente);
        $this->db->or_where('c.Email',$cliente);
        $this->db->or_where('c.Movil',$cliente);
        $this->db->group_end();
        $this->db->where('c.ClaveUsuario',$codigo);

        $result = $this->db->get();

        return $result->row();
    }    

	public function enviar_sms($movil,$codigo,$mensaje = '')
	{
        $enviar = $mensaje;

        if (strlen($enviar) == 0)
        {
            $enviar = 'Su codigo de ingreso para Making Businesss, es: '.$codigo;
        }

		$this->elibom->sendMessage($movil,$enviar);
	}
}