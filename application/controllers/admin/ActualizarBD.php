<?php
class ActualizarBD extends CI_Controller{
    
    public $totalInstancias=0;
    public $totalInstanciasAct=0;
    public $totalInstanciasIdioma=0;
    public $totalInstanciasIdiomaAct=0;
    public $totalProductos=0;
    public $totalProductosAct=0;
    public $totalAuxiliares=0;
    public $totalAuxiliaresAct=0;
    public $totalProductosIdioma=0;
    public $totalProductosIdiomaAct=0;
    public $totalProductosPrecio=0;
    public $totalProductosPrecioAct=0;
    public $totalPulsos=0;
    public $totalPulsosAct=0;

    public $totalProductosIdioma2=0;
    public $totalProductosIdiomaAct2=0;

    public $totalPaises=0;
    public $totalPaisesAct=0;
    public $totalEstados=0;
    public $totalEstadosAct=0;
    public $totalCiudades=0;
    public $totalCiudadesAct=0;
    public $totalClientes=0;
    public $totalClientesAct=0;
    
    public $totalProductosStatur=0;
    public $totalProductosStaturAct=0;   
    public $totalAuxiliaresStatur=0;
    public $totalAuxiliaresStaturAct=0;
    public $totalProductosIdiomaStatur=0;
    public $totalProductosIdiomaStaturAct=0;

    public $totalCaracteristicasBaterias=0;
    public $totalCaracteristicasBateriasAct=0;
    public $totalClasesBateria=0;
    public $totalClasesBateriaAct=0;
    public $totalTiposBateria=0;
    public $totalTiposBateriaAct=0;
    public $totalProductosTipoBateria=0;
    public $totalProductosTipoBateriaAct=0;

    public $totalUsosProducto=0;
    public $totalUsosProductoAct=0;


	public function __construct()
	{
        parent::__construct();
        $this->load->helper('url');
		$this->load->library('session');
        $this->load->model('admin/instancias_model');
        $this->load->model('admin/productos_model');
        $this->load->model('admin/clientes_model');
        $this->load->model('admin/geograficas_model');
        $this->load->model('varios_model');
    }
    
    public function index()
    {
        $this->session->set_userdata('tabla_idiomas','N');
        $this->actualizar();
    }
	
