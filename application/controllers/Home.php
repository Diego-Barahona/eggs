<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Home extends CI_Controller {

	public function __construct(){
		parent:: __construct(); 
	}
	
	//Funcion para cargar la vista del login
    public function login()
	{
		$this->load->view('login');
	}

	//Funcion para redirigir a los usuarios logeados segun privilegios
	public function load_page()
	{
		/*Verificar que el usuario esta logeado*/
		if ($this->accesscontrol->checkAuth()['correct']) {
			$rango = $this->session->rango;
			//Admin
			if ($rango == 1) $this->load_page_role("admin");
			//Seller
			else if ($rango == 2) $this->load_page_role("seller");
        } else {
			redirect('Home/login', 'refresh');
        }
	}

	public function load_page_role($path)
	{
		$this->load->view('shared/'.$path.'/header');
		$this->load->view(''.$path.'/cards');
		$this->load->view('shared/'.$path.'/footer');
	}
}
