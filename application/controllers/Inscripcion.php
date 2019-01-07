
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
        $this->load->model('Actividad_model');
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

    public function addInscripcion($soc_id) {
        $this->load->helper(array('form', 'url'));
        $data['_view'] = 'inscripcion/add-inscripcion';
        $data['title'] = 'Inscripciones';
        $data['subtitle'] = $this->Inscripcion_model->get_apelnom($soc_id);
        $data['soc_id'] = $soc_id;
        $actividades = $this->Actividad_model->get_actividades_small();   
        $opc = array();
        $opc['0']='Seleccione actividad';
		foreach ($actividades as $act) {
			$opc[($act['act_code'])] = $act['act_nombre'];
		} 
		$data['actividades'] = $opc;
        $this->load->view('layouts/main-vertical',$data);
    }

    public function modalidades(){
        $actividades = $this->Actividad_model->get_modalidades_small($this->input->post('act_code'));
        $cadena="<select id='mod_tipo' class='form-control'>";
        if (!$actividades or count($actividades)==0){
			$cadena=$cadena."<option value='0'>Debe crear las modalidades de la actividad</option>";
        }else{
		foreach ($actividades as $act) {
			$cadena=$cadena."<option value='{$act['mod_tipo']}'>{$this->tipo(($act['mod_tipo']))}</option>";
		}         	
        }

		$cadena=$cadena."</select>";
		echo $cadena;
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
                    "draw" => intval($this->input->post('draw')),  
                    "data" => $data   
                    );                
        echo json_encode($json_data); 
    }
}

