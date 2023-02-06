<?php
class Contacto extends CI_Controller{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->model('contactos_model');
		$this->load->model('productos_model');
		$this->load->model('varios_model');
		$this->load->library('session');
	}
	
	public function index()
	{
		$this->load->view('templates/header');
		$this->load->view("contacto");
		$this->load->view('templates/footer');
	}
	
	public function agregar_mensaje()
	{
		
		if ($this->config->item('activar_correo') == 'S')
		{
			$token = $_POST['token'];
			$action = $_POST['action'];
			
			// call curl to POST request
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL,"https://www.google.com/recaptcha/api/siteverify");
			curl_setopt($ch, CURLOPT_POST, 1);
			curl_setopt($ch, CURLOPT_POSTFIELDS, http_build_query(array('secret' => $this->config->item('CLAVE_SECRETA_RECAPTCHA'), 'response' => $token)));
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			$response = curl_exec($ch);
			curl_close($ch);
			$arrResponse = json_decode($response, true);
			
			// verificar la respuesta
			$mensaje = 'Recibimos tu mensaje';

			if($arrResponse["success"] == '1' && $arrResponse["action"] == $action && $arrResponse["score"] >= 0.5) 
			{
				$nombre = $this->input->post('name');
				$email = $this->input->post('email');
				$telefono = $this->input->post('phone');
				$mensaje = $this->input->post('message');
				
				$resultado = $this->contactos_model->agregar_mensaje($nombre,$email,$telefono,$mensaje);
				
				$info = $nombre.PHP_EOL.$email.PHP_EOL.$telefono.PHP_EOL.$mensaje;
				
				$this->varios_model->enviarCorreo($this->config->item('correo_contacto'),'Contacto sitio',$info);

			} 
			else 
			{
				$mensaje = 'El mensaje no puedo enviarse';
			}

			$this->session->set_flashdata('contacto_sitio',$mensaje);

			$this->load->view('templates/header');
			$this->load->view('contacto');
			$this->load->view('templates/footer');
		}
	}
}