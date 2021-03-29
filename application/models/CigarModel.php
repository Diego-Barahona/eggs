<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CigarModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getCigars(){
        $this->db->select(' c.id id, c.nombre name, c.precio price, c.stock stock, c.state');
        $this->db->from('cigarros c');
        return $query = $this->db->get()->result();
    }

    public function create($data){
        $this->db->select('*'); $this->db->from('cigarros'); $this->db->where('nombre', $data['name']);
        $query = $this->db->get();

        if(sizeof($query->result()) != 0){
            return false;
        }else{
            $dataCigar= array(
                'nombre' => $data['name'],
                'precio' => $data['price'],
                'stock' => $data['stock'],
                'state' => 1,
                'codProducto' => 2,
            );
            if($this->db->insert('cigarros', $dataCigar)){
                return true;
            }else{
                return false;
            }
        }
    }

    public function update($data){
        $query = "SELECT * FROM cigarros WHERE (nombre = ? AND nombre != ?)";
        $result = $this->db->query($query, array($data['name'], $data['nameOld']));

        if(sizeof($result->result()) >= 1){
            return false;
        }else{
            $dataCigar= array(
                'nombre' => $data['name'],
                'precio' => $data['price'],
                'stock' => $data['stock'],
                'state' => $data['state'],
            );
            $this->db->where('id', $data['id']);
            if($this->db->update('cigarros', $dataCigar)){
                return true;
            }else{
                return false;
            }
        }
    }

    public function desHab($data){
        $this->db->where('id', $data['id']);
        $query = $this->db->update('cigarros', $data);
        if($query){
            return true;
        }else{
            return false;
        }
    }

}
