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

	public function getfields() {

        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('ProveedorHuevo_model');
            $datos = $this->ProveedorHuevo_model->getFields();
            $this->response->sendJSONResponse($datos);
        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }
    }

	public function getEggs() {

        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('ProveedorHuevo_model');
            $datos = $this->ProveedorHuevo_model->getEggs();
            $this->response->sendJSONResponse($datos);
        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }
    }

	public function addPrecio() {

        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('ProveedorHuevo_model');
             $data = $this->input->post('data');

			 $precio = $data['precio'];
			 $producto = $data['producto'];
			 $proveedor = $data['proveedor'];
			 $ok=true;

			 if($product=""){ $ok= false;}
			 if($proveedor=""){ $ok= false;}
			 if($precio=""){ $ok= false;}

           if($ok){
			       $res = $this->ProveedorHuevo_model->addPrecio($data);
			       if($res){
				   $this->response->sendJSONResponse($res);
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
            $this->load->model('ProveedorHuevo_model');
             $data = $this->input->post('data');

			 $precio = $data['precio'];
			 $producto = $data['producto'];
			 $proveedor = $data['proveedor'];
			 $ok=true;

			 if($producto=""){ $ok= false;}
			 if($proveedor=""){ $ok= false;}
			 if($precio=""){ $ok= false;}

           if($ok){
			       if($datos = $this->ProveedorHuevo_model->editPrecio($data)){
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



	





}