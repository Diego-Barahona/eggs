<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class ProveedorHuevo extends CI_Controller {

	public function __construct(){
		parent:: __construct(); 
		$this->load->model('ProveedorHuevo_model');
		
	}
	
	//Funcion para cargar la vista del login
    public function index()
	{
		if ($this->accesscontrol->checkAuth()['correct']) {
			$this->load->view('shared/admin/header');
			$this->load->view('admin/adminProveedorHuevo');
			$this->load->view('shared/admin/footer');
        } else {
			redirect('Home/login', 'refresh');
        }
	}

	//Funcion para listar usuario
	public function list()
	{
		$proveedorHuevo = $this->ProveedorHuevo_model->get_ProveedorHuevo();
		
        $this->response->sendJSONResponse($proveedorHuevo);

		
	}
}