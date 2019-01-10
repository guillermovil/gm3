<!-- 
CREATE TABLE public.pagossocios
(
    ins_id integer NOT NULL DEFAULT nextval('pagossocios_ins_id_seq'::regclass),
    ps_perdesde timestamp without time zone NOT NULL,
    ps_perhasta timestamp without time zone,
    ps_nrorecibo integer,
    ps_valor numeric(10,2) NOT NULL,
    ps_created timestamp without time zone NOT NULL DEFAULT now(),
    CONSTRAINT pk_pagossocios_ins_id PRIMARY KEY (ins_id, ps_perdesde),
    CONSTRAINT fk_pagossocios_inscripciones FOREIGN KEY (ins_id)
        REFERENCES public.inscripciones (ins_id) MATCH SIMPLE
        ON UPDATE NO ACTION
        ON DELETE NO ACTION
)
-->
<?php
class Cuenta extends CI_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Cuenta_model');
        $this->load->model('Inscripcion_model');
    } 

    private function set_rules()
    {
        $this->form_validation->set_rules('act_code', 'Actividad', 'callback_select_check');
        $this->form_validation->set_rules('mod_tipo', 'Modalidad', 'callback_select_check');
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

    public function index($ins_id)
    {
        //get_details -> act_code, act_nombre, mod_tipo, mod_precio, ins_id, soc_apellido, soc_nombre
        $data['_view'] = 'cuenta/index';
        $data['_dt'] = 'true';
        $data['title'] = 'Pagos del socio ';
        $data['ins_id'] = $ins_id;
        $detalles = $this->Inscripcion_model->get_details($ins_id);
        $data['subtitle'] = $detalles[0]->soc_apellido +', '+$detalles[0]->soc_nombre;
        $data['soc_id'] = $detalles[0]->soc_id;
        $data['act_nombre'] = $detalles[0]->act_nombre;
        $data['mod_tipo'] = $this->tipo($detalles[0]->mod_tipo);
        $data['mod_precio'] = $detalles[0]->mod_precio;
        $this->load->view('layouts/main-vertical',$data);
    }


    public function addInscripcion($soc_id) {
        $this->load->helper(array('form', 'url'));
        $data['_view'] = 'inscripcion/add-inscripcion';
        $data['title'] = 'Inscripciones';
        $data['subtitle'] = $this->Inscripcion_model->get_apelnom($soc_id);
        $data['soc_id'] = $soc_id;
        $actividades = $this->Actividad_model->get_actividades_small();   
        $opc = array();
        $opc['0']='Seleccione actividad';
		foreach ($actividades as $act) {
			$opc[($act['act_code'])] = $act['act_nombre'];
		} 
		$data['actividades'] = $opc;
        $this->load->view('layouts/main-vertical',$data);
    }

    public function addInscripcionPost() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="alert alert-warning" role="alert">', '</div>');
        $this->set_rules();
        // echo '<pre>';
        // print_r($_POST);
        // echo '</pre>';         
        // exit;
        if ($this->form_validation->run() == FALSE){
            // Se produjeron errores vuelve al form de inscripcion
            $data['_view'] = 'inscripcion/add-inscripcion';
            $data['title'] = 'Inscripciones del socio';
            $data['subtitle'] = $this->Inscripcion_model->get_apelnom($this->input->post('soc_id'));;
            $data['soc_id'] = $this->input->post('soc_id');
            $actividades = $this->Actividad_model->get_actividades_small();   
            $opc = array();
            $opc['0']='Seleccione actividad';
            foreach ($actividades as $act) {
                $opc[($act['act_code'])] = $act['act_nombre'];
            } 
            $data['actividades'] = $opc;
            $this->load->view('layouts/main-vertical',$data);
        }else{
            // Los datos para la inscripcion son correctos, guardar y volver al listado
 
            // ins_id integer
            // soc_id integer
            // act_code text
            // mod_tipo text
            // ins_vencimiento

            $data['soc_id'] = $this->input->post('soc_id');
            $data['act_code'] = $this->input->post('act_code');
            $data['mod_tipo'] = $this->input->post('mod_tipo');
            $data['ins_vencimiento'] = $this->sinonull($this->input->post('ins_vencimiento'));              
            
            $insert = $this->Inscripcion_model->insert($data);

            $data1['_view'] = 'inscripcion/index';
            $data1['_dt'] = 'true';
            $data1['title'] = 'Inscripciones del socio';
            $data1['subtitle'] = $this->Inscripcion_model->get_apelnom($this->input->post('soc_id'));
            $data1['soc_id'] = $this->input->post('soc_id');
            if ($insert == true){
                $data1['_alert'] = 'Registro guardado!';
                $data1['_alert_tipo'] = 'alert-success';
            }else{
                $data1['_alert'] = 'No se pudo agregar la inscripción, posiblemente ya hay inscripción vigente para la misma actividad';
                $data1['_alert_tipo'] = 'alert-warning';              
            }
            $this->load->view('layouts/main-vertical',$data1);
            
        }
    }

    public function modalidades(){
        $actividades = $this->Actividad_model->get_modalidades_small($this->input->post('act_code'));
        $cadena="<select id='mod_tipo' name='mod_tipo' class='form-control'>";
        if (!$actividades or count($actividades)==0){
			$cadena=$cadena."<option value='0'>Debe crear las modalidades de la actividad</option>";
        }else{
            $cadena=$cadena."<option value='0'>Seleccione la modalidad</option>";
    		foreach ($actividades as $act) {
    			$cadena=$cadena."<option value='{$act['mod_tipo']}'>{$this->tipo(($act['mod_tipo']))}</option>";
    		}         	
        }

		$cadena=$cadena."</select>";
		echo $cadena;
    }

    public function deleteInscripcion($ins_id,$soc_id) {
        $delete =  $this->Inscripcion_model->delete($ins_id);

        $data1['_view'] = 'inscripcion/index';
        $data1['_dt'] = 'true';
        $data1['title'] = 'Inscripciones del socio';
        $data1['subtitle'] = $this->Inscripcion_model->get_apelnom($soc_id);
        $data1['soc_id'] = $soc_id;
        if ($delete) {
            $data1['_alert'] = 'Registro eliminado!';
            $data1['_alert_tipo'] = 'alert-danger';
        }else{
            $data1['_alert'] = 'No se pudo eliminar el registro!';
            $data1['_alert_tipo'] = 'alert-warning';
        }
        $this->load->view('layouts/main-vertical',$data1);
    }


    public function closeInscripcion($ins_id,$soc_id) {
        $close =  $this->Inscripcion_model->close($ins_id);

        $data1['_view'] = 'inscripcion/index';
        $data1['_dt'] = 'true';
        $data1['title'] = 'Inscripciones del socio';
        $data1['subtitle'] = $this->Inscripcion_model->get_apelnom($soc_id);
        $data1['soc_id'] = $soc_id;
        if ($close) {
            $data1['_alert'] = 'La inscripción fue cerrada!';
            $data1['_alert_tipo'] = 'alert-danger';
        }else{
            $data1['_alert'] = 'No se pudo cerrar la inscripción!';
            $data1['_alert_tipo'] = 'alert-warning';
        }
        $this->load->view('layouts/main-vertical',$data1);
    }

    /*ins_id integer NOT NULL DEFAULT nextval('pagossocios_ins_id_seq'::regclass),
    ps_perdesde timestamp without time zone NOT NULL,
    ps_perhasta timestamp without time zone,
    ps_nrorecibo integer,
    ps_valor numeric(10,2) NOT NULL,
    ps_created */

    public function tabla($ins_id){
        $columns = array( 
    						0 =>'ins_id',
    						1 =>'ps_perdesde',
    						2 =>'ps_perhasta',
    						3 =>'ps_nrorecibo',
                            4 =>'ps_fecha',
    						5 =>'ps_valor',
                            6 =>'ps_created',
                        );

        $pagossocios = $this->Pago_model->all($ins_id);
        $data = array();
        if(!empty($inscripciones))
        {
            foreach ($inscripciones as $ins)
            {

    			$nestedData['ins_id'] = 	$ins->ins_id;
    			$nestedData['ps_perdesde'] = 	$ins->ps_perdesde;
    			$nestedData['ps_perhasta'] = 	$ins->ps_perhasta;
    			$nestedData['ps_nrorecibo'] = $ins->ps_nrorecibo;
    			$nestedData['ps_fecha'] = 	$ins->ps_fecha;
    			$nestedData['ps_valor'] = $ins->ps_valor;
    			$nestedData['ps_created'] = $ins->ps_created;
      
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

