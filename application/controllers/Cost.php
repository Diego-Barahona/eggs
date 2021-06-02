<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Cost extends CI_Controller {

	public function __construct(){
		parent:: __construct(); 
	}


    public function adminCost()
    { 
        
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->view('shared/admin/header');
            $this->load->view('admin/adminCost');
            $this->load->view('shared/admin/footer');
        } else {
            redirect('Home/login', 'refresh');
        }
    }

    
    public function getCost()
    {
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('CostModel');
            $datos = $this->CostModel->getCost();
            $this->response->sendJSONResponse($datos);
        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }
    }


     
    public function getBuys($id)
    {
        if ($this->accesscontrol->checkAuth()['correct']) {
            
            $this->load->model('CostModel');
            $datos = $this->CostModel->getBuys($id);
            $this->response->sendJSONResponse($datos);
        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }
    }


    public function createCost(){

        if ($this->accesscontrol->checkAuth()['correct']) {
            $data = $this->input->post('data');
            $fecha = $data['fecha'];
            $codigo = $data['codigo'];
            $proveedor = $data['proveedor'];
            $compras=$data['compras'];
            $productos=$data['productos'];
            $datos=array();
            $array = json_decode($productos, true);


            

     
            $ok = true;
            $err = array();
            
            if ($proveedor == "") {
                $ok = false;
                $err['proveedor']  = "Ingrese una fecha ";
            }
          
            if ($fecha == "") {
                $ok = false;
                $err['fecha']  = "Ingrese una fecha ";
            }
            if ($codigo == "") {
                $ok = false;
                $err['codigo']  = "Ingrese un codigo ";
            }

            //for para verificar si no hay datos 


            if ($ok) {

               
              // for para guardar compras en tabla stock
                $this->load->model('CostModel');
               $res=$this->CostModel->insertCost($data);//guardar en tabla de costos 
                if($res){
                    foreach ($array as $value) {
                        $datos= array(  
                        "tipoProducto" => $value['tipoProducto'],
                        "producto" => $value['producto'],
                        "valor" => $value['valor'],
                        "cantidad" => $value['cantidad'],
                        "total" => $value['total'],
                        "codigo" => $value['codigo'],
                        );

        
                        $this->load->model('BuyModel');
                        $res=$this->BuyModel->insertBuy($datos);
                   }
                   
                    $this->response->sendJSONResponse(array('msg' => "Producto registrado.")); 
                }else{
                    $this->response->sendJSONResponse(array('msg' => "El codigo ya existe. Reintente con otro." ), 400);
                }
               
            } else {
                $this->response->sendJSONResponse(array('msg' => "Complete los campos del formulario." ,'err'=> $err), 400);
            }
        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }
    }

   
    public function editCost()
    {
        if ($this->accesscontrol->checkAuth()['correct']) {
            $data = $this->input->post('data');
            $fecha = $data['fecha'];
            $codigo = $data['codigo'];
            $proveedor = $data['proveedor'];
            $compras=$data['compras'];
            $productos=$data['productos'];
            $tipoProveedorNuevo =$data['tipoProveedorNuevo'];
            $tipoProveedor=$data['tipoProveedor'];
            $datos=array();
            $array = json_decode($productos, true);

            $ok = true;
            $err = array();
            
            if ($proveedor == "") {
                $ok = false;
                $err['proveedor']  = "Ingrese una fecha ";
            }
          
            if ($fecha == "") {
                $ok = false;
                $err['fecha']  = "Ingrese una fecha ";
            }
           
         
            if ($ok) {
                
                $this->load->model('CostModel');
                //guardar en tabla de costos 
                 
                if($this->CostModel->updateCost($data)){
                    if($tipoProveedor == $tipoProveedorNuevo){ 
                          
                            $this->CostModel->deleteProducts($tipoProveedorNuevo,$codigo); //elimina prductos y salva stockReal

                            foreach ($array as $value) {
                                $datos= array(  
                                "tipoProducto" => $value['tipoProducto'],
                                 "producto" => $value['producto'],
                                 "valor" => $value['valor'],
                                 "cantidad" => $value['cantidad'],
                                 "total" => $value['total'],
                                 "codigo" => $value['codigo'],
                                );
                                 
                                 $res=$this->CostModel->insertCompra($datos);
                                }
                          
                           $this->response->sendJSONResponse(array('msg' => "Producto registrado."));    
                   }else{
                         
                                $this->CostModel->deleteProducts($tipoProveedor,$codigo);
                                foreach ($array as $value) {
                                    $datos= array(  
                                    "tipoProducto" => $value['tipoProducto'],
                                     "producto" => $value['producto'],
                                     "valor" => $value['valor'],
                                     "cantidad" => $value['cantidad'],
                                     "total" => $value['total'],
                                     "codigo" => $value['codigo'],
                                    );
                                    
                                     $this->CostModel->insertCompra($datos);
                                    }
                              
                               $this->response->sendJSONResponse(array('msg' => "Producto registrado.")); 
                            }

                 } else {
                    
                    $this->response->sendJSONResponse(array('msg' => "Error en la edición de la compra." ), 400);}
                 
                 
              } else {
                  $this->response->sendJSONResponse(array('msg' => "Complete los campos del formulario." ,'err'=> $err), 400);
              }

        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }
    }

    public function getEggs()
    {
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('CostModel');
            $data = $this->CostModel->getEggs();
            $this->response->sendJSONResponse($data);
        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }
    }

    public function getCigar()
    {
        if ($this->accesscontrol->checkAuth()['correct']) {
            $this->load->model('CostModel');
            $data = $this->CostModel->getCigar();
            $this->response->sendJSONResponse($data);
        } else {
            $this->response->sendJSONResponse(array('msg' => 'Permisos insuficientes'), 400);
        }
    }







}
