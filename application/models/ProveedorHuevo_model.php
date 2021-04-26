<?php

class ProveedorHuevo_model extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

    public function get_proveedorHuevo(){
        $this->db->select('p.id,p.nomProveedor,p.codProducto');
        $this->db->from('proveedor p');
        $this->db->where('p.codProducto = 1');
        return $query = $this->db->get()->result();
    }

    
}