<?php
defined('BASEPATH') or exit('No direct script access allowed');

class LoginModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function checkUser($rut)
    {
        $query = $this->db->get_where('user', array('rut' => $rut), 1)->row();
        if (!$query) {return false;} else{return $query;}  
    }

    public function get_user($email)
    {
        $query = $this->db->get_where('user', array('email' => $email), 1)->row();
        if (!$query) {return false;} else{return $query;}  
    }

    public function get_user_with_code($code){
        $query = $this->db->get_where('user', array('code_recovery' => $code), 1)->row();
        if (!$query) {return false;} else{return $query;} 
    }

    public function recovery_password($id, $code, $date)
    {
        $datos_user = array(
            'id' => $id,
            'code_recovery' => $code,
            'date_recovery' => $date,
        );
        $this->db->where('id', $id);
        if($this->db->update('user', $datos_user)){return true;}else{return false;};
    }

    public function new_password($email, $passwd)
    {
        $hash = password_hash($passwd, PASSWORD_DEFAULT, ['cost' => 13]);
        $datos_user = array(
            'password' => $hash,
        );
        $this->db->where('email', $email);
        if($this->db->update('user', $datos_user)){return true;}else{return false;};
    }
    
}
