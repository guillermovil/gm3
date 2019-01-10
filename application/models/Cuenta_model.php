<?php

 
class Cuenta_model extends CI_Model
{
    function __construct(){
        parent::__construct();
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
    function all($ins_id){   
		$this->db->where(array('ins_id'=>$ins_id));
        $this->db->order_by('ps_desde','DESC');

		$query = $this->db->get();

        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return null;
        }
    }
}
