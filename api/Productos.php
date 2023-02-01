<?php 
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

class Productos extends CI_Controller
{
	public function __construct()
	{
        parent::__construct();
        $this->load->model('category_model');
    }

    public function lista()
    {
        $ruta = 'api/productos.json';

        if (file_exists($ruta))
        {
            $productos = file_get_contents($ruta);

            print_r($productos);
        }
        else
        {
            echo 'El archivo no existe';
        }
    }

    public function lista1($instancia, $id = '0', $page = 1)
    {            
        $this->session->set_userdata('idioma','1');
        $this->session->set_userdata('IDTipoUsuario','1');

        $productos = $this->category_model->lista_productos($instancia,$this->config->item('img_por_pagina'),$page,0);

        // p.CodProd,p.Impuesto,p.Marca,pi.Descrip,pi.Descrip2,pi.Descrip3,pi.DescAmpliada,pp.Precio,p.CodInst

        $encontrado = false;

        $resultado =  $id != '0' ? '' : '{ "productos" : [';

        foreach($productos as $item)
        {
            if ($id != '0' && $item->CodProd != $id) continue;

            $arreglo = array(
                "CodProd"          => $item->CodProd,
                "Descrip"          => $item->Descrip,
                "Descrip2"         => $item->Descrip2,
                "Descrip3"         => $item->Descrip3,
                "CodInst"          => $item->CodInst,
                "Marca"            => $item->Marca,
                "Precio"           => $item->Precio,
                "Impuesto"         => $item->Impuesto,
                "DescAmpliada"     => $item->DescAmpliada
            );

            $encontrado = true;

            if ($resultado == '{ "productos" : [' || $id != '0')
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
            if ($id == '0')
            {
                $resultado.=']}';
            }

            echo $resultado;
        }
    }

    public function producto($codigo)
    {            
        $this->session->set_userdata('idioma','1');
        $this->session->set_userdata('IDTipoUsuario','1');

        $item = $this->category_model->consulta_producto($codigo);

        $encontrado = false;

        $resultado =  '';

        $arreglo = array(
            "CodProd"          => $item->CodProd,
            "Descrip"          => $item->Descrip,
            "Descrip2"         => $item->Descrip2,
            "Descrip3"         => $item->Descrip3,
            "CodInst"          => $item->CodInst,
            "Marca"            => $item->Marca,
            "Precio"           => $item->Precio,
            "Impuesto"         => $item->Impuesto,
            "DescAmpliada"     => $item->DescAmpliada
        );

        $resultado .=  json_encode($arreglo);

        echo $resultado;
    }
}