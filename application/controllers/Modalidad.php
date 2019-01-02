<?php
class Modalida extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Modalidad_model');
    } 

    private function set_rules()
    {
        $this->form_validation->set_rules('mod_tipo', 'Tipo', 'required|alpha_numeric_spaces');
        $this->form_validation->set_rules('mod_precio', 'Precio', 'required|decimal|greater_than[0]|less_than[10000]');

    }
    private function sinonull($dato){
        if ($dato == ''){
            return null;
        }else{
            return $dato;
        }
    }


    public function addActividad() {
        $this->load->helper(array('form', 'url'));
        $data['_view'] = 'actividad/add-actividad';
        $data['title'] = 'Actividades';
        $data['subtitle'] = 'nueva actividad';
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
            $this->load->view('layouts/main-vertical',$data1);
            
        }
    }
    public function deleteActividad($actividad_id) {
        $delete =  $this->Actividad_model->delete($actividad_id);

        $data1['_view'] = 'actividad/index';
        $data1['_dt'] = 'true';
        $data1['title'] = 'Actividades';
        $data1['subtitle'] = 'Listado general';
        $data1['_alert'] = 'Registro eliminado!';
        $data1['_alert_tipo'] = 'alert-danger';
        $this->load->view('layouts/main-vertical',$data1);

    }

    public function editActividad($actividad_id) {
        $this->load->helper(array('form', 'url'));
        $data['_view'] = 'actividad/edit-actividad';
        $data['title'] = 'Actividades';
        $data['subtitle'] = 'Editar datos de la actividad';
        $data['actividad'] =  $this->Actividad_model->get_actividad($actividad_id);

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
            $this->load->view('layouts/main-vertical',$data);
        }else{
            $data['act_code'] = $this->sinonull($this->input->post('act_code'));
            $data['act_nombre'] = $this->sinonull($this->input->post('act_nombre'));
            $this->Actividad_model->update($this->input->post('act_code_original'),$data);
            $data1['_view'] = 'actividad/index';
            $data1['_dt'] = 'true';
            $data1['title'] = 'Actividades';
            $data1['subtitle'] = 'Listado general';
            $data1['_alert'] = 'Registro guardado!';
            $data1['_alert_tipo'] = 'alert-success';
            $this->load->view('layouts/main-vertical',$data1);
        }
    }

    public function tabla($act_code){
            $columns = array( 
                                0 =>'act_code',   
                                1 =>'mod_tipo', 
                                2 =>'mod_precio'
                            );

            $modalidades = $this->Modalidad_model->all($act_code);
            $data = array();
            if(!empty($modalidades))
            {
                foreach ($modalidades as $mod)
                {
                    $nestedData['act_code'] = $mod->act_code;
                    $nestedData['mod_tipo'] = $mod->mod_tipo;
                    $nestedData['mod_precio'] = $mod->mod_precio;                   
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