	public function actualizar($tabla_idiomas = '1')
	{
        $this->actualizar_instancias_idioma();

        if ($tabla_idiomas == '1')
        {
            $this->session->set_userdata('tabla_idiomas','N');
            $this->session->set_userdata('tabla_idiomas','N');
            $this->actualizar_instancias();
            $this->actualizar_productos();
            $this->actualizar_productos_idioma();
            $this->actualizar_auxiliares();
            //$this->actualizar_precios_producto();
            $this->actualizar_pulsos();

            $this->actualizar_auxiliares_statur();
            $this->actualizar_productos_statur();
            $this->actualizar_productos_idioma_statur();
        }
        else 
        {
            $this->session->set_userdata('tabla_idiomas','S');

            $this->actualizar_instancias2();
            $this->actualizar_productos2();
            $this->actualizar_precios_producto2();
            $this->actualizar_auxiliares2();
            $this->actualizar_productos_idioma2();
            $this->actualizar_pulsos2();
        }

        $this->actualizar_paises();
        $this->actualizar_estados();
        $this->actualizar_ciudades();
        $this->actualizar_clientes();

        $this->actualizar_auxiliares_statur();
        $this->actualizar_productos_statur();
        $this->actualizar_productos_idioma_statur();

        $this->actualizar_caracteristicas_baterias();
        $this->actualizar_clases_bateria();
        $this->actualizar_tipos_bateria();
        $this->actualizar_productos_tipo_bateria();        

        $this->actualizar_usos_producto();

        if ($tabla_idiomas == '1')
        {
            $resultado = 'TIPO,INS,ACT,
                            Categorias,'.$this->totalInstancias.','.$this->totalInstanciasAct.
                            ',Categorias idioma,'.$this->totalInstanciasIdioma.','.$this->totalInstanciasIdiomaAct.
                            ',Productos,'.$this->totalProductos.','.$this->totalProductosAct.
                            ',Productos Statur,'.$this->totalProductosStatur.','.$this->totalProductosStaturAct.
                            ',Auxiliares,'.$this->totalAuxiliares.','.$this->totalAuxiliaresAct.
                            ',Auxiliares Statur,'.$this->totalAuxiliaresStatur.','.$this->totalAuxiliaresStaturAct.
                            ',Productos idioma,'.$this->totalProductosIdioma.','.$this->totalProductosIdiomaAct.
                            ',Productos idioma Statur,'.$this->totalProductosIdiomaStatur.','.$this->totalProductosIdiomaStaturAct.
                            ',Productos precio,'.$this->totalProductosPrecio.','.$this->totalProductosPrecioAct.
                            ',Pulsos,'.$this->totalPulsos.','.$this->totalPulsosAct.
                            ',Paises,'.$this->totalPaises.','.$this->totalPaisesAct.
                            ',Estados,'.$this->totalEstados.','.$this->totalEstadosAct.
                            ',Cuidades,'.$this->totalCiudades.','.$this->totalCiudadesAct.
                            ',Caracteristicas Baterias,'.$this->totalCaracteristicasBaterias.','.$this->totalCaracteristicasBateriasAct.
                            ',Clases Baterias,'.$this->totalClasesBateria.','.$this->totalClasesBateriaAct.
                            ',Tipos Baterias,'.$this->totalTiposBateria.','.$this->totalTiposBateriaAct.
                            ',Productos Tipo Bateria,'.$this->totalProductosTipoBateria.','.$this->totalProductosTipoBateriaAct.
                            ',Usos Producto,'.$this->totalUsosProducto.','.$this->totalUsosProductoAct;                           
        }
        else
        {
            $resultado = 'TIPO,INS,ACT,
                               Categorias,'.$this->totalInstancias.','.$this->totalInstanciasAct.
                               ',Categorias idioma,'.$this->totalInstanciasIdioma.','.$this->totalInstanciasIdiomaAct.
                               ',Productos,'.$this->totalProductos.','.$this->totalProductosAct.
                               ',Auxiliares,'.$this->totalAuxiliares.','.$this->totalAuxiliaresAct.
                               ',Productos idioma2,'.$this->totalProductosIdioma.','.$this->totalProductosIdiomaAct.                           
                               ',Productos precio,'.$this->totalProductosPrecio.','.$this->totalProductosPrecioAct.
                               ',Pulsos,'.$this->totalPulsos.','.$this->totalPulsosAct.                           
                               ',Paises,'.$this->totalPaises.','.$this->totalPaisesAct.
                               ',Estados,'.$this->totalEstados.','.$this->totalEstadosAct.
                               ',Cuidades,'.$this->totalCiudades.','.$this->totalCiudadesAct.
                               ',Clientes,'.$this->totalClientes.','.$this->totalClientesAct;            
        }

        /*$data['resultado'] = $resultado;

        $this->load->view('templates/header');
		$this->load->view("admin/actualizarBD",$data);
		$this->load->view('templates/footer');*/

        echo $resultado;
    }
    
    public function actualizar_instancias()
    {
        if (file_exists("carga/instancias.xml"))
        {
            $instancias = simplexml_load_file("carga/instancias.xml");
            $this->instancias_model->eliminar_instancias();
            $resultado = 0;
            foreach($instancias as $instancia){
                if (isset($instancia->codinst))
                {
                    $resultado = $this->instancias_model->existeInstancia($instancia->codinst);                    

                    if ($resultado == 0){
                        $this->instancias_model->inserta_instancia($instancia);
                        $this->totalInstancias++;
                    }
                    else{
                        $this->instancias_model->actualizar_instancia($instancia);
                        $this->totalInstanciasAct++;
                    }
                }
            }
        }
    }

    public function actualizar_instancias2()
    {
        if (file_exists("carga/instancias2.xml"))
        {
            $instancias = simplexml_load_file("carga/instancias2.xml");
            $this->instancias_model->eliminar_instancias2();
            $resultado = 0;
            foreach($instancias as $instancia){
                if (isset($instancia->codinst))
                {
                    $resultado = $this->instancias_model->existeInstancia2($instancia->codinst);                    

                    if ($resultado == 0){
                        $this->instancias_model->inserta_instancia2($instancia);
                        $this->totalInstancias++;
                    }
                    else{
                        $this->instancias_model->actualizar_instancia($instancia);
                        $this->totalInstanciasAct++;
                    }
                }
            }
        }
    }

