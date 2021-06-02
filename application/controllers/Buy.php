<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Buy extends CI_Controller {

	public function __construct(){
		parent:: __construct(); 
	}


    public function insertBuy(){ 
        
        if ($this->accesscontrol->checkAuth()['correct']) {
            $data = $this->input->post('data');
            $ok = true;
            if ($ok) {
            
                $this->load->model('BuyModel');
               $res=$this->BuyModel->insertBuy($data);//guardar en tabla de costos 
                if($res){
                    $this->response->sendJSONResponse(array('msg' => "Compra registrada.")); 
                }else{
                    $this->response->sendJSONResponse(array('msg' => "Error, se repite la compra." ), 400);
                }
               
            } else {
                $this->response->sendJSONResponse(array('msg' => "Complete los campos del formulario." ,'err'=> $err), 400);
            }
        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }

    }


    public function getSupplier()

    {
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('BuyModel');
            $datos = $this->BuyModel->getSupplier();
            $this->response->sendJSONResponse($datos);
        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }
    }


    public function getProductSupplier($id){ 
     
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('BuyModel');
            $datos = $this->BuyModel->getProductSupplier($id);
            $this->response->sendJSONResponse($datos);
        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }
          
        

    }

    public function getUtilsByPeriod(){ 
        
        if ($this->accesscontrol->checkAuth()['correct']) {
            $data = $this->input->post('data');
            $ok = true;
            if ($ok) {
            
                $this->load->model('BuyModel');


                
               $res=$this->BuyModel->insertBuy($data);//guardar en tabla de costos 
                if($res){
                    $this->response->sendJSONResponse(array('msg' => "Compra registrada.")); 
                }else{
                    $this->response->sendJSONResponse(array('msg' => "Error, se repite la compra." ), 400);
                }
               
            } else {
                $this->response->sendJSONResponse(array('msg' => "Complete los campos del formulario." ,'err'=> $err), 400);
            }
        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }

    }











}
