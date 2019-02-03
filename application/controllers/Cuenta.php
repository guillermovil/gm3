<?php
class Cuenta extends CI_Controller{

    function __construct()
    {
        parent::__construct();
        $this->load->model('Cuenta_model');
        $this->load->model('Inscripcion_model');
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

	function mayor_que($hasta,$desde){
		$hasta1 = strtotime($hasta);
		$desde1 = strtotime($desde);
		if ($hasta1 < $desde1){
			$this->form_validation->set_message('mayor_que', 'El periodo es incorrecto.');
			return false;       
		}else{
			return true;	
		}
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
        $this->form_validation->set_rules('ps_perdesde', 'Desde', 'required|callback_date_valid');
        $this->form_validation->set_rules('ps_perhasta', 'Hasta', 'required|callback_date_valid|callback_mayor_que['.$this->input->post('ps_perdesde').']');
        $this->form_validation->set_rules('ps_fecha'   , 'Fecha', 'required|callback_date_valid');
        $this->form_validation->set_rules('ps_valor'   , 'Valor', 'required|greater_than_equal_to[0]'); 
        $this->form_validation->set_rules('mp_code'    , 'Medio de pago', 'callback_select_check');
       
    }

    private function sinonull($dato){
        if ($dato == ''){
            return null;
        }else{
            return $dato;
        }
    }


    public function index($ins_id)
    {
        //get_details -> act_code, act_nombre, mod_tipo, mod_precio, ins_id, soc_apellido, soc_nombre
        $data['_view'] = 'cuenta/index';
        $data['_dt'] = 'true';
        $data['title'] = 'Pagos del socio ';
        $data['ins_id'] = $ins_id;
        $detalles = $this->Inscripcion_model->get_details($ins_id);
        $estado = $this->Cuenta_model->estadogral($ins_id);
        $data['subtitle'] = $detalles[0]->soc_apellido .', '.$detalles[0]->soc_nombre;
        $data['soc_id'] = $detalles[0]->soc_id;
        $data['act_nombre'] = $detalles[0]->act_nombre;
        $data['mod_tipo'] = $detalles[0]->mod_tipo;
        $data['mod_descrip'] = $detalles[0]->mod_descrip;
        $data['mod_precio'] = $detalles[0]->mod_precio;

        $data['estadogral'] = $estado[0]->cuenta;
        $this->load->view('layouts/main-vertical',$data);
    }


    public function addPago($ins_id) {
        $this->load->helper(array('form', 'url'));
        $detalles = $this->Inscripcion_model->get_details($ins_id);
        $data['_view'] = 'cuenta/add-pago';
        $data['title'] = 'Pagos';
        $data['subtitle'] = $detalles[0]->soc_apellido .', '.$detalles[0]->soc_nombre;
        $data['ins_id'] = $detalles[0]->ins_id;
        $data['act_nombre'] = $detalles[0]->act_nombre;
        $data['mod_tipo'] = $detalles[0]->mod_tipo;
        $data['mod_descrip'] = $detalles[0]->mod_descrip;
        $data['mod_precio'] = $detalles[0]->mod_precio;
        $periodo = $this->Cuenta_model->proxper($ins_id);
        if($periodo and !is_null($periodo[0]->desde)){
            $data['desde'] = $periodo[0]->desde;   
            if(substr($detalles[0]->mod_tipo,0,1)=='m'){
                $data['hasta'] = $periodo[0]->hasta;
            }else{
                $data['hasta'] = $periodo[0]->desde;
            }
        }else{
            $data['desde'] = date('Y-m-d');
            if(substr($detalles[0]->mod_tipo,0,1)=='m'){
                $data['hasta'] = date('Y-m-d', strtotime("+1 months -1 day"));;
            }else{
                $data['hasta'] = date('Y-m-d');
            }


        }


        $medios = $this->Cuenta_model->get_mpago_small();   
        $opc = array();
        $opc['0']='Seleccione medio de pago';
        foreach ($medios as $mp) {
            $opc[($mp['mp_code'])] = $mp['mp_descrip'];
        } 
        $data['medios'] = $opc;        

        // echo '<pre>';
        // print_r($data);
        // echo '</pre>';         
        // exit;

        $this->load->view('layouts/main-vertical',$data);
    }

    public function addPagoPost() {
        $this->load->library('form_validation');
        $this->form_validation->set_error_delimiters('<div class="alert alert-warning" role="alert">', '</div>');
        $this->set_rules();
        

        // echo '<pre>';
        // print_r($_POST);
        // echo '</pre>';         
        // exit;
        $ins_id = $this->input->post('ins_id');;
        if ($this->form_validation->run() == FALSE){
            // Se produjeron errores vuelve al form de inscripcion
            $detalles = $this->Inscripcion_model->get_details($ins_id);
	        $data['_view'] = 'cuenta/add-pago';
	        $data['title'] = 'Pagos';
	        $data['subtitle'] = $detalles[0]->soc_apellido .', '.$detalles[0]->soc_nombre;
	        $data['ins_id'] = $detalles[0]->ins_id;
	        $data['act_nombre'] = $detalles[0]->act_nombre;
	        $data['mod_tipo'] = $detalles[0]->mod_tipo;
            $data['mod_descrip'] = $detalles[0]->mod_descrip;

	        $data['mod_precio'] = $detalles[0]->mod_precio;
	        $periodo = $this->Cuenta_model->proxper($ins_id);
	        if($periodo and !is_null($periodo[0]->desde)){
	            $data['desde'] = $periodo[0]->desde;   
	            if(substr($detalles[0]->mod_tipo,0,1)=='m'){
	                $data['hasta'] = $periodo[0]->hasta;
	            }else{
	                $data['hasta'] = $periodo[0]->desde;
	            }
	        }else{
	            $data['desde'] = date('Y-m-d');
	            $data['hasta'] = date('Y-m-d');
	        }

            $medios = $this->Cuenta_model->get_mpago_small();   
            $opc = array();
            $opc['0']='Seleccione medio de pago';
            foreach ($medios as $mp) {
                $opc[($mp['mp_code'])] = $mp['mp_descrip'];
            } 
            $data['medios'] = $opc; 

            $this->load->view('layouts/main-vertical',$data);
        }else{
            // Los datos del pago son correctos, guardar y volver al listado

        	
            $data['ins_id'] = $ins_id;
            $data['ps_perdesde'] = $this->input->post('ps_perdesde');
            $data['ps_perhasta'] = $this->input->post('ps_perhasta');
            $data['ps_nrorecibo'] = $this->sinonull($this->input->post('ps_nrorecibo'));
            $data['ps_fecha'] = $this->input->post('ps_fecha');
            $data['ps_valor'] = $this->input->post('ps_valor'); 
            $data['mp_code'] = $this->input->post('mp_code'); 

            
            $insert = $this->Cuenta_model->insert($data);

	        $data1['_view'] = 'cuenta/index';
	        $data1['_dt'] = 'true';
	        $data1['title'] = 'Pagos del socio ';
	        $data1['ins_id'] = $ins_id;
	        $detalles = $this->Inscripcion_model->get_details($ins_id);
	        $estado = $this->Cuenta_model->estadogral($ins_id);
	        $data1['subtitle'] = $detalles[0]->soc_apellido .', '.$detalles[0]->soc_nombre;
	        $data1['soc_id'] = $detalles[0]->soc_id;
	        $data1['act_nombre'] = $detalles[0]->act_nombre;
            $data1['mod_tipo'] = $detalles[0]->mod_tipo;
            $data1['mod_descrip'] = $detalles[0]->mod_descrip;
	        $data1['mod_precio'] = $detalles[0]->mod_precio;
	        $data1['estadogral'] = $estado[0]->cuenta;
            if ($insert == true){
                $data1['_alert'] = 'Pago guardado!';
                $data1['_alert_tipo'] = 'alert-success';
            }else{
                $data1['_alert'] = 'No se pudo registrar el pago, posible repetición de periodo';
                $data1['_alert_tipo'] = 'alert-warning';              
            }        
	        $this->load->view('layouts/main-vertical',$data1);

        }
    }


    public function deletePago($ins_id,$ps_perdesde) {
        //Se agrega el urldecode porque sino el espacio en blanco
        //viene reemplazado por %20
        $delete =  $this->Cuenta_model->delete($ins_id,urldecode($ps_perdesde));

        $data1['_view'] = 'cuenta/index';
        $data1['_dt'] = 'true';
        $data1['title'] = 'Pagos del socio ';
        $data1['ins_id'] = $ins_id;
        $detalles = $this->Inscripcion_model->get_details($ins_id);
        $estado = $this->Cuenta_model->estadogral($ins_id);
        $data1['subtitle'] = $detalles[0]->soc_apellido .', '.$detalles[0]->soc_nombre;
        $data1['soc_id'] = $detalles[0]->soc_id;
        $data1['act_nombre'] = $detalles[0]->act_nombre;
        $data1['mod_tipo'] = $detalles[0]->mod_tipo;
        $data1['mod_descrip'] = $detalles[0]->mod_descrip;

        $data1['mod_precio'] = $detalles[0]->mod_precio;
        $data1['estadogral'] = $estado[0]->cuenta;
        if ($delete == true){
            $data1['_alert'] = 'Registro eliminado!';
            $data1['_alert_tipo'] = 'alert-danger';
        }else{
            $data1['_alert'] = 'No se pudo eliminar el registro';
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

        $pagossocios = $this->Cuenta_model->all($ins_id);
        $data = array();
        if(!empty($pagossocios))
        {
            foreach ($pagossocios as $ps)
            {

    			$nestedData['ins_id'] = 	$ps->ins_id;
    			$nestedData['ps_perdesde'] = 	$ps->ps_perdesde;
    			$nestedData['ps_perhasta'] = 	$ps->ps_perhasta;
    			$nestedData['ps_nrorecibo'] = $ps->ps_nrorecibo;
    			$nestedData['ps_fecha'] = 	$ps->ps_fecha;
    			$nestedData['ps_valor'] = $ps->ps_valor;
    			$nestedData['ps_created'] = $ps->ps_created;
      
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

