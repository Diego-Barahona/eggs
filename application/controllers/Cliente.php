<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cliente extends CI_Controller {
	
	public function __construct(){
		parent:: __construct(); 
		$this->load->model('Clientes_model');
		$this->load->helper('clientes_rules');
		
	}

public function index()	{
		if ($this->accesscontrol->checkAuth()['correct']) {
			$this->load->view('shared/admin/header');
			$this->load->view('admin/cliente');
			$this->load->view('shared/admin/footer');
        } else {
			redirect('Home/login', 'refresh');
        }
	}


	public function list()	{
	
		$clientes = $this->Clientes_model->get_clientes();
		$this->response->sendJSONResponse($clientes);
	}
	//Funcion para crear un cliente
	public function create()
	{
		if ($this->accesscontrol->checkAuth()['correct']) {
			/* Datos de formulario*/
		$data = $this->input->post('data'); 
		/* Cargar datos para la validación de formulario*/
		$rules = get_rules_clientes_create();
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_data($data);
		$this->form_validation->set_rules($rules);
		// var_dump($data);
		/*Validación de formulario
		Si el formulario no es valido*/
		if($this->form_validation->run() == FALSE){
		
			if(form_error('nomCliente')) $msg['nomCliente'] = form_error('nomCliente');
			if(form_error('rutCliente')) $msg['rutCliente'] = form_error('rutCliente');
			if(form_error('sector')) $msg['sector'] = form_error('sector');
			if(form_error('nombreCalle')) $msg['nombreCalle'] = form_error('nombreCalle');
			if(form_error('numCalle')) $msg['numCalle'] = form_error('numCalle');
			// if(form_error('state')) $msg['state'] = form_error('state');
			
			$this->response->sendJSONResponse($msg);

			$this->output->set_status_header(400); 
		}else{
		/*Si el formulario es valido*/
			/*Crear usuario*/
			if($id = $this->Clientes_model->create($data)){
				/*Actualizar registro en la tabla roles */
				$msg['msg'] = "Cliente registrado con éxito.";
				$this->response->sendJSONResponse($msg);
			}else{
				$msg['msg'] = "El Cliente ya se encuentra registrado.";
				$this->response->sendJSONResponse($msg);
				$this->output->set_status_header(405);
			} 	
		}     
        } else {
			redirect('Home/login', 'refresh');
        }
    }      //Funcion para editar un usuario
	public function update()
	{   
		if ($this->accesscontrol->checkAuth()['correct']) {
			/* Datos de formulario*/
		$data = $this->input->post('data'); 

		/* Cargar datos para la validación de formulario*/
		$rules = get_rules_clientes_edit();
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_data($data);
		$this->form_validation->set_rules($rules);

		/*Validación de formulario
		Si el formulario no es valido*/
		if($this->form_validation->run() == FALSE){
			if(form_error('nomCliente')) $msg['nomCliente'] = form_error('nomCliente');
			if(form_error('rutCliente')) $msg['rutCliente'] = form_error('rutCliente');
			if(form_error('sector')) $msg['sector'] = form_error('sector');
			if(form_error('nombreCalle')) $msg['nombreCalle'] = form_error('nombreCalle');
			if(form_error('numCalle')) $msg['numCalle'] = form_error('numCalle');
			$this->response->sendJSONResponse($msg);
			$this->output->set_status_header(400); 
		}else{
		/*Si el formulario es valido*/
			if($id = $this->Clientes_model->update($data)){
				/*Actualizar registro en la tabla roles */
				$msg['msg'] = "Cliente actualizado con éxito.";
				$this->response->sendJSONResponse($msg);
			}else{
				$msg['msg'] = "El Cliente ya se encuentra registrado.";
				$this->response->sendJSONResponse($msg);
				$this->output->set_status_header(405);
			} 	
		} 
        } else {
			redirect('Home/login', 'refresh');
        }
	}
	public function des_hab()
	{
		if ($this->accesscontrol->checkAuth()['correct']) {
			/* Datos de formulario*/
			$data = $this->input->post('data');
			$state = $data['state'];

			/* Variables a utilizar*/
			$hab_des=""; /*Mensaje dinamico de des/hab*/
			if($state == 0) {$hab_des ="Deshabilitada";} else{$hab_des ="Habilitada"; } 

			/*actualizar state de la empresa*/ 
			if($this->Clientes_model->des_hab($data)){
				$msg['msg'] = "El cliente ha sido ".$hab_des." con éxito";
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
