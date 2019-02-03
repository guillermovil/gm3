<?php
class Socio extends CI_Controller{
    function __construct()
    {
        parent::__construct();
        $this->load->model('Socio_model');
        $this->load->model('Inscripcion_model');        
        $this->load->library('session');
    } 

    public function date_valid($date){
    // La fecha viene en formato yyyy-mm-dd
    //
        $parts = explode("-", $date);
        if (count($parts) == 3) {      
          if (checkdate($parts[1], $parts[2], $parts[0]))
          {
            return TRUE;
          }
        }else{
            $this->form_validation->set_message('date_valid', 'El formato de la fecha {field} es incorrecto.');
            return false;       
        }
    }

    public function file_check($str){
        $allowed_mime_type_arr = array('image/gif','image/jpeg','image/pjpeg','image/png','image/x-png');
        $mime = get_mime_by_extension($_FILES['soc_foto']['name']);
        if(isset($_FILES['soc_foto']['name']) && $_FILES['soc_foto']['name']!=""){
            if(in_array($mime, $allowed_mime_type_arr)){
                return true;
            }else{
                $this->form_validation->set_message('file_check', 'Por favor sube fotos de tipo gif/jpg/png.');
                return false;
            }
        }else{
        	// En caso de ser campo obligatorio
            //$this->form_validation->set_message('file_check', 'Please choose a file to upload.');
            return true;
        }
    }

    private function set_rules(){
        $this->form_validation->set_rules('soc_tipodoc', 'Tipo documento', 'in_list[DNI,PAS,OTRO]');
        $this->form_validation->set_rules('soc_nrodoc', 'Nro documento', 'required|alpha_numeric_spaces');
        $this->form_validation->set_rules('soc_apellido', 'Apellido', 'required|alpha');
        $this->form_validation->set_rules('soc_email', 'Email', 'required|valid_email');
        $this->form_validation->set_rules('soc_foto', 'Foto', 'callback_file_check');
    }

    private function set_rules_asi(){
        $this->form_validation->set_rules('asi_fecha', 'Fecha', 'required|callback_date_valid');
    }


    private function sinonull($dato){
        if ($dato == ''){
            return null;
        }else{
            return $dato;
        }
    }


    public function index()
    {
        $data['_view'] = 'socio/index';
        $data['_dt'] = 'true';
        $data['title'] = 'Socios';
        $data['subtitle'] = 'Listado general';
        $data['menu0'] = 'sociosmenu';
        $data['menu1'] = 'socioslista';

        $this->load->view('layouts/main-vertical',$data);
    }

