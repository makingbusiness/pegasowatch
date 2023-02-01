<?php 
class Cart_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
    }

    public function mostrar_carro($pagina,$segmento)
    {

    }
}