    public function actualizar_instancias_idioma()
    {
        if (file_exists("carga/instanciasIdioma.xml"))
        {
            $instancias = simplexml_load_file("carga/instanciasIdioma.xml");
            $this->instancias_model->eliminar_instancias_idioma();
            $resultado=0;
            foreach($instancias as $instancia){
                if (isset($instancia->codinst))
                {
                    $resultado = $this->instancias_model->existe_instancia_idioma($instancia);

                    if ($resultado == 0){
                        $this->instancias_model->inserta_instancia_idioma($instancia);
                        $this->totalInstanciasIdioma++;
                    }
                    else{
                        $this->instancias_model->actualizar_instancia_idioma($instancia);
                        $this->totalInstanciasIdiomaAct++;
                    }
                }
            }
        }
    }

    public function actualizar_productos()
    {
        if (file_exists("carga/productos.xml"))
        {
            $productos = simplexml_load_file("carga/productos.xml");
            $this->productos_model->eliminar_productos(false);
            $resultado = 0;
            foreach($productos as $producto){
                if (isset($producto->codprod))
                {
                    $resultado = $this->productos_model->existeProducto($producto->codprod);                    

                    if ($resultado == 0){
                        $this->productos_model->inserta_producto($producto,false);
                        $this->totalProductos++;
                    }
                    else{
                        $this->productos_model->actualizar_productos($producto,false);
                        $this->totalProductosAct++;
                    }
                }
            }
        }
    }

    public function actualizar_productos2()
    {
        if (file_exists("carga/productos2.xml"))
        {
            $productos = simplexml_load_file("carga/productos2.xml");
            $this->productos_model->eliminar_productos(false);
            $resultado = 0;
            foreach($productos as $producto){
                if (isset($producto->codprod))
                {
                    $resultado = $this->productos_model->existeProducto($producto->codprod);                    

                    if ($resultado == 0){
                        $this->productos_model->inserta_producto($producto,false);
                        $this->totalProductos++;
                    }
                    else
                    {
                        $this->productos_model->actualizar_productos($producto,false);
                        $this->totalProductosAct++;
                    }
                }
            }
        }
    }


    public function actualizar_productos_statur()
    {
        if (file_exists("carga/productosStatur.xml"))
        {
            $productos = simplexml_load_file("carga/productosStatur.xml");
            $this->productos_model->eliminar_productos(true);
            $resultado = 0;
            foreach($productos as $producto){
                if (isset($producto->codprod))
                {
                    $resultado = $this->productos_model->existeProducto($producto->codprod);

                    if ($resultado == 0){
                        $this->productos_model->inserta_producto($producto,true);
                        $this->totalProductosStatur++;
                    }
                    else{
                        $this->productos_model->actualizar_productos($producto,true);
                        $this->totalProductosStaturAct++;
                    }
                }
            }
        }
    }

    public function actualizar_auxiliares()
    {
        if (file_exists("carga/auxiliares.xml"))
        {
            $productos = simplexml_load_file("carga/auxiliares.xml");
            $this->productos_model->eliminar_auxiliares();
            $resultado = 0;
            foreach($productos as $producto){
                if (isset($producto->codigoaux))
                {
                    $resultado = $this->productos_model->existeAuxiliar($producto->codigoaux);

                    if ($resultado == 0){
                        $this->productos_model->inserta_auxiliar($producto);
                        $this->totalAuxiliares++;
                    }
                    else{
                        $this->productos_model->actualizar_auxiliar($producto);
                        $this->totalAuxiliaresAct++;
                    }
                }
            }
        }
    }   

    public function actualizar_auxiliares2()
    {
        if (file_exists("carga/auxiliares2.xml"))
        {
            $productos = simplexml_load_file("carga/auxiliares2.xml");
            $this->productos_model->eliminar_auxiliares2();
            $resultado = 0;
            foreach($productos as $producto){
                if (isset($producto->codigoaux))
                {
                    $resultado = $this->productos_model->existeAuxiliar2($producto->codigoaux);

                    if ($resultado == 0){
                        $this->productos_model->inserta_auxiliar2($producto);
                        $this->totalAuxiliares++;
                    }
                    else{
                        $this->productos_model->actualizar_auxiliar2($producto);
                        $this->totalAuxiliaresAct++;
                    }
                }
            }
        }
    }       
    
