<?php
class Login_model extends CI_Model{
 
  function validate($email,$password){
    $this->db->where('soc_email',$email);
    $this->db->where('soc_password',$password);
    $result = $this->db->get('socios',1);
    return $result;
  }
 
}