<?php

class Proveedor_model extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

    public function get_proveedor(){
        $this->db->select('p.*');
        $this->db->from('proveedor p');
        
       return $query = $this->db->get()->result() ;
    }
    public function create($data){
        $this->db->select('*'); $this->db->from('proveedor'); $this->db->where('rutProveedor', $data['rutProveedor']);
       
        $query = $this->db->get();

        if(sizeof($query->result()) != 0){
            return false;
        }else{
            
            $datos_proveedores = array(
                'nombre' => $data['nomProveedor'],
                'rutProveedor' => $data['rutProveedor'],
                'telefono' => $data['telefono'],
                'correoProveedor' => $data['correoProveedor'],
                'codProducto' => $data['codProducto'],
                'state' => 1,
                
            );
            if($this->db->insert('proveedor', $datos_proveedores)){
                return true;
            }else{
                return false;
            }
        }
    }
    public function update($data){
        $query = "SELECT * FROM proveedor WHERE (rutProveedor = ? AND rutProveedor != ?)" ;
        $result = $this->db->query($query, array($data['rutProveedor'], $data['rutProveedor_old']));

        if(sizeof($result->result()) >= 1){
            return false;
        }else{
            $datos_proveedores = array(
                'nombre' => $data['nomProveedor'],
                'rutProveedor' => $data['rutProveedor'],
                'telefono' => $data['telefono'],
                'correoProveedor' => $data['correoProveedor'],
                'codProducto' => $data['codProducto'],
                'state' => 1,
               
            );
            $this->db->where('rutProveedor', $data['rutProveedor_old']);
            if($this->db->update('proveedor', $datos_proveedores)){
                return true;
            }else{
                return false;
            }
        }
    }
    public function des_hab($data){
        $this->db->where('rutProveedor', $data['rutProveedor']);
        $query = $this->db->update('proveedor', $data);
        if($query){
            return true;
        }else{
            return false;
        }
    }
}


