<?php

 
class Modalidad_model extends CI_Model
{
    function __construct(){
        parent::__construct();
    }
    
    function get_modalidad($act_code, $mod_tipo){
        return $this->db->get_where('modalidades',array('act_code'=>$act_code, 'mod_tipo'=>$mod_tipo ))->row_array();
    }
        

    function insert($params){
        $this->db->insert('modalidades',$params);
        return true;
    }
    
    function delete($act_code, $mod_tipo){
        return $this->db->delete('modalidades',array('act_code'=>$act_code, 'mod_tipo'=>$mod_tipo));
    }

    function all($act_code){   
       $query = $this->db->get_where('modalidades',array('act_code'=>$act_code));
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return null;
        }
    }
}
