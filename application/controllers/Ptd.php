<?php 
class Ptd extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('productos_model');
	}
	
    public function index()
	{
		$this->load->view("templates/header");
		$this->load->view("ptd");
		$this->load->view("templates/footer");
	}
}