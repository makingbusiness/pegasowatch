<?php
class Usuariosf extends CI_Controller
{
     public function __construct()
     {
         parent::__construct();
         $this->load->model('usuarios_model');
         $this->load->model('varios_model');
         $this->load->model('pedidos_model');
         $this->load->model('blog_model');
         $this->load->model('category_model');
         $this->load->library('session');
     }

     public function my_account()
     {
          $data['nombre_pagina'] = 'usuarios';
          $data['estilo_header'] = '';

          $this->load->view('templates/headerf',$data);
          $this->load->view('my-accountf');
          $this->load->view('templates/footerf');
     }

     public function registrarse()
     {
          $data['nombre_pagina'] = 'usuarios';
          $data['estilo_header'] = '';

          $this->load->view('templates/headerf',$data);
          $this->load->view('registerf');
          $this->load->view('templates/footerf');
     }

     public function forgot()
     {
          $data['nombre_pagina'] = 'forgot';
          $data['estilo_header'] = '';

          $this->load->view('templates/headerf',$data);
          $this->load->view('forgotf');
          $this->load->view('templates/footerf');
     }

     public function creaUsuario()
     {
          $nombre = $this->input->post('nombre_usuario');
          $apellido = $this->input->post('apellido_usuario');
          $documento = $this->input->post('documento_usuario');
          $correo = $this->input->post('correo_usuario');
          $clave = $this->input->post('pwd_usuario');

          if($this->usuarios_model->registrar($nombre,$apellido,$documento,$correo,$clave))
          {
               //Set message
               $this->session->set_userdata('registrado', 'Registro exitoso');
               $this->session->set_userdata('correo_usuario',$correo);

               $this->session->set_userdata('nombre_usuario', $nombre);
               $this->session->set_userdata('apellido_usuario', $apellido);
               $this->session->set_userdata('documento_usuario', $documento);
               $this->session->set_userdata('correo_usuario', $correo);
               $this->session->set_userdata('pwd_usuario', $clave);
    
               $this->mostrar_productos();
          }
          else
          {
               $this->session->set_userdata('basura','No se pudo guardar el registro. Intente nuevamente.');
          }
     }

     private function mostrar_productos()
     {
          $data['nombre_pagina'] = 'usuarios';
          $data['estilo_header'] = '';
          
          $productos['pagina_activa'] = '1';
          $productos['inicio_pag'] = '1';
          $productos['fin_pag'] = $this->config->item('paginacion');

          $productos['total_productos'] = $this->category_model->total_productos_fabrica();

          $productos['productos'] = $this->category_model->lista_productos_fabrica($this->config->item('img_por_pagina_fab'),'1');

          $this->load->view('templates/headerf',$data);
          $this->load->view('defabrica',$productos);
          $this->load->view('templates/footerf');
     }

     public function actualizarUsuario()
     {
          $nombre = $this->input->post('acc-name');
          $apellido = $this->input->post('acc-mname');
          $documento = $this->input->post('acc-documento');
          $correo = $this->input->post('acc-email');
          $clave = $this->input->post('acc-pass');

          if($this->usuarios_model->actualizar($nombre,$apellido,$documento,$correo,$clave))
          {
              $data['nombre_pagina'] = 'usuarios';
              $data['estilo_header'] = '';

              $this->session->set_userdata('nombre_usuario', $nombre);
              $this->session->set_userdata('apellido_usuario', $apellido);
              $this->session->set_userdata('documento_usuario', $documento);
              $this->session->set_userdata('correo_usuario', $correo);
              $this->session->set_userdata('pwd_usuario', $clave);

              $this->load->view('templates/headerf',$data);
              $this->load->view('my-accountf');
              $this->load->view('templates/footerf');
           }
           else
           {
              $this->session->set_userdata('basura','No se pudo guardar el registro. Intente nuevamente.');
           }
     }

