<?php
defined('BASEPATH') or exit('No direct script access allowed');

class GraphicModel extends CI_Model
{

        public function __construct()
        {
                parent::__construct();
        }

        public function getUtilsByPeriod($data){

         $periodo = $data['periodo'];
        
           if($periodo =="1"){ 
            
              $year = $data['year'] ;

              $year = $data['year'];
              //query que me trae utilidades por año 
              $sql0= "SELECT YEAR(v.fechaVenta) as tiempo , SUM(u.utilidades) as utilidades
              FROM  utilidades u 
              JOIN  venta v ON v.codVenta = u.codVenta
              GROUP BY YEAR(v.fechaVenta)"; 
              $byYear = $this->db->query($sql0)->result();

              $sql1= " SELECT  u.utilidades , v.fechaVenta fecha, v.codVenta codigo , u.totalCompra total_compra , u.totalVenta total_venta 
              FROM  utilidades u 
              JOIN  venta v ON v.codVenta =u.codVenta
              WHERE YEAR(v.fechaVenta) = ? "; 
              $dates = $this->db->query($sql1,array($year))->result();

              $sql = " SELECT   YEAR(v.fechaVenta) as tiempo , SUM(u.utilidades) as utilidades
              FROM  utilidades u 
              JOIN  venta v ON v.codVenta =u.codVenta
              WHERE YEAR(v.fechaVenta) = ? "; 
              $res = $this->db->query($sql,array($year))->result();
              $array =array( $res ,  $byYear ,$dates );
              return $array;
           }

           if($periodo == "2"){
             
                $opcion= $data['option'];

              if($opcion =="1"){
              $year = $data['year'];
              $month = $data['month'];

              $sql2= "SELECT MONTH(v.fechaVenta) as tiempo , SUM(u.utilidades) as utilidades
              FROM  utilidades u 
              JOIN  venta v ON v.codVenta = u.codVenta
              WHERE  YEAR(v.fechaVenta)= ? 
              GROUP BY MONTH(v.fechaVenta)"; 
              $byMonth = $this->db->query($sql2,$year)->result();

             //registro data table
              $sql3= " SELECT  u.utilidades , v.fechaVenta fecha, v.codVenta codigo , u.totalCompra total_compra , u.totalVenta total_venta 
              FROM  utilidades u 
              JOIN  venta v ON v.codVenta = u.codVenta
              WHERE  MONTH(v.fechaVenta) = ? and YEAR(v.fechaVenta) = ? "; 
              $dates = $this->db->query($sql3,array($month,$year))->result();

              $sql4 = " SELECT   MONTH(v.fechaVenta) as tiempo, SUM(u.utilidades) as utilidades
              FROM  utilidades u 
              JOIN  venta v ON v.codVenta =u.codVenta
              WHERE MONTH(v.fechaVenta) = ? and YEAR(v.fechaVenta) = ? "; 
              $res = $this->db->query($sql4,array($month,$year))->result();
              $array =array( $res ,$byMonth ,$dates);
         
              return $array;
              } else{
                  //comparacion entre dos meses de diverso año 

                  $year = $data['year'];  $month = $data['month'];  $year2 = $data['year2'];  $month2 = $data['month2'];

                  $sql1 = " SELECT   MONTH(v.fechaVenta) as tiempo1,YEAR(v.fechaVenta) as tiempo2, SUM(u.utilidades) as utilidades
                  FROM  utilidades u 
                  JOIN  venta v ON v.codVenta =u.codVenta
                  WHERE MONTH(v.fechaVenta) = ? and YEAR(v.fechaVenta) = ? "; 
                  $res1 = $this->db->query($sql1,array($month,$year))->result();
                

                  $sql2 = " SELECT   MONTH(v.fechaVenta) as tiempo1, YEAR(v.fechaVenta) as tiempo2, SUM(u.utilidades) as utilidades
                  FROM  utilidades u 
                  JOIN  venta v ON v.codVenta =u.codVenta
                  WHERE MONTH(v.fechaVenta) = ? and YEAR(v.fechaVenta) = ? "; 
                  $res2 = $this->db->query($sql2,array($month2,$year2))->result();
                  return $array =array( $res1 ,$res2);

              }
           }

           if($periodo == "3"){

                $opcion= $data['option'];

                if($opcion =="1"){
                       
                        $date1 = $data['date1'];

                        $sql7= " SELECT  u.utilidades , v.fechaVenta fecha, v.codVenta codigo, u.totalCompra total_compra , u.totalVenta total_venta 
                                 FROM  utilidades u 
                                JOIN  venta v ON v.codVenta = u.codVenta
                                WHERE  v.fechaVenta = ? "; 
                                 $res1 = $this->db->query($sql7,array($date1))->result();
                        
                        
                        $sql8= " SELECT  v.fechaVenta fecha,SUM(u.utilidades) utilidades
                        FROM  utilidades u 
                        JOIN  venta v ON v.codVenta = u.codVenta
                        WHERE  v.fechaVenta = ?"; 
                        $res2 = $this->db->query($sql8,array($date1))->result();
                        $array = array( $res1 ,$res2 );
                        return $array;

                
                }else{

                       $date1 = $data['date1'];
                       $date2 = $data['date2'];
                       
                       $sql5= " SELECT  v.fechaVenta fecha,SUM(u.utilidades) utilidades 
                        FROM  utilidades u 
                        JOIN  venta v ON v.codVenta = u.codVenta
                        WHERE  v.fechaVenta = ?"; 
                        $res1 = $this->db->query($sql5,array($date1))->result();
            
                        $sql6= " SELECT v.fechaVenta fecha,SUM(u.utilidades) utilidades
                        FROM  utilidades u 
                        JOIN  venta v ON v.codVenta = u.codVenta
                        WHERE  v.fechaVenta = ?"; 
                        $res2 = $this->db->query($sql6,array($date2))->result();
                        $array =array( $res1,$res2);
                      
                        return $array;

                }
            }
        }


