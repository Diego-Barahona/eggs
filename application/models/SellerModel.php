<?php
defined('BASEPATH') or exit('No direct script access allowed');

class SellerModel extends CI_Model
{

        public function __construct()
        {
                parent::__construct();
        }

        public function getSaleEggs($data){

            if($_SESSION['rango'] == 2){

                $periodo = $data['periodo'];
                $user = $_SESSION['id'];
                
              if($periodo =="1"){ 
               
                 $year = $data['year'] ;
                 //query que me trae utilidades por año 
   
                 $sql1= " SELECT  v.fechaVenta fecha, v.codVenta codigo , v.totalVenta total_ventas ,v.nomProducto producto , 
                 v.precioUnitario precio , v.cantidadProducto cantidad ,v.rutCliente cliente , u.utilidades utilidades
                 FROM  venta v
                 JOIN utilidades u ON v.codVenta = u.codVenta
                 JOIN  ventahuevo vh ON  vh.codVenta= v.codVenta
                 WHERE   YEAR(v.fechaVenta)= ? and v.codVendedor = ? 
                 GROUP BY v.codVenta ";

                 $dates1 = $this->db->query($sql1,array($year,$user))->result();


                 $sql2= " SELECT SUM(vh.total) as sum_ventas 
                 FROM  venta v
                 JOIN  ventahuevo vh ON  vh.codVenta= v.codVenta
                 WHERE   YEAR(fechaVenta)= ? and v.codVendedor = ? ";
            
                 $cantidad = $this->db->query($sql2,array($year,$user))->result();
                 $array =array( $dates1 ,$cantidad );

                 return $array;
              }
   
              if($periodo == "2"){
                
                
                 $year = $data['year'];
                 $month = $data['month'];
   
                //registro data table
                 $sql3= " SELECT  v.fechaVenta fecha, v.codVenta codigo , v.totalVenta total_ventas ,v.nomProducto producto , 
                 v.precioUnitario precio , v.cantidadProducto cantidad ,v.rutCliente cliente , u.utilidades utilidades
                 FROM  venta v
                 JOIN utilidades u ON v.codVenta = u.codVenta
                 JOIN  ventahuevo vh ON  vh.codVenta= v.codVenta
                  WHERE  MONTH(fechaVenta) = ? and YEAR(fechaVenta) = ? and v.codVendedor=?
                 GROUP BY v.codVenta ";
                 $date1 = $this->db->query($sql3,array($month,$year,$user))->result();

   
                 $sql4 = " SELECT SUM(vh.total) as sum_ventas 
                 FROM  venta v
                 JOIN  ventahuevo vh ON  vh.codVenta= v.codVenta
                 WHERE   MONTH(fechaVenta)= ? and YEAR(fechaVenta)= ?  and v.codVendedor = ? ";
                 $suma = $this->db->query($sql4,array($month,$year,$user))->result();
                 $array = array( $date1,$suma);
            
                 return $array;

                 
              }
   
              if($periodo == "3"){
   
                           $date = $data['date'];
   
                           $sql7= " SELECT  v.fechaVenta fecha, v.codVenta codigo , v.totalVenta total_ventas ,v.nomProducto producto , 
                           v.precioUnitario precio , v.cantidadProducto cantidad ,v.rutCliente cliente , u.utilidades utilidades
                           FROM  venta v
                           JOIN utilidades u ON v.codVenta = u.codVenta
                           JOIN  ventahuevo vh ON  vh.codVenta= v.codVenta
                            WHERE  v.fechaVenta = ? and v.codVendedor=?
                           GROUP BY v.codVenta"; 
                           $date1 = $this->db->query($sql7,array($date,$user))->result();
                           
                           
                           $sql8= "SELECT SUM(vh.total) as sum_ventas 
                           FROM  venta v
                           JOIN  ventahuevo vh ON  vh.codVenta= v.codVenta
                           WHERE   v.fechaVenta= ?  and v.codVendedor = ?"; 
                           $suma= $this->db->query($sql8,array($date,$user))->result();
                           $array = array( $date1 ,$suma );
                           return $array;
   
                   
                   
               }
           }
        }// end function 


