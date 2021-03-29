<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class User extends CI_Controller {

	public function __construct(){
		parent:: __construct(); 
		$this->load->model('UserModel');
		$this->load->helper('user_rules');
	}
	
	//Funcion para cargar la vista del login
    public function index()
	{
		if ($this->accesscontrol->checkAuth()['correct']) {
			$this->load->view('shared/admin/header');
			$this->load->view('admin/adminUser');
			$this->load->view('shared/admin/footer');
        } else {
			redirect('Home/login', 'refresh');
        }
	}

	//Funcion para listar usuario
	public function list()
	{
		$users = $this->UserModel->get_users();
		$roles = $this->UserModel->get_roles();
        $this->response->sendJSONResponse(array($users, $roles));
	}

	//Funcion para crear un usuario
	public function create()
	{
		if ($this->accesscontrol->checkAuth()['correct']) {
			/* Datos de formulario*/
		$data = $this->input->post('data'); 
		/* Cargar datos para la validación de formulario*/
		$rules = get_rules_user_create();
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_data($data);
		$this->form_validation->set_rules($rules);

		/*Validación de formulario
		Si el formulario no es valido*/
		if($this->form_validation->run() == FALSE){
			if(form_error('rut')) $msg['rut'] = form_error('rut');
			if(form_error('full_name')) $msg['full_name'] = form_error('full_name');
			if(form_error('passwd')) $msg['passwd'] = form_error('passwd');
			if(form_error('email')) $msg['email'] = form_error('email');
			if(form_error('range')) $msg['range'] = form_error('range');
			$this->response->sendJSONResponse($msg);
			$this->output->set_status_header(400); 
		}else{
		/*Si el formulario es valido*/
			/*Crear usuario*/
			if($id = $this->UserModel->create($data)){
				/*Actualizar registro en la tabla roles */
				$msg['msg'] = "Usuario registrado con éxito.";
				$this->response->sendJSONResponse($msg);
			}else{
				$msg['msg'] = "El usuario ya se encuentra registrado.";
				$this->response->sendJSONResponse($msg);
				$this->output->set_status_header(405);
			} 	
		}     
        } else {
			redirect('Home/login', 'refresh');
        }
    }      

	//Funcion para editar un usuario
	public function update()
	{   
		if ($this->accesscontrol->checkAuth()['correct']) {
			/* Datos de formulario*/
		$data = $this->input->post('data'); 

		/* Cargar datos para la validación de formulario*/
		$rules = get_rules_user_edit();
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_data($data);
		$this->form_validation->set_rules($rules);

		/*Validación de formulario
		Si el formulario no es valido*/
		if($this->form_validation->run() == FALSE){
			if(form_error('rut')) $msg['rut'] = form_error('rut');
			if(form_error('full_name')) $msg['full_name'] = form_error('full_name');
			if(form_error('email')) $msg['email'] = form_error('email');
			if(form_error('range')) $msg['range'] = form_error('range');
			$this->response->sendJSONResponse($msg);
			$this->output->set_status_header(400); 
		}else{
		/*Si el formulario es valido*/
			if($id = $this->UserModel->update($data)){
				/*Actualizar registro en la tabla roles */
				$msg['msg'] = "Usuario actualizado con éxito.";
				$this->response->sendJSONResponse($msg);
			}else{
				$msg['msg'] = "El usuario ya se encuentra registrado.";
				$this->response->sendJSONResponse($msg);
				$this->output->set_status_header(405);
			} 	
		} 
        } else {
			redirect('Home/login', 'refresh');
        }
	}

	//Funcion para deshabilitar y habilitar un usuario
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
			if($this->UserModel->des_hab($data)){
				$msg['msg'] = "El usuario ha sido ".$hab_des." con éxito";
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
