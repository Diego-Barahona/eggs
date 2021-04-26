<?php

class ProveedorCigarro_model extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

    public function get_proveedorCigarro(){
        $this->db->select('p.id,p.nomProveedor,p.codProducto');
        $this->db->from('proveedor p');
        $this->db->where('p.codProducto = 2');
        return $query = $this->db->get()->result();
    }

    
}