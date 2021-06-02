<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cards extends CI_Controller {

	public function __construct(){
		parent:: __construct(); 
		$this->load->model('cardModel');
		
	}
	
	//Funcion para cargar la vista del login
    public function cardsAdmin()
	{
		if ($this->accesscontrol->checkAuth()['correct']) {
			$this->load->view('shared/admin/header');
			$this->load->view('admin/cards');
			$this->load->view('shared/admin/footer');
        } else {
			redirect('Home/login', 'refresh');
        }
	}

    public function getDataCards()
    {
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('cardModel');
            $datos = $this->cardModel->getDataCards();
            $this->response->sendJSONResponse($datos);
        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }
    }

   




	//Funcion para listar usuario

}