<?php

class Clientes_model extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

    public function get_clientes(){
        $this->db->select('c.*');
        $this->db->from('cliente c');
        
       return $query = $this->db->get()->result() ;
    }
    public function create($data){
        $this->db->select('*'); $this->db->from('cliente'); $this->db->where('rutCliente', $data['rutCliente']);
       
        $query = $this->db->get();

        if(sizeof($query->result()) != 0){
            return false;
        }else{
            
            $datos_clientes = array(
                'nomCliente' => $data['nomCliente'],
                'rutCliente' => $data['rutCliente'],
                'sector' => $data['sector'],
                'nombreCalle' => $data['nombreCalle'],
                'numCalle' => $data['numCalle'],
                'state' => 1,
                
            );
            if($this->db->insert('cliente', $datos_clientes)){
                return true;
            }else{
                return false;
            }
        }
    }
    public function update($data){
        $query = "SELECT * FROM cliente WHERE (rutCliente = ? AND rutCliente != ?)" ;
        $result = $this->db->query($query, array($data['rutCliente'], $data['rut_old']));

        if(sizeof($result->result()) >= 1){
            return false;
        }else{
            $datos_clientes = array(
                'nomCliente' => $data['nomCliente'],
                'rutCliente' => $data['rutCliente'],
                'sector' => $data['sector'],
                'nombreCalle' => $data['nombreCalle'],
                'numCalle' => $data['numCalle'],
                'state' => 1,
               
            );
            $this->db->where('rutCliente', $data['rut_old']);
            if($this->db->update('cliente', $datos_clientes)){
                return true;
            }else{
                return false;
            }
        }
    }
    public function des_hab($data){
        $this->db->where('rutCliente', $data['rutCliente']);
        $query = $this->db->update('cliente', $data);
        if($query){
            return true;
        }else{
            return false;
        }
    }
}


