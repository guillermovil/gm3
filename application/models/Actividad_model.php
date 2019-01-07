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


    function get_actividades_small()
    {
        $this->db->select('act_code, act_nombre');
        $this->db->order_by('act_nombre', 'asc');
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
        if (!$this->db->update('actividades',$params)){
            return false;
        }else{
            return true;
        }
    }
    
    /*
     * function to delete actividad.
     * Este tipo de control funciona si el ambiente es de producción
     * el cual se configura dentro del index del sitio.
     */
    function delete($act_code)
    {
        if (!$this->db->delete('actividades',array('act_code'=>$act_code))){
            return false;
        }else{
            return true;
        };
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
