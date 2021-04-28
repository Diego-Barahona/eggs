<?php

class ProveedorHuevo_model extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

    public function get_proveedorHuevo(){
        $query = "SELECT p.nombre proveedor, h.name tipoHuevo, hp.precioVenta precio
        FROM proveedor p
        LEFT JOIN huevo_proveedor hp ON p.id = hp.proveedorId
        LEFT JOIN huevo h ON hp.huevoId = h.id
        WHERE p.codProducto = 1 AND p.state = 1  AND h.state = 1      
        ";  
        return $this->db->query($query)->result();
    }
}