     public function login($ingresar = 0)
     {
          $correo = $this->input->post('login-email');
          $clave = $this->input->post('login-password');

          $email = $this->usuarios_model->login($correo, $clave);

          if (!$this->session->has_userdata('Pais'))
          {
               $this->session->set_userdata('Pais','57');
          }

          if (!$this->session->has_userdata('Estado'))
          {
               $this->session->set_userdata('Estado','5');
          }

          if (!$this->session->has_userdata('Ciudad'))
          {
               $this->session->set_userdata('Ciudad','5001');
          }          

          //Validate user
          if($email)
          {
               $info = $this->usuarios_model->consulta_usuario($email);

               //Set message
               $data['nombre_pagina'] = 'usuarios';
               $data['estilo_header'] = '';

               $this->session->set_userdata('correo_usuario',$correo);
               $this->session->set_userdata('nombre_usuario',$info->Nombres);
               $this->session->set_userdata('apellido_usuario',$info->Apellidos);
               $this->session->set_userdata('documento_usuario',$info->CodClie);
               $this->session->set_userdata('pwd_usuario', $info->Password);

               if ($ingresar == '1')
               {
                    $this->load->view('templates/headerf',$data);
                    $this->load->view('checkoutf');
                    $this->load->view('templates/footerf');
               }
               else
               {
                    //$this->load->view('my-accountf');
                    $this->mostrar_productos($data);
               }
          }
          else
          {
                $data['nombre_pagina'] = 'inicio';
                $data['estilo_header'] = '';
                
                //echo 'Los datos de ingreso son '.$correo.' '.$clave.' --> '.password_hash($clave,PASSWORD_DEFAULT);
                $this->session->set_flashdata('error_registro','Los datos ingresados no son correctos');
                
                $this->load->view('templates/headerf',$data);
                $this->load->view('checkoutf');
                $this->load->view('templates/footerf');
          }
    }

     public function logout()
    {
          $this->session->sess_destroy();

          redirect('defabrica');
  	}

    public function consulta_usuario_correo()
    {
    		$info = $this->usuarios_model->consulta_usuario_correo($this->input->post('reset-email'));

    		$mensaje = '';
    		if ($info)
    		{
        			$temp = $this->generar_clave_temp(10);
        			$this->usuarios_model->actualiza_clave_temp($info[0]->Email,$temp);

              if ($this->config->item('activar_correo') == 'S')
              {
            			$this->email->from('sistemas@pegasowatch.com', 'Sistemas Pegaso watches');
            			$this->email->to($this->input->post('email'));
            			$this->email->bcc('sistemas@pegasowatch.com');

            			$this->email->subject('Datos de ingreso');

            			$this->email->message('Tus datos de ingreso: usuario: '.$info[0]->Email.' clave: '.$temp);

            			$this->email->send();
              }

        			$mensaje = 'Hemos enviado tu usuario y una contrase&ntilde;a temporal a tu correo '.
        			           'Recuerda cambiar esta contrase&ntilde;a una vez ingreses al sitio.';
    		}
    		else
    		{
    			    $mensaje = 'La direcci&oacute;n ingresada no se encuentra registrada';
    		}

        echo $mensaje;
	  }

  	public function generar_clave_temp($longitud)
  	{
    		$caracteres = 'ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz0123456789_$';
    		$password = '';
    		for ($i=0; $i<$longitud; ++$i) $password .= substr($caracteres, (mt_rand() % strlen($caracteres)), 1);
    		return $password;
     }
      /* 
     function lista_estados($pais = 0)
     {
          if (!isset($pais)) $pais = 57;
          $retorno = "";
          //if (isset($pais))
          $CI = get_instance();
          $paisBuscar = $pais == 0 ? $this->input->post('pais') : $pais;
          $estados = $CI->varios_model->lista_estados($paisBuscar);
  
          foreach($estados as $estado)
          {
               $retorno.="<option value=\"".$estado->IDEstado."\">".$estado->Descrip."</option>";
          }
  
          echo $retorno;
       }

       function lista_ciudades($estado = 0)
       {
            if (!isset($estado)) $estado = 5;
            $retorno = "";
            //if (isset($pais))
            {
                      $CI = get_instance();
                      $estadoBuscar = $estado == 0 ? $this->input->post('estado') : $estado;
                      $ciudades = $CI->varios_model->lista_ciudades($estadoBuscar);
  
                      foreach($ciudades as $ciudad)
                      {
                           $retorno.="<option value=\"".$ciudad->IDCiudad."\">".$ciudad->Descrip."</option>";
                      }
            }
  
            echo $retorno;
       }       */
}
