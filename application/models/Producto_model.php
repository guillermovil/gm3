<?php

class Producto_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_producto($prod_code)
    {
        $this->db->select('
            prod_code, prod_code,
            prod_descrip, prod_precio,
            prod_stock, prod_ctrl_stock,
            cat_code, cat_descrip');
        $this->db->from('productos');
        $this->db->join('categorias', 'productos.cat_code = categorias.cat_code');
        return $this->db->get_where(array('prod_code'=>$prod_code))->row_array();
    }
        

    function get_all_productos()
    {
        $this->db->from('productos');
        $this->db->join('categorias', 'productos.cat_code = categorias.cat_code');
        $this->db->order_by('prod_descrip', 'asc');
        return $this->db->get()->result_array();
    }
        

    function insert($params){
        $this->db->insert('productos',$params);
        return true;
    }
    

     function update($prod_code,$params)
    {
        $this->db->where('prod_code',$prod_code);
        if (!$this->db->update('productos',$params)){
            return false;
        }else{
            return true;
        }
    }

    function delete($prod_code)
    {
        return $this->db->delete('socios',array('prod_code'=>$prod_code));
    }


    function all_count()
    {   
        $query = $this
                ->db
                ->select('prod_code')     //para contar filas no hace falta traer todas las columnas
                ->get('productos');
    
        return $query->num_rows();  

    }
    
    function all($limit,$start,$col,$dir)
    {   
       $query = $this
                ->db
                ->select('prod_code, prod_descrip, prod_precio, prod_stock, prod_ctrl_stock, cat_code, cat_descrip')
                ->from('productos');
                ->join('categorias', 'productos.cat_code = categorias.cat_code');
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get();
        
        if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
        
    }
   
    function search($limit,$start,$search,$col,$dir)
    {
        $query = $this
                ->db
                ->select('prod_code, prod_descrip, prod_precio, prod_stock, prod_ctrl_stock, cat_code, cat_descrip')
                ->from('productos');
                ->join('categorias', 'productos.cat_code = categorias.cat_code');                
                ->like('prod_code',$search)
                ->or_like('prod_descrip',$search)
                ->or_like('cat_code',$search)
                ->or_like('cat_descrip',$search)
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get();
        
       
        if($query->num_rows()>0)
        {
            return $query->result();  
        }
        else
        {
            return null;
        }
    }

    function search_count($search)
    {
        $query = $this
                ->db
                ->select('prod_code')
                ->from('productos');
                ->join('categorias', 'productos.cat_code = categorias.cat_code');                
                ->like('prod_code',$search)
                ->or_like('prod_descrip',$search)
                ->or_like('cat_code',$search)
                ->or_like('cat_descrip',$search)
                ->get();
    
        return $query->num_rows();
    } 

    function get_categlista_small()
    {
        $this->db->select('cat_code, cat_descrip');
        $this->db->order_by('cat_descrip', 'asc');
        return $this->db->get('categorias')->result_array();
    }

}

