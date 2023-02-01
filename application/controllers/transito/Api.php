<?php 
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

class Api extends CI_Controller
{
	public function __construct()
	{
        parent::__construct();
        $this->load->model('transito/productos_model');
        $this->load->model('transito/proveedores_model');
        $this->load->model('transito/usuarios_model');
        $this->load->model('transito/ordenes_model');
        $this->load->library('email');
    }

    public function guardar_proveedor()
    {
        $info = file_get_contents('php://input');
        $input = json_decode($info);

        $existe = $this->proveedores_model->existe_proveedor($input->ID);

        $result = '';

        if ($existe == 0)
        {
            $result = $this->proveedores_model->insertar_proveedor($input);
        }
        else 
        {
            $result = $this->proveedores_model->actualizar_proveedor($input);
        }

        $response = array(
            'resultado'   => $existe,
            'mensaje'     => 'Lo que llegó fue '.$result
        );

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function lista_proveedores()
    {
        $proveedores = $this->proveedores_model->lista_proveedores();

        $encontrado = false;

        $resultado =  '{ "providers" : [';

        foreach($proveedores as $item)
        {
            $arreglo = array(
                "ID"          => $item->ID,
                "Name"        => $item->Name,
                "Address"     => $item->Address,
                "Phone"       => $item->Phone,
                "Mobile"      => $item->Mobile,
                "Contact"     => $item->Contact,
                "Email"       => $item->Email,
                "Created"     => $item->Created
            );

            $encontrado = true;

            if ($resultado == '{ "providers" : [')
            {
                $resultado .=  json_encode($arreglo);
            }
            else 
            {
                $resultado .= ','.json_encode($arreglo);
            }
        }

        if (!$encontrado) echo "{}";               
        else 
        {
            $resultado.=']}';

            echo $resultado;
        }
    }

    public function eliminar_proveedor($codigo)
    {
        $resultado = $this->proveedores_model->eliminar_proveedor($codigo);

        $response = array(
            'resultado'   => $resultado,
            'mensaje'     => 'Listo'
        );

        header('Content-Type: application/json');
        echo json_encode($response);
    }
    /*********************************************************************************************** */   
    public function guardar_producto()
    {
        $info = file_get_contents('php://input');
        $input = json_decode($info);

        $existe = $this->productos_model->existe_producto($input->Code);

        $result = '';

        if ($existe == 0)
        {
            $result = $this->productos_model->insertar_producto($input);
        }
        else 
        {
            $result = $this->productos_model->actualizar_producto($input);
        }

        $response = array(
            'resultado'   => $existe,
            'mensaje'     => 'Lo que llegó fue '.$result
        );

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function lista_productos()
    {
        $productos = $this->productos_model->lista_productos();

        $encontrado = false;

        $resultado =  '{ "products" : [';

        foreach($productos as $item)
        {
            $arreglo = array(
                "ID"              => $item->ID,
                "Code"            => $item->Code,
                "Description"     => $item->Description,
                "Brand"           => $item->Brand,
                "Refere"          => $item->Refere,
                "GTIN"            => $item->GTIN,
                "Created"         => $item->Created
            );

            $encontrado = true;

            if ($resultado == '{ "products" : [')
            {
                $resultado .=  json_encode($arreglo);
            }
            else 
            {
                $resultado .= ','.json_encode($arreglo);
            }
        }

        if (!$encontrado) echo "{}";               
        else 
        {
            $resultado.=']}';

            echo $resultado;
        }
    }

    public function eliminar_producto($codigo)
    {
        $resultado = $this->productos_model->eliminar_producto($codigo);

        $response = array(
            'resultado'   => $resultado,
            'mensaje'     => 'Listo'
        );

        header('Content-Type: application/json');
        echo json_encode($response);
    }    
}