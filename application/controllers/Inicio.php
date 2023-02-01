<?php
class Inicio extends CI_Controller{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('productos_model');
		$this->load->model('varios_model');

		if (!$this->session->has_userdata('total_items_carro'))
		{
			$this->session->set_userdata('total_items_carro', '0');
		}
		
		if (!$this->session->has_userdata('idioma'))
		{
			$this->session->set_userdata('idioma', '1');
		}

		if (!$this->session->has_userdata('precio_idioma'))
		{
			$this->session->set_userdata('precio_idioma', '1');
		}
		
		if (!$this->session->has_userdata('IDTipoUsuario'))
		{
			$this->session->set_userdata('IDTipoUsuario', '1');		
		}
		
		$this->session->set_userdata('value-lower','1000');
		$this->session->set_userdata('value-upper','2000000');
	}
	
	public function index()
	{
		leer_ubicacion();

		$data['productos'] = $this->productos_model->lista_productos_promocion();			
		
		$this->load->view('templates/header');
		$this->load->view("home",$data);
		$this->load->view('templates/footer');
	}
}