<?php
class Editar_perfil extends CI_Controller{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('varios_model');
		$this->load->library('session');
	}
	
	public function index()
	{
		leer_ubicacion();
		
		$this->load->view('templates/header');
		$this->load->view('editar_perfil');
		$this->load->view('templates/footer');
	}
}