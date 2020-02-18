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
        $this->load->library('Controlfunc');
        
    }

    public function date_valid($date){
        if ($this->controlfunc->date_valid($date)){
            return true;
        }else{
            $this->form_validation->set_message('date_valid', 'El formato de la fecha {field} es incorrecto.');
            return false ;          
        }
    }

    private function set_rules()
    {
        $this->form_validation->set_rules('vta_fecha', 'Fecha', 'required|callback_date_valid');
        if ($this->input->post('soc_id') == '' /* or empty($this->input->post('soc_id')) */ ){
            $this->form_validation->set_rules('vta_cliente', 'Cliente', 'required');    
        }
        $this->form_validation->set_rules('prod_code1[]', 'Detalles', 'required',array('required' => 'Debe incluir al menos un producto en el detalle.'));
    }


    public function index()
    {
        $data['_view'] = 'venta/index';
        $data['_dt'] = 'true';
        $data['title'] = 'Ventas';
        $data['subtitle'] = '';
        $data['menu0'] = 'ventmenu';
        $data['menu1'] = 'ventgrid';

        $this->load->view('layouts/main-vertical',$data);
    }




    public function tabla()
    {

        $columns = array( 
                            0 => 'vta_nro',
                            1 => 'vta_comprob',
                            2 => 'vta_fecha',
                            3 => 'cliente',
                            4 => 'subtotal'
                        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
        $fecha = $this->input->post('fecha');
  
        $totalData = $this->Venta_model->all_count();
            
        $totalFiltered = $totalData; 
            
        if(empty($this->input->post('search')['value']))
        {            
            $ventas = $this->Venta_model->all($limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value']; 

            $ventas =  $this->Venta_model->search($limit,$start,$search,$order,$dir,$fecha);

            $totalFiltered = $this->Venta_model->search_count($search,$fecha);
        }

        $data = array();
        if(!empty($ventas))
        {
            foreach ($ventas as $vta)
            {

                $nestedData['vta_nro'] = $vta->vta_nro;
                $nestedData['vta_comprob'] = $vta->vta_comprob;
                $nestedData['vta_fecha'] = $vta->vta_fecha;
                $nestedData['cliente'] = $vta->cliente;
                $nestedData['subtotal'] = $vta->subtotal;
                $data[] = $nestedData;
            }
        }
          
        $json_data = array(
                    "draw"            => intval($this->input->post('draw')),  
                    "recordsTotal"    => intval($totalData),  
                    "recordsFiltered" => intval($totalFiltered), 
                    "data"            => $data   
                    );
            
        echo json_encode($json_data); 
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

            // echo "Datos listos para guardar";
            // echo '<pre>';
            // print_r($_POST);
            // echo '</pre>';  



            $data['vta_comprob'] = $this->controlfunc->sinonull($this->input->post('vta_comprob'));
            $data['vta_fecha'] = $this->controlfunc->sinonull($this->input->post('vta_fecha'));    
            $data['soc_id'] = $this->controlfunc->sinonull($this->input->post('soc_id'));    
            $data['vta_cliente'] = $this->controlfunc->sinonull($this->input->post('vta_cliente'));    
            $data['prod_code1'] = $this->input->post('prod_code1');
            $data['prod_cantidad1'] = $this->input->post('prod_cantidad1');
            $data['prod_precio1'] = $this->input->post('prod_precio1');
            
            $insert = $this->Venta_model->insert($data);

            $data1['_view'] = 'producto/index';
            $data1['_dt'] = 'true';
            $data1['title'] = 'Productos';
            $data1['subtitle'] = 'Listado general';


            if ($insert=='') {
                $data1['_alert'] = 'Registro guardado!';
                $data1['_alert_tipo'] = 'alert-success';                
            }else{
                $data1['_alert'] = "La venta no se pudo guardar,<br> $insert";
                $data1['_alert_tipo'] = 'alert-warning';                
            }
            $data1['menu0'] = 'ventmenu';
            $data1['menu1'] = 'prodlista';             
            $this->load->view('layouts/main-vertical',$data1);
            
        }
    }


    public function detVenta() {
        $detalles = $this->Venta_model->get_detventa($this->input->post('vta_nro'));
        $cadena = '<table id="ventas_table" class="table table-bordered table-hover" style="width:100%; font-size: smaller;">
            <thead class="custom-blue">
                <tr>
                    <th>Cod</th>
                    <th>Descripción</th>
                    <th>Cant</th>
                    <th>Precio</th>
                    <th>Subtotal</th>
                </tr>
            </thead>';

        foreach ($detalles as $linea) {
            $cadena = $cadena. "<tr><td>{$linea['prod_code']}</td><td>{$linea['prod_descrip']}</td><td>{$linea['dv_cant']}</td><td>{$linea['dv_precio']}</td><td>{$linea['subtotal']}</td></tr>";
        }        
        $cadena = $cadena . "</table>";
        echo $cadena;
    }
} 