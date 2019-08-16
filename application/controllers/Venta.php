<?php
class Venta extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('logged_in') !== TRUE){
            $this->session->set_userdata('url', current_url());
            redirect('login');
        } else {
            //$this->load->model('Venta_model');
            $this->load->model('Venta_model');    
        }
        
    }

    public function date_valid($date){
    // La fecha viene en formato yyyy-mm-dd
        $parts = explode("-", $date);
        if (count($parts) == 3) {      
          if (checkdate($parts[1], $parts[2], $parts[0])){
            return TRUE;
          }
        }else{
            $this->form_validation->set_message('date_valid', 'El formato de la fecha {field} es incorrecto.');
            return false;       
        }
    }

    private function set_rules()
    {
        $this->form_validation->set_rules('vta_fecha', 'Fecha', 'required|callback_date_valid');
        if ($this->input->post('soc_id') == '' or empty($this->input->post('soc_id'))){
            $this->form_validation->set_rules('vta_cliente', 'Cliente', 'required');    
        }
        $this->form_validation->set_rules('prod_code1[]', 'Detalles', 'required',array('required' => 'Debe incluir al menos un producto en el detalle.'));
    }

    public function addVenta() {
        $this->load->helper(array('form', 'url'));
        $data['_view'] = 'venta/add-venta';
        $data['title'] = 'Ventas';
        $data['subtitle'] = 'nueva venta';
        $data['menu0'] = 'ventmenu';
        $data['menu1'] = 'ventlista';    
        $data['vta_nro_aprox'] = $this->Venta_model->get_last_venta();



        $this->load->view('layouts/main-vertical',$data);
    }

    public function addVentaPost() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="alert alert-warning" role="alert">', '</div>');
        $this->set_rules();



        if ($this->form_validation->run() == FALSE){

            $this->load->helper(array('form', 'url'));
            $data['_view'] = 'venta/add-venta';
            $data['title'] = 'Ventas';
            $data['subtitle'] = 'nueva venta';
            $data['menu0'] = 'ventmenu';
            $data['menu1'] = 'ventlista';    
            $data['vta_nro_aprox'] = $this->Venta_model->get_last_venta();

            $this->load->view('layouts/main-vertical',$data);
        }else{

            echo "Datos listos para guardar";
            echo '<pre>';
            print_r($_POST);
            echo '</pre>';  

/*
Array
(
    [vta_nro] => 1
    [vta_comprob] => 
    [vta_fecha] => 2019-08-15
    [soc_id] => 1
    [vta_cliente] => 
    [prod_cantidad] => 1
    [prod_code1] => Array
        (
            [0] => PAL01
        )

    [prod_cantidad1] => Array
        (
            [0] => 1
        )

    [prod_precio1] => Array
        (
            [0] => 5
        )

)
*/


            $data['vta_comprob'] = $this->sinonull($this->input->post('vta_comprob'));
            $data['vta_fecha'] = $this->sinonull($this->input->post('vta_fecha'));    
            $data['soc_id'] = $this->sinonull($this->input->post('soc_id'));    
            $data['vta_cliente'] = $this->sinonull($this->input->post('vta_cliente'));    
            $data['prod_code1'] = $this->input->post('prod_code1');
            $data['prod_cantidad1'] = $this->input->post('prod_cantidad1');
            $data['prod_precio1'] = $this->input->post('prod_precio1');
            
            $insert = $this->Venta_model->insert($data);

            $data1['_view'] = 'producto/index';
            $data1['_dt'] = 'true';
            $data1['title'] = 'Productos';
            $data1['subtitle'] = 'Listado general';


            if ($insert) {
                $data1['_alert'] = 'Registro guardado!';
                $data1['_alert_tipo'] = 'alert-success';                
            }else{
                $data1['_alert'] = 'El registro no se pudo agregar!';
                $data1['_alert_tipo'] = 'alert-warning';                
            }
            $data1['menu0'] = 'ventmenu';
            $data1['menu1'] = 'prodlista';             
            $this->load->view('layouts/main-vertical',$data1);
            
        }
    }





} 