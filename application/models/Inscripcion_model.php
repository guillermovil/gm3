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
        

    function insert($params){
        $this->db->insert('inscripciones',$params);
        return true;
    }
    
    function delete($act_code, $mod_tipo){
        if (!$this->db->delete('modalidades',array('act_code'=>$act_code, 'mod_tipo'=>$mod_tipo))) {
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
		$this->db->select('ins_id, soc_id, inscripciones.act_code, act_nombre, mod_tipo, ins_vencimiento');
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