    public function actualizar_auxiliares_statur()
    {
        if (file_exists("carga/auxiliaresStatur.xml"))
        {
            try
            {
                $productos = simplexml_load_file("carga/auxiliaresStatur.xml");
                $resultado = 0;
    
                if ($productos)
                {
                    foreach($productos as $producto){
                        if (isset($producto->codigoaux))
                        {
                            $resultado = $this->productos_model->existeAuxiliar($producto->codigoaux);
        
                            if ($resultado == 0){
                                $this->productos_model->inserta_auxiliar($producto);
                                $this->totalAuxiliaresStatur++;
                            }
                            else{
                                $this->productos_model->actualizar_auxiliar($producto);
                                $this->totalAuxiliaresStaturAct++;
                            }
                        }
                    }
                }
            }
            catch(Exception $e)
            {
                $resultado = 0;
            }
        }
    }   

    public function actualizar_productos_idioma()
    {
        if (file_exists("carga/productos_idioma.xml"))
        {
            $productos = simplexml_load_file("carga/productos_idioma.xml");
            $this->productos_model->eliminar_productos_idioma();
            $resultado=0;
            foreach($productos as $producto){
                if (isset($producto->codprod))
                {
                    $resultado = $this->productos_model->existe_producto_idioma($producto);

                    if ($resultado == 0){
                        $this->productos_model->inserta_producto_idioma($producto);
                        $this->totalProductosIdioma++;
                    }
                    else{
                        $this->productos_model->actualizar_producto_idioma($producto);
                        $this->totalProductosIdiomaAct++;
                    }
                }
            }
        }
    }

    public function actualizar_productos_idioma2()
    {
        if (file_exists("carga/productos_idioma2.xml"))
        {
            $productos = simplexml_load_file("carga/productos_idioma2.xml");
            $this->productos_model->eliminar_productos_idioma2();
            $resultado=0;
            foreach($productos as $producto){
                if (isset($producto->codprod))
                {
                    $resultado = $this->productos_model->existe_producto_idioma2($producto);

                    if ($resultado == 0){
                        $this->productos_model->inserta_producto_idioma2($producto);
                        $this->totalProductosIdioma2++;
                    }
                    else{
                        $this->productos_model->actualizar_producto_idioma2($producto);
                        $this->totalProductosIdiomaAct2++;
                    }
                }
            }
        }
    }    

    public function actualizar_productos_idioma_statur()
    {
        if (file_exists("carga/productosIdiomaStatur.xml"))
        {
            $productos = simplexml_load_file("carga/productosIdiomaStatur.xml");
            $resultado=0;
            foreach($productos as $producto){
                if (isset($producto->codprod))
                {
                    $resultado = $this->productos_model->existe_producto_idioma($producto);

                    if ($resultado == 0){
                        $this->productos_model->inserta_producto_idioma($producto);
                        $this->totalProductosIdiomaStatur++;
                    }
                    else{
                        $this->productos_model->actualizar_producto_idioma($producto);
                        $this->totalProductosIdiomaStaturAct++;
                    }
                }
            }
        }
    }

    public function actualizar_precios_producto()
    {
        if (file_exists("carga/preciosProducto.xml"))
        {
            $productos = simplexml_load_file("carga/preciosProducto.xml");
            $this->productos_model->eliminar_precios_producto();
            $resultado=0;
            foreach($productos as $producto){
                if (isset($producto->CodProd))
                {
                    $resultado = $this->productos_model->existe_precio_producto($producto);

                    if ($resultado == 0){
                        $this->productos_model->inserta_precio_producto($producto);
                        $this->totalProductosPrecio++;
                    }
                    else{
                        $this->productos_model->actualizar_precio_producto($producto);
                        $this->totalProductosPrecioAct++;
                    }
                }
            }
        }
    }

