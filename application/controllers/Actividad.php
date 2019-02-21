<?php
class Actividad extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('logged_in') !== TRUE){
            $this->session->set_userdata('url', current_url());
            redirect('login');
        } else {
            $this->load->model('Actividad_model');    
        }
        
    } 

    private function set_rules()
    {
        $this->form_validation->set_rules('act_code', 'Código', 'required|alpha_numeric_spaces');
        $this->form_validation->set_rules('act_nombre', 'Nombre', 'required');

    }
    private function sinonull($dato){
        if ($dato == ''){
            return null;
        }else{
            return $dato;
        }
    }


    function index()
    {
        //$data['actividades'] = $this->Actividad_model->get_all_actividades();
        $data['_view'] = 'actividad/index';
        $data['_dt'] = 'true';
        $data['title'] = 'Actividades';
        $data['subtitle'] = 'Listado general';
        $data['menu0'] = 'activmenu';
        $data['menu1'] = 'activlista';        
        $this->load->view('layouts/main-vertical',$data);
    }

    public function addActividad() {
        $this->load->helper(array('form', 'url'));
        $data['_view'] = 'actividad/add-actividad';
        $data['title'] = 'Actividades';
        $data['subtitle'] = 'nueva actividad';
        $data['menu0'] = 'activmenu';
        $data['menu1'] = 'activnuevo';                
        $this->load->view('layouts/main-vertical',$data);
    }

    public function addActividadPost() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="alert alert-warning" role="alert">', '</div>');
        $this->set_rules();

        if ($this->form_validation->run() == FALSE){
            $data['_view'] = 'actividad/add-actividad';
            $data['title'] = 'Actividades';
            $data['subtitle'] = 'nueva actividad';
            $data['menu0'] = 'activmenu';
            $data['menu1'] = 'activnuevo';                            
            $this->load->view('layouts/main-vertical',$data);
        }else{
            $data['act_code'] = $this->sinonull($this->input->post('act_code'));
            $data['act_nombre'] = $this->sinonull($this->input->post('act_nombre'));              
            
            $this->Actividad_model->insert($data);

            $data1['_view'] = 'actividad/index';
            $data1['_dt'] = 'true';
            $data1['title'] = 'Actividades';
            $data1['subtitle'] = 'Listado general';
            $data1['_alert'] = 'Registro guardado!';
            $data1['_alert_tipo'] = 'alert-success';
            $data1['menu0'] = 'activmenu';
            $data1['menu1'] = 'activlista';             
            $this->load->view('layouts/main-vertical',$data1);
            
        }
    }
    public function deleteActividad($actividad_id) {
        $delete =  $this->Actividad_model->delete($actividad_id);

        $data1['_view'] = 'actividad/index';
        $data1['_dt'] = 'true';
        $data1['title'] = 'Actividades';
        $data1['subtitle'] = 'Listado general';
        if ($delete) {
            $data1['_alert'] = 'Registro eliminado!';
            $data1['_alert_tipo'] = 'alert-danger';
        }else{
            $data1['_alert'] = 'El registro no se pudo eliminar!';
            $data1['_alert_tipo'] = 'alert-warning';            
        }

        $this->load->view('layouts/main-vertical',$data1);

    }

    public function editActividad($actividad_id) {
        $this->load->helper(array('form', 'url'));
        $data['_view'] = 'actividad/edit-actividad';
        $data['title'] = 'Actividades';
        $data['_dt'] = 'true';
        $data['subtitle'] = 'Editar datos de la actividad';

        $data['actividad'] =  $this->Actividad_model->get_actividad($actividad_id);
        $data['menu0'] = 'activmenu';
        $data['menu1'] = 'activlista'; 
        $this->load->view('layouts/main-vertical',$data);
    }

    public function editActividadPost() {      
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="alert alert-warning" role="alert">', '</div>');
        $this->set_rules();

        if ($this->form_validation->run() == FALSE){
            $data['_view'] = 'actividad/edit-actividad';
            $data['title'] = 'Actividades';
            $data['subtitle'] = 'editar datos de la actividad';
            $data['actividad'] =  $this->Actividad_model->get_actividad($this->input->post('act_code'));
            $data['menu0'] = 'activmenu';
            $data['menu1'] = 'activlista';            
            $this->load->view('layouts/main-vertical',$data);
        }else{
            $data['act_code'] = $this->sinonull($this->input->post('act_code'));
            $data['act_nombre'] = $this->sinonull($this->input->post('act_nombre'));
            $update = $this->Actividad_model->update($this->input->post('act_code_original'),$data);
            $data1['_view'] = 'actividad/index';
            $data1['_dt'] = 'true';
            $data1['title'] = 'Actividades';
            $data1['subtitle'] = 'Listado general';
            if ($update) {
                $data1['_alert'] = 'Registro guardado!';
                $data1['_alert_tipo'] = 'alert-success';                
            }else{
                $data1['_alert'] = 'El registro no se pudo modificar!';
                $data1['_alert_tipo'] = 'alert-warning';                
            }
            $data1['menu0'] = 'activmenu';
            $data1['menu1'] = 'activlista';            
            $this->load->view('layouts/main-vertical',$data1);
        }
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

