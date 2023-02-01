<?php
class Clientes_model extends CI_Model{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
    }
    
    public function existeCliente($cliente){
        $this->db->from('clientes');
        $this->db->where('CodClie',$cliente);

        return $this->db->count_all_results();
    }

    public function inserta_cliente($cliente){
     
        $data = array(
            'CodClie'         => $cliente->CodClie,
            'TipoDocumento'   => $cliente->TipoDocumento,
            'Nombre'          => $cliente->Nombre,
            'Apellido'        => $cliente->Apellido,
            'Direc1'          => $cliente->Direc1,
            'Pais'            => $cliente->Pais,
            'Departamento'    => $cliente->Departamento,
            'Municipio'       => $cliente->Municipio,
            'Telef'           => $cliente->Telef,
            'Movil'           => $cliente->Movil,
            'Email'           => $cliente->Email,
            'NombreUsuario'   => $cliente->NombreUsuario,
            'ClaveUsuario'    => $cliente->ClaveUsuario,
            'consPrecios'     => $cliente->consPrecios
        );

        $this->db->insert('clientes',$data);
     }

     public function actualizar_cliente($cliente){
         $data = array(
            'TipoDocumento'   => $cliente->TipoDocumento,
            'Nombre'          => $cliente->Nombre,
            'Apellido'        => $cliente->Apellido,
            'Direc1'          => $cliente->Direc1,
            'Pais'            => $cliente->Pais,
            'Departamento'    => $cliente->Departamento,
            'Municipio'       => $cliente->Municipio,
            'Telef'           => $cliente->Telef,
            'Movil'           => $cliente->Movil,
            'Email'           => $cliente->Email,
            'NombreUsuario'   => $cliente->NombreUsuario,
            'ClaveUsuario'    => $cliente->ClaveUsuario,
            'consPrecios'     => $cliente->consPrecios
        );

         $this->db->where('CodClie',$cliente->CodClie);
         $this->db->update('clientes',$data);
     }
}