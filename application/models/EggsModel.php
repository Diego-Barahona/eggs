<?php
class EggsModel extends CI_Model
{

    public function __construct()
    {
        parent::__construct();
    }


    public function getEggs()
    {
        $query = "SELECT h.id ,h.stock as stock, h.tipoHuevo as tipo , p.name as producto , h.state
                  FROM huevo h
                  LEFT JOIN producto p ON p.codProducto = h.codProducto
                  WHERE h.codProducto = 1
                  ";
        return $this->db->query($query)->result();
    }

    public function insertEgg($data)
    {    
   
        $tipo= $data['tipoHuevo'];
        $stock=$data['stock'];
        $product=1;

        $query= "SELECT * FROM huevo WHERE tipoHuevo= ?";
        $result= $this->db->query($query, array($tipo));
         
        if($result->num_rows() > 0){
            return false; 
        }else{
            
            $query = "INSERT INTO huevo (codProducto,tipoHuevo, stock, huevo.state ) VALUES (?,?, ?,?)";
            return $this->db->query($query, array($product,$tipo,$stock, true));
        }
    }

   
    public function updateEgg($data)
    {   

        $id=$data['id'];
        $tipo=$data['tipoHuevo'];
        $stock=$data['stock'];
        $query= "SELECT * FROM huevo WHERE tipoHuevo = ?";
        $result= $this->db->query($query, array($tipo));
        
        $aux = array( "tipoHuevo"=> $tipo,
                        "stock"=> $stock,
                        "id"=>$id
        ); 

        if($result->num_rows() > 0){
            return false; 
        }else{

            $query = "UPDATE huevo SET tipoHuevo= ? , stock = ? WHERE id=?";
            return $this->db->query($query, $aux );  
        }  
       
     }
    

    public function changeState($id, $state)
    {
       $query = "UPDATE huevo SET huevo.state = ? WHERE id = ?";
       return $this->db->query($query, array($state, $id));
    }

    public function getfields() { 
        $query = "SELECT nomCliente , rutCliente   FROM cliente  ";
        return $this->db->query($query)->result();

    }


    public function  createEggClient($data){
    
        $client= $data['client'];
        $precio=$data['precio'];
        $codProducto = $data['id'];

        $query= "SELECT * 
        FROM clientehuevo 
        WHERE rutCliente = ? AND codProducto = ?";
        $result= $this->db->query($query, array($client,$codProducto));
         
        if($result->num_rows() > 0){
            return false; 
        }else{
            $query = "INSERT INTO clientehuevo (rutCliente, precioCliente ,codProducto) VALUES (?,?, ?)";
            return $this->db->query($query, array($client,$precio,$codProducto));
        }


    }

    public function getEggClient($id){
     
     

        $query= "SELECT c.nomCliente, ch.precioCliente ,ch.id
        FROM clientehuevo ch
        LEFT JOIN cliente c ON ch.rutCliente = c.rutCliente
        WHERE ch.codProducto= ?";
        return $this->db->query($query, array($id))->result();
         
            
    }



    
 
}