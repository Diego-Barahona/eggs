<?php
defined('BASEPATH') or exit('No direct script access allowed');

class RouteModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getRoutes(){
        $query = "SELECT r.idRuta id, r.fechaRuta fecha, u.full_name vendedor, r.state estado
            FROM rutas r
            LEFT JOIN user u ON u.id = r.codVendedor"; 
        return $this->db->query($query)->result();
    }

    public function getSellers(){
        $query = "SELECT u.id id, u.full_name name
            FROM user u
            LEFT JOIN rol r ON r.id = u.rol_id
            WHERE r.id = 2"; 
        return $this->db->query($query)->result_array();
    }

    public function getDataClient($data){
        $id = $data['id'];
        $query = "SELECT c.sector sector, c.numCalle numero, c.nombreCalle calle
            FROM cliente c
            WHERE c.id = $id"; 
        return $this->db->query($query)->result();
    }

    public function getProducts(){
        $query = "SELECT tp.codProducto, tp.name FROM tipoproducto tp";
        return $this->db->query($query)->result();
    }

    public function getEggsHeaders(){
        $query = "SELECT h.id, h.name, h.Stock stock, h.format
            FROM huevo h";
        return $this->db->query($query)->result_array();
    }

    public function getEggs(){
        $query = "SELECT h.id, h.name, h.format, h.Stock stock, ch.precioCliente precio, ch.idCliente, ch.codProducto
            FROM huevo h
            JOIN clientehuevo ch ON h.id = ch.codProducto
            Where state = 1 ";
        return $this->db->query($query)->result_array();
    }

    public function getCigars(){
        $query = "SELECT c.id, c.nombre, c.precio
            FROM cigarros c";
        return $this->db->query($query)->result();
    }

    public function getClients(){
        $query = "SELECT c.id, c.nomCliente nombre, c.sector, c.nombreCalle calle, c.numCalle numero
            FROM cliente c";
        return $this->db->query($query)->result();
    }

    public function create($data){
        $datos_route = array(
            'fechaRuta' => $data['fechaRuta'],
            'codVendedor' => $data['codVendedor'],
            'detalle' => json_encode($data['detalle']),
            'state' => 0,
        );
        if($this->db->insert('rutas', $datos_route)){
            return true;
        }else{
            return false;
        }
    }

    
    public function update($data){
        $datos_route = array(
            'fechaRuta' => $data['fechaRuta'],
            'codVendedor' => $data['codVendedor'],
            'detalle' => json_encode($data['detalle']),
            'state' => 0,
        );
        $this->db->where('idRuta', $data['id']);
        if($this->db->update('rutas', $datos_route)){
            return true;
        }else{
            return false;
        }
    }

    public function getRouteById($id){
        $query = "SELECT r.idRuta id, r.fechaRuta fecha, r.detalle, r.codVendedor vendedor
            FROM rutas r
            WHERE r.idRuta = $id";
        return $this->db->query($query)->row_array();
    }

    public function getEggsHeadersByRoute($id){
        $query = "SELECT h.id, h.name, h.Stock stock
            FROM huevo h";
        return $this->db->query($query)->result_array();
    }

    public function delete($id){
        if($this->db->delete('rutas', array('idRuta' => $id))){
            return true;
        }else{
            return false;
        }
        return false;
    }
}
