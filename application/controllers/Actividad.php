<?php
class Actividad extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Actividad_model');
    } 

    function index()
    {
        $data['actividades'] = $this->Actividad_model->get_all_actividades();
        $data['_view'] = 'actividad/index';
        $data['_dt'] = 'true';
        $data['title'] = 'Actividades';
        $data['subtitle'] = 'Listado general';
        $this->load->view('layouts/main-vertical',$data);
    }

    public function tabla()
    {

            $columns = array( 
                                0 =>'act_code', 
                                1 =>'act_nombre'
                            );

            $actividades = $this->Actividad_model->all();
            $data = array();
            if(!empty($actividades))
            {
                foreach ($actividades as $act)
                {

                    $nestedData['act_code'] = $act->act_code;
                    $nestedData['act_nombre'] = $act->act_nombre;                   
                    $data[] = $nestedData;
                }
            }
              
            $json_data = array(
                        "draw"            => intval($this->input->post('draw')),  
                        "data"            => $data   
                        );
                
            echo json_encode($json_data); 
    }

}

