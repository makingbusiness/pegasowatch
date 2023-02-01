<?php
class Login extends CI_Controller{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
		$this->load->model('clientes_model');
		$this->load->model('productos_model');
		$this->load->model('usuarios_model');
		$this->load->model('varios_model');
	}
	
	public function index()
	{
		leer_ubicacion();
		
		$this->login_google();
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
		   $this->session->set_userdata('CodClie',$datos_cliente->CodClie);
		   $this->session->set_userdata('Email',$datos_cliente->Email);

		   // Datos para envío de pedido
		   $this->session->set_userdata('Nombres',$datos_cliente->Nombre);
		   $this->session->set_userdata('Apellidos','');
		   $this->session->set_userdata('paisEnvio',$datos_cliente->Pais);
		   $this->session->set_userdata('estadoEnvio',$datos_cliente->Departamento);		   
		   $this->session->set_userdata('ciudadEnvio',$datos_cliente->Municipio);
		   $this->session->set_userdata('direccionEnvio',$datos_cliente->Direc1);
		   $this->session->set_userdata('telefonoEnvio',$datos_cliente->Telef);
		   
		   if ($this->cart->contents())
		   {
			$this->load->view('templates/header');
			$this->load->view('cart');
			$this->load->view('templates/footer');
		   }
		   else
		   {
			$this->load->view('templates/header');
			$this->load->view('home');
			$this->load->view('templates/footer');
		   }
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

			$this->clientes_model->guardar_codigo_temp($resultado->CodClie,$codigo_ingreso);

			echo $aufzuhoren = 'En un momento recibirá un código de ingreso al correo y celular que tenemos registrado.';
			$this->clientes_model->enviar_sms($resultado->Movil,$codigo_ingreso);				
		}
		else echo 'No hay registros para el dato ingresado';
	}

	// Autenticación Google
	function login_google()
	{
		include_once APPPATH . "google_api/vendor/autoload.php";

		$google_client = new Google_Client();
		$google_client->setClientId($this->config->item('IDGoogle'));
		$google_client->setClientSecret($this->config->item('SecretGogole'));
		$google_client->setRedirectUri($this->config->item('base_url')); //Define your Redirect Uri
		$google_client->addScope('email');
		$google_client->addScope('profile');

		if(isset($_GET["code"]))
		{
			$token = $google_client->fetchAccessTokenWithAuthCode($_GET["code"]);

			if(!isset($token["error"]))
			{
				$google_client->setAccessToken($token['access_token']);
				$this->session->set_userdata('access_token', $token['access_token']);
				$google_service = new Google_Service_Oauth2($google_client);
				$data = $google_service->userinfo->get();
				$current_datetime = date('Y-m-d H:i:s');

				if($this->usuarios_model->Is_already_register($data['id']))
				{
					//update data
					$user_data = array(
					'first_name' => $data['given_name'],
					'last_name'  => $data['family_name'],
					'email_address' => $data['email'],
					'profile_picture'=> $data['picture'],
					'updated_at' => $current_datetime
					);

					$this->usuarios_model->Update_user_data($user_data, $data['id']);
				}
				else
				{
					//insert data
					$user_data = array(
					'login_oauth_uid' => $data['id'],
					'first_name'  => $data['given_name'],
					'last_name'   => $data['family_name'],
					'email_address'  => $data['email'],
					'profile_picture' => $data['picture'],
					'created_at'  => $current_datetime
					);

					$this->usuarios_model->Insert_user_data($user_data);
				}

				$this->session->set_userdata('user_data', $user_data);
			}
		}

		$login_button = '';
		if(!$this->session->userdata('access_token'))
		{
			$login_button = '<a href="'.$google_client->createAuthUrl().'"><img src="'.$this->config->item('base_url').'imagenes/icons/btn_login_google.png" width="250px" class="mt-2"/></a>';
			$data['login_button'] = $login_button;
			$this->load->view('login', $data);
		}
		else
		{
			$this->load->view('login', $data);
		}
	}

	function logout()
	{
		$this->session->unset_userdata('access_token');
		$this->session->unset_userdata('user_data');

		redirect('login');
 }
}