       // get sale information by period

        public function getSaleByPeriod($data){

                $periodo = $data['periodo'];
               
                  if($periodo =="1"){ 
                   
                     $year = $data['year'] ;
       
                
                     //query que me trae utilidades por año 
                     $sql0= "SELECT YEAR(fechaVenta) as tiempo , SUM(totalVenta) as utilidades
                     FROM  venta 
                     GROUP BY YEAR(fechaVenta)"; 
                     $byYear = $this->db->query($sql0)->result();
       
                     $sql1= " SELECT  fechaVenta fecha, codVenta codigo , totalVenta utilidades ,nomProducto producto ,
                     precioUnitario precio , cantidadProducto cantidad
                     FROM  venta 
                     WHERE YEAR(fechaVenta) = ? "; 
                     $dates = $this->db->query($sql1,array($year))->result();
       
                     $sql = " SELECT   YEAR(fechaVenta) as tiempo , SUM(totalVenta) as utilidades
                     FROM  venta
                     WHERE YEAR(fechaVenta) = ? "; 
                     $res = $this->db->query($sql,array($year))->result();
                     $array =array( $res ,  $byYear ,$dates );
                     return $array;
                  }
       
                  if($periodo == "2"){
                    
                       $opcion= $data['option'];
       
                     if($opcion =="1"){

                     $year = $data['year'];
                     $month = $data['month'];
       
                     $sql2= "SELECT MONTH(fechaVenta) as tiempo , SUM(totalVenta) as utilidades
                     FROM  venta
                     WHERE  YEAR(fechaVenta)= ? 
                     GROUP BY MONTH(fechaVenta)"; 
                     $byMonth = $this->db->query($sql2,$year)->result();
       
                    //registro data table
                     $sql3= " SELECT  totalVenta utilidades , fechaVenta fecha, codVenta codigo,nomProducto producto ,
                     precioUnitario precio , cantidadProducto cantidad 
                     FROM  venta
                     WHERE  MONTH(fechaVenta) = ? and YEAR(fechaVenta) = ? "; 
                     $dates = $this->db->query($sql3,array($month,$year))->result();
       
                     $sql4 = " SELECT MONTH(fechaVenta) as tiempo, SUM(totalVenta) as utilidades
                     FROM  venta
                     WHERE MONTH(fechaVenta) = ? and YEAR(fechaVenta) = ? "; 
                     $res = $this->db->query($sql4,array($month,$year))->result();
                     $array =array( $res ,$byMonth ,$dates);
                
                     return $array;

                     } else{
                         //comparacion entre dos meses de diverso año 
       
                         $year = $data['year'];  $month = $data['month'];  $year2 = $data['year2'];  $month2 = $data['month2'];
       
                         $sql1 = " SELECT   MONTH(fechaVenta) as tiempo1,YEAR(fechaVenta) as tiempo2, SUM(totalVenta) as utilidades
                         FROM  venta 
                         WHERE MONTH(fechaVenta) = ? and YEAR(fechaVenta) = ? "; 
                         $res1 = $this->db->query($sql1,array($month,$year))->result();
                       
       
                         $sql2 = " SELECT   MONTH(fechaVenta) as tiempo1, YEAR(fechaVenta) as tiempo2, SUM(totalVenta) as utilidades
                         FROM  venta
                         WHERE MONTH(fechaVenta) = ? and YEAR(fechaVenta) = ? "; 
                         $res2 = $this->db->query($sql2,array($month2,$year2))->result();
                         return $array =array( $res1 ,$res2);
       
                     }
                  }
       
                  if($periodo == "3"){
       
                       $opcion= $data['option'];
       
                       if($opcion =="1"){
                              
                               $date1 = $data['date1'];
       
                               $sql7= " SELECT  totalVenta utilidades , fechaVenta fecha, codVenta codigo,nomProducto producto ,
                               precioUnitario precio , cantidadProducto cantidad
                                        FROM venta
                                       WHERE  fechaVenta = ? "; 
                                        $res1 = $this->db->query($sql7,array($date1))->result();
                               
                               
                               $sql8= " SELECT  fechaVenta fecha,SUM(totalVenta) utilidades
                               FROM  venta
                               WHERE fechaVenta = ?"; 
                               $res2 = $this->db->query($sql8,array($date1))->result();
                               $array = array( $res1 ,$res2 );
                               return $array;
       
                       
                       }else{
       
                              $date1 = $data['date1'];
                              $date2 = $data['date2'];
                              
                               $sql5= " SELECT  fechaVenta fecha,SUM(totalVenta) utilidades 
                               FROM venta
                               WHERE  fechaVenta = ?"; 
                               $res1 = $this->db->query($sql5,array($date1))->result();
                   
                               $sql6= " SELECT fechaVenta fecha,SUM(totalVenta) utilidades
                               FROM  venta
                               WHERE  fechaVenta = ?"; 
                               $res2 = $this->db->query($sql6,array($date2))->result();
                               $array =array( $res1,$res2);
                             
                               return $array;
       
                       }
                   }
               }



