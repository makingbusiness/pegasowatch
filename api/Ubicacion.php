<?php 
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

class Ubicacion extends CI_Controller
{
	public function __construct()
	{
        parent::__construct();
        $this->load->model('varios_model');
    }

    public function paises()
    {
        $paises = $this->varios_model->lista_paises();

        $resultado = '{ "paises" : [';

        foreach($paises as $item)
        {
            $arreglo = array(
                "IDPais"        => $item->IDPais,
                "Descrip"       => $item->Descrip,
            );

            if ($resultado == '{ "paises" : [')
            {
                $resultado .=  json_encode($arreglo);
            }
            else 
            {
                $resultado .= ','.json_encode($arreglo);
            }
        }

        $resultado.=']}';
        echo $resultado;
    }

    public function estados($pais)
    {
        $estados = $this->varios_model->lista_estados($pais);

        $resultado = '{ "estados" : [';

        foreach($estados as $item)
        {
            $arreglo = array(
                "IDEstado"      => $item->IDEstado,
                "Descrip"       => $item->Descrip,
            );

            if ($resultado == '{ "estados" : [')
            {
                $resultado .=  json_encode($arreglo);
            }
            else 
            {
                $resultado .= ','.json_encode($arreglo);
            }
        }

        $resultado.=']}';
        echo $resultado;
    }

    public function ciudades($estado)
    {
        $ciudades = $this->varios_model->lista_ciudades($estado);

        $resultado = '{ "ciudades" : [';

        foreach($ciudades as $item)
        {
            $arreglo = array(
                "IDCiudad"      => $item->IDCiudad,
                "Descrip"       => $item->Descrip,
            );

            if ($resultado == '{ "ciudades" : [')
            {
                $resultado .=  json_encode($arreglo);
            }
            else 
            {
                $resultado .= ','.json_encode($arreglo);
            }
        }

        $resultado.=']}';
        echo $resultado;
    }
}