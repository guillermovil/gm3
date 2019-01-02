<?php

 
class Actividad_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }
    
    /*
     * Get actividad by act_code
     */
    function get_actividad($act_code)
    {
        return $this->db->get_where('actividades',array('act_code'=>$act_code))->row_array();
    }
        
    /*
     * Get all actividades
     */
    function get_all_actividades()
    {
        $this->db->order_by('act_code', 'desc');
        return $this->db->get('actividades')->result_array();
    }
        
    /*
     * function to add new actividad
     */
    function insert($params)
    {
        $this->db->insert('actividades',$params);
        return true;
    }
    
    /*
     * function to update actividad
     */
    function update($act_code,$params)
    {
        $this->db->where('act_code',$act_code);
        return $this->db->update('actividades',$params);
    }
    
    /*
     * function to delete actividad
     */
    function delete($act_code)
    {
        return $this->db->delete('actividades',array('act_code'=>$act_code));
    }


    // Función para el uso de datatables del lado del cliente
    function all()
    {   
       $query = $this
                ->db
                ->get('actividades');
        if($query->num_rows()>0)
        {
            return $query->result(); 
        }else
        {
            return null;
        }
    }
}
