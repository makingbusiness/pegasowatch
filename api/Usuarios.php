<?php 
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

class Usuarios extends CI_Controller
{
	public function __construct()
	{
        parent::__construct();
        $this->load->model('usuarios_model');
    }

    public function consulta($email)
    {
        $item = $this->usuarios_model->consulta_usuario(urldecode($email));

        $resultado =  '';

        $arreglo = array(
            "Apellidos"          => $item->Apellidos,
            "Nombres"            => $item->Nombres,
            "Documento"          => $item->CodClie,
            "Pais"               => $item->Pais,
            "Estado"             => $item->Estado,
            "Ciudad"             => $item->Ciudad,
            "Direccion"          => $item->Direccion,
            "Telefono"           => $item->Telefono,
            "Email"              => $item->Email,
            "Password"           => $item->Password
        );

        $resultado .=  json_encode($arreglo);

        echo $resultado;
    }

    public function agregar()
    {
        $info = file_get_contents('php://input');
        $input = json_decode($info);

        /*$x = $input->Nombres.' '.$input->Apellidos.' '.$input->Direccion.' '.$input->Documento.' '.$input->Telefono.' '.$input->Email.' '.$input->Pais.' '.$input->Estado.' '.$input->Ciudad.' '.$input->Clave;

        $data = array(
            "Valor1"    => 'Datos desde app Angular',
            'Valor2'    => $x,
            'Valor3'    => $input->Nombres
        );

        $this->db->insert('basura',$data);
*/

        $usuario = array(     
            'Nombres'         => $input->Nombres,
            'Apellidos'       => $input->Apellidos,
            'Direccion'       => $input->Direccion,
            'CodClie'         => $input->Documento,
            'Telefono'        => $input->Telefono,
            'Email'           => $input->Email,
            'Pais'            => $input->Pais,
            'Estado'          => $input->Estado,
            'Ciudad'          => $input->Ciudad,
            'Password'        => password_hash($input->Clave,PASSWORD_DEFAULT),
            'IDTipoUsuario'   => '3'
        );

        $resp = $this->usuarios_model->registrarFabrica($usuario);

        $response = array(
            'resultado' => 'OK',
            'mensaje'   => 'datos grabados'
        );


        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function login($valor,$clave)
    {
        $dato = urldecode($valor);
        $resp = $this->usuarios_model->login($dato,$clave);

        $response = array(
            'resultado' => $resp == $dato ? 'OK' : 'Error',
            'mensaje'   => $resp
        );


        header('Content-Type: application/json');
        echo json_encode($response);
    }
}