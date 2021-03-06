<?php


  // prod_code text NOT NULL,
  // prod_descrip text NOT NULL,
  // prod_precio numeric(7,2) NOT NULL, -- Precio unitario
  // prod_stock integer,
  // prod_ctrl_stock boolean NOT NULL DEFAULT true, -- Controlar stock
  // cat_code text NOT NULL,


class Producto extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('logged_in') !== TRUE){
            $this->session->set_userdata('url', current_url());
            redirect('login');
        } else {
            $this->load->model('Producto_model');    
        }
        $this->load->library('Controlfunc');
        
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
        $this->form_validation->set_rules('prod_code', 'Código', 'required|alpha_numeric_spaces');
        $this->form_validation->set_rules('prod_descrip', 'Descripción', 'required');
        $this->form_validation->set_rules('prod_precio', 'Precio', 'required|numeric');
        $this->form_validation->set_rules('cat_code'   , 'Categoría', 'callback_select_check');

    }

    private function ischeck($checkbox, $val){

        if (isset($_POST[$checkbox]) && $_POST[$checkbox] == $val){
            return true;
        }
        else{
            return false;
        }
    }


    function index()
    {
        $data['_view'] = 'producto/index';
        $data['_dt'] = 'true';
        $data['title'] = 'Productos';
        $data['subtitle'] = 'Listado general';
        $data['menu0'] = 'ventmenu';
        $data['menu1'] = 'prodlista';        
        $this->load->view('layouts/main-vertical',$data);
    }

    public function addProducto() {
        $this->load->helper(array('form', 'url'));
        $data['_view'] = 'producto/add-producto';
        $data['title'] = 'Productos';
        $data['subtitle'] = 'nuevo producto';
        $data['menu0'] = 'ventmenu';
        $data['menu1'] = 'prodlista';    

        $categorias = $this->Producto_model->get_categlista_small();   
        $opc = array();
        $opc['0']='Seleccione categoria';
        foreach ($categorias as $cat) {
            $opc[($cat['cat_code'])] = $cat['cat_descrip'];
        } 
        $data['categorias'] = $opc;

        $this->load->view('layouts/main-vertical',$data);
    }

    public function addProductoPost() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="alert alert-warning" role="alert">', '</div>');
        $this->set_rules();

        if ($this->form_validation->run() == FALSE){
            $data['_view'] = 'producto/add-producto';
            $data['title'] = 'Productos';
            $data['subtitle'] = 'nuevo producto';
            $data['menu0'] = 'ventmenu';
            $data['menu1'] = 'prodnuevo';  

            $categorias = $this->Producto_model->get_categlista_small();   
            $opc = array();
            $opc['0']='Seleccione categoria';
            foreach ($categorias as $cat) {
                $opc[($cat['cat_code'])] = $cat['cat_descrip'];
            } 
            $data['categorias'] = $opc;

            $this->load->view('layouts/main-vertical',$data);
        }else{


            // echo '<pre>';
            // print_r($_POST);
            // echo '</pre>';  

            $data['prod_code'] = $this->controlfunc->sinonull($this->input->post('prod_code'));
            $data['prod_descrip'] = $this->controlfunc->sinonull($this->input->post('prod_descrip'));    
            $data['prod_precio'] = $this->controlfunc->sinonull($this->input->post('prod_precio'));    
            $data['prod_stock'] = $this->controlfunc->sinonull($this->input->post('prod_stock'));    
            $data['prod_ctrl_stock'] = $this->ischeck('prod_ctrl_stock','Si');    
            $data['cat_code'] = $this->controlfunc->sinonull($this->input->post('cat_code'));    
            
            $insert = $this->Producto_model->insert($data);

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


    public function deleteProducto($producto_id) {
        $delete =  $this->Producto_model->delete($producto_id);

        $data1['_view'] = 'producto/index';
        $data1['_dt'] = 'true';
        $data1['title'] = 'Productos';
        $data1['subtitle'] = 'Listado general';
        if ($delete) {
            $data1['_alert'] = 'Registro eliminado!';
            $data1['_alert_tipo'] = 'alert-danger';
        }else{
            $data1['_alert'] = 'El registro no se pudo eliminar!';
            $data1['_alert_tipo'] = 'alert-warning';            
        }
        $data1['menu0'] = 'ventmenu';
        $data1['menu1'] = 'prodlista';  
        $this->load->view('layouts/main-vertical',$data1);

    }


    public function editProducto($producto_id) {
        $this->load->helper(array('form', 'url'));
        $data['_view'] = 'producto/edit-producto';
        $data['title'] = 'Productos';
        $data['_dt'] = 'true';
        $data['subtitle'] = 'Editar datos de la producto';

        $data['producto'] =  $this->Producto_model->get_producto($producto_id);
        $data['menu0'] = 'ventmenu';
        $data['menu1'] = 'prodlista'; 

        $categorias = $this->Producto_model->get_categlista_small();   
        $opc = array();
        $opc['0']='Seleccione categoria';
        foreach ($categorias as $cat) {
            $opc[($cat['cat_code'])] = $cat['cat_descrip'];
        } 
        $data['categorias'] = $opc;

        $this->load->view('layouts/main-vertical',$data);
    }

    public function editProductoPost() {      
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="alert alert-warning" role="alert">', '</div>');
        $this->set_rules();

        if ($this->form_validation->run() == FALSE){
            $data['_view'] = 'producto/edit-producto';
            $data['title'] = 'Productos';
            $data['subtitle'] = 'editar datos de la actividad';
            $data['producto'] =  $this->Producto_model->get_producto($this->input->post('prod_code'));
            $data['menu0'] = 'ventmenu';
            $data['menu1'] = 'prodlista';   

            $categorias = $this->Producto_model->get_categlista_small();   
            $opc = array();
            $opc['0']='Seleccione categoria';
            foreach ($categorias as $cat) {
                $opc[($cat['cat_code'])] = $cat['cat_descrip'];
            } 
            $data['categorias'] = $opc;

            $this->load->view('layouts/main-vertical',$data);
        }else{


            //echo 'POST';echo '<pre>';
            //print_r($_POST);
            //echo '</pre>';

            $data['prod_code'] = $this->controlfunc->sinonull($this->input->post('prod_code'));
            $data['prod_descrip'] = $this->controlfunc->sinonull($this->input->post('prod_descrip'));
            $data['prod_precio'] = $this->controlfunc->sinonull($this->input->post('prod_precio'));    
            $data['prod_stock'] = $this->controlfunc->sinonull($this->input->post('prod_stock'));    
            $data['prod_ctrl_stock'] = $this->ischeck('prod_ctrl_stock','Si');    
            $data['cat_code'] = $this->controlfunc->sinonull($this->input->post('cat_code')); 

            $update = $this->Producto_model->update($this->input->post('prod_code_original'),$data);
            $data1['_view'] = 'producto/index';
            $data1['_dt'] = 'true';
            $data1['title'] = 'Productos';
            $data1['subtitle'] = 'Listado general';
            if ($update) {
                $data1['_alert'] = 'Registro guardado!';
                $data1['_alert_tipo'] = 'alert-success';                
            }else{
                $data1['_alert'] = 'El registro no se pudo modificar!';
                $data1['_alert_tipo'] = 'alert-warning';                
            }
            $data1['menu0'] = 'ventmenu';
            $data1['menu1'] = 'prodlista';            
            $this->load->view('layouts/main-vertical',$data1);
        }
    }

    public function tabla()
    {

        $columns = array( 
                            0 => 'prod_code',
                            1 => 'prod_descrip',
                            2 => 'prod_precio',
                            3 => 'prod_stock',
                            4 => 'prod_ctrl_stock',
                            5 => 'cat_code',
                            6 => 'cat_descrip'
                        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  
        $totalData = $this->Producto_model->all_count();
            
        $totalFiltered = $totalData; 
            
        if(empty($this->input->post('search')['value']))
        {            
            $productos = $this->Producto_model->all($limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value']; 

            $productos =  $this->Producto_model->search($limit,$start,$search,$order,$dir);

            $totalFiltered = $this->Producto_model->search_count($search);
        }

        $data = array();
        if(!empty($productos))
        {
            foreach ($productos as $prod)
            {
                $nestedData['prod_code'] = $prod->prod_code  ;
                $nestedData['prod_descrip'] = $prod->prod_descrip  ;
                $nestedData['prod_precio'] = $prod->prod_precio  ;
                $nestedData['prod_stock'] = $prod->prod_stock  ;
                $nestedData['prod_ctrl_stock'] = $prod->prod_ctrl_stock  ;
                $nestedData['cat_code'] = $prod->cat_code  ;
                $nestedData['cat_descrip'] = $prod->cat_descrip  ;
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

}

