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
			$this->load->view('shared/admin/header');
			$this->load->view('chartsModule/chartSale');
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
			$this->load->view('shared/admin/header');
			$this->load->view('chartsModule/chartStock');
			$this->load->view('shared/admin/footer');
        } else {
			redirect('Home/login', 'refresh');
        }
	}
	public function getUtilsByPeriod()
	{
		if ($this->accesscontrol->checkAuth()['correct']) {
			$this->load->model('GraphicModel');
			$data= $this->input->post('data');
			$periodo= $data['periodo'];
            if($res=$this->GraphicModel->getUtilsByPeriod($data)){
				$this->response->sendJSONResponse(array("res" =>$res , "periodo" =>$periodo)); 

			}else{


			}


        } else {
			redirect('Home/login', 'refresh');
        }
	}








  
}