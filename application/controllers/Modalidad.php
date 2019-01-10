<?php
class Modalidad extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Modalidad_model');
        $this->load->model('Actividad_model');
    } 

    private function set_rules()
    {
        $this->form_validation->set_rules('mod_tipo', 'Tipo', 'required|alpha_numeric_spaces');
        $this->form_validation->set_rules('mod_precio', 'Precio', 'required|numeric|greater_than[0]|less_than[10000]');
        
    }
    private function sinonull($dato){
        if ($dato == ''){
            return null;
        }else{
            return $dato;
        }
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


    public function addModalidad($act_code) {
        $this->load->helper(array('form', 'url'));
        $data['_view'] = 'modalidad/add-modalidad';
        $data['title'] = 'Modalidades';
        $data['subtitle'] = 'nueva modalidad para la actividad';
        $data['act_code'] = $act_code;
        $this->load->view('layouts/main-vertical',$data);
    }

    public function addModalidadPost() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="alert alert-warning" role="alert">', '</div>');
        $this->form_validation->reset_validation();
        $this->set_rules();
        // echo '<pre>';
        // print_r($_POST);
        // echo '</pre>';         
        // exit;
        if ($this->form_validation->run() == FALSE){
            // Se produjeron errores vuelve al form de modalidad
            $data['_view'] = 'modalidad/add-modalidad';
            $data['title'] = 'Modalidades';
            $data['subtitle'] = 'nueva modalidad para la actividad';
            $data['act_code'] = $this->input->post('act_code');
            $this->load->view('layouts/main-vertical',$data);

        }else{
            // Los datos para la modalidad son correctos, guardar y volver al form de actividad
            $data['act_code'] = $this->input->post('act_code');
            $data['mod_tipo'] = $this->sinonull($this->input->post('mod_tipo'));
            $data['mod_precio'] = $this->sinonull($this->input->post('mod_precio'));              
            
            $this->Modalidad_model->insert($data);


            $this->load->helper(array('form', 'url'));
            $data1['_view'] = 'actividad/edit-actividad';
            $data1['title'] = 'Actividades';
            $data1['_dt'] = 'true';
            $data1['subtitle'] = 'Editar datos de la actividad';
            $data1['_alert'] = 'Registro guardado!';
            $data1['_alert_tipo'] = 'alert-success';
            $data1['actividad'] =  $this->Actividad_model->get_actividad($this->input->post('act_code'));

            $this->load->view('layouts/main-vertical',$data1);
            
        }
    }

    public function editModalidad($act_code, $mod_tipo) {
        $this->load->helper(array('form', 'url'));
        $data['_view'] = 'modalidad/edit-modalidad';
        $data['title'] = 'Modalidades';
        $actividad = $this->Actividad_model->get_actividad($act_code)['act_nombre'];
        $data['subtitle'] = 'Editar precio de: '.$actividad.' - '.$this->tipo($mod_tipo) ;
        $data['modalidad'] =  $this->Modalidad_model->get_modalidad($act_code, $mod_tipo);
        
        $this->load->view('layouts/main-vertical',$data);
    }

    public function editModalidadPost() {      
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="alert alert-warning" role="alert">', '</div>');
        $this->form_validation->reset_validation();
        $this->set_rules();

        if ($this->form_validation->run() == FALSE){
            $data['_view'] = 'modalidad/edit-modalidad';
            $data['title'] = 'Modalidades';
            $actividad = $this->Actividad_model->get_actividad($this->input->post('act_code'))['act_nombre'];
            $data['subtitle'] = 'Editar precio de: '.$actividad.' - '.$this->tipo($this->input->post('mod_tipo')) ;
            
            $this->load->view('layouts/main-vertical',$data);

        }else{
            $data['act_code']   = $this->input->post('act_code');
            $data['mod_tipo']   = $this->input->post('mod_tipo');
            $data['mod_precio'] = $this->input->post('mod_precio');
            $update = $this->Modalidad_model->update($this->input->post('act_code'),$this->input->post('mod_tipo'),$data);

            $this->load->helper(array('form', 'url'));
            $data1['_view'] = 'actividad/edit-actividad';
            $data1['title'] = 'Actividades';
            $data1['_dt'] = 'true';
            $data1['subtitle'] = 'Editar datos de la actividad';

            if ($update) {
                $data1['_alert'] = 'Registro guardado!';
                $data1['_alert_tipo'] = 'alert-success';                
            }else{
                $data1['_alert'] = 'El registro no se pudo modificar!';
                $data1['_alert_tipo'] = 'alert-warning';                
            }

            $data1['actividad'] =  $this->Actividad_model->get_actividad($this->input->post('act_code'));

            $this->load->view('layouts/main-vertical',$data1);
        }
    }


    public function updPrecios($act_code) {
        $this->load->helper(array('form', 'url'));
        $data['_view'] = 'modalidad/upd-precios';
        $data['title'] = 'Actualización de precios';
        $actividad = $this->Actividad_model->get_actividad($act_code)['act_nombre'];
        $data['subtitle'] = 'Actualizar precios de: '.$actividad;
        $data['act_code'] =  $act_code;
        $data['upd_precio'] =  10.00;
        
        $this->load->view('layouts/main-vertical',$data);
    }



    public function updPreciosPost() {      
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="alert alert-warning" role="alert">', '</div>');
        $this->form_validation->reset_validation();
        $this->form_validation->set_rules('upd_precio', 'Porcentaje', 'required|numeric|greater_than[0]|less_than[100.01]');

        if ($this->form_validation->run() == FALSE){
            $data['_view'] = 'modalidad/upd-precios';
            $data['title'] = 'Actualización de precios';
            $actividad = $this->Actividad_model->get_actividad($this->input->post('act_code'))['act_nombre'];
            $data['subtitle'] = 'actualizar precios de: '.$actividad ;
            
            $this->load->view('layouts/main-vertical',$data);

        }else{
            $porcentaje = 1+ $this->input->post('upd_precio') / 100.00;
            if ($this->input->post('upd_all') == 1){
                $update = $this->Modalidad_model->updPrecioAll($porcentaje);
            }else{
                $update = $this->Modalidad_model->updPrecio($this->input->post('act_code'),$porcentaje);    
            }
            

            $this->load->helper(array('form', 'url'));
            $data1['_view'] = 'actividad/edit-actividad';
            $data1['title'] = 'Actividades';
            $data1['_dt'] = 'true';
            $data1['subtitle'] = 'Editar datos de la actividad';

            if ($update) {
                $data1['_alert'] = 'Precios actualizados!';
                $data1['_alert_tipo'] = 'alert-success';                
            }else{
                $data1['_alert'] = 'Los precios no se pudieron actualizar!';
                $data1['_alert_tipo'] = 'alert-warning';                
            }

            $data1['actividad'] =  $this->Actividad_model->get_actividad($this->input->post('act_code'));

            $this->load->view('layouts/main-vertical',$data1);
        }
    }



    public function deleteModalidad($act_code,$mod_tipo) {
        $delete =  $this->Modalidad_model->delete($act_code,$mod_tipo);

        $this->load->helper(array('form', 'url'));
        $data1['_view'] = 'actividad/edit-actividad';
        $data1['title'] = 'Actividades';
        $data1['_dt'] = 'true';
        if ($delete) {
            $data1['_alert'] = 'Registro eliminado!';
            $data1['_alert_tipo'] = 'alert-danger';
        }else{
            $data1['_alert'] = 'No se pudo eliminar el registro!';
            $data1['_alert_tipo'] = 'alert-warning';
        }
        $data1['subtitle'] = 'Editar datos de la actividad';
        $data1['actividad'] =  $this->Actividad_model->get_actividad($act_code);
        $this->load->view('layouts/main-vertical',$data1);

    }

    public function tabla($act_code){
            $columns = array( 
                                0 =>'act_code', 
                                1 => 'mod_tipo', 
                                2 =>'mod_descrip', 
                                3 =>'mod_precio'
                            );

            $modalidades = $this->Modalidad_model->all($act_code);
            $data = array();
            if(!empty($modalidades))
            {
                foreach ($modalidades as $mod)
                {
                    $nestedData['act_code'] = $mod->act_code;
                    $nestedData['mod_tipo'] = $mod->mod_tipo;
                    $nestedData['mod_descrip'] = $this->tipo($mod->mod_tipo);
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

