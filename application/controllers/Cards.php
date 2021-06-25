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
            $user = $_SESSION['rango'];
			$path ='';
			if($user == '2'){
				$path ='seller';
			}else if($user == '1'){
				$path ='admin';
			}
			$this->load->view('shared/'.$path.'/header');
			$this->load->view('admin/cards');
			$this->load->view('shared/'.$path.'/footer');
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