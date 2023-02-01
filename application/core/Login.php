<?php
class Login extends CI_Controller{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('clientes_model');
		$this->load->library('elibom');
	}
	
	public function index()
	{
		$this->load->view('login');
	}
	
	public function recuperar_pwd()
	{
		$this->load->view('templates/header');
		$this->load->view('recover_pass');
		$this->load->view('templates/footer');
	}

	public function acceso_clientes()
	{
		$this->load->view('templates/header');
		$this->load->view('acceso_clientes');
		$this->load->view('templates/footer');
	}

	public function ingreso_cliente()
	{
		$cliente = $this->input->post('datos_codigo');
		$codigo = $this->input->post('codigo_acceso');

		$CodClie = $this->clientes_model->consultar_acceso_cliente($cliente, $codigo);
		
		//Validate user
		if($CodClie)
		{
			$datos_cliente = $this->clientes_model->consulta_cliente($cliente);
				  
		   //Set message
		   $this->session->set_userdata('registrado', 'Registro exitoso');
		   $this->session->set_userdata('IDTipoUsuario', '2');
		   $this->session->set_userdata('CodClie',$cliente);
		   $this->session->set_userdata('Email',$datos_cliente->Email);
		   
		   $this->load->view('templates/header');
		   $this->load->view('home');
		   $this->load->view('templates/footer');
	   } 
	   else 
	   {
		   //Set error
		   $this->session->set_flashdata('error_acceso', 'Los datos ingresados no son v&aacute;lidos');
		   redirect('login/acceso_clientes');
		   //echo 'El usuario o la contrase&ntilde;a no son v&aacute;lidos';
	   }
	}

	public function consulta_cliente()
	{
		$cliente = $this->input->post('dato');
		$resultado = $this->clientes_model->consulta_cliente($cliente);
		
		if ($resultado)
		{
			$codigo_ingreso = mt_rand(111111,999999);

			$this->clientes_model->guardar_codigo_temp($cliente,$codigo_ingreso);

			echo $aufzuhoren = 'En un momento recibirá un código de ingreso al correo y celular que tenemos registrado.';
			$this->enviar_sms($resultado->Movil,$codigo_ingreso);				
		}
		else echo 'No hay registros para el dato ingresado';
	}

	public function enviar_sms($movil,$codigo)
	{
		$this->elibom->sendMessage($movil,'Su codigo de ingreso para Making Businesss, es: '.$codigo);
	}
}