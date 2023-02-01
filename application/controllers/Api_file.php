<?php 
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

class Api extends CI_Controller{
	public function __construct()
	{
		parent::__construct();
    }

    public function instancias($id = '0')
    {
        $ruta = 'api/instancias.json';

        if (file_exists($ruta))
        {
            $datos = file_get_contents($ruta);

            if ($id == '0')
            {
                print_r($datos);
            }
            else
            {
                $instancias = json_decode($datos,true);
                $encontrado = false;

                foreach($instancias as $instancia)
                {
                    foreach($instancia as $item)
                    {
                        if ($item["CodInst"] == $id)
                        {
                            $arreglo = array(
                                "CodInst"     => $item["CodInst"],
                                "Descrip"     => $item["Descrip"],
                                'InsPadre'    => $item["InsPadre"],
                                'EsPulso'     => $item["EsPulso"]
                            );

                            $encontrado = true;
                            echo json_encode($arreglo);
                        }
                    }
                }

                if (!$encontrado) echo "{}";
            }
        }
        else
        {
            echo "Archivo no encontrado";
        }
    }

    public function instanciasPadre($id)
    {
        $ruta = 'api/instancias.json';

        if (file_exists($ruta))
        {
            $datos = file_get_contents($ruta);

            $instancias = json_decode($datos,true);
            $encontrado = false;

            $resultado =  '{ "instancias" : [';

            foreach($instancias as $instancia)
            {
                foreach($instancia as $item)
                {
                    if ($item["InsPadre"] == $id)
                    {
                        $arreglo = array(
                            "CodInst"     => $item["CodInst"],
                            "Descrip"     => $item["Descrip"],
                            'InsPadre'    => $item['InsPadre'],
                            'EsPulso'     => $item["EsPulso"]
                        );

                        $encontrado = true;
                        if ($resultado == '{ "instancias" : [')
                        {
                            $resultado .=  json_encode($arreglo);
                        }
                        else 
                        {
                            $resultado .= ','.json_encode($arreglo);
                        }
                    }
                }
            }

            if (!$encontrado) echo "{}";
            else
            {
                $resultado.=']}';

                echo $resultado;
            }
        }
        else
        {
            echo "Archivo no encontrado";
        }
    }

