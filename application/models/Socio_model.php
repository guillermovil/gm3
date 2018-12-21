<?php

class Socio_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_socio($soc_id)
    {
        return $this->db->get_where('socios',array('soc_id'=>$soc_id))->row_array();
    }
        

    function get_all_socios()
    {
        $this->db->order_by('soc_apellido', 'asc');
        return $this->db->get('socios')->result_array();
    }
    public function insert($data) {
        $this->db->insert('socios', $data);
        return $this->db->insert_id();
    }
    
    function update_socio($soc_id,$params)
    {
        $this->db->where('soc_id',$soc_id);
        return $this->db->update('socios',$params);
    }

    function delete($soc_id)
    {
        return $this->db->delete('socios',array('soc_id'=>$soc_id));
    }

    function all_count()
    {   
        $query = $this
                ->db
                ->select('soc_id')     //para contar filas no hace falta traer todas las columnas
                ->get('socios');
    
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
   


}

