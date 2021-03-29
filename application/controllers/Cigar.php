<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cigar extends CI_Controller {

	public function __construct(){
		parent:: __construct(); 
		$this->load->model('CigarModel');
		$this->load->helper('cigar_rules');
	}
	
	//Function to load cigar index view
    public function index()
	{
		if ($this->accesscontrol->checkAuth()['correct']) {
			$this->load->view('shared/admin/header');
			$this->load->view('admin/adminCigar');
			$this->load->view('shared/admin/footer');
        } else {
			redirect('Home/login', 'refresh');
        }
	}

	//Function to load list cigars
	public function list()
	{
		$cigars = $this->CigarModel->getCigars();
        $this->response->sendJSONResponse($cigars);
	}

	//Function to create cigar
	public function create()
	{
		if ($this->accesscontrol->checkAuth()['correct']) {
			/* Datos de formulario*/
		$data = $this->input->post('data'); 
		/* Cargar datos para la validación de formulario*/
		$rules = getRulesCreateCigar();
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_data($data);
		$this->form_validation->set_rules($rules);
            /*Validación de formulario
            Si el formulario no es valido*/
            if($this->form_validation->run() == FALSE){
                if(form_error('name')) $msg['name'] = form_error('name');
                if(form_error('price')) $msg['price'] = form_error('price');
                if(form_error('stock')) $msg['stock'] = form_error('stock');
                $this->response->sendJSONResponse($msg);
                $this->output->set_status_header(400); 
            }else{
            /*If the form it's OK*/
                /*Create cigar*/
                if($id = $this->CigarModel->create($data)){
                    /*Actualizar registro en la tabla roles */
                    $msg['msg'] = "Tipo de cigarro registrado con éxito.";
                    $this->response->sendJSONResponse($msg);
                }else{
                    $msg['msg'] = "El tipo de cigarro ya se encuentra registrado.";
                    $this->response->sendJSONResponse($msg);
                    $this->output->set_status_header(405);
                } 	
            }     
        } else {
			redirect('Home/login', 'refresh');
        }
    }      

	//Function to update cigar
	public function update()
	{   
		if ($this->accesscontrol->checkAuth()['correct']) {
			/* Datos de formulario*/
		$data = $this->input->post('data'); 

		/* Cargar datos para la validación de formulario*/
		$rules = getRulesCreateCigar();
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_data($data);
		$this->form_validation->set_rules($rules);

		/*Validación de formulario
		Si el formulario no es valido*/
		if($this->form_validation->run() == FALSE){
            if(form_error('name')) $msg['name'] = form_error('name');
            if(form_error('price')) $msg['price'] = form_error('price');
            if(form_error('stock')) $msg['stock'] = form_error('stock');
            $this->response->sendJSONResponse($msg);
            $this->output->set_status_header(400); 
		}else{
		/*Si el formulario es valido*/
			if($id = $this->CigarModel->update($data)){
				/*Actualizar registro en la tabla roles */
				$msg['msg'] = "Tipo de cigarro actualizado con éxito.";
				$this->response->sendJSONResponse($msg);
			}else{
				$msg['msg'] = "El tipo de cigarro ya se encuentra registrado.";
				$this->response->sendJSONResponse($msg);
				$this->output->set_status_header(405);
			} 	
		} 
        } else {
			redirect('Home/login', 'refresh');
        }
	}
	
	//Function to disable or enable cigar
	public function desHab()
	{
		if ($this->accesscontrol->checkAuth()['correct']) {
			/* Datos de formulario*/
			$data = $this->input->post('data');
			$state = $data['state'];

			/* Variables a utilizar*/
			$hab_des=""; /*Mensaje dinamico de des/hab*/
			if($state == 0) {$hab_des ="deshabilitado";} else{$hab_des ="habilitado"; } 

			/*actualizar state del cigarro*/ 
			if($this->CigarModel->desHab($data)){
				$msg['msg'] = "El cigarro ha sido ".$hab_des." con éxito";
				$this->response->sendJSONResponse($msg);
			}else{
				$msg['msg'] = "No se pudo cargar el recurso.";
				$this->response->sendJSONResponse($msg);
			}
		} else {
			redirect('Home/login', 'refresh');
		}
	}
}
