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
 //       $this->set_rules();

        echo '<pre>';
        print_r($_POST);
        echo '</pre>';  


        // if ($this->form_validation->run() == FALSE){


        // }else{


        //     // echo '<pre>';
        //     // print_r($_POST);
        //     // echo '</pre>';  
            
        // }
    }





} 