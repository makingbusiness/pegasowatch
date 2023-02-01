<?php
class Ubicacion extends CI_Controller{
	
	public function __construct()
	{
        parent::__construct();
        $this->load->model('varios_model');
		$this->load->library('session');
	}
	
	public function index($pais)
	{
    }
    
    public function pais($pais)
    {
        //$data['productos'] = $this->productos_model->lista_productos_promocion();			
        
        $this->session->set_userdata('tabla_idiomas',$pais == 1 ? 'S' : 'N');
        
        redirect('inicio');
    }
}