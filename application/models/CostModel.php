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

       if($tipo == "2" ){  //Operaciones con las compras de cigarro

            $id_cigarro= $data['producto'];
            $precioCompra=$data['valor'];
            $codigo=$data['codigo'];
            $stock_nuevo=0;
          
            $compra=array(
                'cantidad'=> $data['cantidad'],
                'precioCompra'=> $data['valor'],
                'total'=> $data['total'],                             
                'costoId'=>  $data['codigo'] ,
                'cigarroId'=>  $data['producto'], 
                );
    
                 $query_stock = "SELECT COUNT(*) as contador FROM stock_cigarro WHERE codTipoProducto IN (?) and precioCompra=?";
                 $count_row =  $this->db->query( $query_stock,array($id_cigarro,$precioCompra))->row_array();

                 if($count_row['contador'] == 0){//si no existe -> lo crea 

                    $query = "INSERT INTO compra_cigarro(cantidad,precioCompra,total,costoId,cigarroId) VALUES (?,?,?,?,?)";
                    $this->db->query($query, $compra);
   
                    $row = array( 'precioCompra'=> $data['valor'], 'auxiliar'=> $data['cantidad'],'cantidad'=> $data['cantidad'],'codTipoProducto'=>  $data['producto']);
    
                    $save_stock = "INSERT INTO stock_cigarro(precioCompra,auxiliar,cantidad,codTipoProducto) VALUES (?,?,?,?)";
                    return $this->db->query($save_stock, $row);

                 }else{

                    $query = "INSERT INTO compra_cigarro(cantidad,precioCompra,total,costoId,cigarroId) VALUES (?,?,?,?,?)";
                    $this->db->query($query, $compra);
                      
                    $query2 = "SELECT auxiliar ,cantidad FROM stock_cigarro WHERE codTipoProducto = ? and precioCompra=?"; // extrae la suma antigua del producto
                    $suma_antigua = $this->db->query($query2, array($id_cigarro,$precioCompra))->row_array();
        
                    $query3=  "SELECT SUM(cantidad) AS suma_actual  FROM compra_cigarro WHERE cigarroId = ? and precioCompra=?"; // extrae la suma actual del producto ( compra )
                    $suma_actual = $this->db->query($query3, array($id_cigarro,$precioCompra))->row_array();
                    
                    $result_sum = $suma_antigua['auxiliar']- $suma_actual['suma_actual'];


                    if($result_sum > 0 ){   // si resulta un numero positivo
               
                        $stock_nuevo = ($suma_antigua['cantidad'] - $result_sum );
                       
                    }else{ 
        
                        $stock_nuevo = ($suma_antigua['cantidad'] - $result_sum );
                        
                    }

                    if($stock_nuevo >= 0 ){

                        $query4 = "UPDATE stock_cigarro SET cantidad=? ,auxiliar=?  WHERE codTipoProducto = ? and precioCompra = ?";
                        return $this->db->query($query4, array($stock_nuevo,$suma_actual['suma_actual'],$id_cigarro,$precioCompra));
                        
                    }else{
        
                        $query5 = "SELECT cantidad  FROM compra_cigarro WHERE costoId=? and cigarroId=? ";
                        $result3 = $this->db->query($query5, array($data['codigo'],$id_huevo))->row_array();
                     
                        $retorno = $result3['cantidad']+$result_sum;
                       
                        $cantidad_anterior = "UPDATE compra_cigarro SET cantidad=? WHERE costoId=? and cigarroId=? ";
                        $this->db->query($cantidad_anterior, array($retorno,$data['codigo'],$id_cigarro));
        
        
                        $query6 = "SELECT compras  FROM costos WHERE id=?";
                        $result1 = $this->db->query($query6, array($data['codigo']))->row_array();
                        //$productos= json_decode($result1);
                       $array=json_decode($result1['compras']);
                       $producto = $array->insumos;
                       $datos=array();
        
                       foreach ($producto as $value) {
                        var_dump($value->producto);
                        var_dump($value->tipoProducto);
                        if($value->tipoProducto == "2" && $value->producto==strval($id_cigarro)){
                           
                         $pro= array(  
                             "tipoProducto" => $value->tipoProducto,
                              "producto" => $value->producto,
                              "valor" => $value->valor,
                              "cantidad" => strval($retorno),
                              "total" => $value->total,
                              "codigo" => $value->codigo,
                             );
                             array_push($datos,$pro);
                        }else{
                         $pro= array(  
                             "tipoProducto" => $value->tipoProducto,
                              "producto" => $value->producto,
                              "valor" => $value->valor,
                              "cantidad" => $value->cantidad,
                              "total" => $value->total,
                              "codigo" => $value->codigo,
                             );
                            
                             array_push($datos,$pro);
                        
                        }}//fin del ciclo 
        
                       $insumos =json_encode( array( "insumos"=>$datos));
        
                       $query7 = "UPDATE costos SET compras =? WHERE id=?";   // actualiza el json de compras en tabla costo
                        $this->db->query($query7, array($insumos,$data['codigo']));
        
                        return false;
                    }

                 }
          
         } else { //Operaciones con las compras de huevos 


             $id_huevo= $data['producto'];
             $precioCompra=$data['valor'];
             $codigo=$data['codigo'];
             $stock_nuevo=0;

             $compra=array(
            'cantidad'=> $data['cantidad'],
            'precioCompra'=> $data['valor'],
            'total'=> $data['total'],                             
            'costoId'=>  $data['codigo'] ,
            'huevoId'=>  $data['producto'], 
            );

             $query_stock = "SELECT COUNT(*) as contador FROM stock_huevo WHERE codTipoProducto IN (?) and precioCompra=?";
             $count_row =  $this->db->query( $query_stock,array($id_huevo,$precioCompra))->row_array();
 
             if($count_row['contador'] == 0){//si no existe -> lo crea 
                 $query = "INSERT INTO compra_huevo(cantidad,precioCompra,total,costoId,huevoId) VALUES (?,?,?,?,?)";
                 $this->db->query($query, $compra);

                 $row = array( 'precioCompra'=> $data['valor'], 'auxiliar'=> $data['cantidad'],'cantidad'=> $data['cantidad'],'codTipoProducto'=>  $data['producto']);
 
                 $save_stock = "INSERT INTO stock_huevo(precioCompra,auxiliar,cantidad,codTipoProducto) VALUES (?,?,?,?)";
                 return $this->db->query($save_stock, $row);
 
             }else{

            $query = "INSERT INTO compra_huevo(cantidad,precioCompra,total,costoId,huevoId) VALUES (?,?,?,?,?)";
            $this->db->query($query, $compra);
              
            $query2 = "SELECT auxiliar ,cantidad FROM stock_huevo WHERE codTipoProducto = ? and precioCompra=?"; // extrae la suma antigua del producto
            $suma_antigua = $this->db->query($query2, array($id_huevo,$precioCompra))->row_array();

            $query3=  "SELECT SUM(cantidad) AS suma_actual  FROM compra_huevo WHERE huevoId = ? and precioCompra=?"; // extrae la suma actual del producto ( compra )
            $suma_actual = $this->db->query($query3, array($id_huevo,$precioCompra))->row_array();
            
            $result_sum = $suma_antigua['auxiliar']- $suma_actual['suma_actual'];
            
           

            if($result_sum > 0 ){   // si resulta un numero positivo
               
                $stock_nuevo = ($suma_antigua['cantidad'] - $result_sum );
               
            }else{ 

                $stock_nuevo = ($suma_antigua['cantidad'] - $result_sum );
                
            }

            if($stock_nuevo >= 0 ){

                $query4 = "UPDATE stock_huevo SET cantidad=? ,auxiliar=?  WHERE codTipoProducto = ? and precioCompra = ?";
                return $this->db->query($query4, array($stock_nuevo,$suma_actual['suma_actual'],$id_huevo,$precioCompra));
                
            }else{

                $query5 = "SELECT cantidad  FROM compra_huevo WHERE costoId=? and huevoId=? ";
                $result3 = $this->db->query($query5, array($data['codigo'],$id_huevo))->row_array();
             
                $retorno = $result3['cantidad']+$result_sum;
               
                $cantidad_anterior = "UPDATE compra_huevo SET cantidad=? WHERE costoId=? and huevoId=? ";
                $this->db->query($cantidad_anterior, array($retorno,$data['codigo'],$id_huevo));


                $query6 = "SELECT compras  FROM costos WHERE id=?";
                $result1 = $this->db->query($query6, array($data['codigo']))->row_array();
                //$productos= json_decode($result1);
               $array=json_decode($result1['compras']);
               $producto = $array->insumos;
               $datos=array();

               foreach ($producto as $value) {
                var_dump($value->producto);
                var_dump($value->tipoProducto);
                if($value->tipoProducto == "1" && $value->producto==strval($id_huevo)){
                   
                 $pro= array(  
                     "tipoProducto" => $value->tipoProducto,
                      "producto" => $value->producto,
                      "valor" => $value->valor,
                      "cantidad" => strval($retorno),
                      "total" => $value->total,
                      "codigo" => $value->codigo,
                     );
                     array_push($datos,$pro);
                }else{
                 $pro= array(  
                     "tipoProducto" => $value->tipoProducto,
                      "producto" => $value->producto,
                      "valor" => $value->valor,
                      "cantidad" => $value->cantidad,
                      "total" => $value->total,
                      "codigo" => $value->codigo,
                     );
                    
                     array_push($datos,$pro);
                
                }}//fin del ciclo 

               $insumos =json_encode( array( "insumos"=>$datos));

               $query7 = "UPDATE costos SET compras =? WHERE id=?";   // actualiza el json de compras en tabla costo
                $this->db->query($query7, array($insumos,$data['codigo']));

                return false;
            }
          }
        } 
    }

     public function getOldNewProduct($tipoProveedorNuevo,$codigo){

        if($tipoProveedorNuevo == 1){
            $query ="SELECT * FROM compra_huevo WHERE costoId=?  ";
            return $this->db->query($query, array($codigo))->row_array();
    
        }else{
            $query ="SELECT * FROM compra_cigarro WHERE costoId=?  ";
            return $this->db->query($query, array($codigo))->row_array();
        }
         
     }


     public function deleteProductOld($compras,$codigo,$tipoProducto){

        $productos_nuevos = array();
         
        foreach ($compras as $value) {
            array_push($productos_nuevos,$value['producto']);
        }
      
        if( $tipoProducto == 1 ){
            // HUEVOS
        $query ="SELECT * FROM compra_huevo WHERE costoId=? and huevoId  NOT IN  ? ";
        $result = $this->db->query($query,array($codigo,$productos_nuevos))->result_array();
       
       
        if(sizeof($result) == 0){
      
           return true;
        }else{
            
            $datos=array();
            foreach ($result as $value) {
                $datos= array(  
                     "cantidad" => $value['cantidad'],
                     "precioCompra" => $value['precioCompra'],
                     "huevoId" => $value['huevoId'],
                     "costoId"=> $value['costoId']
                    );
                $this->actualizarStock($datos,$tipoProducto);
                     
            }//fin foreach
        }//fin

        }else{
            //CIGARROS
            $query ="SELECT * FROM compra_cigarro WHERE costoId=? and cigarroId  NOT IN ? ";
            $result = $this->db->query($query,array($codigo,$productos_nuevos))->result_array();
           var_dump("entre");

        }
         
    
    }


    public function actualizarStock($datos,$tipoProducto){
        
        if($tipoProducto == 1){
            
            $id_huevo = $datos['huevoId'];
            $precioCompra = $datos['precioCompra'];
            $costo=$datos['costoId'];
            $cantidad= $datos['cantidad'];

            $query2 = "SELECT auxiliar ,cantidad FROM stock_huevo WHERE codTipoProducto = ? and precioCompra=?"; // extrae la suma antigua del producto
            $suma_antigua = $this->db->query($query2, array($id_huevo,$precioCompra))->row_array();

            $query=  "SELECT SUM(cantidad) AS suma_actual  FROM compra_huevo WHERE huevoId = ? and precioCompra=?"; // extrae la suma actual del producto ( compra )
            $suma_actual = $this->db->query($query, array($id_huevo,$precioCompra))->row_array();
            $resta= $suma_actual['suma_actual']-$cantidad;
        
            // nueva suma 
            $result_sum = $suma_antigua['auxiliar']-$resta;
           
            
            if($result_sum > 0 ){   // si resulta un numero positivo

                $stock_nuevo = ($suma_antigua['cantidad'] - $result_sum );
            }else{ 

                $stock_nuevo = ($suma_antigua['cantidad'] - $result_sum );
            }

            if($stock_nuevo >= 0 ){
                 
                $query4 = "UPDATE stock_huevo SET cantidad=? ,auxiliar=?  WHERE codTipoProducto = ? and precioCompra=?";
         
             $this->db->query($query4, array($stock_nuevo,$resta,$id_huevo,$precioCompra));
             return true;
                
            }else{
                     // retorno de la cantidad a campo de "compras"

                $query5 = "SELECT cantidad  FROM compra_huevo WHERE costoId=? and huevoId=? ";
                $result3 = $this->db->query($query5, array($costo,$id_huevo))->row_array();
              
                $retorno = $result3['cantidad']+$result_sum;
              
                $query6 = "SELECT compras  FROM costos WHERE id=?";
                $result1 = $this->db->query($query6, array($codigo))->row_array();
                //$productos= json_decode($result1);
               $array=json_decode($result1['compras']);
               $producto = $array->insumos;
               $datos=array();

               foreach ($producto as $value) {
                
                if($value->tipoProducto == "1" && $value->producto==strval($id_huevo)){
                   
                 $pro= array(  
                     "tipoProducto" => $value->tipoProducto,
                      "producto" => $value->producto,
                      "valor" => $value->valor,
                      "cantidad" => strval($retorno),
                      "total" => $value->total,
                      "codigo" => $value->codigo,
                     );
                     array_push($datos,$pro);
                }else{
                 $pro= array(  
                     "tipoProducto" => $value->tipoProducto,
                      "producto" => $value->producto,
                      "valor" => $value->valor,
                      "cantidad" => $value->cantidad,
                      "total" => $value->total,
                      "codigo" => $value->codigo,
                     );
                    
                     array_push($datos,$pro);
                
                }}//fin del ciclo 

               $insumos =json_encode( array( "insumos"=>$datos));

               $query7 = "UPDATE costos SET compras =? WHERE id=?";   // actualiza el json de compras en tabla costo
                $this->db->query($query7, array($insumos,$data['codigo']));

               return false;

              }

            


        }else{
 

          var_dump("HOLA SOY CIGARRO");


        }


    }

        public function cambioProveedor ($codigo,$tipoProveedor){

           
         if($tipoProducto==1){

            $query6 = "SELECT compras  FROM costos WHERE id=?";
            $result1 = $this->db->query($query6, array($data['codigo']))->row_array();
            //$productos= json_decode($result1);
           $array=json_decode($result1['compras']);
           $producto = $array->insumos;
           $datos=array();

           foreach ($producto as $value) {
                $cantidad=$value->valor;
               if($value->tipoProducto == 1 && $value->producto==strval($id_huevo)){
                   $cantidad=$retorno;

               }
           $datos= array(  
            "tipoProducto" => $value->tipoProducto,
             "producto" => $value->producto,
             "valor" => $value->valor,
             "cantidad" =>$cantidad ,
             "total" => $value->total,
             "codigo" => $value->codigo,
            );
          } 


        }else{}
        
        }// fin de la funcion









 

}
