<?php
class Instancias_model extends CI_Model{
	
	public function __construct()
	{
		parent::__construct();
		$this->load->library('session');
    }
    
    public function eliminar_instancias(){
        //$data = array('Activo' => 'N');
        
        $this->db->empty_table('categorias');//,$data);
    }

    public function existeInstancia($instancia){
        $this->db->from('categorias');
        $this->db->where('CodInst',$instancia);

        return $this->db->count_all_results();
    }

    public function inserta_instancia($instancia){
     
        $data = array(
            'CodInst'       => $instancia->codinst,
            'InsPadre'      => $instancia->inspadre,
            'Nivel'         => $instancia->nivel,
            'InstanciaBase' => $instancia->instanciabase,
            'EsPulso'       => $instancia->snpulso,
            'EsBateria'     => $instancia->snbateria
        );

        $this->db->insert('categorias',$data);
     }

     public function actualizar_instancia($instancia){
         $data = array(
             'InsPadre' => $instancia->inspadre,
             'Nivel' => $instancia->nivel,
             'InstanciaBase' => $instancia->instanciabase,
             'EsPulso'     => $instancia->snpulso
         );

         $this->db->where('CodInst',$instancia->codinst);
         $this->db->update('categorias',$data);
     }

     public function eliminar_instancias_idioma(){
        $data = array('Activo' => 'N');
        
        $this->db->update('categorias_idioma',$data);
    }

    public function inserta_instancia_idioma($instancia){
     
        $data = array(
            'CodInst'  => $instancia->codinst,
            'Descrip'  => $instancia->descrip,
            'IDIdioma' => $instancia->IDIdioma
        );

        $this->db->insert('categorias_idioma',$data);
     }

     public function actualizar_instancia_idioma($instancia){
        $data = array(
            'Descrip' => $instancia->descrip,
        );

        $this->db->where('CodInst', $instancia->codinst);
        $this->db->where('IDIdioma',$instancia->IDIdioma);
        $this->db->update('categorias_idioma',$data);
     }

     public function existe_instancia_idioma($instanci){
         $this->db->from('categorias_idioma');
         $this->db->where('CodInst',$instanci->codinst);
         $this->db->where('IDIdioma',$instanci->IDIdioma);

         return $this->db->count_all_results();
     }

     /************************ idioma2 ********************** */
     public function eliminar_instancias2(){
        //$data = array('Activo' => 'N');
        
        $this->db->empty_table('categorias_ingles');//,$data);
    }

    public function existeInstancia2($instancia){
        $this->db->from('categorias_ingles');
        $this->db->where('CodInst',$instancia);

        return $this->db->count_all_results();
    }

    public function inserta_instancia2($instancia){
     
        $data = array(
            'CodInst' => $instancia->codinst,
            'InsPadre' => $instancia->inspadre,
            'Nivel' => $instancia->nivel,
            'InstanciaBase' => $instancia->instanciabase,
            'EsPulso'   => $instancia->snpulso
        );

        $this->db->insert('categorias_ingles',$data);
     }

     public function actualizar_instancia2($instancia){
         $data = array(
             'InsPadre' => $instancia->inspadre,
             'Nivel' => $instancia->nivel,
             'InstanciaBase' => $instancia->instanciabase,
             'EsPulso'     => $instancia->snpulso
         );

         $this->db->where('CodInst',$instancia->codinst);
         $this->db->update('categorias_ingles',$data);
     }
}