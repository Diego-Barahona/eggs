<?php

class Gastos_model extends CI_Model {

    public function __construct(){
        parent::__construct();
    }

    public function get_gastos  (){
        $this->db->select('g.*');
        $this->db->from('gastosgenerales g');
        
        return $query = $this->db->get()->result();
    }

    

    public function create($data){

           
            $datos_gastos = array(
                'nomGastoGeneral' => $data['nomGastoGeneral'],
                'costoMonetarioGeneral' => $data['costoMonetarioGeneral'],
                'fechaGasto'=> $data['fecha'],
                'codigo'=> $data['codGastoGeneral'],
            );

            if($this->db->insert('gastosgenerales', $datos_gastos)){
                return true;
            }else{
                return false;
            }
        
    }
    public function update($data){
        
            
        $query = "SELECT * FROM gastosgenerales WHERE (nomGastoGeneral = ? AND nomGastoGeneral != ?)" ;
        $result = $this->db->query($query, array($data['nomGastoGeneral'], $data['nomGastoGeneral_old']));

        if(sizeof($result->result()) >= 1){
            return false;
        }else{
            
            $datos_gastos = array(
                
                'nomGastoGeneral' => $data['nomGastoGeneral'],
                'costoMonetarioGeneral' => $data['costoMonetarioGeneral'],
                'fechaGasto'=> $data['fecha'],
                'codigo'=> $data['codGastoGeneral'],     
            );


            $this->db->where('idGastoGeneral', $data['idGastoGeneral']);
            if($this->db->update('gastosgenerales', $datos_gastos)){
                return true;
            }else{
                return false;
            }
        }
    }
    public function des_hab($data){

        $this->db->where('idGastoGeneral', $data);
        $query = $this->db->delete('gastosgenerales');
        if($query){
            return true;
        }else{
            return false;
        }
    }

    
}