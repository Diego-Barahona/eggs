<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Gastos extends CI_Controller {
	
	public function __construct(){
		parent:: __construct(); 
		$this->load->model('Gastos_model');
		$this->load->helper('gastos_rules');
		
		
	}

public function index()	{
		if ($this->accesscontrol->checkAuth()['correct']) {
			$this->load->view('shared/admin/header');
			$this->load->view('admin/gastosGenerales');
			$this->load->view('shared/admin/footer');
        } else {
			redirect('Home/login', 'refresh');
        }
	}


	public function list()	{
	
		$gastos = $this->Gastos_model->get_gastos();
	
		$this->response->sendJSONResponse($gastos);
        
	}
	//Funcion para crear un gasto
	public function create()
	{
		if ($this->accesscontrol->checkAuth()['correct']) {
			/* Datos de formulario*/
		$data = $this->input->post('data'); 
	
		/* Cargar datos para la validación de formulario*/
		$rules = get_rules_gastos_create();
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_data($data);
		$this->form_validation->set_rules($rules);
		// var_dump($data);
		/*Validación de formulario
		Si el formulario no es valido*/
		if($this->form_validation->run() == FALSE){
			// if(form_error('idGastoGeneral')) $msg['idGastoGeneral'] = form_error('idGastoGeneral');
			if(form_error('nomGastoGeneral')) $msg['nomGastoGeneral'] = form_error('nomGastoGeneral');
			if(form_error('costoMonetarioGeneral')) $msg['costoMonetarioGeneral'] = form_error('costoMonetarioGeneral');
			if(form_error('fecha')) $msg['fecha'] = form_error('fecha');
			
			$this->response->sendJSONResponse($msg);

			$this->output->set_status_header(400); 
		}else{
		/*Si el formulario es valido*/
			/*Crear gasto*/
			if($id = $this->Gastos_model->create($data)){
				/*Actualizar registro en la tabla roles */
				$msg['msg'] = "Gasto registrado con éxito.";
				$this->response->sendJSONResponse($msg);
			}else{
				$msg['msg'] = "El Gasto ya se encuentra registrado.";
				$this->response->sendJSONResponse($msg);
				$this->output->set_status_header(405);
			} 	
		}     
        } else {
			redirect('Home/login', 'refresh');
        }
    }      //Funcion para editar un gasto
	public function update()
	{   
		if ($this->accesscontrol->checkAuth()['correct']) {
			/* Datos de formulario*/
		$data = $this->input->post('data'); 

		/* Cargar datos para la validación de formulario*/
		$rules = get_rules_gastos_edit();
		$this->form_validation->set_error_delimiters('', '');
		$this->form_validation->set_data($data);
		$this->form_validation->set_rules($rules);

		/*Validación de formulario
		Si el formulario no es valido*/
		if($this->form_validation->run() == FALSE){
			// if(form_error('idGastoGeneral')) $msg['idGastoGeneral'] = form_error('idGastoGeneral');
			if(form_error('nomGastoGeneral')) $msg['nomGastoGeneral'] = form_error('nomGastoGeneral');
			if(form_error('costoMonetarioGeneral')) $msg['costoMonetarioGeneral'] = form_error('costoMonetarioGeneral');
			if(form_error('fecha')) $msg['fecha'] = form_error('fecha');
			
			$this->response->sendJSONResponse($msg);
			$this->output->set_status_header(400); 
		}else{
		/*Si el formulario es valido*/
			if($id = $this->Gastos_model->update($data)){
				/*Actualizar registro en la tabla roles */
				$msg['msg'] = "Gasto actualizado con éxito.";
				$this->response->sendJSONResponse($msg);
			}else{
				$msg['msg'] = "El Gasto ya se encuentra registrado.";
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
			$idGastoGeneral = $data['idGastoGeneral'];

	
			
			/*actualizar state de la empresa*/ 
			if($this->Gastos_model->des_hab($idGastoGeneral)){
				$msg['msg'] = "El Gasto ha sido eliminado con éxito";
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