    public function addSocio() {
        $this->load->helper(array('form', 'url'));
        $data['_view'] = 'socio/add-socio';
        $data['title'] = 'Socios';
        $data['subtitle'] = 'nuevo socio';
        $data['menu0'] = 'sociosmenu';
        $data['menu1'] = 'sociosnuevo';        
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
        $this->load->helper('file');
        $this->form_validation->set_error_delimiters('<div class="alert alert-warning" role="alert">', '</div>');
        $this->set_rules();

        if ($this->form_validation->run() == FALSE){
            $data['_view'] = 'socio/add-socio';
            $data['title'] = 'Socios';
            $data['subtitle'] = 'nuevo socio';
            $data['menu0'] = 'sociosmenu';
            $data['menu1'] = 'sociosnuevo';            
            $this->load->view('layouts/main-vertical',$data);
        }else{

        	// Cargar la imágen seleccionada
	        $errorfile = false;
	        if(isset($_FILES['soc_foto']) && $_FILES['soc_foto']['size'] > 0){
	            $hasfile = true;
	            if ( ! $this->upload->do_upload('soc_foto')){
	                $errorfile = true; 
					$data['_errorfile'] = array('error' => $this->upload->display_errors());
		            $data['_view'] = 'socio/add-socio';
		            $data['title'] = 'Socios';
		            $data['subtitle'] = 'nuevo socio';
                    $data['menu0'] = 'sociosmenu';
                    $data['menu1'] = 'sociosnuevo';
		            $this->load->view('layouts/main-vertical',$data);

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
	        }else{
	           $hasfile = false; 
	        }
	        if ($errorfile == false){
	            $data['soc_tipodoc'] = $this->sinonull($this->input->post('soc_tipodoc'));
	            $data['soc_nrodoc'] = $this->sinonull($this->input->post('soc_nrodoc'));
	            $data['soc_apellido'] = $this->sinonull($this->input->post('soc_apellido'));
	            $data['soc_nombre'] = $this->sinonull($this->input->post('soc_nombre'));
	            $data['soc_domicilio'] = $this->sinonull($this->input->post('soc_domicilio'));
	            $data['soc_nacimiento'] = $this->sinonull($this->input->post('soc_nacimiento'));
	            $data['soc_telefono'] = $this->sinonull($this->input->post('soc_telefono'));
	            $data['soc_email'] = $this->sinonull($this->input->post('soc_email'));
	            $data['hasfile'] = $hasfile;
	            if ($hasfile == true){
	                $data['soc_foto'] = $escaped; 
	            }                
	            
	            $this->Socio_model->insert($data);

	            $data1['_view'] = 'socio/index';
	            $data1['_dt'] = 'true';
	            $data1['title'] = 'Socios';
	            $data1['subtitle'] = 'Listado general';
	            $data1['_alert'] = 'Registro guardado!';
	            $data1['_alert_tipo'] = 'alert-success';
                $data['menu0'] = 'sociosmenu';
                $data['menu1'] = 'socioslista';
	            $this->load->view('layouts/main-vertical',$data1);
	        }
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
        $this->load->helper('file');
        $this->form_validation->set_error_delimiters('<div class="alert alert-warning" role="alert">', '</div>');
        $this->set_rules();

        if ($this->form_validation->run() == FALSE){
            $data['_view'] = 'socio/edit-socio';
            $data['title'] = 'Socios';
            $data['subtitle'] = 'editar datos del socio';
            $this->load->view('layouts/main-vertical',$data);
        }else{

        	// Cargar la imágen seleccionada
	        $errorfile = false;
	        if(isset($_FILES['soc_foto']) && $_FILES['soc_foto']['size'] > 0){
	            $hasfile = true;
	            if ( ! $this->upload->do_upload('soc_foto')){
	                $errorfile = true; 
					$data['_errorfile'] = array('error' => $this->upload->display_errors());
		            $data['_view'] = 'socio/edit-socio';
		            $data['title'] = 'Socios';
		            $data['subtitle'] = 'editar datos socio';
		            $this->load->view('layouts/main-vertical',$data);

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
	        }else{
	           $hasfile = false; 
	        }
	        if ($errorfile == false){
	        	$data['soc_id'] = $this->sinonull($this->input->post('soc_id'));
	            $data['soc_tipodoc'] = $this->sinonull($this->input->post('soc_tipodoc'));
	            $data['soc_nrodoc'] = $this->sinonull($this->input->post('soc_nrodoc'));
	            $data['soc_apellido'] = $this->sinonull($this->input->post('soc_apellido'));
	            $data['soc_nombre'] = $this->sinonull($this->input->post('soc_nombre'));
	            $data['soc_domicilio'] = $this->sinonull($this->input->post('soc_domicilio'));
	            $data['soc_nacimiento'] = $this->sinonull($this->input->post('soc_nacimiento'));
	            $data['soc_telefono'] = $this->sinonull($this->input->post('soc_telefono'));
	            $data['soc_email'] = $this->sinonull($this->input->post('soc_email'));
	            $data['hasfile'] = $hasfile;
	            if ($hasfile == true){
	                $data['soc_foto'] = $escaped; 
	            }                
	            
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
            $imagen = file_get_contents('resources/image/user_dark.png');
            echo $imagen;
        }else{
            echo base64_decode($fotoraw);
        }
    }

    public function asistencia($socio_id) {
        $this->load->helper(array('form', 'url'));
        $data['_view'] = 'socio/asistencia';
        $data['title'] = 'Socios';
        
        $data['socio'] =  $this->Socio_model->get_socio($socio_id);

        $opciones = $this->Inscripcion_model->vigentes($socio_id);
        if (!$opciones){
            $data['subtitle'] = 'No está inscripto a ninguna actividad';
            $data['opciones'] = array();
        }else{
            $data['subtitle'] = 'Asistencia del socio';
            $opc=array();
            foreach ($opciones as $x) {
                $opc[($x['ins_id'])] = $x['act_nombre'].' '.$x['mod_descrip'];
            } 
            $data['opciones'] = $opc;            
        }
        // echo '<pre>';
        // print_r($opciones);
        // echo '</pre>';        
        // exit;
        $data['_dt'] = 'true';
        $this->load->view('layouts/main-vertical',$data);
    }    

    public function asistenciaPost() {  
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="alert alert-warning" role="alert">', '</div>');
        $this->set_rules_asi();

        // echo '<pre>';
        // print_r($_POST);
        // echo '</pre>';
        // if (@$_POST['opciones']){
        //     foreach ($_POST['opciones'] as $key => $value) {
        //         echo "$value <br>";
        //     }
        // }
        // exit;

        if ($this->form_validation->run() == FALSE){
            $data['_view'] = 'socio/asistencia';
            $data['title'] = 'Socios';
            $data['subtitle'] = 'Asistencia del socio';
            $data['socio'] =  $this->Socio_model->get_socio($socio_id);

            $opciones = $this->Inscripcion_model->vigentes($socio_id);
            $opc=array();
            foreach ($opciones as $x) {
                $opc[($x['ins_id'])] = $x['act_nombre'].' '.$x['mod_descrip'];
            } 
            $data['opciones'] = $opc;
            $data['_dt'] = 'true';
            $this->load->view('layouts/main-vertical',$data);
        }else{
            $data['asi_fecha'] = $this->input->post('asi_fecha');
            $errortxt = '';
            $insert = false;
            if (@$_POST['opciones']){
                foreach ($_POST['opciones'] as $key => $value) {
                    $data['ins_id'] = $value;
                    $insert = $this->Socio_model->insertAsi($data);
                }
            }else{
                $errortxt = 'No seleccionó ninguna actividad';
            }
            
            $data1['_view'] = 'socio/index';
            $data1['_dt'] = 'true';
            $data1['title'] = 'Socios';
            $data1['subtitle'] = 'Listado general';
            if ($insert == true && $errortxt ==''){
                $data1['_alert'] = 'Asistencia guardada!';
                $data1['_alert_tipo'] = 'alert-success';
            }else{
                $data1['_alert'] = 'No se pudo registrar la asistencia. '.$errortxt;
                $data1['_alert_tipo'] = 'alert-warning';              
            }        
            $this->load->view('layouts/main-vertical',$data1);
        }
    }
    public function tabla_asistencia($soc_id){
        $asistencia = $this->Socio_model->asistencia($soc_id);
        $data = array();
        if(!empty($asistencia))
        {
            foreach ($asistencia as $ps)
            {

                $nestedData['asi_id'] =     $ps->asi_id;
                $nestedData['asi_fecha'] =    $ps->asi_fecha;
                $nestedData['act_nombre'] =    $ps->act_nombre;      
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