               public function getSaleByProduct($data){

                $periodo = $data['periodo'];
                $table_join=$data['table'];    
                $table_product=$data['table_product'];             
                $fk= $data['cod_venta'];
                $id= $data['id_product'];
                $name = $data['name'];
                $id_join= $data['id_join'];

               
                  if($periodo =="1"){ 

                     //$product = $data['product'];

                     // if($product =="1"){
                     $year = $data['year'] ;
                     //query que me trae utilidades por año 
                     $sql0= "SELECT YEAR(v.fechaVenta) as tiempo , SUM(v.totalVenta) as utilidades
                     FROM  venta v
                     JOIN $table_join ON v.codVenta =  $fk 
                     GROUP BY YEAR(v.fechaVenta)"; 
                     $byYear = $this->db->query($sql0)->result();
       
                     $sql1= " SELECT  v.fechaVenta fecha, v.codVenta codigo , v.totalVenta utilidades , $name , v.nomProducto producto ,
                     v.precioUnitario precio , v.cantidadProducto cantidad
                     FROM  venta v
                     JOIN  $table_join ON v.codVenta =   $fk 
                     JOIN  $table_product  ON $id_join= $id
                     WHERE YEAR(v.fechaVenta) = ? "; 
                     $dates = $this->db->query($sql1,array($year))->result();
       
                     $sql = " SELECT   YEAR(v.fechaVenta) as tiempo , SUM(v.totalVenta) as utilidades
                     FROM  venta v
                     JOIN  $table_join ON v.codVenta =  $fk
                     WHERE YEAR(v.fechaVenta) = ? "; 
                     $res = $this->db->query($sql,array($year))->result();
                     $array =array( $res ,  $byYear ,$dates );
                     return $array;
                    
                     }
       
                  if($periodo == "2"){
                    
                       $opcion= $data['option'];
                    
       
                     if($opcion =="1"){

                       $year = $data['year'];
                       $month = $data['month'];
                       $sql2= "SELECT MONTH(fechaVenta) as tiempo , SUM(totalVenta) as utilidades
                       FROM  venta v
                     JOIN $table_join  ON v.codVenta = $fk
                     WHERE  YEAR(fechaVenta)= ? 
                     GROUP BY MONTH(fechaVenta)"; 
                     $byMonth = $this->db->query($sql2,$year)->result();
       
                    //registro data table
                     $sql3= " SELECT  v.totalVenta utilidades , v.fechaVenta fecha, v.codVenta codigo ,$name, v.nomProducto producto ,
                     v.precioUnitario precio , v.cantidadProducto cantidad
                     FROM  venta v
                     JOIN  $table_join ON v.codVenta =$fk 
                     JOIN  $table_product  ON $id_join= $id
                     WHERE  MONTH(v.fechaVenta) = ? and YEAR(v.fechaVenta) = ? "; 
                     $dates = $this->db->query($sql3,array($month,$year))->result();
       
                     $sql4 = " SELECT MONTH(v.fechaVenta) as tiempo, SUM(v.totalVenta) as utilidades
                     FROM  venta v
                     JOIN  $table_join ON v.codVenta =   $fk 
                     WHERE MONTH(v.fechaVenta) = ? and YEAR(v.fechaVenta) = ? "; 
                     $res = $this->db->query($sql4,array($month,$year))->result();
                     $array =array( $res ,$byMonth ,$dates);
                
                     return $array;

                       }else{
                         //comparacion entre dos meses de diverso año 
       
                         $year = $data['year'];  $month = $data['month'];  $year2 = $data['year2'];  $month2 = $data['month2'];
       
                         $sql1 = " SELECT   MONTH(v.fechaVenta) as tiempo1,YEAR(v.fechaVenta) as tiempo2, SUM(v.totalVenta) as utilidades
                         FROM  venta v
                         JOIN  $table_join ON v.codVenta =$fk 
                         WHERE MONTH(fechaVenta) = ? and YEAR(fechaVenta) = ? "; 
                         $res1 = $this->db->query($sql1,array($month,$year))->result();

                         $sql2 = " SELECT   MONTH(v.fechaVenta) as tiempo1, YEAR(v.fechaVenta) as tiempo2, SUM(v.totalVenta) as utilidades
                         FROM  venta v
                         JOIN  $table_join ON v.codVenta =$fk 
                         WHERE MONTH(v.fechaVenta) = ? and YEAR(v.fechaVenta) = ? "; 
                         $res2 = $this->db->query($sql2,array($month2,$year2))->result();
                         return $array =array( $res1 ,$res2);
                        
                        }
                  }
       
                  if($periodo == "3"){
       
                       $opcion= $data['option'];
       
                       if($opcion =="1"){
                              
                               $date1 = $data['date1'];

                               $sql7= " SELECT  v.totalVenta utilidades , v.fechaVenta fecha, v.codVenta codigo,v.nomProducto producto ,
                               v.precioUnitario precio , v.cantidadProducto cantidad 
                                        FROM venta v
                                        JOIN  $table_join ON v.codVenta = $fk 
                                       WHERE  v.fechaVenta = ? "; 
                                        $res1 = $this->db->query($sql7,array($date1))->result();
                               
                               
                               $sql8= " SELECT  v.fechaVenta fecha,SUM(v.totalVenta) utilidades
                                        FROM  venta v
                                        JOIN  $table_join ON v.codVenta = $fk 
                                        WHERE v.fechaVenta = ?"; 
                                        $res2 = $this->db->query($sql8,array($date1))->result();
                               $array = array( $res1 ,$res2 );

                               return $array;
       
                       
                       }else{
       
                               $date1 = $data['date1'];
                               $date2 = $data['date2'];
                              
                               $sql5= " SELECT  v.fechaVenta fecha, SUM(v.totalVenta) utilidades 
                               FROM venta v
                               JOIN  $table_join ON v.codVenta = $fk 
                               WHERE  v.fechaVenta = ?"; 
                               $res1 = $this->db->query($sql5,array($date1))->result();
                   
                               $sql6= " SELECT v.fechaVenta fecha,SUM(v.totalVenta) utilidades
                               FROM  venta v
                               JOIN  $table_join ON v.codVenta = $fk 
                               WHERE  v.fechaVenta = ?"; 
                               $res2 = $this->db->query($sql6,array($date2))->result();
                               $array =array( $res1,$res2);
                             
                               return $array;
       
                       }
                   }
               }

