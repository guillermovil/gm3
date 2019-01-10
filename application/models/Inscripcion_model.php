<?php

 
class Inscripcion_model extends CI_Model
{
    function __construct(){
        parent::__construct();
    }
    
    function get_apelnom($soc_id){
        $this->db->select("coalesce(soc_apellido,'')||' '||coalesce(soc_nombre,'') as apelnom");
        $query=$this->db->get_where('socios',array('soc_id'=>$soc_id));
        return $query->result()[0]->apelnom;
    }
        

    function get_details($ins_id){
        $this->db->select("socios.soc_id, actividades.act_code, act_nombre, inscripciones.mod_tipo, mod_precio, ins_id, soc_apellido, soc_nombre");
        $this->db->from('inscripciones');
        $this->db->join('modalidades', 'inscripciones.act_code = modalidades.act_code and inscripciones.mod_tipo = modalidades.mod_tipo');    
        $this->db->join('actividades', 'modalidades.act_code = modalidades.act_code');  
        $this->db->join('socios', 'inscripciones.soc_id = socios.soc_id');  
        $this->db->where(array('ins_id'=>$ins_id));
        $query = $this->db->get();

        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return null;
        }       
    }

    function insert($params){
        
        if (!$this->db->insert('inscripciones',$params)) {
            return false;
        }else{
            return true;
        }


        return true;
    }
    
    function delete($ins_id){
        if (!$this->db->delete('inscripciones',array('ins_id'=>$ins_id))) {
            return false;
        }else{
            return true;
        }
    }


    function close($ins_id)
    {
        $sql = "UPDATE inscripciones SET
                    ins_vencimiento = now()
                WHERE
                    ins_id = {$ins_id};";
        //echo $sql;       //debug query
        //exit;

        if (!$this->db->query($sql)) {
            return false;
        }else{
            return true;
        }        
    }




    // ins_id
    // soc_id
    // act_code
    // act_nombre
    // mod_tipo
    // mod_tipo
    // ins_vencimiento
    function all($soc_id){   
		$this->db->select("ins_id, soc_id, inscripciones.act_code, act_nombre, mod_tipo, ins_vencimiento, coalesce(ins_vencimiento,'2100-01-01'::timestamp)::date - CURRENT_DATE as dif");
		$this->db->from('inscripciones');
		$this->db->join('actividades', 'inscripciones.act_code = actividades.act_code');
		$this->db->where(array('soc_id'=>$soc_id));
        $this->db->order_by('ins_id','DESC');

		$query = $this->db->get();

        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return null;
        }
    }
}
