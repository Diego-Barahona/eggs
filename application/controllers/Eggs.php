<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Eggs extends CI_Controller
{
    public function adminEggs()
    { 
        
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->view('shared/admin/header');
            $this->load->view('admin/adminEggs');
            $this->load->view('shared/admin/footer');
        } else {
            redirect('Home/login', 'refresh');
        }
    }

    public function edittable()
    { 
        
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->view('shared/admin/header');
            $this->load->view('admin/edittable');
            $this->load->view('shared/admin/footer');
        } else {
            redirect('Home/login', 'refresh');
        }
    }

    public function getEggs()
    {
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('EggsModel');
            $datos = $this->EggsModel->getEggs();
            $this->response->sendJSONResponse($datos);
        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }
    }


    public function createEgg()
    {        
        if ($this->accesscontrol->checkAuth()['correct']) {
            $data = $this->input->post('data');
            $tipo = $data['tipoHuevo'];
            $stock = $data['stock'];

            $ok = true;
            $err = array();

            if ($tipo == "") {
                $ok = false;
                $err['name']  = "Ingrese un nombre.";
            }
            if ($stock == "") {
                $ok = false;
                $err['stock']  = "Ingrese una cantidad ";
            }

            if ($ok) {
              
                $this->load->model('EggsModel');
               $res=$this->EggsModel->insertEgg($data);
                if($res){
                    $this->response->sendJSONResponse(array('msg' => "Producto registrado.")); 
                }else{
                    $this->response->sendJSONResponse(array('msg' => "El nombre ya existe. Reintente con otro." ), 400);
                }
               
            } else {
                $this->response->sendJSONResponse(array('msg' => "Complete los campos del formulario." ,'err'=> $err), 400);
            }
        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }
    }




    public function editEgg()
	{
		if ($this->accesscontrol->checkAuth()['correct']) {
			$data = $this->input->post('data');
            $tipo = $data['tipoHuevo'];
            $stock = $data['stock'];
			$ok = true;
			$err = array();

            if ($tipo == "") {
                $ok = false;
                $err['name']  = "Ingrese un nombre.";
            }
            if ($stock == "") {
                $ok = false;
                $err['stock']  = "Ingrese una cantidad ";
            }
			
			if ($ok) {
				$this->load->model('EggsModel');
				$res = $this->EggsModel->updateEgg($data);
				if ($res) {
					$this->response->sendJSONResponse(array('msg' => "Producto modificado."));
				} else {
                    $this->response->sendJSONResponse(array('msg' => "El nombre ya existe. Reintente con otro." ,'err'=>"Ingrese un nombre"), 400);
				}
			} else {
                $this->response->sendJSONResponse(array('msg' => "Complete los campos del formulario." ,'err'=> $err), 400);
			}
		} else {
			$this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
		}
    }


    public function changeStateEgg()
	{
		if ($this->accesscontrol->checkAuth()['correct']) {
			$this->load->model('EggsModel');
			$data = $this->input->post('data');
			$state = $data['state'];
			$id = $data['id'];
			$res = $this->EggsModel->changeState($id, $state);
			if ($res) {
				$this->response->sendJSONResponse(array('msg' => "Estado cambiado exitosamente."));
			} else {
				$this->response->sendJSONResponse(array('msg' => "No se pudo cambiar el estado."), 400);
			}
		} else {
			$this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
		}
	}

    


    public function createEggClient () { 
        if ($this->accesscontrol->checkAuth()['correct']) {
            $data = $this->input->post('data');
            $client = $data['client'];
            $precio = $data['precio'];

            $ok = true;
            $err = array();

            if ($client == "") {
                $ok = false;
                $err['client']  = "Ingrese un cliente.";
            }
            if ($precio == "") {
                $ok = false;
                $err['precio']  = "Ingrese un precio. ";
            }

            if ($ok) {
              
                $this->load->model('EggsModel');
               $res=$this->EggsModel->createEggClient($data);
                if($res){
                    $this->response->sendJSONResponse(array('msg' => "Producto registrado.")); 
                }else{
                    $this->response->sendJSONResponse(array('msg' => "El nombre ya existe. Reintente con otro." ), 400);
                }
               
            } else {
                $this->response->sendJSONResponse(array('msg' => "Complete los campos del formulario." ,'err'=> $err), 400);
            }
        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }
      

    }

    public function getEggClient($id){

     
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('EggsModel');
            $datos = $this->EggsModel->getEggClient($id);
            $this->response->sendJSONResponse($datos);
        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }

    }


    public function getfields() {

        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('EggsModel');
            $datos = $this->EggsModel->getFields();
            $this->response->sendJSONResponse($datos);
        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }
    }

    public function editEggsClient () { 
        //editTable configuration
        if ($this->accesscontrol->checkAuth()['correct']) {
        $id = $this->input->post('id');
        $precio = $this->input->post('precioCliente');
        $ok=true;
        //   $action  = $this->input->post('action');   ---> edit
        if ($precio == "") {
            $ok = false;
            $err['precio']  = "Ingrese un precio.";
        }
        if ($ok) {
              
            $this->load->model('EggsModel');
           $res=$this->EggsModel->editEggsClient($precio,$id);
            if($res){
                $this->response->sendJSONResponse(array('msg' => "Guardado con exito .")); 
            }else{
                $this->response->sendJSONResponse(array('msg' => "No se ha podido guardar el registro" ), 400);
            }
           
        } else {
            $this->response->sendJSONResponse(array('msg' => "Complete los datos de la tabla." ,'err'=> $err), 400);
        }
      } else {
        $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
      }

    }

/*
     public function editEggsTest () { 

        if ($this->accesscontrol->checkAuth()['correct']) {
        $id = $this->input->post('id');
        $tipo = $this->input->post('tipo');
        $stock  = $this->input->post('stock');
        $action  = $this->input->post('action');
        $ok = true;
        $err = array();

        if ($stock == "") {
            $ok = false;
            $err['stock']  = "Ingrese un cliente.";
        }
        if ($tipo == "") {
            $ok = false;
            $err['tipo']  = "Ingrese un precio. ";
        }

        if ($ok) {
              
            $this->load->model('EggsModel');
           $res=$this->EggsModel->editEggsTest($stock, $tipo,$id);
            if($res){
                $this->response->sendJSONResponse(array('msg' => "Guardado con exito .")); 
            }else{
                $this->response->sendJSONResponse(array('msg' => "El nombre ya existe. Reintente con otro." ), 400);
            }
           
        } else {
            $this->response->sendJSONResponse(array('msg' => "Complete los datos de la tabla." ,'err'=> $err), 400);
        }
    } else {
        $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
    }

    
   }

    */


    

}