    public function productos($pagina, $id = '0', $page = 0)
    {               
        $ruta = "api/".$pagina.".json";

        $cantProd = $this->config->item('productosAPI');

        if (file_exists($ruta))
        {
            $datos = file_get_contents($ruta);

            if ($id == '0' && $page == 0)
            {
                print_r($datos);
            }
            else
            {
                $productos = json_decode($datos,true);

                $encontrado = false;
                $pos = 1;

                $resultado =  $id != '0' ? '' : '{ "productos" : [';

                foreach($productos as $producto)
                {
                    foreach($producto as $item)
                    {
                        if ($page != 0 && ($pos < ($page - 1) * $cantProd || $pos > $page * $cantProd))
                        {
                            $pos++;
                            continue;
                        }

                        if ($id != '0' && $item["CodProd"] != $id) continue;

                        $arreglo = array(
                                "CodProd"          => $item["CodProd"],
                                "Descrip"          => $item["Descrip"],
                                "CodInst"          => $item["CodInst"],
                                "Precio"           => $item["Precio"],
                                "PrecioInternet"   => $item["PrecioInternet"],
                                "Impuesto"         => $item["Impuesto"],
                                "DescAmpliada"     => $item["DescAmpliada"]
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

                        $pos++;
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
        }
        else
        {
            echo "No existe el archivo ".$ruta;
        }
    }

    public function productosInstancia($pagina, $id , $page = 0)
    {               
        $ruta = "api/".$pagina.".json";

        $cantProd = $this->config->item('productosAPI');

        if (file_exists($ruta))
        {
            $datos = file_get_contents($ruta);

            $productos = json_decode($datos,true);

            $encontrado = false;
            $pos = 1;

            $resultado =  '{ "productos" : [';

            foreach($productos as $producto)
            {
                foreach($producto as $item)
                {
                    if ($item["CodInst"] == $id)
                    {
                        if ($page != 0 && ($pos < ($page - 1) * $cantProd || $pos > $page * $cantProd))
                        {
                            $pos++;
                            continue;
                        }

                        $arreglo = array(
                                "CodProd"          => $item["CodProd"],
                                "Descrip"          => $item["Descrip"],
                                "CodInst"          => $item["CodInst"],
                                "Precio"           => $item["Precio"],
                                "PrecioInternet"   => $item["PrecioInternet"],
                                "Impuesto"         => $item["Impuesto"],
                                "DescAmpliada"     => $item["DescAmpliada"]
                        );

                        $encontrado = true;

                        if ($resultado == '{ "productos" : [')
                        {
                            $resultado .=  json_encode($arreglo);
                        }
                        else 
                        {
                            $resultado .= ','.json_encode($arreglo);
                        }

                        $pos++;
                    }
                }
            }

            if (!$encontrado) echo "{}";               
            else 
            {
                $resultado.=']}';

                echo $resultado;
            }
        }
        else
        {
            echo "No existe el archivo ".$ruta;
        }
    }

    /********************** PUlsos ******************************************/
    public function pulsos($pagina, $id = '0', $page = 0)
    {               
        $ruta = "api/".$pagina.".json";

        $cantProd = $this->config->item('productosAPI');

        if (file_exists($ruta))
        {
            $datos = file_get_contents($ruta);

            if ($id == '0' && $page == 0)
            {
                print_r($datos);
            }
            else
            {
                $productos = json_decode($datos,true);

                $encontrado = false;
                $pos = 1;

                $resultado =  ($id != '0' && strlen(strpos($pagina,'ref')) != 0 ) ? '' : '{ "pulsos" : [';

                foreach($productos as $producto)
                {
                    foreach($producto as $item)
                    {
                        if ($page != 0 && ($pos < ($page - 1) * $cantProd || $pos > $page * $cantProd))
                        {
                            $pos++;
                            continue;
                        }

                        //echo $id.' ? ['.strlen(strpos($pagina,'ref')).']  ';
                        if ($id != '0' && strlen(strpos($item["CodProd"], $id)) == 0) continue;

                        if (strlen(strpos($pagina,'ref_')) != 0)
                        {
                            $arreglo = array(
                                "CodProd"          => $item["CodProd"],
                                "CodInst"          => $item["CodInst"],
                                "Descrip"          => $item["Descrip"],
                                "ListaCalibres"    => $item["ListaCalibres"],
                                "ListaColores"     => $item["ListaColores"]
                            );
                        }
                        else
                        {
                            $arreglo = array(
                                "CodProd"          => $item["CodProd"],
                                "CodInst"          => $item["CodInst"],
                                "Descrip"          => $item["Descrip"],
                                "Preciot"          => $item["Precio"],
                                "PrecioInternet"   => $item["PrecioInternet"],
                                "Impuesto"         => $item["Impuesto"],
                                "DescAmpliada"     => $item["DescAmpliada"],
                            );
                        }

                        $encontrado = true;

                        if ($resultado == '{ "pulsos" : [' || ($id != '0' && strlen(strpos($pagina,'ref')) != 0))
                        {
                            $resultado .=  json_encode($arreglo);
                        }
                        else 
                        {
                            $resultado .= ','.json_encode($arreglo);
                        }

                        $pos++;
                    }
                }

                if (!$encontrado) echo "{}";               
                else 
                {
                    if ($id == '0' || strlen(strpos($pagina,'ref')) == 0)
                    {
                        $resultado.=']}';
                    }

                    echo $resultado;
                }

            }
        }
        else
        {
            echo "No existe el archivo ".$ruta;
        }
    }

    public function pulsosInstancia($pagina, $id , $page = 0)
    {               
        $ruta = "api/".$pagina.".json";

        $cantProd = $this->config->item('productosAPI');

        if (file_exists($ruta))
        {
            $datos = file_get_contents($ruta);

            $productos = json_decode($datos,true);

            $encontrado = false;
            $pos = 1;

            $resultado =  '{ "pulsos" : [';

            foreach($productos as $producto)
            {
                foreach($producto as $item)
                {
                    if ($item["CodInst"] == $id)
                    {
                        if ($page != 0 && ($pos < ($page - 1) * $cantProd || $pos > $page * $cantProd))
                        {
                            $pos++;
                            continue;
                        }

                        $arreglo = array(
                            "CodProd"          => $item["CodProd"],
                            "CodInst"          => $item["CodInst"],
                            "Descrip"          => $item["Descrip"],
                            "ListaCalibres"    => $item["ListaCalibres"],
                            "ListaColores"     => $item["ListaColores"]
                        );

                        $encontrado = true;

                        if ($resultado == '{ "pulsos" : [')
                        {
                            $resultado .=  json_encode($arreglo);
                        }
                        else 
                        {
                            $resultado .= ','.json_encode($arreglo);
                        }

                        $pos++;
                    }
                }
            }

            if (!$encontrado) echo "{}";               
            else 
            {
                $resultado.=']}';

                echo $resultado;
            }
        }
        else
        {
            echo "No existe el archivo ".$ruta;
        }
    }
};