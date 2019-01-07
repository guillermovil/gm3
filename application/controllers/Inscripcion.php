
<?php
class Inscripcion extends CI_Controller{

    // ins_id integer
    // soc_id integer
    // act_code text
    // mod_tipo text
    // ins_vencimiento

    function __construct()
    {
        parent::__construct();
        $this->load->model('Inscripcion_model');
    } 

    private function set_rules()
    {
        $this->form_validation->set_rules('act_codigo', 'Actividad', 'required|alpha_numeric');
        $this->form_validation->set_rules('mod_tipo', 'Modalidad', 'required|alpha_numeric');
    }
    public function index($soc_id)
    {
        $data['_view'] = 'inscripcion/index';
        $data['_dt'] = 'true';
        $data['title'] = 'Inscripciones del socio';
        $data['subtitle'] = $this->Inscripcion_model->get_apelnom($soc_id);
        $data['soc_id'] = $soc_id;
        $this->load->view('layouts/main-vertical',$data);
    }

    private function tipo($dato){
        $nombre = $dato;
        switch ($dato) {
            case "d":
                $nombre = "Diario";
                break;
            case "m2":
                $nombre = "Mensual 2 x semana";
                break;
            case "m3":
                $nombre = "Mensual 3 x semana";
                break;
            case "m6":
                $nombre = "Mensual todos los días";
                break;
            case "s":
                $nombre = "Semanal";
                break;
        }
        return $nombre;        
    }

    public function tabla($soc_id){
            $columns = array( 
								0 =>'ins_id',
								1 =>'soc_id',
								2 =>'act_code',
								3 =>'mod_tipo',
								4 =>'ins_vencimiento'
                            );

            $inscripciones = $this->Inscripcion_model->all($soc_id);
            $data = array();
            if(!empty($inscripciones))
            {
                foreach ($inscripciones as $ins)
                {

					$nestedData['ins_id'] = 	$ins->ins_id;
					$nestedData['soc_id'] = 	$ins->soc_id;
					$nestedData['act_code'] = 	$ins->act_code;
					$nestedData['act_nombre'] = $ins->act_nombre;
					$nestedData['mod_tipo'] = 	$ins->mod_tipo;
					$nestedData['mod_nombre'] = $this->tipo($ins->mod_tipo);
					$nestedData['ins_vencimiento'] = $ins->ins_vencimiento;
          
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

