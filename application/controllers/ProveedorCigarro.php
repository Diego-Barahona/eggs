<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProveedorCigarro extends CI_Controller {

	public function __construct(){
		parent:: __construct(); 
		$this->load->model('ProveedorCigarro_model');
		
	}
	
	//Funcion para cargar la vista del login
    public function index()
	{
		if ($this->accesscontrol->checkAuth()['correct']) {
			$this->load->view('shared/admin/header');
			$this->load->view('admin/adminProveedorCigarro');
			$this->load->view('shared/admin/footer');
        } else {
			redirect('Home/login', 'refresh');
        }
	}

	//Funcion para listar usuario
	public function list()
	{
		$proveedorCigarro = $this->ProveedorCigarro_model->get_ProveedorCigarro();
		
        $this->response->sendJSONResponse($proveedorCigarro);

		
	}
}