    public function actualizar_precios_producto2()
    {
        if (file_exists("carga/preciosProducto2.xml"))
        {
            $productos = simplexml_load_file("carga/preciosProducto2.xml");
            $this->productos_model->eliminar_precios_producto();
            $resultado=0;
            foreach($productos as $producto){
                if (isset($producto->CodProd))
                {
                    $resultado = $this->productos_model->existe_precio_producto($producto);

                    if ($resultado == 0){
                        $this->productos_model->inserta_precio_producto($producto);
                        $this->totalProductosPrecio++;
                    }
                    else{
                        $this->productos_model->actualizar_precio_producto($producto);
                        $this->totalProductosPrecioAct++;
                    }
                }
            }
        }
    }

    public function actualizar_pulsos()
    {
        if (file_exists("carga/pulsos.xml"))
        {
            $productos = simplexml_load_file("carga/pulsos.xml");
            $this->productos_model->eliminar_pulsos();
            $resultado=0;
            foreach($productos as $producto){
                if (isset($producto->codprod))
                {
                    $resultado = $this->productos_model->existe_pulso($producto);

                    if ($resultado == 0){
                        $this->productos_model->inserta_pulso($producto);
                        $this->totalPulsos++;
                    }
                    else{
                        $this->productos_model->actualizar_pulso($producto);
                        $this->totalPulsosAct++;
                    }
                }
            }
        }
    }

    public function actualizar_pulsos2()
    {
        if (file_exists("carga/pulsos2.xml"))
        {
            $productos = simplexml_load_file("carga/pulsos2.xml");
            $this->productos_model->eliminar_pulsos();
            $resultado=0;
            foreach($productos as $producto){
                if (isset($producto->codprod))
                {
                    $resultado = $this->productos_model->existe_pulso($producto);

                    if ($resultado == 0){
                        $this->productos_model->inserta_pulso($producto);
                        $this->totalPulsos++;
                    }
                    else{
                        $this->productos_model->actualizar_pulso($producto);
                        $this->totalPulsosAct++;
                    }
                }
            }
        }
    }    

    public function actualizar_paises()
    {
        if (file_exists("carga/paises.xml"))
        {
            $paises = simplexml_load_file("carga/paises.xml");
            $this->geograficas_model->eliminar_paises();
            $resultado = 0;
            foreach($paises as $pais){
                if (isset($pais->Pais))
                {
                    $resultado = $this->geograficas_model->existePais($pais->Pais);

                    if ($resultado == 0){
                        $this->geograficas_model->inserta_pais($pais);
                        $this->totalPaises++;
                    }
                    else{
                        $this->geograficas_model->actualizar_pais($pais);
                        $this->totalPaisesAct++;
                    }
                }
            }
        }
    }

    public function actualizar_estados()
    {
        if (file_exists("carga/estados.xml"))
        {
            $estados = simplexml_load_file("carga/estados.xml");
            $this->geograficas_model->eliminar_estados();
            $resultado = 0;
            foreach($estados as $estado){
                if (isset($estado->Estado))
                {
                    $resultado = $this->geograficas_model->existeEstado($estado);

                    if ($resultado == 0){
                        $this->geograficas_model->inserta_estado($estado);
                        $this->totalEstados++;
                    }
                    else{
                        $this->geograficas_model->actualizar_estado($estado);
                        $this->totalEstadosAct++;
                    }
                }
            }
        }
    }
    
    public function actualizar_ciudades()
    {
        if (file_exists("carga/ciudades.xml"))
        {
            $ciudades = simplexml_load_file("carga/ciudades.xml");
            $this->geograficas_model->eliminar_ciudades();
            $resultado = 0;
            foreach($ciudades as $ciudad){
                if (isset($ciudad->Ciudad))
                {
                    $resultado = $this->geograficas_model->existeCiudad($ciudad);

                    if ($resultado == 0){
                        $this->geograficas_model->inserta_ciudad($ciudad);
                        $this->totalCiudades++;
                    }
                    else{
                        $this->geograficas_model->actualizar_ciudad($ciudad);
                        $this->totalCiudadesAct++;
                    }
                }
            }
        }
    }    

    public function actualizar_clientes()
    {
        if (file_exists("carga/clientes.xml"))
        {
            $clientes = simplexml_load_file("carga/clientes.xml");
            $resultado = 0;
            foreach($clientes as $cliente){
                if (isset($cliente->CodClie))
                {
                    $resultado = $this->clientes_model->existeCliente($cliente->CodClie);

                    if ($resultado == 0){
                        $this->clientes_model->inserta_cliente($cliente);
                        $this->totalClientes++;
                    }
                    else{
                        $this->clientes_model->actualizar_cliente($cliente);
                        $this->totalClientesAct++;
                    }
                }
            }
        }
    }

