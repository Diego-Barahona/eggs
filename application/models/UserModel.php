<?php

class UserModel extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

    public function get_users(){
        $this->db->select('u.*, r.description');
        $this->db->from('user u');
        $this->db->join('rol r', 'r.id = u.rol_id','left');
        return $query = $this->db->get()->result();
    }

    public function get_roles(){
        return $query=$this->db->get('rol')->result();
    }

    public function create($data){
        $this->db->select('*'); $this->db->from('user'); $this->db->where('rut', $data['rut']);
        $this->db->or_where('email', $data['email']);
        $query = $this->db->get();

        if(sizeof($query->result()) != 0){
            return false;
        }else{
            $hash = password_hash($data['passwd'], PASSWORD_DEFAULT, ['cost' => 13]);
            $datos_user = array(
                'rut' => $data['rut'],
                'password' => $hash,
                'full_name' => $data['full_name'],
                'email' => $data['email'],
                'state' => 1,
                'rol_id' => $data['range'],
            );
            if($this->db->insert('user', $datos_user)){
                return true;
            }else{
                return false;
            }
        }
    }

    public function update($data){
        $query = "SELECT * FROM user WHERE (rut = ? AND rut != ?) OR (email = ? AND email != ?)";
        $result = $this->db->query($query, array($data['rut'], $data['rut_old'], $data['email'], $data['email_old']));

        if(sizeof($result->result()) >= 1){
            return false;
        }else{
            $datos_user = array(
                'rut' => $data['rut'],
                'full_name' => $data['full_name'],
                'email' => $data['email'],
                'state' => 1,
                'rol_id' => $data['range'],
            );
            $this->db->where('rut', $data['rut_old']);
            if($this->db->update('user', $datos_user)){
                return true;
            }else{
                return false;
            }
        }
    }

    public function des_hab($data){
        $this->db->where('rut', $data['rut']);
        $query = $this->db->update('user', $data);
        if($query){
            return true;
        }else{
            return false;
        }
    }
}