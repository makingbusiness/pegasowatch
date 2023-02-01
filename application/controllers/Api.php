<?php 
header('Access-Control-Allow-Origin: *');
header("Access-Control-Allow-Headers: Origin, X-Requested-With, Content-Type, Accept");
header('Access-Control-Allow-Methods: GET, POST, PUT, DELETE');

class Api extends CI_Controller
{
	public function __construct()
	{
        parent::__construct();
        $this->load->model('productos_model');
        $this->load->model('varios_model');
        $this->load->model('usuarios_model');
        $this->load->model('clientes_model');
        $this->load->model('pedidos_model');
        $this->load->library('email');
    }

    public function instancia($idioma, $id)
    {       
        $item = $this->productos_model->consulta_categoria($idioma,$id);

        $resultado =  '';

        $arreglo = array(
            "CodInst"        => $item->CodInst,
            "Descrip"        => $item->Descrip,
            'InsPadre'       => $item->InsPadre,
            'EsPulso'        => $item->EsPulso,
            'InstanciaBase'  => $item->InstanciaBase,
            'EsBateria'      => $item->EsBateria
        );

        $resultado .=  json_encode($arreglo);

        echo $resultado;
    }

    public function instancias($idioma,$padre)
    {
        $instancias = $this->productos_model->lista_categorias($idioma,$padre);
        $encontrado = false;

        $resultado =  '{ "instancias" : [';

        foreach($instancias as $item)
        {
            if ($item->InsPadre == $padre)
            {
                $arreglo = array(
                    "CodInst"        => $item->CodInst,
                    "Descrip"        => $item->Descrip,
                    'InsPadre'       => $item->InsPadre,
                    'EsPulso'        => $item->EsPulso,
                    'InstanciaBase'  => $item->InstanciaBase,
                    'EsBateria'      => $item->EsBateria
                );

                $encontrado = true;
                if ($resultado != '{ "instancias" : [')
                {
                    $resultado .=  ',';
                }

                $resultado .= json_encode($arreglo);
            }
        }

        if (!$encontrado) echo "{}";
        else
        {
            $resultado.=']}';

            echo $resultado;
        }
    }

    public function productos($instancia, $id = '0', $page = 1, $precio = '-1')
    {
        $this->listaProductos(0, $instancia, $id, $page, $precio);
    }

    public function productosInstancia($instancia, $page = 1, $precio = '-1')
    {
        $this->listaProductos(1, $instancia, '0', $page, $precio);
    }

