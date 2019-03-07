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
                ->select('soc_id, soc_tipodoc, soc_nrodoc, soc_apellido, soc_nombre, soc_email')
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get('socios');
        
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
                ->select('soc_id, soc_tipodoc, soc_nrodoc, soc_apellido, soc_nombre, soc_email')
                ->like('soc_apellido',$search)
                ->or_like('soc_nombre',$search)
                ->or_like('soc_email',$search)
                ->or_like('soc_nrodoc',$search)
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get('socios');
        
       
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
                ->select('soc_id') //para contar filas no hace falta traer todas las columnas
                ->like('soc_apellido',$search)
                ->or_like('soc_nombre',$search)
                ->or_like('soc_email',$search)
                ->get('socios');
    
        return $query->num_rows();
    } 



    function cumples()
    {   
       $query = $this
                ->db
                ->select("soc_apellido, soc_nombre, soc_nacimiento, abs(current_date - make_date(date_part('year',CURRENT_DATE)::int, date_part('month',soc_nacimiento)::int,  date_part('day',soc_nacimiento)::int)) dif")
                ->where("abs(current_date - make_date(date_part('year',CURRENT_DATE)::int, date_part('month',soc_nacimiento)::int,  date_part('day',soc_nacimiento)::int)) < 2")
                ->order_by("4","ASC")
                ->get('socios');
        
        if($query->num_rows()>0)
        {
            return $query->result(); 
        }
        else
        {
            return null;
        }
        
    }
    function insertAsi($params){
        
        if (!$this->db->insert('asistencia',$params)) {
            return false;
        }else{
            return true;
        }
    }
    function asistencia($soc_id){   

        $this->db->select("a.asi_id, a.asi_fecha, a1.act_nombre||' '||t.mod_descrip as act_nombre");
        $this->db->from('asistencia a');
        $this->db->join('inscripciones i', 'a.ins_id = i.ins_id');
        $this->db->join('modalidades m1', 'i.act_code = m1.act_code AND i.mod_tipo = m1.mod_tipo');
        $this->db->join('tipomodalidad t', 'm1.mod_tipo = t.mod_tipo');
        $this->db->join('actividades a1', 'm1.act_code = a1.act_code');

        $this->db->where(array('soc_id'=>$soc_id));
        $this->db->order_by('asi_fecha','DESC');
        $this->db->limit(100);


        $query = $this->db->get();

        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return null;
        }
    }

}

