<?php 
class Usuarios extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
		$this->load->model('usuarios_model');
		$this->load->model('pedidos_model');
		$this->load->model('productos_model');		
		$this->load->model('clientes_model');
		$this->load->model('varios_model');
		$this->load->library('form_validation');
		$this->load->library('session');
		$this->load->library('email');

		leer_ubicacion();
	}
	
	public function index()
	{
	}

	public function registrar(){
		//Validation Rules
		$this->form_validation->set_rules('idNumber','Documento','numeric');
		$this->form_validation->set_rules('name','Nombres','min_length[3]');
        $this->form_validation->set_rules('lastname','Apellidos','min_length[3]');
		//$this->form_validation->set_rules('telefono','Tel&eacute;fono','numeric');
        $this->form_validation->set_rules('email','Email','valid_email');
        //$this->form_validation->set_rules('cumple','Fecha de cumplea&ntilde;os','min_length[10]|max_length[10]');		
        //$this->form_validation->set_rules('usuario','Usuario','trim|required|min_length[4]|max_length[16]');
        $this->form_validation->set_rules('password','Clave','trim|required|min_length[4]|max_length[50]');
        //$this->form_validation->set_rules('clave2','Confirmaci&oacute;n clave','trim|required|matches[clave]');

		$data['name'] = $this->input->post('name');
		$data['lastname'] = $this->input->post('lastname');
		$data['idNumber'] = $this->input->post('idNumber');
		$data['email'] = $this->input->post('email');		
		
		if ($this->form_validation->run() == FALSE){
			$this->session->set_flashdata('error_registro', 'Los datos ingresados no son v&aacute;lidos');
		}
		else{
			if ($this->input->post('password') != $this->input->post('passConfirm'))
			{
				$mensaje_error = 'Las contrase&ntilde;as no coinciden';

			}
			else
			{
				$mensaje_error = '';
				if ($this->usuarios_model->consulta_usuario_correo($this->input->post('email'))){
					$mensaje_error = 'El correo ya est&aacute; registrado';
				}
				else
				{				 
					if($this->usuarios_model->registrar()){  
                  
						//Set message
						$this->session->set_userdata('registrado', 'Registro exitoso');
					
						$data1['opcion'] = 'Bienvenida';
						$this->consulta_usuario($this->input->post('idNumber'));

						/*$this->load->view('templates/header');
						$this->load->view('editar_perfil');
						$this->load->view('templates/footer');*/
					}
					else
					{
						$mensaje_error = 'No se pudo guardar el registro. Intente nuevamente.';
					}
				}
			}
			
			if ($mensaje_error != ''){
				$this->session->set_flashdata('error_registro',$mensaje_error);
				$this->load->view('login',$data);
			}
		}	
	}
	
	public function actualizar(){
		//Validation Rules
		$this->form_validation->set_rules('cc','Documento','numeric');
		$this->form_validation->set_rules('nombre','Nombres','min_length[3]');
        $this->form_validation->set_rules('apellido','Apellidos','min_length[3]');
		$this->form_validation->set_rules('celular','Telefono','numeric');
        $this->form_validation->set_rules('correo','Email','valid_email');
        $this->form_validation->set_rules('direccion','Direccion','min_length[10]|max_length[100]');
        //$this->form_validation->set_rules('usuario','Usuario','trim|required|min_length[4]|max_length[16]');
        //$this->form_validation->set_rules('clave','Clave','trim|required|min_length[4]|max_length[50]');
        //$this->form_validation->set_rules('clave2','Confirmaci&oacute;n clave','trim|required|matches[clave]');
	
		if ($this->form_validation->run() == FALSE){
			//Show View
			$this->session->set_flashdata('Error','Algo paso que no se pudo grabar');
			$this->consulta_usuario($this->input->post('cc'));
		}
		else{
			if($this->usuarios_model->actualizar())
			{       
				$this->session->set_flashdata('actualizado', 'Usuario actualizado correctamente');
				$this->consulta_usuario($this->input->post('cc'));
            }
		}	
	}	
	
	public function login()
	{
		//$this->form_validation->set_rules('email','Email','trim|required|min_length[4]|max_length[80]');
        //$this->form_validation->set_rules('password','Password','trim|required|min_length[4]|max_length[20]');
		
		$email = $this->input->post('email');
		$clave = $this->input->post('password');
		
		$CodClie = $this->usuarios_model->login($email, $clave);
		
		//Validate user
		if($CodClie){
			$resultado = $this->usuarios_model->consulta_usuario($CodClie);
				   
			//Set message
			$this->session->set_userdata('registrado', 'Registro exitoso');

			//Create array of user data
			$data = array(
				'CodClie'          => $resultado[0]->CodClie,
				'Apellidos'        => $resultado[0]->Apellidos,
				'Nombres'          => $resultado[0]->Nombres,
				'direccionEnvio'   => $resultado[0]->Direccion,
				'telefonoEnvio'    => $resultado[0]->Telefono,
				'Email'            => $resultado[0]->Email,
				'correoEnvio'      => $resultado[0]->Email,
				'IDTipoUsuario'    => $resultado[0]->IDTipoUsuario,
				'paisEnvio'        => $resultado[0]->Pais,
				'estadoEnvio'      => $resultado[0]->Estado,
				'ciudadEnvio'      => $resultado[0]->Ciudad
			);
			//Set session userdata
			$this->session->set_userdata($data);

			$data['usuarios'] = $resultado;			

			$this->load->view('templates/header');

			if ($this->cart->contents())
			{
				$this->load->view('cart',$data);
			}
			else
			{
				$this->load->view('editar_perfil',$data);
			}
			$this->load->view('templates/footer');
        } 
		else 
		{
            //Set error
            $this->session->set_flashdata('error_ingreso', 'Los datos ingresados no son v&aacute;lidos');
			redirect('login');
			//echo 'El usuario o la contrase&ntilde;a no son v&aacute;lidos';
        }
	}
	
	public function logout(){
		//Unset user data
        /*$this->session->unset_userdata('logged_in');
        $this->session->unset_userdata('user_id');
        $this->session->unset_userdata('username');*/
        $this->session->sess_destroy();

        redirect('inicio');
	}
	
	public function editar_perfil()
	{
		$resultado = $this->usuarios_model->consulta_usuario($this->session->CodClie);
		
		if ($resultado)
		{
			$data['usuarios'] = $resultado;
		
			$this->load->view('templates/header');
			$this->load->view('editar_perfil',$data);
			$this->load->view('templates/footer');
		}
		else
		{
			//$this->load->view('templates/header');
			$this->load->view('login');//,$data);
			//$this->load->view('templates/footer');			
		}		
	}
	
	public function consulta_usuario($CodClie){
	
		$resultado = $this->usuarios_model->consulta_usuario($CodClie);
		
		if ($resultado)
		{
			//Create array of user data
			$data = array(
				'CodClie'          => $resultado[0]->CodClie,
				'Apellidos'        => $resultado[0]->Apellidos,
				'Nombres'          => $resultado[0]->Nombres,
				'direccionEnvio'   => $resultado[0]->Direccion,
				'telefonoEnvio'    => $resultado[0]->Telefono,
				'Email'            => $resultado[0]->Email,
				'IDTipoUsuario'    => $resultado[0]->IDTipoUsuario,
				'paisEnvio'        => $resultado[0]->Pais,
				'estadoEnvio'      => $resultado[0]->Estado,
				'ciudadEnvio'      => $resultado[0]->Ciudad
			);
			//Set session userdata
			$this->session->set_userdata($data);
			
			$data['usuarios'] = $resultado;
		
			$this->load->view('templates/header');
			$this->load->view('editar_perfil',$data);
			$this->load->view('templates/footer');
		}
		else
		{
			$this->load->view('templates/header');
			$this->load->view('consulta',$data);
			$this->load->view('templates/footer');
		}
	}
	
	public function history()
	{
		$this->load->view('templates/header');
		$this->load->view('history');
		$this->load->view('templates/footer');
	}
	
	public function suscripcion()
	{
		$nombre = $this->input->post('nombre_suscrip');
		$email = $this->input->post('email_suscrip');
		
		$resultado = $this->usuarios_model->inserta_suscripcion($nombre,$email,'','MB');
		
		$this->varios_model->enviarCorreo($this->config->item('correo_contacto'),'Suscripción a boletín',$nombre.' '.$email);
	}
	
	public function consulta_usuario_correo(){
		$info = $this->usuarios_model->consulta_usuario_correo($this->input->post('email'));
	
		$mensaje = '';
		if ($info)
		{
			$temp = $this->generar_clave_temp(10);
			$this->usuarios_model->actualiza_clave_temp($info[0]->Email,$temp);
			
			$this->email->from('sistemas@makingbusiness.com.co', 'Sistemas Making Business');
			$this->email->to($this->input->post('email'));
			$this->email->bcc('sistemas@makingbusiness.com.co');

			$this->email->subject('Datos de ingreso');
			
			$this->email->message('Tus datos de ingreso: usuario: '.$info[0]->Email.' clave: '.$temp);
	
			$this->email->send();
			
			$data['datos_cuenta'] = 'Hemos enviado tu usuario y una contrase&ntilde;a temporal a tu correo '.
			                        'Recuerda cambiar esta contrase&ntilde;a una vez ingreses al sitio.';
		}
		else
		{
			$data['datos_cuenta'] = 'La direcci&oacute;n ingresada no se encuentra registrada';
		}
	}
	
	public function generar_clave_temp($longitud)
	{
		$caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789_$';
		$password = '';
		for ($i=0; $i<$longitud; ++$i) $password .= substr($caracteres, (mt_rand() % strlen($caracteres)), 1);
		return $password;
	}
	
	public function lista_estados()
	{
		$estados = $this->varios_model->lista_estados($this->input->post('pais'));

		$retorno = "";
		foreach($estados as $estado)
		{
			$retorno.="<option value=\"".$estado->IDEstado."\">".$estado->Descrip."</option>";
		}
		
		echo $retorno;
	}
	
	public function lista_ciudades()
	{
		$ciudades = $this->varios_model->lista_ciudades($this->input->post('estado'));

		$retorno = "";
		foreach($ciudades as $ciudad)
		{
			$retorno.="<option value=\"".$ciudad->IDCiudad."\">".$ciudad->Descrip."</option>";
		}
		
		echo $retorno;
	}
	
	public function modificarClave()
	{
		$this->load->view("templates/header");
		$this->load->view("modificarClave");
		$this->load->view("templates/footer");
	}
	
	public function actualizaClave()
	{
		$claveAnt = $this->input->post('claveAnt');
		$claveNueva = $this->input->post('claveNueva');
		
		$clave = $this->usuarios_model->consulta_clave_usuario();

		if (!password_verify($claveAnt, $clave[0]->Password))
		{
			echo 'N';
		}
		else
		{
			$this->usuarios_model->actualiza_clave($claveNueva);
			echo 'S';
		}
	}
}