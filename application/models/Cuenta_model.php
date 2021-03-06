<?php

 
class Cuenta_model extends CI_Model
{
    function __construct(){
        parent::__construct();
    }
    

    function insert($params){
        
        if (!$this->db->insert('pagossocios',$params)) {
            return false;
        }else{
            return true;
        }


        return true;
    }
    
    function delete($ins_id,$ps_perdesde){
        if (!$this->db->delete('pagossocios',array('ins_id'=>$ins_id, 'ps_perdesde'=>$ps_perdesde))) {
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
    function get_mpago_small()
    {
        $this->db->select('mp_code, mp_descrip');
        $this->db->order_by('mp_descrip', 'asc');
        return $this->db->get('mediospago')->result_array();
    }

    function estadogral($ins_id)   {
        //contar cuantas cuotas sin vencer tiene el nro de inscripción
        $sql = "select 
            count(ins_id) cuenta
            from
                inscripciones i
                left join pagossocios p using (ins_id)
            where 
                ins_id = $ins_id
                and p.ps_perhasta > current_timestamp";
        $query = $this->db->query($sql);
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return null;
        }
    }

    function proxper($ins_id)   {
        //contar cuantas cuotas sin vencer tiene el nro de inscripción
        $sql = "select 
        		(max(ps_perhasta) + interval '1 day')::date desde,
        		(max(ps_perhasta) + interval '1 month')::date hasta 
        	from pagossocios 
        	where ins_id = $ins_id";
        $query = $this->db->query($sql);
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return null;
        }
    }

    function all($ins_id){   
		$this->db->where(array('ins_id'=>$ins_id));
        $this->db->order_by('ps_perdesde','DESC');

		$query = $this->db->get('pagossocios');

        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return null;
        }
    }

    function vencimientos(){   
        $this->db->order_by('dias_vencer','DESC');

		$query = $this->db->get('vw_board_vencimientos');

        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return null;
        }
    }

    function superan(){   
        $this->db->select('soc_apellido, soc_nombre, act_nombre, mod_descrip, semana, asistencias');
        $this->db->where('asistencias > mod_xsemana');
        $this->db->order_by('semana','DESC');
        $query = $this->db->get('vw_board_asisxsemana');

        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return null;
        }
    }  


   function board_caja_stack($dias)   {
   		$dias = $dias - 1;
        $sql = "select 
            trim(act_nombre) as act_nombre,
            t::date,
                (
                select coalesce(sum(ps_valor),0)
                from pagossocios inner join inscripciones using(ins_id)
                where ps_fecha::date = t::date and inscripciones.act_code = actividades.act_code
                ) valor,
                count (act_code) over(partition by t) + 1 as acts
            from
                actividades, 
                generate_series((current_date - 7)::timestamp,(current_date)::timestamp,'1 day') t

            union all

            select 
                'ventas' as act_nombre,  
                t::date,
                (
                    select coalesce (sum(dv_precio*dv_cant),0)
                    from 
                        ventas v
                        inner join detventas d on v.vta_nro = d.vta_nro 
                    where
                        vta_fecha::date = t::date

                ) valor, 7 as acts
            from 
                generate_series((current_date - 7)::timestamp,(current_date)::timestamp,'1 day') t

            order by 2,1";

        $query = $this->db->query($sql);
        if($query->num_rows()>0){
            return $query->result_array(); 
        }else{
            return null;
        }
    }  

    function caja_hoy(){   

        $sql = "select 
            ps_fecha, ps_created, 'PS' concepto_caja, socios.soc_apellido||', '|| socios.soc_nombre socio, act_nombre actividad,  ps_valor
            from 
                pagossocios 
                inner join inscripciones using(ins_id)
                inner join actividades using(act_code)
                inner join socios using(soc_id)
            where ps_fecha::date >= current_date

            union all

            select 
                vta_fecha, vta_fecha, 'VTA' concepto_caja, 
                coalesce(soc_apellido||', '|| soc_nombre ,vta_cliente) socio, 
                '-' actividad, 
                sum(dv_cant*dv_precio) ps_valor 
            from 
                ventas v 
                inner join detventas d using(vta_nro) 
                left join socios s on v.soc_id=s.soc_id 
            where
                vta_fecha::date >= current_date
            group by 1,2,3,4,5

            order by 1 desc, 2 desc";

        $query = $this->db->get('vw_board_vencimientos');

        $query = $this->db->query($sql);
        if($query->num_rows()>0){
            return $query->result(); 
        }else{
            return null;
        }
    }
}
