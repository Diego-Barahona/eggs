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
        
       if($tipo == "2" ){
        
        $idProducto= $data['producto'];
        $precioCompra =$data['valor'];
       
             $compra=array(

            'cantidad'=> $data['cantidad'],
            'precioCompra'=> $data['valor'],
            'total'=> $data['total'],                  
            'costoId'=>  $data['codigo'] ,
            'cigarroId'=>  $data['producto'], 
            );

            // contador para saber si exite o no el producto-precio en tabla stock_cigarro
            $query_stock = "SELECT COUNT(*) as contador FROM stock_cigarro WHERE codTipoProducto IN (?) and precioCompra=?";
            $count_row =  $this->db->query( $query_stock,array($idProducto,$precioCompra))->row_array();

            if($count_row['contador'] == 0){//si no existe -> lo crea 

                $row = array( 'precioCompra'=> $data['valor'], 'auxiliar'=> $data['cantidad'],'cantidad'=> $data['cantidad'],'codTipoProducto'=>  $data['producto']);

                $save_stock = "INSERT INTO stock_cigarro(precioCompra,auxiliar,cantidad,codTipoProducto) VALUES (?,?,?,?)";
                $this->db->query($save_stock, $row);

               
            }else { //si existe -> le suma cantidad al stock de ese producto-precio

                $query_cant= "SELECT cantidad ,auxiliar FROM stock_cigarro WHERE codTipoProducto IN (?) and precioCompra=?";
                $cant_old = $this->db->query($query_cant,array($idProducto,$precioCompra))->row_array();
                
                $new_stock = ($cant_old['cantidad'] + $data['cantidad']);
                $new_auxiliar= ($cant_old['auxiliar'] + $data['cantidad']);
                                                                                                                                                                   
                $row = array('auxiliar'=> $new_auxiliar, 'cantidad'=> $new_stock , 'codTipoProducto'=>  $data['producto'],'precioCompra'=>$precioCompra );

                $save_stock = "UPDATE stock_cigarro SET auxiliar = ?, cantidad=? WHERE codTipoProducto = ? and precioCompra=?";
                $this->db->query($save_stock, $row);

            }

            $query = "INSERT INTO compra_cigarro(cantidad,precioCompra,total,costoId,cigarroId) VALUES (?,?,?,?,?)";
            return $this->db->query($query, $compra);
           
         } else { 
            
        
            $idProducto= $data['producto'];
            $precioCompra=$data['valor'];
              
             $compra=array(

            'cantidad'=> $data['cantidad'],
            'precioCompra'=> $data['valor'],
            'total'=> $data['total'],                  
            'costoId'=>  $data['codigo'] ,
            'huevoId'=>  $data['producto'], 
            );


            // contador para saber si exite o no el producto-precio en tabla stock_huevo
            $query_stock = "SELECT COUNT(*) as contador FROM stock_huevo WHERE codTipoProducto IN (?) and precioCompra=?";
            $count_row =  $this->db->query( $query_stock,array($idProducto,$precioCompra))->row_array();

            if($count_row['contador'] == 0){//si no existe -> lo crea 

                $row = array( 'precioCompra'=> $data['valor'], 'auxiliar'=> $data['cantidad'],'cantidad'=> $data['cantidad'],'codTipoProducto'=>  $data['producto']);

                $save_stock = "INSERT INTO stock_huevo(precioCompra,auxiliar,cantidad,codTipoProducto) VALUES (?,?,?,?)";
                $this->db->query($save_stock, $row);

               
            }else { //si existe -> le suma cantidad al stock de ese producto-precio

                $query_cant= "SELECT cantidad ,auxiliar FROM stock_huevo WHERE codTipoProducto IN (?) and precioCompra=?";
                $cant_old = $this->db->query($query_cant,array($idProducto,$precioCompra))->row_array();
                
                $new_stock = ($cant_old['cantidad'] + $data['cantidad']);
                $new_auxiliar= ($cant_old['auxiliar'] + $data['cantidad']);
                                                                                                                                                                   
                $row = array('auxiliar'=> $new_auxiliar, 'cantidad'=> $new_stock , 'codTipoProducto'=>  $data['producto'],'precioCompra'=>$precioCompra );

                $save_stock = "UPDATE stock_huevo SET auxiliar = ?, cantidad=? WHERE codTipoProducto = ? and precioCompra=?";
                $this->db->query($save_stock, $row);

            }

            $query = "INSERT INTO compra_huevo(cantidad,precioCompra,total,costoId,huevoId) VALUES (?,?,?,?,?)";
            return $this->db->query($query, $compra);
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
