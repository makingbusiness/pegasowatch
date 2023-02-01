<?php
class Geograficas_model extends CI_Model{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
    }
    
    /******* Países ******************/
    public function eliminar_paises(){
//        $data = array('Activo' => 'N');
        
        $this->db->empty_table('paises');//,$data);
    }

    public function existePais($pais){
        $this->db->from('paises');
        $this->db->where('IDPais',$pais);

        return $this->db->count_all_results();
    }

    public function inserta_pais($pais){
     
        $data = array(
            'IDPais'  => $pais->Pais,
            'Descrip' => $pais->Descrip,
            'Activo'  => 'S'
        );

        $this->db->insert('paises',$data);
     }

     public function actualizar_pais($pais){
         $data = array(
             'Descrip' => $pais->Descrip,
             'Activo'  => 'S'
         );

         $this->db->where('IDPais',$pais->Pais);
         $this->db->update('paises',$data);
     }

    /******* Estados ******************/
    public function eliminar_estados(){
        //$data = array('Activo' => 'N');
        
        $this->db->empty_table('estados');//,$data);
    }

    public function existeEstado($estado){
        $this->db->from('estados');
        $this->db->where('IDEstado',$estado->IDEstado);
        $this->db->where('IDPais',$estado->IDPais);

        return $this->db->count_all_results();
    }

    public function inserta_estado($estado){
     
        $data = array(
            'IDPais'    => $estado->Pais,
            'IDEstado'  => $estado->Estado,
            'Descrip'   => $estado->Descrip,
            'Activo'    => 'S'
        );

        $this->db->insert('estados',$data);
     }

     public function actualizar_estado($estado){
         $data = array(
             'IDPais'  => $estado->Pais,
             'Descrip' => $estado->Descrip,
             'Activo'  => 'S'
         );

         $this->db->where('IDEstado',$estado->Estado);
         $this->db->update('estados',$data);
     }

    /******* Ciudades ******************/
    public function eliminar_ciudades(){
        //$data = array('Activo' => 'N');
        
        $this->db->empty_table('ciudades');//,$data);
    }

    public function existeCiudad($ciudad){
        $this->db->from('ciudades');
        $this->db->where('IDCiudad',$ciudad->IDCiudad);
        $this->db->where('IDEstado',$ciudad->IDEstado);
        $this->db->where('IDPais',$ciudad->IDPais);

        return $this->db->count_all_results();
    }

    public function inserta_ciudad($ciudad){
     
        if ($this->existeCiudad($ciudad->Ciudad) == 0)
        {
            $data = array(
                'IDPais'    => $ciudad->Pais,
                'IDEstado'  => $ciudad->Estado,
                'IDCiudad'  => $ciudad->Ciudad,
                'Descrip'   => $ciudad->Descrip,
                'Activo'    => 'S'
            );
    
            $this->db->insert('ciudades',$data);
        }
     }

     public function actualizar_ciudad($ciudad){
         $data = array(
             'IDPais'    => $ciudad->Pais,
             'IDEstado'  => $ciudad->Estado,
             'Descrip'   => $ciudad->Descrip,
             'Activo'    => 'S'
         );

         $this->db->where('IDCiudad',$ciudad->Ciudad);
         $this->db->update('ciudades',$data);
     }     
}