<?php
class Login extends CI_Controller{
  function __construct(){
    parent::__construct();
    $this->load->model('login_model');
  }
 
	function index(){
		$data['_view'] = 'login/login_view';
		$data['title'] = 'Acceso al sistema';
		$data['subtitle'] = 'Ingrese sus credenciales';
		$data['menu0'] = 'activmenu';
		$data['menu1'] = 'activlista';        
		$this->load->view('layouts/main-vertical',$data);
  	}
 
  function auth(){
    $email    = $this->input->post('email',TRUE);
    $password = md5($this->input->post('password',TRUE));
    $validate = $this->login_model->validate($email,$password);
    if($validate->num_rows() > 0){
        $data  = $validate->row_array();
        $name  = $data['us_name'];
        $email = $data['us_email'];
        $level = $data['us_level'];
        $sesdata = array(
            'username'  => $name,
            'email'     => $email,
            'level'     => $level,
            'logged_in' => TRUE
        );
        $this->session->set_userdata($sesdata);
        if ($this->session->has_userdata('url')){
        	redirect($this->session->url);
        }else{
        	redirect('socio');
        }
        // access login for admin
        // if($level === '1'){
        //     redirect('board');
 
        // // access login for staff
        // }elseif($level === '2'){
        //     redirect('socio');
 
        // // access login for author
        // }else{
        //     redirect('socio');
        // }
    }else{
		$data['_view'] = 'login/login_view';
		$data['title'] = 'Acceso al sistema';
		$data['subtitle'] = 'Ingrese sus credenciales';
		$data['menu0'] = 'activmenu';
		$data['menu1'] = 'activlista';    
        $data['_alert'] = 'Usuario o contraseña incorrecto';
        $data['_alert_tipo'] = 'alert-danger';		    
		$this->load->view('layouts/main-vertical',$data);
    }
  }
 
	function logout(){
  		$this->session->sess_destroy();
		$data['_view'] = 'login/login_view';
		$data['title'] = 'Acceso al sistema';
		$data['subtitle'] = 'Ingrese sus credenciales';
		$data['menu0'] = 'activmenu';
		$data['menu1'] = 'activlista';    
        $data['_alert'] = 'Se desconectó del sistema';
        $data['_alert_tipo'] = 'alert-danger';		    
		$this->load->view('layouts/main-vertical',$data);
  	}
 
}