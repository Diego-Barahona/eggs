<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Proveedor extends CI_Controller {
	
	public function __construct(){
		parent:: __construct(); 
		$this->load->model('Proveedor_model');
		$this->load->helper('Proveedor_rules');
		
	}

public function index()	{
		if ($this->accesscontrol->checkAuth()['correct']) {
			$this->load->view('shared/admin/header');
			$this->load->view('admin/adminProveedor');
			$this->load->view('shared/admin/footer');
        } else {
			redirect('Home/login', 'refresh');
        }
	}


	public function list()	{
	
		$proveedores = $this->Proveedor_model->get_proveedor();
		$this->response->sendJSONResponse($proveedores);
	}
	//Funcion para crear un cliente
	public function create()
	{
		if ($this->accesscontrol->checkAuth()['correct']) {
			/* Datos de formulario*/
		$data = $this->input->post('data'); 
		/* Cargar datos para la validación de formulario*/
		$rules = get_rules_proveedor_create();
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_data($data);
		$this->form_validation->set_rules($rules);
		// var_dump($data);
		/*Validación de formulario
		Si el formulario no es valido*/
		if($this->form_validation->run() == FALSE){
		
			if(form_error('nomProveedor')) $msg['nomProveedor'] = form_error('nomProveedor');
			if(form_error('rutProveedor')) $msg['rutProveedor'] = form_error('rutProveedor');
			if(form_error('telefono')) $msg['telefono'] = form_error('telefono');
			if(form_error('correoProveedor')) $msg['correoProveedor'] = form_error('correoProveedor');
			if(form_error('codProducto')) $msg['codProducto'] = form_error('codProducto');
			if(form_error('state')) $msg['state'] = form_error('state');
			
			$this->response->sendJSONResponse($msg);

			$this->output->set_status_header(400); 
		}else{
		/*Si el formulario es valido*/
			/*Crear usuario*/
			if($id = $this->Proveedor_model->create($data)){
				/*Actualizar registro en la tabla roles */
				$msg['msg'] = "Proveedor registrado con éxito.";
				$this->response->sendJSONResponse($msg);
			}else{
				$msg['msg'] = "El Proveedor ya se encuentra registrado.";
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
		$rules = get_rules_proveedor_edit();
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_data($data);
		$this->form_validation->set_rules($rules);

		/*Validación de formulario
		Si el formulario no es valido*/
		if($this->form_validation->run() == FALSE){
			if(form_error('nomProveedor')) $msg['nomProveedor'] = form_error('nomProveedor');
			if(form_error('rutProveedor')) $msg['rutProveedor'] = form_error('rutProveedor');
			if(form_error('telefono')) $msg['telefono'] = form_error('telefono');
			if(form_error('correoProveedor')) $msg['correoProveedor'] = form_error('correoProveedor');
			if(form_error('codProducto')) $msg['codProducto'] = form_error('codProducto');
			$this->response->sendJSONResponse($msg);
			$this->output->set_status_header(400); 
		}else{
		/*Si el formulario es valido*/
			if($id = $this->Proveedor_model->update($data)){
				/*Actualizar registro en la tabla roles */
				$msg['msg'] = "Proveedor actualizado con éxito.";
				$this->response->sendJSONResponse($msg);
			}else{
				$msg['msg'] = "El Proveedor ya se encuentra registrado.";
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
			if($this->Proveedor_model->des_hab($data)){
				$msg['msg'] = "El Proveedor ha sido ".$hab_des." con éxito";
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
