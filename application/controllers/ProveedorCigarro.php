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


	public function getfields() {

        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('ProveedorCigarro_model');
            $datos = $this->ProveedorCigarro_model->getFields();
            $this->response->sendJSONResponse($datos);
        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }
    }

	public function getCigars() {

        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('ProveedorCigarro_model');
            $datos = $this->ProveedorCigarro_model->getCigars();
            $this->response->sendJSONResponse($datos);
        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }
    }

	public function addPrecio() {

        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('ProveedorCigarro_model');
             $data = $this->input->post('data');

			 $precio = $data['precio'];
			 $producto = $data['producto'];
			 $proveedor = $data['proveedor'];
			 $ok=true;

			 if($product==""){ $ok= false;}
			 if($proveedor==""){ $ok= false;}
			 if($precio==""){ $ok= false;}

           if($ok){
			       if($datos = $this->ProveedorCigarro_model->addPrecio($data)){
				   $this->response->sendJSONResponse($datos);
			       }else{
				$this->response->sendJSONResponse(array("msg"=> "El producto ya esta asociado al proveedor seleccionado. Intente con otro producto."),400);
			    }
            }else{
				$this->response->sendJSONResponse(array("msg"=> "Complete los campos del formulario."),400);
			}
            
         
        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }
    }

	public function editPrecio() {

		if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('ProveedorCigarro_model');
             $data = $this->input->post('data');

			 $precio = $data['precio'];
			 $producto = $data['producto'];
			 $proveedor = $data['proveedor'];
			 $ok=true;

			 if($producto==""){ $ok= false;}
			 if($proveedor==""){ $ok= false;}
			 if($precio==""){ $ok= false;}

           if($ok){
			       if($datos = $this->ProveedorCigarro_model->editPrecio($data)){
				   $this->response->sendJSONResponse($datos);
			       }else{
				$this->response->sendJSONResponse(array("msg"=> "El producto ya esta asociado a este proveedor. Intente con otro producto."),400);
			    }
            }else{
				$this->response->sendJSONResponse(array("msg"=> "Complete los campos del formulario."),400);
			}
            
         
        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }
    }



}