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

    function update($act_code,$mod_tipo, $params)
    {
        $this->db->where(array('act_code'=>$act_code, 'mod_tipo'=>$mod_tipo ));
        if (!$this->db->update('modalidades',$params)){
            return false;
        }else{
            return true;
        }
    }

    function updPrecio($act_code,$porcentaje)
    {

        $this->db->set('mod_precio', 'mod_precio * '.$porcentaje, FALSE);
        $this->db->where(array('act_code'=>$act_code));
        if (!$this->db->update('modalidades')){
            return false;
        }else{
            return true;
        }
    }
 
    function updPrecioAll($porcentaje)
    {
        $this->db->set('mod_precio', 'mod_precio * '.$porcentaje, FALSE);
        if (!$this->db->update('modalidades')){
            return false;
        }else{
            return true;
        }
    }

    function delete($act_code, $mod_tipo){
        if (!$this->db->delete('modalidades',array('act_code'=>$act_code, 'mod_tipo'=>$mod_tipo))) {
            return false;
        }else{
            return true;
        }
    }


    function get_tmodalidad_small()
    {
        $this->db->select('mod_tipo, mod_descrip');
        $this->db->order_by('mod_descrip', 'asc');
        return $this->db->get('tipomodalidad')->result_array();
    }

    function all($act_code){   
        $this->db->from('modalidades');
        $this->db->join('tipomodalidad', 'modalidades.mod_tipo = tipomodalidad.mod_tipo');    
        $this->db->where(array('act_code'=>$act_code));
        $query = $this->db->get();

        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return null;
        }
    }
}
