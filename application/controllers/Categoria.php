<?php
class Categoria extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        if($this->session->userdata('logged_in') !== TRUE){
            $this->session->set_userdata('url', current_url());
            redirect('login');
        } else {
            $this->load->model('Categoria_model');    
        }
        
    } 

    private function set_rules()
    {
        $this->form_validation->set_rules('cat_code', 'Código', 'required|alpha_numeric_spaces');
        $this->form_validation->set_rules('cat_descrip', 'Descripción', 'required');

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
        $data['_view'] = 'categoria/index';
        $data['_dt'] = 'true';
        $data['title'] = 'Categorías';
        $data['subtitle'] = 'Listado general';
        $data['menu0'] = 'ventmenu';
        $data['menu1'] = 'categlista';        
        $this->load->view('layouts/main-vertical',$data);
    }

    public function addCategoria() {
        $this->load->helper(array('form', 'url'));
        $data['_view'] = 'categoria/add-categoria';
        $data['title'] = 'Categorías';
        $data['subtitle'] = 'nueva categoría';
        $data['menu0'] = 'ventmenu';
        $data['menu1'] = 'categnuevo';                
        $this->load->view('layouts/main-vertical',$data);
    }

    public function addCategoriaPost() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="alert alert-warning" role="alert">', '</div>');
        $this->set_rules();

        if ($this->form_validation->run() == FALSE){
            $data['_view'] = 'categoria/add-categoria';
            $data['title'] = 'Categorías';
            $data['subtitle'] = 'nueva categoría';
            $data['menu0'] = 'ventmenu';
            $data['menu1'] = 'categnuevo';                            
            $this->load->view('layouts/main-vertical',$data);
        }else{
            $data['cat_code'] = $this->sinonull($this->input->post('cat_code'));
            $data['cat_descrip'] = $this->sinonull($this->input->post('cat_descrip'));              
            
            $this->Categoria_model->insert($data);

            $data1['_view'] = 'categoria/index';
            $data1['_dt'] = 'true';
            $data1['title'] = 'Categorías';
            $data1['subtitle'] = 'Listado general';
            $data1['_alert'] = 'Registro guardado!';
            $data1['_alert_tipo'] = 'alert-success';
            $data1['menu0'] = 'ventmenu';
            $data1['menu1'] = 'categlista';             
            $this->load->view('layouts/main-vertical',$data1);
            
        }
    }
    public function deleteCategoria($categoria_id) {
        $delete =  $this->Categoria_model->delete($categoria_id);

        $data1['_view'] = 'categoria/index';
        $data1['_dt'] = 'true';
        $data1['title'] = 'Categorías';
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

    public function editCategoria($categoria_id) {
        $this->load->helper(array('form', 'url'));
        $data['_view'] = 'categoria/edit-categoria';
        $data['title'] = 'Categorías';
        $data['_dt'] = 'true';
        $data['subtitle'] = 'Editar datos de la categoría';

        $data['categoria'] =  $this->Categoria_model->get_categoria($categoria_id);
        $data['menu0'] = 'ventmenu';
        $data['menu1'] = 'categlista'; 
        $this->load->view('layouts/main-vertical',$data);
    }

    public function editCategoriaPost() {      
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="alert alert-warning" role="alert">', '</div>');
        $this->set_rules();

        if ($this->form_validation->run() == FALSE){
            $data['_view'] = 'categoria/edit-categoria';
            $data['title'] = 'Categorías';
            $data['subtitle'] = 'editar datos de la actividad';
            $data['categoria'] =  $this->Categoria_model->get_categoria($this->input->post('cat_code'));
            $data['menu0'] = 'ventmenu';
            $data['menu1'] = 'categlista';            
            $this->load->view('layouts/main-vertical',$data);
        }else{
            $data['cat_code'] = $this->sinonull($this->input->post('cat_code'));
            $data['cat_descrip'] = $this->sinonull($this->input->post('cat_descrip'));
            $update = $this->Categoria_model->update($this->input->post('cat_code_original'),$data);
            $data1['_view'] = 'categoria/index';
            $data1['_dt'] = 'true';
            $data1['title'] = 'Categorías';
            $data1['subtitle'] = 'Listado general';
            if ($update) {
                $data1['_alert'] = 'Registro guardado!';
                $data1['_alert_tipo'] = 'alert-success';                
            }else{
                $data1['_alert'] = 'El registro no se pudo modificar!';
                $data1['_alert_tipo'] = 'alert-warning';                
            }
            $data1['menu0'] = 'ventmenu';
            $data1['menu1'] = 'categlista';            
            $this->load->view('layouts/main-vertical',$data1);
        }
    }

    public function tabla()
    {

            $columns = array( 
                                0 =>'cat_code', 
                                1 =>'cat_descrip'
                            );

            $categorias = $this->Categoria_model->all();
            $data = array();
            if(!empty($categorias))
            {
                foreach ($categorias as $cat)
                {

                    $nestedData['cat_code'] = $cat->cat_code;
                    $nestedData['cat_descrip'] = $cat->cat_descrip;                   
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

