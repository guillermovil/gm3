<?php
class Login_model extends CI_Model{
 
  function validate($email,$password){
    $this->db->where('us_email',$email);
    $this->db->where('us_password',$password);
    $result = $this->db->get('users',1);
    return $result;
  }
 
}