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

        $sql = "INSERT INTO public.socios(
            soc_tipodoc, 
            soc_nrodoc, soc_apellido, 
            soc_nombre, soc_domicilio, 
            soc_foto, soc_nacimiento, 
            soc_created, soc_telefono, 
            soc_email)
        VALUES (
            {$this->db->escape($data['soc_tipodoc'])},
            {$this->db->escape($data['soc_nrodoc'])},
            {$this->db->escape($data['soc_apellido'])},
            {$this->db->escape($data['soc_nombre'])},
            {$this->db->escape($data['soc_domicilio'])},
            decode('{$data['soc_foto']}' , 'hex'),
            {$this->db->escape($data['soc_nacimiento'])},
            now(),
            {$this->db->escape($data['soc_telefono'])},
            {$this->db->escape($data['soc_email'])}
        )";
        //echo $sql;       debug query
        $this->db->query($sql);
        return $this->db->insert_id();
    }
    
    public function foto($soc_id)
    {
        $sql = "SELECT coalesce(encode(soc_foto, 'base64'),'sf') AS soc_foto FROM socios WHERE soc_id = $soc_id";
        $query = $this->db->query($sql);
        $row = $query->row();
        return $row->soc_foto;
    }

    function update($data)
    {

        $sql = "UPDATE socios SET
                    soc_tipodoc =  {$this->db->escape($data['soc_tipodoc'])},
                    soc_nrodoc =  {$this->db->escape($data['soc_nrodoc'])},
                    soc_apellido =  {$this->db->escape($data['soc_apellido'])},
                    soc_nombre =  {$this->db->escape($data['soc_nombre'])},
                    soc_domicilio =  {$this->db->escape($data['soc_domicilio'])},
                    soc_nacimiento =  {$this->db->escape($data['soc_nacimiento'])},
                    soc_telefono =  {$this->db->escape($data['soc_telefono'])},
                    soc_email =         {$this->db->escape($data['soc_email'])}
                WHERE
                    soc_id = {$data['soc_id']};";
        echo $sql;       //debug query
        $this->db->query($sql);
        return $data['soc_id'];
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

