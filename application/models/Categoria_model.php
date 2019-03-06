<?php

 
class Categoria_model extends CI_Model
{
    function __construct(){
        parent::__construct();
    }
    

    function get_categoria($cat_code){
        return $this->db->get_where('categorias',array('cat_code'=>$cat_code))->row_array();
    }
        
    function get_all_categorias() {
        $this->db->order_by('cat_code', 'asc');
        return $this->db->get('categorias')->result_array();
    }


    function get_categorias_small(){
        $this->db->select('cat_code, cat_descrip');
        $this->db->order_by('cat_descrip', 'asc');
        return $this->db->get('categorias')->result_array();
    }
    
    function insert($params){
        $this->db->insert('categorias',$params);
        return true;
    }
    
    function update($cat_code,$params)
    {
        $this->db->where('cat_code',$cat_code);
        if (!$this->db->update('categorias',$params)){
            return false;
        }else{
            return true;
        }
    }
    
    /*
     * function to delete categoria.
     * Este tipo de control funciona si el ambiente es de producción
     * el cual se configura dentro del index del sitio.
     */
    function delete($cat_code)
    {
        if (!$this->db->delete('categorias',array('cat_code'=>$cat_code))){
            return false;
        }else{
            return true;
        };
    }


    // Función para el uso de datatables del lado del cliente
    function all()
    {   
       $query = $this->db
                ->order_by('cat_descrip', 'asc')
                ->get('categorias');
        if($query->num_rows()>0)
        {
            return $query->result(); 
        }else
        {
            return null;
        }
    }
}
