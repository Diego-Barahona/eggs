<?php

class ProveedorCigarro_model extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

    public function get_proveedorCigarro(){
        $query = "SELECT p.nombre proveedor, c.nombre cigarro, cp.precioVenta precio,cp.id
        FROM proveedor p
        LEFT JOIN cigarro_proveedor cp ON p.id = cp.proveedorId
        LEFT JOIN cigarros c ON cp.cigarroId = c.id
        WHERE p.codProducto = 2 AND p.state = 1  AND c.state = 1      
        ";  
        return $this->db->query($query)->result();
    }

    public function getFields(){

       $query = "SELECT * FROM proveedor WHERE proveedor.state=? AND codProducto = 2 ";
       return $this->db->query($query,array(true))->result();

    }

    public function getCigars (){

        $query= "SELECT * FROM cigarros WHERE cigarros.state=?";
        return $this->db->query($query,array(true))->result();
    }


    public function addPrecio ($data){
 
        $proveedor = $data['proveedor'];
        $producto  = $data['producto'];

        $query= "SELECT count(*) as contador FROM cigarro_proveedor WHERE proveedorId=? and cigarroId=?";
        $result= $this->db->query($query,array($proveedor,$producto))->row_array();

        if($result['contador'] == 0 ){   
           $obj = array(
               "precioVenta" =>$data['precio'],
               "cigarroId"=>$data['producto'],
               "proveedorId" =>$data['proveedor'],
           );

            $query = "INSERT INTO cigarro_proveedor (precioVenta,cigarroId,proveedorId) VALUES (?,?,?)";
            $this->db->query($query,$obj);

            return true;
        }else{
            return false;
        }
        }


    public function editPrecio ($data){
            
        $proveedor = $data['proveedor'];
        $producto  = $data['producto'];

        $query= "SELECT count(*) as contador FROM cigarro_proveedor WHERE proveedorId=? and cigarroId=?";
        $result= $this->db->query($query,array($proveedor,$producto))->row_array();

        if($result['contador'] == 0 ){   

            $obj = array(
            
                "precioVenta" =>$data['precio'],
                "cigarroId"=>$data['producto'],
                "proveedorId" =>$data['proveedor'],
                "id"=>$data['id']
            );
 
             $query = "UPDATE cigarro_proveedor SET  precioVenta=?,cigarroId=?,proveedorId=? WHERE id=?";
             $this->db->query($query,$obj);
             return true;
        }else{

            $precio = $data['precio'];

            $query= "SELECT precioVenta as precio FROM cigarro_proveedor WHERE proveedorId=? and cigarroId=?";
            $result= $this->db->query($query,array($proveedor,$producto))->row_array();
    

            if($result['precio'] == $precio){
                return false;
            }else{

                $obj = array(
                    "precioVenta" =>$precio,
                    "id"=>$data['id']
                );
    
                $query = "UPDATE cigarro_proveedor SET  precioVenta=? WHERE id=?";
                $this->db->query($query,$obj);
                return false;

               }
          

            
      
            }

         }



       
    
    
}