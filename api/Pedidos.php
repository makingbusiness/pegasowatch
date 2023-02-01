<?php 
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

class Pedidos extends CI_Controller
{
	public function __construct()
	{
        parent::__construct();
        $this->load->model('pedidos_model');
    }

    public function lista()
    {
    }

    public function agregar()
    {
        $info = file_get_contents('php://input');
        $input = json_decode($info);

        $pedido = array(
            'Usuario'       => $input->Usuario,
            'Valor'         => $input->Valor,
            'Impuesto'      => $input->Impuesto,
            'Observaciones' => $input->Observaciones,
            'Pais'          => $input->Pais,
            'Departamento'  => $input->Departamento,
            'Ciudad'        => $input->Ciudad,
            'Direccion'     => $input->Direccion,
            'Telefono'      => $input->Telefono,
            'Estado'        => 0/*,
            'Tipo'          => $tipo*/
        );

        $productos = $input->Productos;

        $result = $this->pedidos_model->guardar_fabrica($pedido,$productos);

        $data['nombre_pagina'] = 'pedidos';
        $data['estilo_header'] = '';
        $data['impuesto'] = '0';
        $this->session->set_userdata('total_blog','0');
        $this->cart = null;

        $datos_pago['paisEnvio'] = $input->Pais;
		$datos_pago['estadoEnvio'] = $input->Departamento;
		$datos_pago['ciudadEnvio'] = $input->Ciudad;
		$datos_pago['direccionEnvio'] = $input->Direccion;
		$datos_pago['telefonoEnvio'] = $input->Telefono;
		$datos_pago['obsEnvio'] = $input->Observaciones;
        $datos_pago['totalPedido'] = $input->Valor;
        $datos_pago['totalImpuesto'] = $input->Impuesto;
		$datos_pago['valorEnvio'] = 0;
		$datos_pago['Nombres'] = 'Andrés';
        $datos_pago['Apellidos'] = 'Giraldo';
        $datos_pago['Email'] = $input->Usuario;
        $datos_pago['CodClie'] = '10203040';

        //$this->load->view('templates/header',$data);
   		$this->load->view('finalizaCompra',$datos_pago);
   		//$this->load->view('templates/footer');

        $response = array(
            'resultado' => 'OK',
            'mensaje'   => 'datos grabados'
        );


        header('Content-Type: application/json');
        echo json_encode($response);
    }
}