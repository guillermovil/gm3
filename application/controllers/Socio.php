<?php
class Socio extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Socio_model');
        $this->load->library('session');
    } 
    private function set_rules()
    {
        $this->form_validation->set_rules('soc_tipodoc', 'Tipo documento', 'in_list[DNI,PAS,OTRO]');
        $this->form_validation->set_rules('soc_nrodoc', 'Nro documento', 'required|alpha_numeric_spaces');
        $this->form_validation->set_rules('soc_apellido', 'Apellido', 'required|alpha');
        $this->form_validation->set_rules('soc_email', 'Email', 'required|valid_email');
    }

    public function index()
    {
        $data['socios'] = $this->Socio_model->get_all_socios();
        $data['_view'] = 'socio/index';
        $data['_dt'] = 'true';
        $data['title'] = 'Socios';
        $data['subtitle'] = 'Listado general';
        $this->load->view('layouts/main-vertical',$data);
    }


    public function addSocio() {
        $this->load->helper(array('form', 'url'));
        $data['_view'] = 'socio/add-socio';
        $data['title'] = 'Socios';
        $data['subtitle'] = 'nuevo socio';
        $this->load->view('layouts/main-vertical',$data);
    }

    public function addSocioPost() {
        $config['upload_path']   = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']      = 600;
        $config['max_width']     = 300;
        $config['max_height']    = 300;        
        $this->load->library('form_validation');
        $this->load->library('upload', $config);
        $this->form_validation->set_error_delimiters('<div class="alert alert-warning" role="alert">', '</div>');
        $this->set_rules();

        $errorfile = false;
        if ( ! $this->upload->do_upload('soc_foto')){
            $error = array('error' => $this->upload->display_errors());
            $errorfile = true; 
        }else{
            $datafile = array('upload_data' => $this->upload->data());
            // echo '<pre>';
            // print_r($datafile);
            // echo '</pre>';           
            $fp = fopen( $datafile['upload_data']['full_path'], "rb");
            $contenido = fread($fp,$datafile['upload_data']['file_size']*1024);
            fclose($fp);
            $escaped = bin2hex( $contenido );  

        }


        if ($this->form_validation->run() == FALSE or $errorfile == TRUE){
            $data['_view'] = 'socio/add-socio';
            $data['title'] = 'Socios';
            $data['subtitle'] = 'nuevo socio';
            $data['_errorfile'] = $error;
            $this->load->view('layouts/main-vertical',$data);
        }else{
            $data['soc_tipodoc'] = $this->input->post('soc_tipodoc');
            $data['soc_nrodoc'] = $this->input->post('soc_nrodoc');
            $data['soc_apellido'] = $this->input->post('soc_apellido');
            $data['soc_nombre'] = $this->input->post('soc_nombre');
            $data['soc_domicilio'] = $this->input->post('soc_domicilio');
            $data['soc_nacimiento'] = $this->input->post('soc_nacimiento');
            $data['soc_telefono'] = $this->input->post('soc_telefono');
            $data['soc_email'] = $this->input->post('soc_email');
            $data['soc_foto'] = $escaped; 
          

            $this->Socio_model->insert($data);

            $data1['_view'] = 'socio/index';
            $data1['_dt'] = 'true';
            $data1['title'] = 'Socios';
            $data1['subtitle'] = 'Listado general';
            $data1['_alert'] = 'Registro guardado!';
            $data1['_alert_tipo'] = 'alert-success';
            $this->load->view('layouts/main-vertical',$data1);
        }
    }


    public function editSocio($socio_id) {
        $this->load->helper(array('form', 'url'));
        $data['_view'] = 'socio/edit-socio';
        $data['title'] = 'Socios';
        $data['subtitle'] = 'Editar datos del socio';
        $data['socio'] =  $this->Socio_model->get_socio($socio_id);

        $this->load->view('layouts/main-vertical',$data);
    }


    public function editSocioPost() {
        $config['upload_path']   = './uploads/';
        $config['allowed_types'] = 'gif|jpg|png';
        $config['max_size']      = 600;
        $config['max_width']     = 300;
        $config['max_height']    = 300;        
        $this->load->library('form_validation');
        $this->load->library('upload', $config);
        $this->form_validation->set_error_delimiters('<div class="alert alert-warning" role="alert">', '</div>');
        $this->set_rules();

        $errorfile = false;
        if ( ! $this->upload->do_upload('soc_foto')){
            $error = array('error' => $this->upload->display_errors());
            $errorfile = true; 
        }else{
            $datafile = array('upload_data' => $this->upload->data());
            // echo '<pre>';
            // print_r($datafile);
            // echo '</pre>';           
            $fp = fopen( $datafile['upload_data']['full_path'], "rb");
            $contenido = fread($fp,$datafile['upload_data']['file_size']*1024);
            fclose($fp);
            $escaped = bin2hex( $contenido );  

        }


        if ($this->form_validation->run() == FALSE or $errorfile == TRUE){
            $data['_view'] = 'socio/edit-socio';
            $data['title'] = 'Socios';
            $data['subtitle'] = 'editar datos del socio';
            $data['_errorfile'] = $error;
            $this->load->view('layouts/main-vertical',$data);
        }else{
            $data['soc_tipodoc'] = $this->input->post('soc_tipodoc');
            $data['soc_nrodoc'] = $this->input->post('soc_nrodoc');
            $data['soc_apellido'] = $this->input->post('soc_apellido');
            $data['soc_nombre'] = $this->input->post('soc_nombre');
            $data['soc_domicilio'] = $this->input->post('soc_domicilio');
            $data['soc_nacimiento'] = $this->input->post('soc_nacimiento');
            $data['soc_telefono'] = $this->input->post('soc_telefono');
            $data['soc_email'] = $this->input->post('soc_email');
            $data['soc_foto'] = $escaped; 
          

            $this->Socio_model->update($data);

            $data1['_view'] = 'socio/index';
            $data1['_dt'] = 'true';
            $data1['title'] = 'Socios';
            $data1['subtitle'] = 'Listado general';
            $data1['_alert'] = 'Registro guardado!';
            $data1['_alert_tipo'] = 'alert-success';
            $this->load->view('layouts/main-vertical',$data1);
        }
    }





    public function deleteSocio($socios_id) {
        $delete =  $this->Socio_model->delete($socios_id);

        $data1['_view'] = 'socio/index';
        $data1['_dt'] = 'true';
        $data1['title'] = 'Socios';
        $data1['subtitle'] = 'Listado general';
        $data1['_alert'] = 'Registro eliminado!';
        $data1['_alert_tipo'] = 'alert-danger';
        $this->load->view('layouts/main-vertical',$data1);

    }

    public function tabla()
    {

        $columns = array( 
                            0 => 'soc_id',
                            1 => 'soc_tipodoc',
                            2 => 'soc_nrodoc',
                            3 => 'soc_apellido',
                            4 => 'soc_nombre',
                            5 => 'soc_email'
                        );

        $limit = $this->input->post('length');
        $start = $this->input->post('start');
        $order = $columns[$this->input->post('order')[0]['column']];
        $dir = $this->input->post('order')[0]['dir'];
  
        $totalData = $this->Socio_model->all_count();
            
        $totalFiltered = $totalData; 
            
        if(empty($this->input->post('search')['value']))
        {            
            $socios = $this->Socio_model->all($limit,$start,$order,$dir);
        }
        else {
            $search = $this->input->post('search')['value']; 

            $socios =  $this->Socio_model->search($limit,$start,$search,$order,$dir);

            $totalFiltered = $this->Socio_model->search_count($search);
        }

        $data = array();
        if(!empty($socios))
        {
            foreach ($socios as $soc)
            {

                $nestedData['soc_id'] = $soc->soc_id;
                $nestedData['soc_tipodoc'] = $soc->soc_tipodoc;
                $nestedData['soc_nrodoc'] = $soc->soc_nrodoc;
                $nestedData['soc_apellido'] = $soc->soc_apellido;
                $nestedData['soc_nombre'] = $soc->soc_nombre;
                $nestedData['soc_email'] =  $soc->soc_email;
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
    public function showfoto($soc_id)
    {
        $fotoraw = $this->Socio_model->foto($soc_id);
        header("Content-Type: image/jpeg");
        if ($fotoraw=='sf'){
            $imagen = file_get_contents('image/sinimagen.jpg');
            echo $imagen;
        }else{
            echo base64_decode($fotoraw);
        }
    }

}