               ////////////////// compras ///////////////////////////

               public function getBuysByPeriod($data){

                $periodo = $data['periodo'];
               
                  if($periodo =="1"){ 
                   
                     $year = $data['year'] ;
       
                
                     //query que me trae utilidades por año 
                     $sql0= "SELECT YEAR(fecha) as tiempo , SUM(costoGasto) as utilidades
                     FROM  costos
                     GROUP BY YEAR(fecha)"; 
                     $byYear = $this->db->query($sql0)->result();
       
                     $sql1= " SELECT  c.fecha fecha, c.id codigo , c.costoGasto utilidades , p.nombre proveedor,p.codProducto producto
                     FROM  costos c
                     JOIN  proveedor p ON p.id = c.proveedorId
                     WHERE YEAR(c.fecha) = ? "; 
                     $dates = $this->db->query($sql1,array($year))->result();
       
                     $sql = " SELECT   YEAR(fecha) as tiempo , SUM(costoGasto) as utilidades
                     FROM  costos
                     WHERE YEAR(fecha) = ? "; 
                     $res = $this->db->query($sql,array($year))->result();
                     $array =array( $res ,  $byYear ,$dates );
                     return $array;
                  }
       
                  if($periodo == "2"){
                    
                       $opcion= $data['option'];
       
                     if($opcion =="1"){

                     $year = $data['year'];
                     $month = $data['month'];
       
                     $sql2= "SELECT MONTH(fecha) as tiempo , SUM(costoGasto) as utilidades
                     FROM  costos
                     WHERE  YEAR(fecha)= ? 
                     GROUP BY MONTH(fecha)"; 
                     $byMonth = $this->db->query($sql2,$year)->result();
       
                    //registro data table
                     $sql3= " SELECT  c.costoGasto utilidades , c.fecha fecha, c.id codigo ,p.nombre proveedor,p.codProducto producto
                     FROM  costos c 
                     JOIN  proveedor p ON p.id = c.proveedorId
                     WHERE  MONTH(c.fecha) = ? and YEAR(c.fecha) = ? "; 
                     $dates = $this->db->query($sql3,array($month,$year))->result();
       
                     $sql4 = " SELECT MONTH(fecha) as tiempo, SUM(costoGasto) as utilidades
                     FROM  costos
                     WHERE MONTH(fecha) = ? and YEAR(fecha) = ? "; 
                     $res = $this->db->query($sql4,array($month,$year))->result();
                     $array =array( $res ,$byMonth ,$dates);
                
                     return $array;

                     } else{
                         //comparacion entre dos meses de diverso año 
                         $year = $data['year'];  $month = $data['month'];  $year2 = $data['year2'];  $month2 = $data['month2'];
       
                         $sql1 = " SELECT   MONTH(fecha) as tiempo1,YEAR(fecha) as tiempo2, SUM(costoGasto) as utilidades FROM  costos WHERE MONTH(fecha) = ? and YEAR(fecha) = ? "; 
                         $res1 = $this->db->query($sql1,array($month,$year))->result();
                       
       
                         $sql2 = " SELECT   MONTH(fecha) as tiempo1, YEAR(fecha) as tiempo2, SUM(costoGasto) as utilidades FROM  costos  WHERE MONTH(fecha) = ? and YEAR(fecha) = ? "; 
                         $res2 = $this->db->query($sql2,array($month2,$year2))->result();
                         return $array =array( $res1 ,$res2);
                     }
                  }
       
                  if($periodo == "3"){
       
                       $opcion= $data['option'];
       
                       if($opcion =="1"){
                              
                               $date1 = $data['date1'];
       
                               $sql7= " SELECT  c.fecha fecha, c.id codigo , c.costoGasto utilidades , p.nombre proveedor ,p.codProducto producto FROM  costos c
                               JOIN  proveedor p ON p.id = c.proveedorId
                               WHERE  c.fecha = ? "; 
                                        $res1 = $this->db->query($sql7,array($date1))->result();
                               
                               $sql8= " SELECT  fecha fecha , SUM(costoGasto) utilidades FROM  costos  WHERE fecha = ?"; 
                                        $res2 = $this->db->query($sql8,array($date1))->result();
                                        $array = array( $res1 ,$res2 );
                               return $array;
                       }else{
       
                              $date1 = $data['date1'];
                              $date2 = $data['date2'];
                              
                               $sql5= " SELECT  fecha fecha , SUM(costoGasto) utilidades FROM costos WHERE  fecha = ?"; 
                                        $res1 = $this->db->query($sql5,array($date1))->result();
                   
                               $sql6= " SELECT fecha fecha,SUM(costoGasto) utilidades FROM  costos WHERE  fecha = ?"; 
                                        $res2 = $this->db->query($sql6,array($date2))->result();

                               $array =array( $res1,$res2);
                             
                               return $array;
       
                       }
                   }
               }