        public function getSaleCigar($data){

                if($_SESSION['rango'] == 2){
    
                    $periodo = $data['periodo'];
                    $user = $_SESSION['id'];
                    
                  if($periodo =="1"){ 
                   
                     $year = $data['year'] ;
                     //query que me trae utilidades por año 
       
                     $sql1= " SELECT  v.fechaVenta fecha, v.codVenta codigo , v.totalVenta as total_ventas ,v.nomProducto producto , 
                     v.precioUnitario precio , v.cantidadProducto cantidad ,v.rutCliente cliente , u.utilidades utilidades
                     FROM  venta v
                     JOIN utilidades u ON v.codVenta = u.codVenta
                     JOIN  ventacigarro vc ON  vc.codVenta= v.codVenta
                     WHERE   YEAR(v.fechaVenta)= ? and v.codVendedor = ? 
                     GROUP BY v.codVenta ";
    
                     $dates1 = $this->db->query($sql1,array($year,$user))->result();
    
    
                     $sql2= " SELECT SUM(vc.total) as sum_ventas 
                     FROM  venta v
                     JOIN  ventacigarro vc ON  vc.codVenta= v.codVenta
                     WHERE   YEAR(v.fechaVenta)= ? and v.codVendedor = ? ";
                
                     $cantidad = $this->db->query($sql2,array($year,$user))->result();
                     $array =array( $dates1 ,$cantidad );
    
                     return $array;
                  }
       
                  if($periodo == "2"){
                    
                    
                     $year = $data['year'];
                     $month = $data['month'];
       
                    //registro data table
                     $sql3= " SELECT  v.fechaVenta fecha, v.codVenta codigo , v.totalVenta total_ventas ,v.nomProducto producto , 
                     v.precioUnitario precio , v.cantidadProducto cantidad ,v.rutCliente cliente , u.utilidades utilidades
                     FROM  venta v
                     JOIN utilidades u ON v.codVenta = u.codVenta
                     JOIN  ventacigarro vh ON  vh.codVenta= v.codVenta
                      WHERE  MONTH(fechaVenta) = ? and YEAR(fechaVenta) = ? and v.codVendedor=?
                     GROUP BY v.codVenta ";
                     $date1 = $this->db->query($sql3,array($month,$year,$user))->result();
    
       
                     $sql4 = " SELECT SUM(vh.total) as sum_ventas 
                     FROM  venta v
                     JOIN  ventacigarro vh ON  vh.codVenta= v.codVenta
                     WHERE   MONTH(fechaVenta)= ? and YEAR(fechaVenta)= ?  and v.codVendedor = ? ";
                     $suma = $this->db->query($sql4,array($month,$year,$user))->result();
                     $array = array( $date1,$suma);
                
                     return $array;
    
                     
                  }
       
                  if($periodo == "3"){
       
                               $date = $data['date'];
       
                               $sql7= " SELECT  v.fechaVenta fecha, v.codVenta codigo , v.totalVenta total_ventas ,v.nomProducto producto , 
                               v.precioUnitario precio , v.cantidadProducto cantidad ,v.rutCliente cliente , u.utilidades utilidades
                               FROM  venta v
                               JOIN utilidades u ON v.codVenta = u.codVenta
                               JOIN  ventacigarro vh ON  vh.codVenta= v.codVenta
                                WHERE  v.fechaVenta = ? and v.codVendedor=?
                               GROUP BY v.codVenta"; 
                               $date1 = $this->db->query($sql7,array($date,$user))->result();
                               
                               
                               $sql8= "SELECT SUM(vh.total) as sum_ventas 
                               FROM  venta v
                               JOIN  ventacigarro vh ON  vh.codVenta= v.codVenta
                               WHERE   v.fechaVenta= ?  and v.codVendedor = ?"; 
                               $suma= $this->db->query($sql8,array($date,$user))->result();
                               $array = array( $date1 ,$suma );
                               return $array;
                   }
               }
            }// end function 

            public function getEggs(){
               $this->db->select(' h.id id, h.name producto, h.stock stock');
               $this->db->from('huevo h');
               $this->db->where('h.state',true);
               return $query = $this->db->get()->result();
           }

          /* EMERGENCIA ---> tarjeta stock huevo 
           public function getEggs(){
            $this->db->select(' h.name producto, st.cantidad stock','st.precioCompra');
            $this->db->from('huevo h');
            $this->db->join('stock_huevo st','st.huevoId = h.id');
            $this->db->where('h.state',true);
            return $query = $this->db->get()->result();
            }   


            public function getCigar(){
            $this->db->select(' c.nombre producto, st.cantidad stock','st.precioCompra');
            $this->db->from('cigarros c');
            $this->db->join('stock_cigarro st','st.cigarroId = c.id');
            $this->db->where('c.state',true);
            return $query = $this->db->get()->result();
            }   
              */

             public function getCigar(){
               $this->db->select(' c.id id, c.nombre producto, c.precio price, c.stock stock');
               $this->db->from('cigarros c');
               $this->db->where('c.state',true);
               return $query = $this->db->get()->result();
           }
       



    
}