    /************************ Baterías ************************ */
    public function actualizar_caracteristicas_baterias()
    {
        if (file_exists("carga/caracteristicasBaterias.xml"))
        {
            $instancias = simplexml_load_file("carga/caracteristicasBaterias.xml");
            $this->productos_model->eliminar_caracteristicas_baterias();
            $resultado = 0;
            foreach($instancias as $instancia){
                if (isset($instancia->Referencia))
                {
                    $resultado = $this->productos_model->existeCaracteristicaBateria($instancia->Referencia);

                    if ($resultado == 0){
                        $this->productos_model->inserta_caracteristica_bateria($instancia);
                        $this->totalCaracteristicasBaterias++;
                    }
                    else{
                        $this->productos_model->actualizar_caracteristica_bateria($instancia);
                        $this->totalCaracteristicasBateriasAct++;
                    }
                }
            }
        }
    }

    public function actualizar_clases_bateria()
    {
        if (file_exists("carga/clasesBateria.xml"))
        {
            $instancias = simplexml_load_file("carga/clasesBateria.xml");
            $this->productos_model->eliminar_clase_bateria();
            $resultado = 0;
            foreach($instancias as $instancia){
                if (isset($instancia->Id))
                {
                    $resultado = $this->productos_model->existeClaseBateria($instancia->Id);

                    if ($resultado == 0){
                        $this->productos_model->inserta_clase_bateria($instancia);
                        $this->totalClasesBateria++;
                    }
                    else{
                        $this->productos_model->actualizar_clase_bateria($instancia);
                        $this->totalClasesBateriaAct++;
                    }
                }
            }
        }
    }

    public function actualizar_tipos_bateria()
    {
        if (file_exists("carga/tiposBateria.xml"))
        {
            $instancias = simplexml_load_file("carga/tiposBateria.xml");
            $this->productos_model->eliminar_tipo_bateria();
            $resultado = 0;
            foreach($instancias as $instancia){
                if (isset($instancia->Id))
                {
                    $resultado = $this->productos_model->existeTipoBateria($instancia->Id);

                    if ($resultado == 0){
                        $this->productos_model->inserta_tipo_bateria($instancia);
                        $this->totalTiposBateria++;
                    }
                    else{
                        $this->productos_model->actualizar_tipo_bateria($instancia);
                        $this->totalTiposBateriasAct++;
                    }
                }
            }
        }
    }

    public function actualizar_productos_tipo_bateria()
    {
        if (file_exists("carga/productosTipoBateria.xml"))
        {
            $instancias = simplexml_load_file("carga/productosTipoBateria.xml");
            $this->productos_model->eliminar_producto_tipo_bateria();
            $resultado = 0;
            foreach($instancias as $instancia){
                if (isset($instancia->CodProd))
                {
                    $resultado = $this->productos_model->existeProductoTipoBateria($instancia);

                    if ($resultado == 0){
                        $this->productos_model->inserta_producto_tipo_bateria($instancia);
                        $this->totalProductosTipoBateria++;
                    }
                    else{
                        $this->productos_model->actualizar_producto_tipo_bateria($instancia);
                        $this->totalProductosTipoBateriaAct++;
                    }
                }
            }
        }
    }

    public function actualizar_usos_producto()
    {
        if (file_exists("carga/usosProducto.xml"))
        {
            $instancias = simplexml_load_file("carga/usosProducto.xml");
            $this->productos_model->eliminar_usos_producto();
            $resultado = 0;
            foreach($instancias as $instancia){
                if (isset($instancia->codprod))
                {
                    $resultado = $this->productos_model->existeUsoProducto($instancia);

                    if ($resultado == 0){
                        $this->productos_model->inserta_uso_producto($instancia);
                        $this->totalUsosProducto++;
                    }
                    else{
                        $this->productos_model->actualizar_uso_producto($instancia);
                        $this->totalUsosProductoAct++;
                    }
                }
            }
        }
    }
}