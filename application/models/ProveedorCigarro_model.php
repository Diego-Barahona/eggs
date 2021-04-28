<?php

class ProveedorCigarro_model extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

    public function get_proveedorCigarro(){
        $query = "SELECT p.nombre proveedor, c.nombre cigarro, cp.precioVenta precio
        FROM proveedor p
        LEFT JOIN cigarro_proveedor cp ON p.id = cp.proveedorId
        LEFT JOIN cigarros c ON cp.cigarroId = c.id
        WHERE p.codProducto = 2 AND p.state = 1  AND c.state = 1      
        ";  
        return $this->db->query($query)->result();
    }
}