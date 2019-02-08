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
        $this->db->select("socios.soc_id, actividades.act_code, act_nombre, inscripciones.mod_tipo, mod_precio, mod_descrip, ins_id, soc_apellido, soc_nombre");
        $this->db->from('inscripciones');
        $this->db->join('modalidades', 'inscripciones.act_code = modalidades.act_code and inscripciones.mod_tipo = modalidades.mod_tipo');    
        $this->db->join('actividades', 'actividades.act_code = modalidades.act_code');  
        $this->db->join('socios', 'inscripciones.soc_id = socios.soc_id');  
        $this->db->join('tipomodalidad', 'modalidades.mod_tipo = tipomodalidad.mod_tipo');
        $this->db->where(array('ins_id'=>$ins_id));

        // $sql = $this->db->get_compiled_select('mytable');
        // echo $sql;
        // exit;

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
		$this->db->select("ins_id, soc_id, inscripciones.act_code, act_nombre, inscripciones.mod_tipo, mod_descrip, ins_vencimiento, coalesce(ins_vencimiento,'2100-01-01'::timestamp)::date - CURRENT_DATE as dif");
		$this->db->from('inscripciones');
		$this->db->join('actividades', 'inscripciones.act_code = actividades.act_code');
        $this->db->join('tipomodalidad', 'inscripciones.mod_tipo = tipomodalidad.mod_tipo');
		$this->db->where(array('soc_id'=>$soc_id));
        $this->db->order_by('ins_id','DESC');

		$query = $this->db->get();

        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return null;
        }
    }
    function vigentes($soc_id){   
        $this->db->select("ins_id, soc_id, inscripciones.act_code, act_nombre, inscripciones.mod_tipo, mod_descrip, ins_vencimiento");
        $this->db->from('inscripciones');
        $this->db->join('actividades', 'inscripciones.act_code = actividades.act_code');
        $this->db->join('tipomodalidad', 'inscripciones.mod_tipo = tipomodalidad.mod_tipo');
        $this->db->where('soc_id',$soc_id);
        $this->db->where("(ins_vencimiento is null OR ins_vencimiento >= now())");
        $this->db->order_by('ins_id','DESC');

        $query = $this->db->get();

        if($query->num_rows()>0){
            return $query->result_array(); 
        }else{
            return null;
        }
    }

    function inscxactividad($act_code){   
        $this->db->select("ins_id, ins_vencimiento, socio, documento, actividad, ult_vto, ult_asist");
        $this->db->from('vw_inscripciones');
        $this->db->where(array('act_code'=>$act_code));
        $this->db->where(("ins_vencimiento >= now() OR ins_vencimiento IS null"));
        $this->db->order_by('socio','ASC');

        $query = $this->db->get();

        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return null;
        }
    }

}
