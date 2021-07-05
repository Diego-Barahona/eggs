<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Seller extends CI_Controller {

	public function __construct(){
		parent:: __construct(); 
	}

    public function adminSaleEggs()
    { 
        
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->view('shared/seller/header');
            $this->load->view('seller/saleEggs');
            $this->load->view('shared/seller/footer');
        } else {
            redirect('Home/login', 'refresh');
        }
    }

    public function adminSaleCigar()
    { 
        
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->view('shared/seller/header');
            $this->load->view('seller/saleCigar');
            $this->load->view('shared/seller/footer');
        } else {
            redirect('Home/login', 'refresh');
        }
    }
	
    public function getSaleEggs() {

        if ($this->accesscontrol->checkAuth()['correct']) {
			$this->load->model('SellerModel');
			$data= $this->input->post('data');
			$periodo= $data['periodo'];
            if($res=$this->SellerModel->getSaleEggs($data)){
				$this->response->sendJSONResponse(array("res" =>$res , "periodo" =>$periodo)); 

			}else{
              
				$this->response->sendJSONResponse(array("msg"=>"No se podido cargar la información."),400); 
			}

        } else {
			redirect('Home/login', 'refresh');
        }
    }

    public function getSaleCigar() {

        if ($this->accesscontrol->checkAuth()['correct']) {
			$this->load->model('SellerModel');
			$data= $this->input->post('data');
			$periodo= $data['periodo'];
            if($res=$this->SellerModel->getSaleCigar($data)){
				$this->response->sendJSONResponse(array("res" =>$res , "periodo" =>$periodo)); 

			}else{
              
				$this->response->sendJSONResponse(array("msg"=>"No se podido cargar la información."),400); 
			}

        } else {
			redirect('Home/login', 'refresh');
        }
    }


    public function getEggs()
    {
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('SellerModel');
            $datos = $this->SellerModel->getEggs();
            $this->response->sendJSONResponse($datos);
        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }
    }

    public function getCigar()
    {
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('SellerModel');
            $datos = $this->SellerModel->getCigar();
            $this->response->sendJSONResponse($datos);
        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }
    }

    






}
