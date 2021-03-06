
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
        if($this->session->userdata('logged_in') !== TRUE){
            $this->session->set_userdata('url', current_url());
            redirect('login');
        } else {
            $this->load->model('Inscripcion_model');
            $this->load->model('Actividad_model');
        }
    } 


    public function select_check($str){
        if ($str == '0' or $str==''){
            $this->form_validation->set_message('select_check', '{field}: Debe seleccionar una opción');
            return false;
        }else{
            return true;
        }
    }

    private function set_rules()
    {
        $this->form_validation->set_rules('act_code', 'Actividad', 'callback_select_check');
        $this->form_validation->set_rules('mod_tipo', 'Modalidad', 'callback_select_check');
    }

    private function sinonull($dato){
        if ($dato == ''){
            return null;
        }else{
            return $dato;
        }
    }


    public function index($soc_id)
    {
        $data['_view'] = 'inscripcion/index';
        $data['_dt'] = 'true';
        $data['title'] = 'Inscripciones del socio';
        $data['subtitle'] = $this->Inscripcion_model->get_apelnom($soc_id);
        $data['soc_id'] = $soc_id;
        $data['menu0'] = 'activmenu';
        $data['menu1'] = 'activlista';        
        $this->load->view('layouts/main-vertical',$data);
    }

    public function index_inscripciones($act_code)
    {
        $data['_view'] = 'actividad/index_inscripcion';
        $data['_dt'] = 'true';
        $data['title'] = 'Listado de inscripciones de';
        $act = $this->Actividad_model->get_actividad($act_code);
        $data['subtitle'] = $act['act_nombre'];
        $data['act_code'] = $act_code;
        $data['menu0'] = 'activmenu';
        $data['menu1'] = 'activlista';        
        $this->load->view('layouts/main-vertical',$data);
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

    public function addInscripcionPost() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="alert alert-warning" role="alert">', '</div>');
        $this->set_rules();
        // echo '<pre>';
        // print_r($_POST);
        // echo '</pre>';         
        // exit;
        if ($this->form_validation->run() == FALSE){
            // Se produjeron errores vuelve al form de inscripcion
            $data['_view'] = 'inscripcion/add-inscripcion';
            $data['title'] = 'Inscripciones del socio';
            $data['subtitle'] = $this->Inscripcion_model->get_apelnom($this->input->post('soc_id'));;
            $data['soc_id'] = $this->input->post('soc_id');
            $actividades = $this->Actividad_model->get_actividades_small();   
            $opc = array();
            $opc['0']='Seleccione actividad';
            foreach ($actividades as $act) {
                $opc[($act['act_code'])] = $act['act_nombre'];
            } 
            $data['actividades'] = $opc;
            $this->load->view('layouts/main-vertical',$data);
        }else{
            // Los datos para la inscripcion son correctos, guardar y volver al listado
 
            // ins_id integer
            // soc_id integer
            // act_code text
            // mod_tipo text
            // ins_vencimiento

            $data['soc_id'] = $this->input->post('soc_id');
            $data['act_code'] = $this->input->post('act_code');
            $data['mod_tipo'] = $this->input->post('mod_tipo');
            $data['ins_vencimiento'] = $this->sinonull($this->input->post('ins_vencimiento'));              
            
            $insert = $this->Inscripcion_model->insert($data);

            $data1['_view'] = 'inscripcion/index';
            $data1['_dt'] = 'true';
            $data1['title'] = 'Inscripciones del socio';
            $data1['subtitle'] = $this->Inscripcion_model->get_apelnom($this->input->post('soc_id'));
            $data1['soc_id'] = $this->input->post('soc_id');
            if ($insert == true){
                $data1['_alert'] = 'Registro guardado!';
                $data1['_alert_tipo'] = 'alert-success';
            }else{
                $data1['_alert'] = 'No se pudo agregar la inscripción, posiblemente ya hay inscripción vigente para la misma actividad';
                $data1['_alert_tipo'] = 'alert-warning';              
            }
            $this->load->view('layouts/main-vertical',$data1);
            
        }
    }

    public function modalidades(){
        $actividades = $this->Actividad_model->get_modalidades_small($this->input->post('act_code'));
        $cadena="<select id='mod_tipo' name='mod_tipo' class='form-control'>";
        if (!$actividades or count($actividades)==0){
			$cadena=$cadena."<option value='0'>Debe crear las modalidades de la actividad</option>";
        }else{
            $cadena=$cadena."<option value='0'>Seleccione la modalidad</option>";
    		foreach ($actividades as $act) {
    			$cadena=$cadena."<option value='{$act['mod_tipo']}'>{$act['mod_descrip']}</option>";
    		}         	
        }

		$cadena=$cadena."</select>";
		echo $cadena;
    }

    public function deleteInscripcion($ins_id,$soc_id) {
        $delete =  $this->Inscripcion_model->delete($ins_id);

        $data1['_view'] = 'inscripcion/index';
        $data1['_dt'] = 'true';
        $data1['title'] = 'Inscripciones del socio';
        $data1['subtitle'] = $this->Inscripcion_model->get_apelnom($soc_id);
        $data1['soc_id'] = $soc_id;
        if ($delete) {
            $data1['_alert'] = 'Registro eliminado!';
            $data1['_alert_tipo'] = 'alert-danger';
        }else{
            $data1['_alert'] = 'No se pudo eliminar el registro!';
            $data1['_alert_tipo'] = 'alert-warning';
        }
        $this->load->view('layouts/main-vertical',$data1);
    }


    public function closeInscripcion($ins_id,$soc_id) {
        $close =  $this->Inscripcion_model->close($ins_id);

        $data1['_view'] = 'inscripcion/index';
        $data1['_dt'] = 'true';
        $data1['title'] = 'Inscripciones del socio';
        $data1['subtitle'] = $this->Inscripcion_model->get_apelnom($soc_id);
        $data1['soc_id'] = $soc_id;
        if ($close) {
            $data1['_alert'] = 'La inscripción fue cerrada!';
            $data1['_alert_tipo'] = 'alert-danger';
        }else{
            $data1['_alert'] = 'No se pudo cerrar la inscripción!';
            $data1['_alert_tipo'] = 'alert-warning';
        }
        $this->load->view('layouts/main-vertical',$data1);
    }

    public function tabla($soc_id){

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
    			$nestedData['mod_descrip'] = $ins->mod_descrip;
    			$nestedData['ins_vencimiento'] = $ins->ins_vencimiento;
                $nestedData['dif'] = $ins->dif;
      
                $data[] = $nestedData;
            }
        }
          
        $json_data = array(
                    "draw" => intval($this->input->post('draw')),  
                    "data" => $data   
                    );                
        echo json_encode($json_data); 
    }

    public function tabla_inscripciones($act_code){


        $inscripciones = $this->Inscripcion_model->inscxactividad($act_code);
        $data = array();
        if(!empty($inscripciones))
        {
            foreach ($inscripciones as $ins)
            {
                $nestedData['ins_id'] = $ins->ins_id;
                $nestedData['ins_vencimiento'] = $ins->ins_vencimiento;
                $nestedData['socio'] = $ins->socio;
                $nestedData['documento'] = $ins->documento;
                $nestedData['actividad'] = $ins->actividad;
                $nestedData['ult_vto'] = $ins->ult_vto;
                $nestedData['ult_asist'] = $ins->ult_asist;
      
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

