<?php
defined('BASEPATH') or exit('No direct script access allowed');

class BuyModel extends CI_Model
{
    public function __construct()
    {
        parent::__construct();
    }

   
    public function insertBuy($data){
       
        $codigo= $data['codigo'];
        $validacion = "SELECT * FROM costos WHERE id =?" ;
        $row = $this->db->query($validacion, array($codigo)); 
        
        $tipo=$data['tipoProducto'];
    
        
        if ($row->num_rows() == 0 ) { 
        //1 es huevo 
       
       if($tipo == "2" ){
     
        $idProducto= $data['producto'];
        $cigar = "SELECT stock FROM cigarros WHERE id =?" ;
        $result = $this->db->query($cigar, array($idProducto))->row_array(); 

        $stock_actual = $data['cantidad'] + $result['stock'];  // actualiza el stock en el tipo de huevo 
        $query = "UPDATE cigarros SET stock= ? WHERE id=?";
        $this->db->query($query,array($stock_actual, $idProducto)); 
    
        $compra=array(
            'cantidad'=> $data['cantidad'],
            'precioCompra'=> $data['valor'],
            'total'=> $data['total'],
            'stockReal'=> $stock_actual,
            'costoId'=>  $data['codigo'] ,
            'cigarroId'=>  $data['producto'], // cambiar cuando se implemente ! a dinamico
                    );
       


                                               //sumar a stock de cigarro

        $query = "INSERT INTO compra_cigarro(cantidad,precioCompra,total,stockReal,costoId,cigarroId) VALUES (?,?,?,?,?,?)";
        return $this->db->query($query, $compra);
          
         } else { 
            
        
            $idProducto= $data['producto'];
            $eggs = "SELECT stock FROM huevo WHERE id =?" ;
            $result = $this->db->query($eggs, array($idProducto))->row_array(); 

            $stock_actual = ($data['cantidad'] + $result['stock']);  // actualiza el stock en el tipo de huevo 
            $query = "UPDATE huevo SET stock= ? WHERE id=?";
            $this->db->query($query,array($stock_actual, $idProducto)); 
        
              
             $compra=array(

            'cantidad'=> $data['cantidad'],
            'precioCompra'=> $data['valor'],
            'total'=> $data['total'],                  
            'stockReal'=> $stock_actual,              
            'costoId'=>  $data['codigo'] ,
            'huevoId'=>  $data['producto'], 
            );

            $query = "INSERT INTO compra_huevo(cantidad,precioCompra,total,stockReal,costoId,huevoId) VALUES (?,?,?,?,?,?)";
            return $this->db->query($query, $compra);
        } 
        

    }else{

        return false;
    }

    }





    public function getProductSupplier($id)
    {
       
        $sql = "SELECT * FROM proveedor WHERE id =? AND codProducto = ? " ;
        $codProducto = $this->db->query($sql, array($id,"1")); //1 es huevo 
       
        if ($codProducto->num_rows() > 0 ) { 

            $query = "SELECT h.id , h.name, precioVenta ,p.codProducto ,h.codProducto as idType FROM proveedor p 
            LEFT JOIN huevo_proveedor hp  ON  hp.proveedorId = p.id 
            LEFT JOIN huevo h ON hp.huevoId = h.id
            WHERE p.id = ? AND h.state =? " ;
            return $this->db->query($query,array($id,true))->result();

        } else {

            $cigars= "SELECT c.id, c.nombre as name, cp.precioVenta ,p.codProducto ,c.codProducto as idType FROM proveedor p 
            LEFT JOIN cigarro_proveedor cp  ON p.id = cp.proveedorId
            LEFT JOIN cigarros c  ON cp.cigarroId = c.id
            WHERE p.id=? AND c.state=?" ;
            return $this->db->query($cigars,array($id,true))->result();
        }


    }

    public function getSupplier()
    {
        $query = "SELECT *
                  FROM proveedor
                  ORDER BY nombre ASC" ;
        return $this->db->query($query)->result();
    }










 

}
