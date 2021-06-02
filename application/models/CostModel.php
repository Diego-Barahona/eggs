<?php
defined('BASEPATH') or exit('No direct script access allowed');

class CostModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

    public function getCost()
    {
        $query = "SELECT 
          c.costoGasto as costo_total , c.id , c.fecha ,c.proveedorId as proveedor , p.nombre as nombre_proveedor ,p.codProducto tipoProducto
         FROM costos c 
         JOIN proveedor p ON p.id =c.proveedorId";
        return $this->db->query($query)->result();
    }




    public function getBuys($code)
    {
        $query = "SELECT compras
         FROM costos 
         WHERE id = ?  ";
        return $this->db->query($query,array($code))->result();
    }


    public function getEggs()
    {   
        $query = "SELECT tipoHuevo as nombre , id FROM huevo WHERE huevo.state=? ";
        return $this->db->query($query,array(true))->result();  
    }

    public function getCigar()
    {
        $query = "SELECT nombre , id FROM cigarros WHERE cigarros.state=? ";
        return $this->db->query($query,array(true))->result();  
    }

    public function  insertCost($data) { 


        // tabla -compras ---> compras , cantidad , precio unitario , total 
        //tabla -costo ---> codigo de factura ($id), total final compra , proveedor 
        $codigo = $data['codigo'];
        $validacion = "SELECT * FROM costos WHERE id =?" ;
        $row = $this->db->query($validacion, array($codigo)); 
        
         if($row->num_rows() == 0){
        $costo=array(

            'id'=> $data['codigo'],
            'costoGasto'=> $data['total_costos'],
            'compras'=> $data['compras'],
            'fecha'=> $data['fecha'],
            'proveedorId'=> $data['proveedor'] ,  // cambiar cuando se implemente ! a dinamico
        );

        $query = "INSERT INTO costos (id,costoGasto,compras,fecha,proveedorId) VALUES (?,?, ?,?,?)";
        return $this->db->query($query, $costo);
    }else{ 
        return false;
    }
    //    $query2 = "INSERT INTO costos (idGasto, compra ,nombreGasto,costoGasto,fecha) VALUES (?,?, ?,?,?)";
      //  return $this->db->query($query2, $datos);
         
}
      public function  updateCost($data) { 


        // tabla -compras ---> compras , cantidad , precio unitario , total 
        //tabla -costo ---> codigo de factura ($id), total final compra , proveedor 
       
        $costo= array(
     
            'costoGasto'=> $data['total_costos'],
            'compras'=> $data['compras'],
            'fecha'=> $data['fecha'],
            'proveedorId'=> $data['proveedor'] , 
            'id'=> $data['codigo'], // cambiar cuando se implemente ! a dinamico
        );

        $query = "UPDATE costos SET costoGasto= ? , compras= ? , fecha = ? , proveedorId = ? WHERE id=?";
        return $this->db->query($query, $costo);  
    


    }

     
    public function  deleteProducts($tipoProveedorNuevo,$codigo) { 

        if($tipoProveedorNuevo == 1){
            
            $query = "DELETE FROM compra_huevo WHERE costoId = ?";
            return $this->db->query($query, $codigo);  

        }else{
            $query = "DELETE FROM compra_cigarro WHERE costoId = ?";
            return $this->db->query($query, $codigo);  
           
        }
       
    }

    public function insertCompra($data){
    
        $tipo=$data['tipoProducto'];
       if($tipo == "2" ){
      
            $compra=array(
                'cantidad'=> $data['cantidad'],
                'precioCompra'=> $data['valor'],
                'total'=> $data['total'],
                'stockReal'=> 1000,
                'costoId'=>  $data['codigo'] ,
                'cigarroId'=>  $data['producto'], // cambiar cuando se implemente ! a dinamico
                        );
        
            $query = "INSERT INTO compra_cigarro(cantidad,precioCompra,total,stockReal,costoId,cigarroId) VALUES (?,?,?,?,?,?)";
            return $this->db->query($query, $compra);
          
         } else { 
              
             $compra=array(

            'cantidad'=> $data['cantidad'],
            'precioCompra'=> $data['valor'],
            'total'=> $data['total'],                  
            'stockReal'=> 1000,              
            'costoId'=>  $data['codigo'] ,
            'huevoId'=>  $data['producto'], 
            );

            $query = "INSERT INTO compra_huevo(cantidad,precioCompra,total,stockReal,costoId,huevoId) VALUES (?,?,?,?,?,?)";
            return $this->db->query($query, $compra);
        } 

    }











 

}
