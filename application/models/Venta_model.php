<?php
/*

  vta_nro integer
  vta_comprob integer,
  vta_fecha timestamp
  soc_id integer,
  vta_cliente text

*/
class Venta_model extends CI_Model
{
    function __construct()
    {
        parent::__construct();
    }

    function get_last_venta()
    {
        $query = $this->db->query('SELECT last_value FROM ventas_vta_nro_seq;');
        foreach ($query->result() as $row){
                $last_value =  $row->last_value;
        }
        return $last_value;
    }

    function get_venta($vta_nro)
    {
        $this->db->select('
            vta_nro,
            vta_comprob,
            vta_fecha,
            soc_id,
            vta_cliente,
            soc_apellido,
            soc_nombre');
        $this->db->from('ventas');
        $this->db->join('socios', 'ventas.soc_id = socios.soc_id','left');
        $this->db->where('vta_nro',$vta_nro);
        return $this->db->get()->row_array();
    }
        

    function get_all_ventas()
    {
        $this->db->from('ventas');
        $this->db->join('socios', 'ventas.soc_id = socios.soc_id','left');
        $this->db->order_by('vta_nro','asc');
        return $this->db->get()->result_array();
    }
        

    function insert($params){
        datos[] array();
        vta_comprob = $params['vta_comprob'];
        vta_fecha = $params['vta_fecha']; 
        soc_id = $params['soc_id']; 
        vta_cliente = $params['vta_cliente']; 

        if ($this->db->insert('ventas',$params)){
            $insert_id = $this->db->insert_id();
            return $insert_id;
        }else{
            return false;
        }
    }
    

     function update($vta_nro,$params)
    {
        $this->db->where('vta_nro',$vta_nro);
        if (!$this->db->update('vta_nro',$params)){
            return false;
        }else{
            return true;
        }
    }


    function delete($vta_nro){
        if (!$this->db->delete('ventas',array('vta_nro'=>$vta_nro))) {
            return false;
        }else{
            return true;
        }
    }

    function all_count()
    {   
        $query = $this
                ->db
                ->select('vta_nro')     //para contar filas no hace falta traer todas las columnas
                ->get('ventas');
        return $query->num_rows();  
    }
    
    function all($limit,$start,$col,$dir)
    {   
       $query = $this
                ->db
                ->select('vta_nro, vta_comprob, vta_fecha, soc_id, vta_cliente, soc_apellido, soc_nombre')
                ->from('ventas')
                ->join('socios', 'ventas.soc_id = socios.soc_id','left')
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get();
        
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return null;
        }
    }
   
    function search($limit,$start,$search,$col,$dir)
    {
        $query = $this
                ->db
                ->select('vta_nro, vta_comprob, vta_fecha, soc_id, vta_cliente, soc_apellido, soc_nombre')
                ->from('ventas')
                ->join('socios', 'ventas.soc_id = socios.soc_id','left')
                ->or_where('vta_nro',$search)
                ->or_where('vta_comprob',$search)
                ->or_like('vta_cliente',$search)
                ->or_like('soc_apellido',$search)
                ->or_like('soc_nombre',$search)
                ->limit($limit,$start)
                ->order_by($col,$dir)
                ->get();
        
       
        if($query->num_rows()>0){
            return $query->result();  
        }else{
            return null;
        }
    }

    function search_count($search)
    {
        $query = $this
                ->db
                ->select('vta_nro')
                ->from('ventas')
                ->join('socios', 'ventas.soc_id = socios.soc_id','left')
                ->or_where('vta_nro',$search)
                ->or_where('vta_comprob',$search)
                ->or_like('vta_cliente',$search)
                ->or_like('soc_apellido',$search)
                ->or_like('soc_nombre',$search)
                ->get();
        return $query->num_rows();
    } 
}

