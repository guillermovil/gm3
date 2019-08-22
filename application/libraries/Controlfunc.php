<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Controlfunc {

    public function date_valid($date){
    // La fecha viene en formato yyyy-mm-dd
        $parts = explode("-", $date);
        if (count($parts) == 3) {      
          if (checkdate($parts[1], $parts[2], $parts[0])){
            return true;
          }
        }else{
            return false;       
        }
    }

    public function sinonull($dato){
        if ($dato == ''){
            return null;
        }else{
            return $dato;
        }
    }    
}