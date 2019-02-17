<?php
class Board extends CI_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Cuenta_model');
        $this->load->model('Socio_model');

    } 



    public function index()
    {
        //get_details -> act_code, act_nombre, mod_tipo, mod_precio, ins_id, soc_apellido, soc_nombre
        $data['_view'] = 'board/index';
        $data['_dt'] = 'true';
        $data['title'] = 'Panel principal';
        $data['subtitle'] = date('d-m-Y');
        $data['menu0'] = 'boardmenu';
        $data['menu1'] = 'board1';
        $data['caja_stack']=$this->caja_stack(7);
        $this->load->view('layouts/main-vertical',$data);
    }

    public function caja_stack($dias){
        $cs = $this->Cuenta_model->board_caja_stack($dias);
        // echo '<pre>';
        // print_r($cs);
        // echo '</pre>'; 

        $i=0;
        foreach ($cs as $f) {
            $acts=$f['acts'];  //se podría ejecutar una sola vez afuera
            if ($i<$acts) {
                $series[] = $f['act_nombre'];
            }
            if ($i % $acts == 0){
                if($i>0){
                    $y[]=$fila;
                    unset($fila);
                }
                $fila[] = $f["t"]; 
            }
            $fila[] = $f["valor"];
            $i++;       
        }
        $y[]=$fila;

        $csv = join(",", $series);
        $csv = 'Categories,'.$csv . "\n";

        foreach ($y as $y) {
            $csv = $csv . join(",", $y);            
            $csv = $csv . "\n";
        }  
        return $csv;      
    }

    public function tabla_vencimientos(){
        $columns = array( 
			0 =>'soc_apellido',
			1 =>'soc_nombre',
			2 =>'mod_tipo',
			3 =>'act_code',
			4 =>'act_nombre',
			5 =>'ins_id',
			6 =>'ins_vencimiento',
			5 =>'hasta',
			6 =>'dias_vencer',
			7 =>'ult_asistencia'
		);

        $vencimientos = $this->Cuenta_model->vencimientos();
        $data = array();
        if(!empty($vencimientos))
        {
            foreach ($vencimientos as $vt)
            {

				$nestedData['soc_apellido']  =  $vt->soc_apellido;
				$nestedData['soc_nombre']  =  $vt->soc_nombre;
				$nestedData['mod_tipo']  =  $vt->mod_tipo;
                $nestedData['mod_descrip']  =  $vt->mod_descrip;

				$nestedData['act_code']  =  $vt->act_code;
				$nestedData['act_nombre']  =  $vt->act_nombre;
				$nestedData['ins_id']  =  $vt->ins_id;
				$nestedData['ins_vencimiento']  =  $vt->ins_vencimiento;
				$nestedData['hasta']  =  $vt->hasta;
				$nestedData['dias_vencer']  =  $vt->dias_vencer;
				$nestedData['ult_asistencia']  =  $vt->ult_asistencia;
      
                $data[] = $nestedData;
            }
        }
          
        $json_data = array(
                    "draw" => intval($this->input->post('draw')),  
                    "data" => $data   
                    );                
        echo json_encode($json_data); 
    }

    //soc_apellido, soc_nombre, act_nombre, mod_descrip, semana, asistencias
    public function tabla_superan(){
        $columns = array( 
            0 =>'soc_apellido',
            1 =>'soc_nombre',
            2 =>'act_nombre',
            3 =>'mod_descrip',
            4 =>'semana',
            5 =>'asistencias'
        );
        $superan = $this->Cuenta_model->superan();
        $data = array();
        if(!empty($superan))
        {
            foreach ($superan as $vt)
            {

                $nestedData['soc_apellido']  =  $vt->soc_apellido;
                $nestedData['soc_nombre']  =  $vt->soc_nombre;
                $nestedData['act_nombre']  =  $vt->act_nombre;
                $nestedData['mod_descrip']  =  $vt->mod_descrip;
                $nestedData['semana']  =  $vt->semana;
                $nestedData['asistencias']  =  $vt->asistencias;
                $data[] = $nestedData;
            }
        }
          
        $json_data = array(
                    "draw" => intval($this->input->post('draw')),  
                    "data" => $data   
                    );                
        echo json_encode($json_data); 
    }    


    public function tabla_cumples(){
        $columns = array( 
            0 =>'soc_apellido',
            1 =>'soc_nombre',
            2 =>'nacimmiento',
            3 => 'dif'
        );
        $cumples = $this->Socio_model->cumples();
        $data = array();
        if(!empty($cumples))
        {
            foreach ($cumples as $vt)
            {

                $nestedData['soc_apellido']  =  $vt->soc_apellido;
                $nestedData['soc_nombre']  =  $vt->soc_nombre;
                $nestedData['soc_nacimiento']  =  $vt->soc_nacimiento;
                $nestedData['dif']  =  $vt->dif;

                $data[] = $nestedData;
            }
        }
          
        $json_data = array(
                    "draw" => intval($this->input->post('draw')),  
                    "data" => $data   
                    );                
        echo json_encode($json_data); 
    }  


    public function tabla_caja(){
        $columns = array( 
            0 =>'ps_fecha',
            1 =>'ps_created',
            2 =>'concepto_caja',
            3 =>'socio',
            4 =>'actividad',
            5 =>'ps_valor'
        );

        $caja_hoy = $this->Cuenta_model->caja_hoy();
        $data = array();
        if(!empty($caja_hoy))
        {
            foreach ($caja_hoy as $ch)
            {

                $nestedData['ps_fecha']  =  $ch->ps_fecha;
                $nestedData['ps_created']  =  $ch->ps_created;
                $nestedData['concepto_caja']  =  $ch->concepto_caja;
                $nestedData['socio']  =  $ch->socio;

                $nestedData['actividad']  =  $ch->actividad;
                $nestedData['ps_valor']  =  $ch->ps_valor;
      
                $data[] = $nestedData;
            }
        }
          
        $json_data = array(
                    "draw" => intval($this->input->post('draw')),  
                    "data" => $data   
                    );                
        echo json_encode($json_data); 
    }


}

