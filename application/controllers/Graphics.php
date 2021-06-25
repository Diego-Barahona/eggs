<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Graphics extends CI_Controller {

	public function __construct(){
		parent:: __construct(); 
	}
	
    public function adminCharts()
	{
		if ($this->accesscontrol->checkAuth()['correct']) {
			$this->load->view('shared/admin/header');
			$this->load->view('admin/adminCharts');
			$this->load->view('shared/admin/footer');
        } else {
			redirect('Home/login', 'refresh');
        }
	}



    public function chartGeneral()
	{
		if ($this->accesscontrol->checkAuth()['correct']) {
			$this->load->view('shared/admin/header');
			$this->load->view('chartsModule/chartGeneral');
			$this->load->view('shared/admin/footer');
        } else {
			redirect('Home/login','refresh');
        }
	}


    public function chartUtils()
	{
		if ($this->accesscontrol->checkAuth()['correct']) {
			$this->load->view('shared/admin/header');
			$this->load->view('chartsModule/chartUtils');
			$this->load->view('shared/admin/footer');
        } else {
			redirect('Home/login','refresh');
        }
	}
    public function chartSale()
	{
		if ($this->accesscontrol->checkAuth()['correct']) {
			$data['venta']=2;
			$this->load->view('shared/admin/header');
			$this->load->view('chartsModule/chartSale',$data);
			$this->load->view('shared/admin/footer');
        } else {
			redirect('Home/login', 'refresh');
        }
	}

    public function chartBuys()
	{
		if ($this->accesscontrol->checkAuth()['correct']) {
			$this->load->view('shared/admin/header');
			$this->load->view('chartsModule/chartBuys');
			$this->load->view('shared/admin/footer');
        } else {
			redirect('Home/login', 'refresh');
        }
	}

    public function chartExpensive()
	{
		if ($this->accesscontrol->checkAuth()['correct']) {
			$this->load->view('shared/admin/header');
			$this->load->view('chartsModule/chartExpensive');
			$this->load->view('shared/admin/footer');
        } else {
			redirect('Home/login', 'refresh');
        }
	}

    public function chartCredit()
	{
		if ($this->accesscontrol->checkAuth()['correct']) {
			$this->load->view('shared/admin/header');
			$this->load->view('chartsModule/chartCredit');
			$this->load->view('shared/admin/footer');
        } else {
			redirect('Home/login', 'refresh');
        }
	}

    public function chartStock()
	{
		if ($this->accesscontrol->checkAuth()['correct']) {
			$data['venta']=1;
			$this->load->view('shared/admin/header');
			$this->load->view('chartsModule/chartSale',$data);
			$this->load->view('shared/admin/footer');
        } else {
			redirect('Home/login', 'refresh');
        }
	}
	public function getUtilsByPeriod(){
		if ($this->accesscontrol->checkAuth()['correct']) {
			$this->load->model('GraphicModel');
			$data= $this->input->post('data');
			$periodo= $data['periodo'];
            if($res=$this->GraphicModel->getUtilsByPeriod($data)){
				$this->response->sendJSONResponse(array("res" =>$res , "periodo" =>$periodo)); 

			}else{
              
				$this->response->sendJSONResponse(array("msg"=>"No se podido cargar la información."),400); 
			}

        } else {
			redirect('Home/login', 'refresh');
        }
	}



	public function getSaleByPeriod(){
		if ($this->accesscontrol->checkAuth()['correct']) {
			$this->load->model('GraphicModel');
			$data= $this->input->post('data');
			$periodo= $data['periodo'];
            if($res=$this->GraphicModel->getSaleByPeriod($data)){
				$this->response->sendJSONResponse(array("res" =>$res , "periodo" =>$periodo)); 

			}else{
              
				$this->response->sendJSONResponse(array("msg"=>"No se podido cargar la información."),400); 
			}

        } else {
			redirect('Home/login', 'refresh');
        }
	}

	public function getSaleByProduct(){
		if ($this->accesscontrol->checkAuth()['correct']) {
			$this->load->model('GraphicModel');
			$data= $this->input->post('data');
			$product=$data['product'];
			$periodo= $data['periodo'];

			if($product =="1"){
			    $data['table_product']="huevo h";
				$data['cod_venta']="vh.codVenta";
				$data['id_product']="h.id";
				$data['id_join']="vh.idHuevo";
				$data['name']="h.name";


			}else{
				$data['table_product']="cigarros c";
				$data['cod_venta']="vc.codVenta";
				$data['id_product']="c.id";
				$data['id_join']="vc.idCigarro";
				$data['name']="c.nombre";
			}

            if($res=$this->GraphicModel->getSaleByProduct($data)){
				$this->response->sendJSONResponse(array("res" =>$res , "periodo" =>$periodo)); 

			}else{
              
				$this->response->sendJSONResponse(array("msg"=>"No se podido cargar la información."),400); 
			}

        } else {
			redirect('Home/login', 'refresh');
        }
	}


	public function getBuyByProduct(){

		if ($this->accesscontrol->checkAuth()['correct']) {

			$this->load->model('GraphicModel');
			$data= $this->input->post('data');
			$product=$data['product'];
			$periodo= $data['periodo'];

			if($product =="1"){
				
			    $data['table_product']="huevo h";    //ok
				$data['cod_compra']="ch.costoId";     //ok
				$data['id_product']="h.id";          //
				$data['id_join']="ch.huevoId";       //
				$data['name']="h.name"; 
				$data['total'] ="ch.total"  ;       //

			}else{

				$data['table_product']="cigarros c"; //ok
				$data['cod_compra']="cc.costoId";     // ok
				$data['id_product']="c.id";          //ok
				$data['id_join']="cc.cigarroId";    //
				$data['name']="c.nombre";  
				$data['total'] ="cc.total"  ;            //
			}

            if($res=$this->GraphicModel->getBuyByProduct($data)){
				$this->response->sendJSONResponse(array("res" =>$res , "periodo" =>$periodo)); 
			}else{
				$this->response->sendJSONResponse(array("msg"=>"No se podido cargar la información."),400); 
			}

        } else {
			redirect('Home/login', 'refresh');
        }
	}


	public function getBuysByPeriod(){

		if ($this->accesscontrol->checkAuth()['correct']) {
			$this->load->model('GraphicModel');
			$data= $this->input->post('data');
			$periodo= $data['periodo'];
            if ($res=$this->GraphicModel->getBuysByPeriod($data) ){
				$this->response->sendJSONResponse(array("res" =>$res , "periodo" =>$periodo)); 

			}else{
              
				$this->response->sendJSONResponse(array("msg"=>"No se podido cargar la información."),400); 
			}

        } else {
			redirect('Home/login', 'refresh');
        }

	}


 	public function getExpensiveByPeriod(){

          if ($this->accesscontrol->checkAuth()['correct']) {
			$this->load->model('GraphicModel');
			$data= $this->input->post('data');
			$periodo= $data['periodo'];
            if ($res=$this->GraphicModel->getExpensiveByPeriod($data) ){
				$this->response->sendJSONResponse(array("res" =>$res , "periodo" =>$periodo)); 
			}else{
				$this->response->sendJSONResponse(array("msg"=>"No se podido cargar la información."),400); 
			}

        } else {
			redirect('Home/login', 'refresh');
        }

	 }










	

	

	




















  
}