<?php 
class Usuarios_model extends CI_Model{
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
	}
	
	public function registrar(){
		 $data = array(
            'CodClie'         => $this->input->post('idNumber'),
			'Nombres'         => $this->input->post('name'),
            'Apellidos'       => $this->input->post('lastname'),
            //'Direccion'       => $this->input->post('direccion'),
            //'Telefono'        => $this->input->post('telefono'),
            'email'           => $this->input->post('email'),
            'Password'        => password_hash($this->input->post('password'),PASSWORD_DEFAULT)
        );
		
		$this->session->set_userdata('CodClie', $this->input->post('codclie'));
		$this->session->set_userdata('Email', $this->input->post('email'));
		
		$insert = $this->db->insert('usuarios', $data);
		return $insert;
	}
	
	public function actualizar(){
		 $data = array(
			'Nombres'         => $this->input->post('nombre'),
            'Apellidos'       => $this->input->post('apellido'),
            'Direccion'       => $this->input->post('direccion'),
            'Telefono'        => $this->input->post('celular'),
            'Email'           => $this->input->post('correo'),
		    'CodClie'         => $this->input->post('cc'),
			'Pais'            => $this->input->post('pais'),
			'Estado'          => $this->input->post('estado'),
			'Ciudad'          => $this->input->post('ciudad')
        );
		
		$this->db->where('CodClie',$this->input->post('cc'));
		
		$act = $this->db->update('usuarios', $data);
		return $act;
	}	
	
	public function login($email,$clave){  
        //Validate
		$this->db->select('*');
		$this->db->from('usuarios');
        $this->db->where('Email',$email);
        /*$this->db->where('ClaveUsuario',$clave);
        
        $result = $this->db->get('pacientes');
        if($result->num_rows() == 1){
            return $result->row(0)->CodClie;
        } else {
            return false;
        }*/
			
		$result = $this->db->get();

		$row = $result->row();

		if (password_verify($clave, $row->Password))
		{
			return $row->CodClie;
		}
		else
		{
			return false;
		}
    }
	
	public function consulta_usuario($cliente){
		$this->db->select('u.CodClie,u.Apellidos,u.Nombres,u.Direccion,u.Telefono,u.Email,u.Password,u.IDTipoUsuario,u.Pais,u.Estado,u.Ciudad');
		$this->db->from('usuarios u');
		
		$this->db->where('u.CodClie',$cliente);
		
		$query = $this->db->get();
		
		return $query->result();
	}
	
	public function inserta_suscripcion($nombre,$email,$telefono,$bd,$mensaje = '')
	{
		$data = array(
			'Nombre'   => $nombre,
			'Email'    => $email,
			'Telefono' => $telefono,
			'Mensaje'  => $mensaje,
			'BD'       => $bd
		);
		
		$insert = $this->db->insert('suscripciones', $data);
	}
	
	public function consulta_usuario_correo($email){
		$this->db->select('u.Email');
		$this->db->from('usuarios u');
		$this->db->where('u.Email',$email);
		
		$query = $this->db->get();
		
		return $query->result();
	}
	
	public function consulta_clave_usuario()
	{
		$this->db->select('u.Password');
		$this->db->from('usuarios u');
		$this->db->where('u.Email',$this->session->Email);
		
		$query = $this->db->get();
		
		return $query->result();
	}
	
	public function actualiza_clave_temp($email,$clave)
	{
		$data = array(
			'Password'   => password_hash($clave,PASSWORD_DEFAULT)
		);
		
		$this->db->where('Email',$email);
		$this->db->update('usuarios',$data);		
	}
	
	public function actualiza_clave($clave)
	{
		$data = array(
			'Password'   => password_hash($clave,PASSWORD_DEFAULT)
		);
		
		$this->db->where('Email',$this->session->Email);
		$this->db->update('usuarios',$data);
	}

	public function registrarApp($usuario)
	{		
		if ($this->consulta_usuario_objeto($usuario))
		{
			return 0;
		}

		$data = array(
			   'CodClie'         => $usuario->CodClie,
			   'Nombres'         => $usuario->Nombres,
			   'Apellidos'       => $usuario->Apellidos,
			   'Telefono'        => $usuario->Telefono,
			   'Email'           => $usuario->Email,
			   'Password'        => password_hash($usuario->Clave,PASSWORD_DEFAULT),
			   'IDTipoUsuario'   => 3
		   );
			  
	   $insert = $this->db->insert('usuarios', $data);
	   return $insert;
   }
   
   public function actualizarApp($usuario){
		$data = array(
			'Nombres'         => $usuario->Nombres,
			'Apellidos'       => $usuario->Apellidos,
			'Direccion'       => $usuario->Direccion,
			'Telefono'        => $usuario->Telefono,
			'Email'           => $usuario->Email,
			'Pais'            => $usuario->Pais,
			'Estado'          => $usuario->Estado,
			'Ciudad'          => $usuario->Ciudad,
			'IDTipoUsuario'   => 3
		);
		
		$this->db->where('CodClie',$usuario->CodClie);
		
		$act = $this->db->update('usuarios', $data);
		return $act;
	}	

	public function actualiza_clave_app($usuario)
	{
		$data = array(
			'Password'   => password_hash($usuario->Clave,PASSWORD_DEFAULT)
		);
		
		$this->db->where('CodClie',$usuario->CodClie);
		$this->db->where('IDTipoUsuario','3');
		$this->db->update('usuarios',$data);
	}

	public function consulta_usuario_valor($valor){
		$this->db->select('u.CodClie,u.Apellidos,u.Nombres,u.Direccion,u.Telefono,u.Email,u.Password,u.IDTipoUsuario,u.Pais,u.Estado,u.Ciudad,t.Precio');
		$this->db->from('usuarios as u');
		$this->db->join('tipos_usuario as t','u.IDTipoUsuario=t.IDTipoUsuario','INNER');
		$this->db->where('u.IDTipoUsuario','3');
		$this->db->group_start();
		$this->db->or_where('u.CodClie',$valor);
		$this->db->or_where('u.Telefono',$valor);
		$this->db->or_where('u.Email',$valor);
		$this->db->group_end();
		
		$query = $this->db->get();
		
		return $query->row();
	}	

	public function consulta_usuario_objeto($usuario){
		$this->db->select('u.CodClie,u.Apellidos,u.Nombres,u.Direccion,u.Telefono,u.Email,u.Password,u.IDTipoUsuario,u.Pais,u.Estado,u.Ciudad');
		$this->db->from('usuarios u');	
		$this->db->where('u.IDTipoUsuario','3');
		$this->db->group_start();
		$this->db->or_where('u.CodClie',$usuario->CodClie);
		$this->db->or_where('u.Telefono',$usuario->Telefono);
		$this->db->or_where('u.Email',$usuario->Email);
		$this->db->group_end();
		
		$query = $this->db->get();
		
		return $query->result();
	}		

	public function login_app($valor,$clave){  
        //Validate
		$this->db->select('*');
		$this->db->from('usuarios');
        $this->db->where('Email',$valor);
		$this->db->or_where('CodClie',$valor);
		$this->db->or_where('Telefono',$valor);
			
		$result = $this->db->get();

		$row = $result->row();

		if ($row)
		{
			if (password_verify($clave, $row->Password))
			{
				return $this->consulta_usuario_valor($valor);
			}
			else
			{
				return false;
			}
		}
		else
		{
			return false;
		}
    }

	// Autenticación Google
	function Is_already_register($id)
	{
		$this->db->where('login_oauth_uid', $id);
		$query = $this->db->get('chat_user');
		if($query->num_rows() > 0)
		{
		return true;
		}
		else
		{
		return false;
		}
	}

	function Update_user_data($data, $id)
	{
		$this->db->where('login_oauth_uid', $id);
		$this->db->update('chat_user', $data);
	}

	function Insert_user_data($data)
	{
		$this->db->insert('chat_user', $data);
	}
}