    public function listaProductos($tipo, $instancia, $id = '0', $page = 1, $precio = '-1')
    {
        $this->session->set_userdata('idioma','1');
        //$this->session->set_userdata('IDTipoUsuario','1');

        if ($instancia != '0')
        {
            $productos = $this->productos_model->lista_productos_api($instancia,$id,$this->config->item('img_por_pagina_app'),$page);
        }
        else
        {
            $productos = $this->productos_model->buscar_productos_api($id,$this->config->item('img_por_pagina_app'),$page);
        }

        // p.CodProd,p.Impuesto,p.Marca,pi.Descrip,pi.Descrip2,pi.Descrip3,pi.DescAmpliada,pp.Precio,p.CodInst

        $encontrado = false;

        $resultado =  '{ "productos" : [';

        foreach($productos as $item)
        {
            //if ($tipo == 0 && $item->CodProd != $id) continue;

            $producto = $this->productos_model->consulta_producto($item->CodProd,$precio);

            if ($producto)
            {
                $arreglo = array(
                    "CodProd"          => $item->CodProd,
                    "Descrip"          => $producto->Descrip,
                    "CodInst"          => $producto->CodInst,
                    "Marca"            => $producto->Marca,
                    "Precio"           => $producto->Precio,
                    "Impuesto"         => $producto->Impuesto,
                    "ListaProductos"   => $producto->ListaProductos,
                    'UnidadNum'        => $producto->UnidadNum,
                    'UnidadWeb'        => $producto->UnidadWeb,
                    'Unidad'           => $producto->Unidad,
                    'Empaque'          => $producto->Empaque,
                    'EmpaqueWeb'       => $producto->EmpaqueWeb,
                    "Precio1"          => $producto->Precio1,
                    "Precio2"          => $producto->Precio2,
                    "Precio3"          => $producto->Precio3,
                    "Precio4"          => $producto->Precio4,
                    "PrecioInternet"   => $producto->PrecioInternet,
                    "Existen"          => $producto->Existen
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
            }
        }

        if (!$encontrado) echo "{}";               
        else 
        {
            //if ($tipo != 0)
            {
                $resultado.=']}';
            }

            echo $resultado;
        }
    }

    public function producto($id,$precio = '-1')
    {
        $this->session->set_userdata('idioma','1');
        //$this->session->set_userdata('IDTipoUsuario','1');

        $item = $this->productos_model->consulta_producto($id,$precio);

        $arreglo = array(
            "CodProd"          => $item->CodProd,
            "Descrip"          => $item->Descrip,
            "CodInst"          => $item->CodInst,
            "Marca"            => $item->Marca,
            "Precio"           => $item->Precio,
            "Impuesto"         => $item->Impuesto,
            "ListaProductos"   => $item->ListaProductos,
            "DescAmpliada"     => htmlspecialchars_decode($item->DescAmpliada),
            "ImgPrincipal"     => $item->ImgPrincipal,
            "ImgAdicionales"   => $item->ImgAdicionales,
            "UnidadNum"        => $item->UnidadNum,
            "UnidadWeb"        => $item->UnidadWeb,
            "Unidad"           => $item->Unidad,
            'Empaque'          => $item->Empaque,
            'EmpaqueWeb'       => $item->EmpaqueWeb,
            "Precio1"          => $item->Precio1,
            "Precio2"          => $item->Precio2,
            "Precio3"          => $item->Precio3,
            "Precio4"          => $item->Precio4,
            "PrecioInternet"   => $item->PrecioInternet,
            "Existen"          => $item->Existen
        );

        $resultado =  json_encode($arreglo);

        echo $resultado;
    }    

    /********************** Pulsos ******************************************/
    public function pulso($idioma, $parte)
    {               
        //$this->session->set_userdata('IDTipoUsuario','1');
        
        $productos = $this->productos_model->consulta_producto_like($idioma,$parte);

        $encontrado = false;
        $pos = 1;

        $resultado =  '{ "pulsos" : [';

        foreach($productos as $item)
        {
            $arreglo = array(
                "CodProd"          => $item->CodProd,
                "CodInst"          => $item->CodInst,
                "Descrip"          => $item->Descrip,
                "Precio"           => $item->Precio,
                "Impuesto"         => $item->Impuesto,
                "DescAmpliada"     => $item->DescAmpliada,
                "Precio1"          => $item->Precio1,
                "Precio2"          => $item->Precio2,
                "Precio3"          => $item->Precio3,
                "Precio4"          => $item->Precio4,
                "PrecioInternet"   => $item->PrecioInternet
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

        if (!$encontrado) echo "{}";               
        else 
        {
            $resultado.=']}';

            echo $resultado;
        }
    }

    public function pulsos($instancia, $clave = '0', $page = 1)
    {               
        $productos = $this->productos_model->lista_manillas($instancia,$clave,$this->config->item('img_por_pagina_app'),$page);

        $encontrado = false;
        $pos = 1;

        $resultado =  '{ "pulsos" : [';

        foreach($productos as $item)
        {
            $imagen = $this->productos_model->consulta_imagen_manilla_app($item->CodProd);

            $arreglo = array(
                "CodProd"          => $item->CodProd,
                "CodInst"          => $item->CodInst,
                "Descrip"          => $item->Descrip,
                "ListaCalibres"    => $item->ListaCalibres,
                "ListaColores"     => $item->ListaColores,
                "ImgPrincipal"     => $imagen->ImgPrincipal
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

        if (!$encontrado) echo "{}";               
        else 
        {
            $resultado.=']}';

            echo $resultado;
        }
    }

    public function consulta_pulso_app($parte)
    {               
        //$this->session->set_userdata('IDTipoUsuario','1');
        
        $item = $this->productos_model->consulta_pulso_base($parte);

        $encontrado = false;

        $resultado =  '';

        $arreglo = array(
            "CodProd"          => $item->CodProd,
            "Descrip"          => $item->Descrip,
            "ListaCalibres"    => $item->ListaCalibres,
            "ListaColores"     => $item->ListaColores,
            "ListaPartes"      => $item->ListaPartes,
            "CodInst"          => $item->CodInst,
        );

        $encontrado = true;

        $resultado .=  json_encode($arreglo);

        if (!$encontrado) echo "{}";               
        else 
        {
            echo $resultado;
        }
    }

    public function lista_pulsos_base($base,$precio = '-1')
    {               
        //$this->session->set_userdata('IDTipoUsuario','1');
        
        $productos = $this->productos_model->lista_pulsos_base($base,$precio);

        $encontrado = false;
        $pos = 1;

        $resultado =  '{ "pulsos" : [';

        foreach($productos as $item)
        {
            //p.CodProd,r.Descrip,r.DescAmpliada,p.Precio'.$precio.' AS Precio,p.Impuesto,p.ImgPrincipal,p.ImgAdicionales,p.ImgTexturas
            $arreglo = array(
                "CodProd"         => $item->CodProd,
                "Descrip"         => $item->Descrip,
                "Precio"          => $item->Precio,
                "Impuesto"        => $item->Impuesto,
                "ImgPrincipal"    => $item->ImgPrincipal,
                "ImgAdicionales"  => $item->ImgAdicionales,
                "ImgTexturas"     => $item->ImgTexturas,
                "Precio1"          => $item->Precio1,
                "Precio2"          => $item->Precio2,
                "Precio3"          => $item->Precio3,
                "Precio4"          => $item->Precio4,
                "PrecioInternet"   => $item->PrecioInternet
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

        if (!$encontrado) echo "{}";               
        else 
        {
            $resultado.=']}';

            echo $resultado;
        }
    }

    public function detalle_pulso_app($parte)
    {               
        //$this->session->set_userdata('IDTipoUsuario','3');
        
        $productos = $this->productos_model->lista_pulsos_base($parte);

        $encontrado = false;
        $pos = 1;

        $resultado =  '{ "pulsos" : [';

        foreach($productos as $item)
        {
            $arreglo = array(
                "CodProd"          => $item->CodProd,
                "Descrip"          => $item->Descrip,
                "Precio"           => $item->Precio,
                "Impuesto"         => $item->Impuesto,
                "ListaCalibres"    => $item->ListaCalibres,
                "ImgPrincipal"     => $item->ImgPrincipal,
                "ImgAdicionales"   => $item->ImgAdicionales,
                "ImgTexturas"      => $item->ImgTexturas
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

        if (!$encontrado) echo "{}";               
        else 
        {
            $resultado.=']}';

            echo $resultado;
        }
    }

    /********************* Suscripciones **************************** */
    public function suscripcion()
    {
        $info = file_get_contents('php://input');
        $input = json_decode($info);
        
        $result = $this->usuarios_model->inserta_suscripcion($input->Nombre,$input->Email,$input->Telefono,$input->BD,$input->Mensaje);

        if ($this->config->item('activar_correo') == 'S')
        {
            $this->email->from('sistemas@clou.com.co', 'Landing Page CLOU');
            $this->email->to('ventas@clou.com.co');
            $this->email->cc('iestrada@clou.com.co');
            $this->email->bcc('sistemas@makingbusiness.com.co');
    
            $this->email->subject('Registro de usuario');

            $mensaje = $input->Nombre.' Tel: '.$input->Telefono.' Email: '.$input->Email.' - '.$input->Mensaje;

            $this->email->message('Nuevo registro en la página'.$mensaje);
    
            $this->email->send();
        }

        $response = array(
            'resultado'   => 'OK',
            'mensaje'     => $result
        );

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function prueba()
    {
        $info = file_get_contents('php://input');
        $input = json_decode($info);

        $basura = array(
            'ID'      => 1,
            'rowid'   => 'Hola',
            'qty'     => 'Si alcanzo a llamar',
            'todo'    => 'Y quedo registrado aqui'
        );

        $this->db->insert('basura', $basura);

        $response = array(
            'OK'    => true,
            'Mensaje'   => 'Todo bien!!'
        );

        header('Content-Type: application/json');
        echo json_encode($response);

    }

    /************************* Varios ***********************************/
    public function listaPaises()
    {
        $paises = lista_paises();

        $resultado =  '{ "paises" : [';

        $encontrado = false;

        foreach($paises as $item)
        {
            $arreglo = array(
                "IDPais"           => $item->IDPais,
                "Descrip"          => $item->Descrip
            );

            $encontrado = true;

            if ($resultado == '{ "paises" : [')
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

    public function listaEstados()
    {
        $estados = lista_estados();

        $resultado =  '{ "estados" : [';

        $encontrado = false;

        foreach($estados as $item)
        {
            $arreglo = array(
                "IDPais"           => $item->IDPais,
                "IDEstado"         => $item->IDEstado,
                "Descrip"          => $item->Descrip
            );

            $encontrado = true;

            if ($resultado == '{ "estados" : [')
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
    
    public function listaCiudades()
    {
        $paises = lista_ciudades();

        $resultado =  '{ "ciudades" : [';

        $encontrado = false;

        foreach($paises as $item)
        {
            $arreglo = array(
                "IDPais"           => $item->IDPais,
                "IDEstado"         => $item->IDEstado,
                "IDCiudad"         => $item->IDCiudad,
                "Descrip"          => $item->Descrip
            );

            $encontrado = true;

            if ($resultado == '{ "ciudades" : [')
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

    /********************** Registro usuarios ************************************* */
    public function insertar_usuario()
    {
        $info = file_get_contents('php://input');
        $usuario = json_decode($info);

        $result = $this->usuarios_model->registrarApp($usuario);

        $response = array(
            'resultado'   => $result == 0 ? 'Error' : 'OK',
            'mensaje'     => $result == 0 ? 'El usuario ya está registrado' : $result
        );

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function actualizar_usuario()
    {
        $info = file_get_contents('php://input');
        $usuario = json_decode($info);

        $result = $this->usuarios_model->actualizarApp($usuario);

        $response = array(
            'resultado'   => 'OK',
            'mensaje'     => $result
        );

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function actualizar_clave()
    {
        $info = file_get_contents('php://input');
        $usuario = json_decode($info);

        $result = $this->usuarios_model->actualiza_clave_app($usuario);

        $response = array(
            'resultado'   => 'OK',
            'mensaje'     => $result
        );

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function consulta_usuario($codigo)
    {
        $datos = $this->usuarios_model->consulta_usuario_valor($codigo);

        $resultado = '';

        if ($datos)
        {
            $item = $datos;

            $usuario = array(
                "CodClie"      => $item->CodClie,
                "Apellidos"    => $item->Apellidos,
                "Nombres"      => $item->Nombres,
                "Telefono"     => $item->Telefono,
                "Email"        => $item->Email,
                "Pais"         => $item->Pais,
                "Estado"       => $item->Estado,
                "Ciudad"       => $item->Ciudad,
                "Direccion"    => $item->Direccion
            );

            $arreglo = array(
                'ok'         => true,
                'usuario'    => $usuario
            );
    
            $resultado =  json_encode($arreglo);
        }
        else 
        {
            $arreglo = array(
                'ok'        => false,
                'mensaje'   => 'El usuario no está registrado'
            );

            $resultado =  json_encode($arreglo);
        }

        echo $resultado;
    }

    public function login()
    {      
        $info = file_get_contents('php://input');
        $usuario = json_decode($info);

        $result = $this->usuarios_model->login_app($usuario->Valor,$usuario->Clave);

        
        if ($result)
        {
            $response = array(
                'resultado'   => 'OK',
                'usuario'     => $result
            );
        }
        else
        {
            $response = array(
                'resultado'   => 'false',
                'mensaje'     => 'El usuario o la contraseña no son válidos'
            );
        }

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function acceso_clientes()
    {
        $info = file_get_contents('php://input');
        $datos = json_decode($info);

        $cliente = $this->clientes_model->consultar_acceso_cliente_app($datos->Valor,$datos->Clave);

        $response = array(
            'resultado'     => 'ok',
            'cliente'       => $cliente
        );

        echo json_encode($response);    
    }

	public function enviar_sms($cliente)
	{
		$resultado = $this->clientes_model->consulta_cliente($cliente);

		if ($resultado)
		{
			$codigo_ingreso = mt_rand(111111,999999);

			$this->clientes_model->guardar_codigo_temp($resultado->CodClie,$codigo_ingreso);
            
            $response = array(
                'ok'      => true,
                'mensaje' => 'En un momento recibirá un código de ingreso al correo y celular que tenemos registrado.'
            );
            
            $msj = json_encode($response);
            echo $msj;
            
            $basura = json_encode($this->clientes_model->enviar_sms($resultado->Movil,$codigo_ingreso));
            echo $basura['deliveryToken'];
        }
        else
        {
            $response = array(
                'ok'      => false,
                'mensaje' =>  'No hay registros para el dato ingresado'
            );

            $msj = json_encode($response);
            echo $msj;
        }        
    }
    
    public function enviar_clave_temporal($info)
    {
		$resultado = $this->usuarios_model->consulta_usuario_valor($info);

		if ($resultado)
		{
			$codigo_ingreso = mt_rand(111111,999999);

			$this->usuarios_model->actualiza_clave_temp($resultado->CodClie,$codigo_ingreso);
            
            $mensaje = 'Su clave temporal es '.$codigo_ingreso;

            $response = array(
                'ok'      => true,
                'mensaje' => $mensaje
            );
            
            $msj = json_encode($response);
            echo $msj;
            
            $basura = json_encode($this->clientes_model->enviar_sms($resultado->Telefono,$codigo_ingreso,$mensaje));
            echo $basura['deliveryToken'];
        }
        else
        {
            $response = array(
                'ok'      => false,
                'mensaje' =>  'No hay registros para el dato ingresado'
            );

            $msj = json_encode($response);
            echo $msj;
        }
    }
    /*********************** Registro pedidos ********************** */
    public function insertar_pedido()
    {
        $info = file_get_contents('php://input');
        $pedido = json_decode($info);

        $result = $this->pedidos_model->registrarApp($pedido->pedido,$pedido->detalle);

        $response = array(
            'resultado'   => 'OK',
            'mensaje'     => $result
        );

        header('Content-Type: application/json');
        echo json_encode($response);
    }

    public function listar_pedidos($codigo)
    {
        $pedidos = $this->pedidos_model->lista_pedidos_app($codigo);

        $encontrado = false;

        $resultado =  '{ "pedidos" : [';

        foreach($pedidos as $item)
        {
            $arreglo = array(
                "id"             => $item->IDPedido,
                "Fecha"          => $item->FechaPedido,
                "Email"          => $item->Email,
                "CodClie"        => $item->CodClie,
                'Observaciones'  => $item->Observaciones,
                'Valor'          => $item->Valor,
                'Impuesto'       => $item->Impuesto,
                "Pais"           => $item->Pais,
                "Estado"         => $item->Estado,
                "Ciudad"         => $item->Ciudad,
                'EstadoPedido'   => $item->EstadoPedido
            );

            $encontrado = true;
            if ($resultado != '{ "pedidos" : [')
            {
                $resultado .=  ',';
            }

            $resultado .= json_encode($arreglo);
        }

        if (!$encontrado) echo "{}";
        else
        {
            $resultado.=']}';

            echo $resultado;
        }
    }

    public function listar_detalle_pedidos($codigo)
    {
        $pedidos = $this->pedidos_model->consulta_detalle_pedido_usuario($codigo);

        $encontrado = false;

        $resultado =  '{ "detalle" : [';

        foreach($pedidos as $item)
        {
            $arreglo = array(
                "Pedido"         => $item->IDPedido,
                "CodProd"        => $item->CodProd,
                "Descrip"        => $item->Descripcion,
                "Cantidad"       => $item->Cantidad,
                'Valor'          => $item->Valor,
                'Impuesto'       => $item->Impuesto,
                "ImgPrincipal"   => $item->ImgPrincipal
            );

            $encontrado = true;
            if ($resultado != '{ "detalle" : [')
            {
                $resultado .=  ',';
            }

            $resultado .= json_encode($arreglo);
        }

        if (!$encontrado) echo "{}";
        else
        {
            $resultado.=']}';

            echo $resultado;
        }
    }

    /************* Clasificación baterías *********************************** */

    public function listar_clases_bateria()
    {
        $clases = $this->productos_model->listar_clases_bateria();

        $encontrado = false;

        $resultado =  '{ "clases" : [';

            foreach($clases as $item)
            {
                $arreglo = array(
                    "Id"             => $item->Id,
                    "Descrip"        => $item->Descrip,
                );
    
                $encontrado = true;
                if ($resultado != '{ "clases" : [')
                {
                    $resultado .=  ',';
                }
    
                $resultado .= json_encode($arreglo);
            }
    
            if (!$encontrado) echo "{}";
            else
            {
                $resultado.=']}';
    
                echo $resultado;
            }
    }

    public function listar_tipos_bateria()
    {
        $tipos = $this->productos_model->listar_tipos_bateria();

        $encontrado = false;

        $resultado =  '{ "tipos" : [';

            foreach($tipos as $item)
            {
                $arreglo = array(
                    "Id"             => $item->Id,
                    "Descrip"        => $item->Descrip,
                );
    
                $encontrado = true;
                if ($resultado != '{ "tipos" : [')
                {
                    $resultado .=  ',';
                }
    
                $resultado .= json_encode($arreglo);
            }
    
            if (!$encontrado) echo "{}";
            else
            {
                $resultado.=']}';
    
                echo $resultado;
            }
    }    

    public function listar_marcas_clase_bateria($clase)
    {
        $marcas = $this->productos_model->lista_marcas_clase($clase);

        $encontrado = false;

        $resultado =  '{ "marcas" : [';

        foreach($marcas as $item)
        {
            $arreglo = array(
                "CodInst"        => $item->CodInst,
                "Descrip"        => $this->productos_model->consulta_descripcion_categoria($item->CodInst)->Descrip,
                'InsPadre'       => $item->InsPadre,
                'EsPulso'        => $item->EsPulso,
                'InstanciaBase'  => $item->InstanciaBase
            );

            $encontrado = true;
            if ($resultado != '{ "marcas" : [')
            {
                $resultado .=  ',';
            }

            $resultado .= json_encode($arreglo);
        }

        if (!$encontrado) echo "{}";
        else
        {
            $resultado.=']}';

            echo $resultado;
        }
    }

    public function listar_productos_clase_bateria($clase, $precio = '-1')
    {
        $this->session->set_userdata('idioma','1');
        //$this->session->set_userdata('IDTipoUsuario','1');

        $productos = $this->productos_model->listar_productos_clase_bateria($clase);

        // p.CodProd,p.Impuesto,p.Marca,pi.Descrip,pi.Descrip2,pi.Descrip3,pi.DescAmpliada,pp.Precio,p.CodInst

        $encontrado = false;

        $resultado =  '{ "productos" : [';

        foreach($productos as $item)
        {
            //if ($tipo == 0 && $item->CodProd != $id) continue;

            $producto = $this->productos_model->consulta_producto($item->CodProd,$precio);

            if ($producto)
            {
                $arreglo = array(
                    "CodProd"          => $item->CodProd,
                    "Descrip"          => $producto->Descrip,
                    "CodInst"          => $producto->CodInst,
                    "Marca"            => $producto->Marca,
                    "Precio"           => $producto->Precio,
                    "Impuesto"         => $producto->Impuesto,
                    "ListaProductos"   => '',//$producto->ListaProductos
                    'UnidadNum'        => $producto->UnidadNum,
                    'UnidadWeb'        => $producto->UnidadWeb,
                    'Unidad'           => $producto->Unidad,
                    "Precio1"          => $producto->Precio1,
                    "Precio2"          => $producto->Precio2,
                    "Precio3"          => $producto->Precio3,
                    "Precio4"          => $producto->Precio4,
                    "PrecioInternet"   => $producto->PrecioInternet,
                    "Existen"          => $producto->Existen
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
            }
        }

        if (!$encontrado) echo "{}";               
        else 
        {
            //if ($tipo != 0)
            {
                $resultado.=']}';
            }

            echo $resultado;
        }
    }

    public function listar_marcas_tipo_bateria($tipo)
    {
        $tipos = $this->productos_model->lista_marcas_tipo($tipo);

        $encontrado = false;

        $resultado =  '{ "marcas" : [';

        foreach($tipos as $item)
        {
            $arreglo = array(
                "CodInst"        => $item->CodInst,
                "Descrip"        => $this->productos_model->consulta_descripcion_categoria($item->CodInst)->Descrip,
                'InsPadre'       => $item->InsPadre,
                'EsPulso'        => $item->EsPulso,
                'InstanciaBase'  => $item->InstanciaBase
            );

            $encontrado = true;
            if ($resultado != '{ "marcas" : [')
            {
                $resultado .=  ',';
            }

            $resultado .= json_encode($arreglo);
        }

        if (!$encontrado) echo "{}";
        else
        {
            $resultado.=']}';

            echo $resultado;
        }
    }

    public function listar_productos_tipo_bateria($tipo, $precio = '-1')
    {
        $this->session->set_userdata('idioma','1');
        //$this->session->set_userdata('IDTipoUsuario','1');

        $productos = $this->productos_model->listar_productos_tipo_bateria($tipo);

        // p.CodProd,p.Impuesto,p.Marca,pi.Descrip,pi.Descrip2,pi.Descrip3,pi.DescAmpliada,pp.Precio,p.CodInst

        $encontrado = false;

        $resultado =  '{ "productos" : [';

        foreach($productos as $item)
        {
            //if ($tipo == 0 && $item->CodProd != $id) continue;

            $producto = $this->productos_model->consulta_producto($item->CodProd,$precio);

            if ($producto)
            {
                $arreglo = array(
                    "CodProd"          => $item->CodProd,
                    "Descrip"          => $producto->Descrip,
                    "CodInst"          => $producto->CodInst,
                    "Marca"            => $producto->Marca,
                    "Precio"           => $producto->Precio,
                    "Impuesto"         => $producto->Impuesto,
                    "ListaProductos"   => '',//$producto->ListaProductos
                    'UnidadNum'        => $producto->UnidadNum,
                    'UnidadWeb'        => $producto->UnidadWeb,
                    'Unidad'           => $producto->Unidad,
                    'Empaque'          => $producto->Empaque,
                    'EmpaqueWeb'       => $producto->EmpaqueWeb,
                    "Precio1"          => $producto->Precio1,
                    "Precio2"          => $producto->Precio2,
                    "Precio3"          => $producto->Precio3,
                    "Precio4"          => $producto->Precio4,
                    "PrecioInternet"   => $producto->PrecioInternet,
                    "Existen"          => $producto->Existen
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
            }
        }

        if (!$encontrado) echo "{}";               
        else 
        {
            //if ($tipo != 0)
            {
                $resultado.=']}';
            }

            echo $resultado;
        }
    }    
    
    public function listar_marcas_tipo_clase_bateria($clase,$tipo)
    {
        $tipos = $this->productos_model->lista_marcas_tipo_clase($clase,$tipo);

        $encontrado = false;

        $resultado =  '{ "marcas" : [';

        foreach($tipos as $item)
        {
            $arreglo = array(
                "CodInst"        => $item->CodInst,
                "Descrip"        => $this->productos_model->consulta_descripcion_categoria($item->CodInst)->Descrip,
                'InsPadre'       => $item->InsPadre,
                'EsPulso'        => $item->EsPulso,
                'InstanciaBase'  => $item->InstanciaBase
            );

            $encontrado = true;
            if ($resultado != '{ "marcas" : [')
            {
                $resultado .=  ',';
            }

            $resultado .= json_encode($arreglo);
        }

        if (!$encontrado) echo "{}";
        else
        {
            $resultado.=']}';

            echo $resultado;
        }
    }    

    public function listar_productos_tipo_clase_bateria($clase, $tipo, $precio = '-1')
    {
        $this->session->set_userdata('idioma','1');
        //$this->session->set_userdata('IDTipoUsuario','1');

        $productos = $this->productos_model->listar_productos_tipo_clase_bateria($clase,$tipo);

        // p.CodProd,p.Impuesto,p.Marca,pi.Descrip,pi.Descrip2,pi.Descrip3,pi.DescAmpliada,pp.Precio,p.CodInst

        $encontrado = false;

        $resultado =  '{ "productos" : [';

        foreach($productos as $item)
        {
            //if ($tipo == 0 && $item->CodProd != $id) continue;

            $producto = $this->productos_model->consulta_producto($item->CodProd,$precio);

            if ($producto)
            {
                $arreglo = array(
                    "CodProd"          => $item->CodProd,
                    "Descrip"          => $producto->Descrip,
                    "CodInst"          => $producto->CodInst,
                    "Marca"            => $producto->Marca,
                    "Precio"           => $producto->Precio,
                    "Impuesto"         => $producto->Impuesto,
                    "ListaProductos"   => '',//$producto->ListaProductos
                    'UnidadNum'        => $producto->UnidadNum,
                    'UnidadWeb'        => $producto->UnidadWeb,
                    'Unidad'           => $producto->Unidad,
                    'Empaque'          => $producto->Empaque,
                    'EmpaqueWeb'       => $producto->EmpaqueWeb,
                    "Precio1"          => $producto->Precio1,
                    "Precio2"          => $producto->Precio2,
                    "Precio3"          => $producto->Precio3,
                    "Precio4"          => $producto->Precio4,
                    "PrecioInternet"   => $producto->PrecioInternet,
                    "Existen"          => $producto->Existen
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
            }
        }

        if (!$encontrado) echo "{}";               
        else 
        {
            //if ($tipo != 0)
            {
                $resultado.=']}';
            }

            echo $resultado;
        }
    }    

    public function consulta_caracteristicas_bateria($codigo)
    {
        $item = $this->productos_model->consulta_caracteristicas_bateria($codigo);

        $resultado =  '';

        $arreglo = array(
            "Material"         => $item->Material,
            "Voltaje"          => $item->Voltaje,
            'Diametro'         => $item->Diametro,
            'Altura'           => $item->Altura,
            'mAh'              => $item->mAh,
            'Dimensiones'      => $item->Dimensiones,
            'Peso'             => $item->Peso,
            'Caracteristicas'  => $item->Caracteristicas,
            'UnidadNum'        => $item->UnidadNum,
            'UnidadWeb'        => $item->UnidadWeb,
            'Unidad'           => $item->Unidad,
            'Empaque'          => $item->Empaque,
            'EmpaqueWeb'       => $item->EmpaqueWeb,
            "Precio1"          => $item->Precio1,
            "Precio2"          => $item->Precio2,
            "Precio3"          => $item->Precio3,
            "Precio4"          => $item->Precio4,
            "PrecioInternet"   => $item->PrecioInternet,
            "Existen"          => $item->Existen
        );

        $resultado .=  json_encode($arreglo);

        echo $resultado;       
    }

    public function listar_usos_producto($codigo)
    {
        $clases = $this->productos_model->listar_usos_producto($codigo);

        $encontrado = false;

        $resultado =  '{ "usosProducto" : [';

            foreach($clases as $item)
            {
                $arreglo = array(
                    "Uso"            => $item->Uso
                );
    
                $encontrado = true;
                if ($resultado != '{ "usosProducto" : [')
                {
                    $resultado .=  ',';
                }
    
                $resultado .= json_encode($arreglo);
            }
    
            if (!$encontrado) echo "{}";
            else
            {
                $resultado.=']}';
    
                echo $resultado;
            }
    }

    /******************************* Epayco ***************************************************/
    public function login_epayco()
    {
        $curl = curl_init();

        curl_setopt_array($curl, array(
            CURLOPT_URL             => 'https://apify.epayco.co/login/mail',
            CURLOPT_CUSTOMREQUEST  => 'POST',
            CURLOPT_HTTPAUTH  => CURLAUTH_BASIC,
            CURLOPT_USERNAME  => $this->config->item('usr_epayco'),
            CURLOPT_PASSWORD  => $this->config->item('pwd_epayco'),
            CURLOPT_HEADER => false,
            CURLOPT_HTTPHEADER  => array(
                'Content-type'    => 'application/json',
                'public_key'      => $this->config->item('public_key')
            )
        ));

        $response = curl_exec($curl);
        $error = curl_error($curl);
        curl_close($curl);

        if ($error)
        {
            echo $error;
        }
        else
        {
            echo $response;
        }
    }

    public function listar_bancos()
    {

    }
}