               public function getBuyByProduct($data){

                $periodo = $data['periodo']; //1 o2
                $table_join=$data['table'];   // compra_cigarro cc o compra_huevo ch 
                $table_product=$data['table_product'];  // cigarro c o huevo h          
                $fk= $data['cod_compra']; // cc.costoID o ch.costoID
                $id= $data['id_product']; //h.id o c.id
                $name = $data['name'];  //h.name o c.nombre
                $id_join= $data['id_join']; //idCigarro o idHuevo
                $total = $data['total'] ; 

               
                  if($periodo =="1"){ 

                     //$product = $data['product'];

                     // if($product =="1"){
                     $year = $data['year'] ;
                     
                     //query que me trae utilidades por año 
                     $sql0= "SELECT YEAR(ct.fecha) as tiempo , SUM($total) as utilidades
                     FROM  costos ct
                     JOIN $table_join ON ct.id =  $fk 
                     GROUP BY YEAR(ct.fecha)"; 
                     $byYear = $this->db->query($sql0)->result();
       
                     $sql1= " SELECT  ct.fecha fecha, ct.id codigo , ct.costoGasto utilidades , $name, p.nombre proveedor ,p.codProducto producto
                     FROM  costos ct
                     JOIN  $table_join ON  ct.id =  $fk 
                     JOIN  $table_product  ON $id_join= $id
                     JOIN  proveedor p ON p.id= ct.proveedorId
                     WHERE YEAR(ct.fecha) = ?
                     GROUP BY ct.id "; 
                     $dates = $this->db->query($sql1,array($year))->result();
       
                     $sql = " SELECT   YEAR(ct.fecha) as tiempo , SUM($total) as utilidades
                     FROM  costos ct
                     JOIN  $table_join ON ct.id =  $fk
                     WHERE YEAR(ct.fecha) = ? "; 
                     $res = $this->db->query($sql,array($year))->result();
                     $array =array( $res ,  $byYear ,$dates );
                     return $array;
                    
                     }
       
                  if($periodo == "2"){
                    
                       $opcion= $data['option'];
                    
       
                     if($opcion =="1"){

                      $year = $data['year'];
                      $month = $data['month'];
                      $sql2= "SELECT MONTH(ct.fecha) as tiempo , SUM($total) as utilidades
                      FROM  costos ct
                      JOIN $table_join  ON ct.id  = $fk
                      WHERE  YEAR(ct.fecha)= ?
                      GROUP BY MONTH(ct.fecha)"; 
                     $byMonth = $this->db->query($sql2,$year)->result();

       
                    //registro data table
                     $sql3= " SELECT  ct.costoGasto utilidades , ct.fecha fecha, ct.id codigo ,$name, p.nombre proveedor ,p.codProducto producto
                     FROM  costos ct
                     JOIN  $table_join ON ct.id =$fk 
                     JOIN  $table_product  ON $id_join= $id
                     JOIN  proveedor p ON p.id= ct.proveedorId
                     WHERE  MONTH(ct.fecha) = ? and YEAR(ct.fecha) = ? 
                     GROUP BY ct.id"; 
                     
                     $dates = $this->db->query($sql3,array($month,$year))->result();
       
                     $sql4 = " SELECT MONTH(ct.fecha) as tiempo, SUM($total) as utilidades
                     FROM  costos ct
                     JOIN  $table_join ON ct.id =  $fk 
                     WHERE MONTH(ct.fecha) = ? and YEAR(ct.fecha) = ? "; 
                     $res = $this->db->query($sql4,array($month,$year))->result();
                     $array =array( $res ,$byMonth ,$dates);
                
                     return $array ;

                       }else{
                         //comparacion entre dos meses de diverso año 
       
                         $year = $data['year'];  $month = $data['month'];  $year2 = $data['year2'];  $month2 = $data['month2'];
       
                         $sql1 = " SELECT   MONTH(ct.fecha) as tiempo1,YEAR(ct.fecha) as tiempo2, SUM($total) as utilidades
                         FROM  costos ct
                         JOIN  $table_join ON ct.id =$fk 
                         WHERE MONTH(ct.fecha) = ? and YEAR(ct.fecha) = ? "; 
                         $res1 = $this->db->query($sql1,array($month,$year))->result();

                         $sql2 = " SELECT   MONTH(ct.fecha) as tiempo1, YEAR(ct.fecha) as tiempo2, SUM($total) as utilidades
                         FROM  costos ct
                         JOIN  $table_join ON ct.id =$fk 
                         WHERE MONTH(ct.fecha) = ? and YEAR(ct.fecha) = ? "; 
                         $res2 = $this->db->query($sql2,array($month2,$year2))->result();
                         return $array =array( $res1 ,$res2);
                        
                        }
                  }
       
                  if($periodo == "3"){
       
                       $opcion= $data['option'];
       
                       if($opcion =="1"){
                              
                               $date1 = $data['date1'];

                               $sql7= " SELECT  SUM($total) utilidades , ct.fecha fecha, ct.id codigo, p.nombre proveedor ,p.codProducto producto
                                        FROM costos ct
                                        JOIN  $table_join ON ct.id = $fk 
                                        JOIN  proveedor p ON p.id= ct.proveedorId
                                        WHERE  ct.fecha = ? 
                                        GROUP BY ct.id ";
                                        $res1 = $this->db->query($sql7,array($date1))->result();
                               
                               
                               $sql8= " SELECT  ct.fecha fecha ,SUM($total) utilidades
                                        FROM  costos ct
                                        JOIN  $table_join ON ct.id = $fk 
                                        WHERE ct.fecha = ?";
                                        $res2 = $this->db->query($sql8,array($date1))->result();
                               $array = array( $res1 ,$res2 );

                               return $array;
       
                       
                       }else{
       
                               $date1 = $data['date1'];
                               $date2 = $data['date2'];
                              
                               $sql5= " SELECT  ct.fecha fecha, SUM($total) utilidades 
                               FROM costos ct
                               JOIN  $table_join ON ct.id = $fk 
                               WHERE  ct.fecha = ?"; 
                               $res1 = $this->db->query($sql5,array($date1))->result();
                   
                               $sql6= " SELECT ct.fecha fecha,SUM($total) utilidades
                               FROM  costos ct
                               JOIN  $table_join ON ct.id = $fk 
                               WHERE  ct.fecha = ?"; 
                               $res2 = $this->db->query($sql6,array($date2))->result();
                               $array =array( $res1,$res2);
                             
                               return $array;
       
                       }
                   }
               }


               
        public function getExpensiveByPeriod($data){

                $periodo = $data['periodo'];
               
                  if($periodo =="1"){ 
                   
                     $year = $data['year'] ;
       
                     $year = $data['year'];
                     //query que me trae utilidades por año 
                     $sql0= "SELECT YEAR(fechaGasto) as tiempo , SUM(costoMonetarioGeneral) as utilidades
                     FROM  gastosgenerales g
                     GROUP BY YEAR(fechaGasto)"; 
                     $byYear = $this->db->query($sql0)->result();
       
                     $sql1= " SELECT  costoMonetarioGeneral utilidades , fechaGasto fecha,  codigo , nomGastoGeneral nombre
                     FROM  gastosgenerales g
                     WHERE YEAR(fechaGasto) = ? "; 
                     $dates = $this->db->query($sql1,array($year))->result();
       
                     $sql = " SELECT   YEAR(fechaGasto) as tiempo , SUM(costoMonetarioGeneral) as utilidades
                     FROM  gastosgenerales g
                     WHERE YEAR(fechaGasto) = ? "; 
                     $res = $this->db->query($sql,array($year))->result();
                     $array =array( $res ,  $byYear ,$dates );
                     return $array;
                  }
       
                  if($periodo == "2"){
                    
                       $opcion= $data['option'];
       
                     if($opcion =="1"){
                     $year = $data['year'];
                     $month = $data['month'];
       
                     $sql2= "SELECT MONTH(fechaGasto) as tiempo , SUM(costoMonetarioGeneral) as utilidades
                     FROM  gastosgenerales g
                     WHERE  YEAR(fechaGasto)= ? 
                     GROUP BY MONTH(fechaGasto)"; 
                     $byMonth = $this->db->query($sql2,$year)->result();
       
                    //registro data table
                     $sql3= " SELECT  costoMonetarioGeneral utilidades , fechaGasto fecha, codigo , nomGastoGeneral nombre
                     FROM  gastosgenerales g
                     WHERE  MONTH(fechaGasto) = ? and YEAR(fechaGasto) = ? "; 
                     $dates = $this->db->query($sql3,array($month,$year))->result();
       
                     $sql4 = " SELECT   MONTH(fechaGasto) as tiempo, SUM(costoMonetarioGeneral) as utilidades
                     FROM  gastosgenerales g
                     WHERE MONTH(fechaGasto) = ? and YEAR(fechaGasto) = ? "; 
                     $res = $this->db->query($sql4,array($month,$year))->result();
                     $array =array( $res ,$byMonth ,$dates);
                
                     return $array;
                     } else{
                         //comparacion entre dos meses de diverso año 
       
                         $year = $data['year'];  $month = $data['month'];  $year2 = $data['year2'];  $month2 = $data['month2'];
       
                         $sql1 = " SELECT   MONTH( fechaGasto ) as tiempo1,YEAR( fechaGasto ) as tiempo2, SUM(costoMonetarioGeneral) as utilidades
                         FROM  gastosgenerales g
                         WHERE MONTH( fechaGasto ) = ? and YEAR( fechaGasto ) = ? "; 
                         $res1 = $this->db->query($sql1,array($month,$year))->result();
                       
       
                         $sql2 = " SELECT   MONTH( fechaGasto ) as tiempo1, YEAR( fechaGasto ) as tiempo2, SUM(costoMonetarioGeneral) as utilidades
                         FROM  gastosgenerales g
                         WHERE MONTH( fechaGasto ) = ? and YEAR( fechaGasto ) = ? "; 
                         $res2 = $this->db->query($sql2,array($month2,$year2))->result();
                         return $array =array( $res1 ,$res2);
       
                     }
                  }
       
                  if($periodo == "3"){
       
                       $opcion= $data['option'];
       
                       if($opcion =="1"){
                              
                               $date1 = $data['date1'];
       
                               $sql7= " SELECT  costoMonetarioGeneral utilidades , fechaGasto  fecha,  codigo, nomGastoGeneral nombre
                                        FROM    gastosgenerales g
                                       WHERE  fechaGasto  = ? "; 
                                        $res1 = $this->db->query($sql7,array($date1))->result();
                               
                               
                               $sql8= " SELECT  fechaGasto fecha,SUM(costoMonetarioGeneral) utilidades
                               FROM  gastosgenerales g
                               WHERE  fechaGasto = ?"; 
                               $res2 = $this->db->query($sql8,array($date1))->result();
                               $array = array( $res1 ,$res2 );
                               return $array;
       
                       
                       }else{
       
                              $date1 = $data['date1'];
                              $date2 = $data['date2'];
                              
                              $sql5= " SELECT  fechaGasto fecha,SUM(costoMonetarioGeneral) utilidades 
                               FROM  gastosgenerales g
                               WHERE  fechaGasto = ?"; 
                               $res1 = $this->db->query($sql5,array($date1))->result();
                   
                               $sql6= " SELECT fechaGasto fecha,SUM(costoMonetarioGeneral) utilidades
                               FROM  gastosgenerales g
                               WHERE  fechaGasto = ?"; 
                               $res2 = $this->db->query($sql6,array($date2))->result();
                               $array =array( $res1,$res2);
                             
                               return $array;
       
                       }
                   }
               }
       


}