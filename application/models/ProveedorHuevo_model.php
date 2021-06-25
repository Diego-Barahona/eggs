<?php

class ProveedorHuevo_model extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

    public function get_proveedorHuevo(){

        $query = "SELECT p.nombre proveedor, h.name tipoHuevo, hp.precioVenta precio , hp.id
        FROM proveedor p
        LEFT JOIN huevo_proveedor hp ON p.id = hp.proveedorId
        LEFT JOIN huevo h ON hp.huevoId = h.id
        WHERE p.codProducto = 1 AND p.state = 1  AND h.state = 1      
        ";  
        return $this->db->query($query)->result();
    }


    public function getFields(){

        $query = "SELECT * FROM proveedor WHERE proveedor.state=? AND codProducto = 1 ";
        return $this->db->query($query,array(true))->result();
 
     }
 
     public function getEggs(){
 
         $query= "SELECT * FROM huevo WHERE huevo.state=?";
         return $this->db->query($query,array(true))->result();
     }
 
 
     public function addPrecio ($data){

              $proveedor=$data['proveedor'];
              $producto=$data['producto'];

              $query= "SELECT count(*) as contador FROM huevo_proveedor WHERE proveedorId=? and huevoId=?";
              $result= $this->db->query($query,array($proveedor,$producto))->row_array();

              if($result['contador'] == 0 ){

                $obj = array(
                    "precioVenta" =>$data['precio'],
                    "huevoId"=>$data['producto'],
                    "proveedorId" =>$data['proveedor'],
                  );
     
                 $query = "INSERT INTO huevo_proveedor (precioVenta,huevoId,proveedorId) VALUES (?,?,?)";
                 $this->db->query($query,$obj);
                 return true;

              }else{
                  return false;
              
              }
         }
 
 
     public function editPrecio ($data){

        $proveedor = $data['proveedor'];
        $producto  = $data['producto'];

        $query= "SELECT count(*) as contador FROM huevo_proveedor WHERE proveedorId=? and huevoId=?";
        $result= $this->db->query($query,array($proveedor,$producto))->row_array();
  
        if($result['contador'] == 0 ){   
             
             $obj = array(
             
                 "precioVenta" =>$data['precio'],
                 "huevoId"=>$data['producto'],
                 "proveedorId" =>$data['proveedor'],
                 "id"=>$data['id']
             );
  
              $query = "UPDATE huevo_proveedor SET  precioVenta=?,huevoId=?,proveedorId=? WHERE id=?";
              $this->db->query($query,$obj);
              return true;


            } else {

                $precio = $data['precio'];

                $query= "SELECT precioVenta as precio FROM huevo_proveedor WHERE proveedorId=? and huevoId=?";
                $result= $this->db->query($query,array($proveedor,$producto))->row_array();
    

                if($result['precio'] == $precio){
                return false;
            
                }else{

                $obj = array(
                    "precioVenta" =>$precio,
                    "id"=>$data['id']
                );
    
                $query = "UPDATE huevo_proveedor SET  precioVenta=? WHERE id=?";
                $this->db->query($query,$obj);
                return false;

               }
                   
             
            }


    }
 
 
}