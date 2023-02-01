<?php
class Productos_model extends CI_Model{

	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
    }

    public function eliminar_productos($statur){
        $data = array('Activo' => 'N');

        //$this->db->where('ST',$statur ? 'S' : 'N');
        $this->db->update($this->session->tabla_idiomas == 'S' ? 'productos_ingles' : 'productos',$data);
    }

    public function existeProducto($producto){
        $this->db->from($this->session->tabla_idiomas == 'S' ? 'productos_ingles' : 'productos');
        $this->db->where('CodProd',$producto);

        return $this->db->count_all_results();
    }

    public function inserta_producto($producto,$statur){

        $data = array(
            'CodProd'         => $producto->codprod,
            'CodInst'         => $producto->codinst,
            'Impuesto'        => $producto->impuesto,
            'Marca'           => $producto->marca,
            'Unidad'          => $producto->Unidad,
            'CodigoAux'       => $producto->codigoaux,
            'RefBase'         => $producto->refBase,
            'Precio1'         => $producto->precio1,
            'Precio2'         => $producto->precio2,
            'Precio3'         => $producto->precio3,
            'Precio4'         => $producto->precio4,
            'PrecioInternet'  => $producto->precioInternet,
            'PrecioWA'        => $producto->precioWA,
            'Activo'          => 'S',
            'ST'              => $statur ? 'S' : 'N',
            'EsNuevo'         => $producto->EsNuevo,
            'ImgPrincipal'    => $producto->imgPrincipal,
            'ImgAdicionales'  => $producto->imgAdicional,
            'ImgTexturas'     => $producto->imgTextura,
            'ImgStatur'       => $producto->imgStatur,
            'Existen'         => $producto->Existen
        );

        $this->db->insert($this->session->tabla_idiomas == 'S' ? 'productos_ingles' : 'productos',$data);
     }

     public function actualizar_productos($producto,$statur){
         $data = array(
            'CodInst'         => $producto->codinst,
            'Impuesto'        => $producto->impuesto,
            'Marca'           => $producto->marca,
            'Unidad'          => $producto->Unidad,            
            'CodigoAux'       => $producto->codigoaux,
            'RefBase'         => $producto->refBase,
            'Precio1'         => $producto->precio1,
            'Precio2'         => $producto->precio2,
            'Precio3'         => $producto->precio3,
            'Precio4'         => $producto->precio4,
            'PrecioInternet'  => $producto->precioInternet,
            'PrecioWA'        => $producto->precioWA,            
            'Activo'          => 'S',
            'ST'              => $statur ? 'S' : 'N',
            'EsNuevo'         => $producto->EsNuevo,
            'ImgPrincipal'    => $producto->imgPrincipal,
            'ImgAdicionales'  => $producto->imgAdicional,
            'ImgTexturas'     => $producto->imgTextura,
            'ImgStatur'       => $producto->imgStatur,
            'Existen'         => $producto->Existen
         );

         $this->db->where('CodProd',$producto->codprod);
         $tabla = $this->session->tabla_idiomas == 'S' ? 'productos_ingles' : 'productos';
         $this->db->update($tabla,$data);
     }

     public function eliminar_auxiliares(){
        $data = array('Activo' => 'N');

        $this->db->update('auxiliares_producto',$data);
    }

    public function existeAuxiliar($producto){
        $this->db->from('auxiliares_producto');
        $this->db->where('CodigoAux',$producto);

        return $this->db->count_all_results();
    }

    public function inserta_auxiliar($producto){

        $data = array(
            'CodigoAux'      => $producto->codigoaux,
            'ListaProductos' => $producto->listaProductos,
            'RefBase'        => $producto->refBase,
            'Activo'         => 'S'
        );

        $this->db->insert('auxiliares_producto',$data);
     }

     public function actualizar_auxiliar($producto){
         $data = array(
            'ListaProductos' => $producto->listaProductos,
            'RefBase'        => $producto->refBase,
            'Activo'         => 'S'
         );

         $this->db->where('CodigoAux',$producto->codigoaux);
         $this->db->update('auxiliares_producto',$data);
     }

    public function eliminar_productos_idioma(){
        $data = array('Activo' => 'N');

        $this->db->update('productos_idioma',$data);
    }

    public function inserta_producto_idioma($producto){

        $data = array(
            'CodProd'      => $producto->codprod,
            'Descrip'      => $producto->descrip,
            'Descrip2'     => $producto->descrip2,
            'Descrip3'     => $producto->descrip3,
            'IDIdioma'     => $producto->IDIdioma,
            'DescAmpliada' => $producto->descAmpliada,
            'Activo'       => 'S'
        );

        $this->db->insert('productos_idioma',$data);
     }

     public function actualizar_producto_idioma($producto){
        $data = array(
            'Descrip'      => $producto->descrip,
            'Descrip2'     => $producto->descrip2,
            'Descrip3'     => $producto->descrip3,
            'DescAmpliada' => $producto->descAmpliada,
            'Activo'       => 'S'
        );

        $this->db->where('CodProd', $producto->codprod);
        $this->db->where('IDIdioma',$producto->IDIdioma);
        $this->db->update('productos_idioma',$data);
     }

     public function existe_producto_idioma($producto){
         $this->db->from('productos_idioma');
         $this->db->where('CodProd',$producto->codprod);
         $this->db->where('IDIdioma',$producto->IDIdioma);

         return $this->db->count_all_results();
     }

     public function eliminar_precios_producto(){
        $data = array('Activo' => 'N');

        $this->db->update($this->session->tabla_idiomas == 'S' ? 'precios_producto_ingles' : 'precios_producto',$data);
    }

    public function inserta_precio_producto($producto){

        $data = array(
            'CodProd'          => $producto->CodProd,
            'Precio1'          => $producto->Precio1,
            'Precio2'          => $producto->Precio2,
            'Precio3'          => $producto->Precio3,
            'Precio4'          => $producto->Precio4,
            'PrecioInternet'   => $producto->PrecioInternet,
            'Activo'           => 'S'
        );

        $this->db->insert($this->session->tabla_idiomas == 'S' ? 'precios_producto_ingles' : 'precios_producto',$data);
     }

     public function actualizar_precio_producto($producto){
        $data = array(
            'Precio1'        => $producto->Precio1,
            'Precio2'        => $producto->Precio2,
            'Precio3'        => $producto->Precio3,
            'Precio4'        => $producto->Precio4,
            'PrecioInternet' => $producto->PrecioInternet,
            'Activo'         => 'S'
        );

        $this->db->where('CodProd', $producto->CodProd);
        $this->db->update($this->session->tabla_idiomas == 'S' ? 'precios_producto_ingles' : 'precios_producto',$data);
     }

     public function existe_precio_producto($producto){
         $this->db->from($this->session->tabla_idiomas == 'S' ? 'precios_producto_ingles' : 'precios_producto');
         $this->db->where('CodProd',$producto->CodProd);

         return $this->db->count_all_results();
     }

     public function eliminar_pulsos(){
        $data = array('Activo' => 'N');

        $this->db->update($this->session->tabla_idiomas == 'S' ? 'referencias_manilla_ingles' : 'referencias_manilla',$data);
    }

    public function inserta_pulso($producto){

        $data = array(
            'CodProd'       => $producto->codprod,
            'Descrip'       => $producto->descrip,
            'ListaCalibres' => $producto->calibre,
            'ListaColores'  => $producto->color,
            'ListaPartes'   => $producto->partes,
            'CodInst'       => $producto->codinst,
            'Impuesto'      => $producto->impuesto,
            'Activo'        => 'S'
        );

        $this->db->insert($this->session->tabla_idiomas == 'S' ? 'referencias_manilla_ingles' : 'referencias_manilla',$data);
     }

     public function actualizar_pulso($producto){
        $data = array(
            'Descrip'       => $producto->descrip,
            'ListaCalibres' => $producto->calibre,
            'ListaColores'  => $producto->color,
            'ListaPartes'   => $producto->partes,
            'CodInst'       => $producto->codinst,
            'Impuesto'      => $producto->impuesto,
            'Activo'        => 'S'
        );

        $this->db->where('CodProd', $producto->codprod);
        $this->db->update($this->session->tabla_idiomas == 'S' ? 'referencias_manilla_ingles' : 'referencias_manilla',$data);
     }

     public function existe_pulso($producto){
         $this->db->from($this->session->tabla_idiomas == 'S' ? 'referencias_manilla_ingles' : 'referencias_manilla');
         $this->db->where('CodProd',$producto->codprod);

         return $this->db->count_all_results();
     }

     /******************* Baterías ***************************** */
     public function eliminar_caracteristicas_baterias()
     {
        $this->db->empty_table('tabcaracteristicasbaterias');
     }

     public function existeCaracteristicaBateria($referencia)
     {
         $this->db->from('tabcaracteristicasbaterias');
         $this->db->where('Referencia',$referencia);

         return $this->db->count_all_results();
     }

     public function inserta_caracteristica_bateria($bateria)
     {
        $data = array(
            'Referencia'        => $bateria->Referencia,
            'Descripcion'       => $bateria->Descripcion,
            'Material'          => $bateria->Material,
            'Voltaje'           => $bateria->Voltaje,
            'Diametro'          => $bateria->Diametro,
            'Altura'            => $bateria->Altura,
            'mAh'               => $bateria->mAh,
            'Dimensiones'       => $bateria->Dimensiones,
            'Peso'              => $bateria->Peso,
            'Caracteristicas'   => $bateria->Caracteristicas,
            'Unidad'            => $bateria->Unidad,
            'UnidadWeb'         => $bateria->UnidadWeb,
            'Empaque'           => $bateria->Empaque,
            'EmpaqueWeb'        => $bateria->EmpaqueWeb
        );

        $this->db->insert('tabcaracteristicasbaterias', $data);
     }

     public function actualizar_caracteristica_bateria()
     {
        $data = array(
            'Referencia'        => $bateria->Referencia,
            'Descripcion'       => $bateria->Descripcion,
            'Material'          => $bateria->Material,
            'Voltaje'           => $bateria->Voltaje,
            'Diametro'          => $bateria->Diametro,
            'Altura'            => $bateria->Altura,
            'mAh'               => $bateria->mAh,
            'Dimensiones'       => $bateria->Dimensiones,
            'Peso'              => $bateria->Peso,
            'Caracteristicas'   => $bateria->Caracteristicas,
            'Unidad'            => $bateria->Unidad,
            'UnidadWeb'         => $bateria->UnidadWeb,
            'Empaque'           => $bateria->Empaque,
            'EmpaqueWeb'        => $bateria->EmpaqueWeb
        );

        $this->db->where('Referencia', $bateria->Referencia);
        $this->db->update('tabcaracteristicasbaterias', $data);
     }

     public function eliminar_clase_bateria()
     {
         $this->db->empty_table('tabclasebateria');
     }

     public function existeClaseBateria($id)
     {
        $this->db->from('tabclasebateria');
        $this->db->where('Id',$id);

        return $this->db->count_all_results();
     }

     public function inserta_clase_bateria($clase)
     {
        $data = array(
            'Id'          => $clase->Id,
            'Descrip'     => $clase->Descrip
        );

        $this->db->insert('tabclasebateria', $data);
     }

     public function actualizar_clase_bateria($tipo)
     {
        $data = array(
            'Descrip'     => $tipo->Descrip
        );

        $this->db->where('Id', $tipo->Id);
        $this->db->update('tabtipobateria', $data);
     }

     public function eliminar_tipo_bateria()
     {
         $this->db->empty_table('tabtipobateria');
     }

     public function existeTipoBateria($id)
     {
        $this->db->from('tabtipobateria');
        $this->db->where('Id',$id);

        return $this->db->count_all_results();
     }

     public function inserta_tipo_bateria($tipo)
     {
        $data = array(
            'Id'          => $tipo->Id,
            'Descrip'     => $tipo->Descrip
        );

        $this->db->insert('tabtipobateria', $data);
     }

     public function actualizar_tipo_bateria($tipo)
     {
        $data = array(
            'Descrip'     => $tipo->Descrip
        );

        $this->db->where('Id', $tipo->Id);
        $this->db->update('tabtipobateria', $data);
     }

     public function eliminar_producto_tipo_bateria()
     {
         $this->db->empty_table('tabproductostipobateria');
     }

     public function existeProductoTipoBateria($obj)
     {
        $this->db->from('tabproductostipobateria');
        $this->db->where('Id',$obj->Id);
        $this->db->where('IdTipo',$obj->IdTipo);        

        return $this->db->count_all_results();
     }

     public function inserta_producto_tipo_bateria($obj)
     {
         $data = array(
             'Id'       => $obj->Id,
             'IdTipo'   => $obj->IdTipo,
             'CodProd'  => $obj->CodProd
         );

         $this->db->insert('tabproductostipobateria', $data);
     }

     public function actualizar_producto_tipo_bateria($tipo)
     {
        $data = array(
            'IdTipo'   => $obj->IdTipo,
            'CodProd'  => $obj->CodProd
        );

        $this->db->where('Id', $tipo->Id);
        $this->db->where('IdTipo', $tipo->IdTipo);
        $this->db->update('tabproductostipobateria', $data);
     }

     public function eliminar_usos_producto()
     {
         $this->db->empty_table('tabusosproducto');
     }

     public function existeUsoProducto($obj)
     {
        $this->db->from('tabusosproducto');
        $this->db->where('CodProd',$obj->codprod);
        $this->db->where('Uso',$obj->uso);

        return $this->db->count_all_results();
     }

     public function inserta_uso_producto($obj)
     {
         $data = array(
             'CodProd'  => $obj->codprod,
             'Uso'  => $obj->uso
         );

         $this->db->insert('tabusosproducto', $data);
     }

     public function actualizar_uso_producto($tipo)
     {
        $data = array(
            'CodProd'  => $obj->codprod,
            'Uso'  => $obj->uso
        );

        $this->db->where('CodProd', $tipo->codprod);
        $this->db->where('Uso', $tipo->uso);
        $this->db->update('tabusosproducto', $data);
     }

     /******************* Idioma2 - **** */

     public function eliminar_auxiliares2(){
        $data = array('Activo2' => 'N');

        $this->db->update('auxiliares_producto',$data);
    }

    public function existeAuxiliar2($producto){
        $this->db->from('auxiliares_producto');
        $this->db->where('CodigoAux',$producto);

        return $this->db->count_all_results();
    }

    public function inserta_auxiliar2($producto){

        $data = array(
            'CodigoAux'      => $producto->codigoaux,
            'ListaProductos' => $producto->listaProductos,
            'RefBase'        => $producto->refBase,
            'Activo2'        => 'S'
        );

        $this->db->insert('auxiliares_producto',$data);
     }

     public function actualizar_auxiliar2($producto){
         $data = array(
            'ListaProductos' => $producto->listaProductos,
            'RefBase'        => $producto->refBase,
            'Activo'         => 'S'
         );

         $this->db->where('CodigoAux',$producto->codigoaux);
         $this->db->update('auxiliares_producto',$data);
     }

    public function eliminar_productos_idioma2(){
        $data = array('Activo2' => 'N');

        $this->db->update('productos_idioma',$data);
    }

    public function inserta_producto_idioma2($producto){

        $data = array(
            'CodProd'      => $producto->codprod,
            'Descrip'      => $producto->descrip,
            'Descrip2'     => $producto->descrip2,
            'Descrip3'     => $producto->descrip3,
            'IDIdioma'     => $producto->IDIdioma,
            'DescAmpliada' => $producto->descAmpliada,
            'Activo'       => 'N',
            'Activo2'      => 'S'
        );

        $this->db->insert('productos_idioma',$data);
     }

     public function actualizar_producto_idioma2($producto){
        $data = array(
            'Descrip'      => $producto->descrip,
            'Descrip2'     => $producto->descrip2,
            'Descrip3'     => $producto->descrip3,
            'DescAmpliada' => $producto->descAmpliada,
            'Activo2'      => 'S'
        );

        $this->db->where('CodProd', $producto->codprod);
        $this->db->where('IDIdioma',$producto->IDIdioma);
        $this->db->update('productos_idioma',$data);
     }

     public function existe_producto_idioma2($producto){
         $this->db->from('productos_idioma');
         $this->db->where('CodProd',$producto->codprod);
         $this->db->where('IDIdioma',$producto->IDIdioma);

         return $this->db->count_all_results();
     }

	/*********************** Productos de fábrica ************************* */
	public function lista_productos_fabrica($porpagina,$segmento)
	{
	   $this->db->select('p.CodProd,p.Impuesto,p.Descrip,p.DescAmpliada,p.Precio,p.CodInst');
	   $this->db->from('productos_fabrica AS p');
	   $this->db->order_by('p.CodProd','ASC');

	   $this->db->limit($porpagina,$porpagina*($segmento-1));

	   $query = $this->db->get();
	   return $query->result();
	}

	public function total_productos_fabrica()
	{
		$this->db->from('productos_fabrica AS p');

		return $this->db->count_all_results();
	}


}
