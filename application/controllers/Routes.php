<?php
defined('BASEPATH') OR exit('No direct script access allowed');

class Routes extends CI_Controller {

	public function __construct(){
		parent:: __construct(); 
		$this->load->model('RouteModel');
		$this->load->helper('route_rules');
	}
	
	//Function to load routes index view
    public function index()
	{
		if ($this->accesscontrol->checkAuth()['correct']) {
			$this->load->view('shared/admin/header');
			$this->load->view('admin/adminRoute');
			$this->load->view('shared/admin/footer');
        } else {
			redirect('Home/login', 'refresh');
        }
	}

	//Function to load list route
	public function list()
	{
		if ($this->accesscontrol->checkAuth()['correct']) {
			$routes = $this->RouteModel->getRoutes();
			$this->response->sendJSONResponse($routes);
        } else {
			redirect('Home/login', 'refresh');
        }
	}

	//Function load index to create route
	public function indexCreate()
	{
		if ($this->accesscontrol->checkAuth()['correct']) {   
            $data['sellers'] = $this->RouteModel->getSellers();
			$data['eggs'] = $this->RouteModel->getEggsHeaders();
			$this->load->view('shared/admin/header');
			$this->load->view('admin/createRoute' , $data);
			$this->load->view('shared/admin/footer');
        } else {
			redirect('Home/login', 'refresh');
        }
    }      

	//Function to get data client to load datatable
	public function getDataClient()
	{   
		if ($this->accesscontrol->checkAuth()['correct']) {
			$data = $this->input->post('data'); 
			$client = $this->RouteModel->getDataClient($data);
			$this->response->sendJSONResponse($client);
        } else {
			redirect('Home/login', 'refresh');
        }
	}

	//Function to get data client to load datatable
	public function getDataForm()
	{   
		if ($this->accesscontrol->checkAuth()['correct']) {
			$data = $this->input->post('data'); 
			$products= $this->RouteModel->getProducts();
			$eggs = $this->RouteModel->getEggs();
			$eggsHeader = $this->RouteModel->getEggsHeaders();
			$cigars= $this->RouteModel->getCigars();
			$clients = $this->RouteModel->getClients();
			$this->response->sendJSONResponse(array($eggs, $clients, $eggsHeader));
		} else {
			redirect('Home/login', 'refresh');
		}
	}

	//Function to get data client to load datatable
	public function getDataFormUpdate()
	{   
		if ($this->accesscontrol->checkAuth()['correct']) {
			$url = parse_url($_SERVER['REQUEST_URI']);
            parse_str($url['query'], $params);
            $id = $params['id'];
			$route = $this->RouteModel->getRouteById($id);
			$eggsClient = $this->RouteModel->getEggs();
			$eggsStock = $this->RouteModel->getEggsHeaders();
			$eggsHeaderRoute = $this->getEggsHeadersByRoute($route['detalle']);
			$this->response->sendJSONResponse(array($eggsClient, $route, $eggsHeaderRoute, $eggsStock));
		} else {
			redirect('Home/login', 'refresh');
		}
	}

	//Function to get data client to load datatable
	public function create()
	{   
		if ($this->accesscontrol->checkAuth()['correct']) {
			$data = $this->input->post('data');
			if($this->RouteModel->create($data)){
				/*Actualizar registro en la tabla roles */
				$msg['msg'] = "Ruta registrada con éxito.";
				$this->response->sendJSONResponse($msg);
			}else{
				$msg['msg'] = "No se pudo encontrar el recurso";
				$this->response->sendJSONResponse($msg);
				$this->output->set_status_header(405);
			} 	
		}else {
			redirect('Home/login', 'refresh');
        }
	}

	//Function to get data client to load datatable
	public function adminDetails()
	{   
		if ($this->accesscontrol->checkAuth()['correct']) {
			$url = parse_url($_SERVER['REQUEST_URI']);
			parse_str($url['query'], $params);
			$id = $params['id'];
			$data = $this->RouteModel->getRouteById($id);
			$data['sellers'] = $this->RouteModel->getSellers();
			$this->load->view('shared/admin/header');
			$this->load->view('admin/detailsRoute' , $data);
			$this->load->view('shared/admin/footer');
		}else {
			redirect('Home/login', 'refresh');
		}
	}

	//Function to get data client to load datatable
	public function adminUpdate()
	{   
		if ($this->accesscontrol->checkAuth()['correct']) {
			$url = parse_url($_SERVER['REQUEST_URI']);
            parse_str($url['query'], $params);
            $id = $params['id'];
			$data = $this->RouteModel->getRouteById($id);
			$data['eggs'] = $this->getEggsHeadersByRoute($data['detalle']);
			$data['sellers'] = $this->RouteModel->getSellers();
			$this->load->view('shared/admin/header');
			$this->load->view('admin/updateRoute' , $data);
			$this->load->view('shared/admin/footer');
		}else {
			redirect('Home/login', 'refresh');
		}
	}

	//Function to get data client to load datatable
	public function update()
	{   
		if ($this->accesscontrol->checkAuth()['correct']) {
			$data = $this->input->post('data');
			if($this->RouteModel->update($data)){
				/*Actualizar registro en la tabla roles */
				$msg['msg'] = "Ruta registrada con éxito.";
				$this->response->sendJSONResponse($msg);
			}else{
				$msg['msg'] = "No se pudo encontrar el recurso";
				$this->response->sendJSONResponse($msg);
				$this->output->set_status_header(405);
			} 	
		}else {
			redirect('Home/login', 'refresh');
        }
	}


	//Function to get data client to load datatable
	public function delete()
	{   
		if ($this->accesscontrol->checkAuth()['correct']) {
			$url = parse_url($_SERVER['REQUEST_URI']);
            parse_str($url['query'], $params);
            $id = $params['id'];
			if($this->RouteModel->delete($id)){
				/*Actualizar registro en la tabla roles */
				$msg['msg'] = "Ruta eliminada con éxito.";
				$this->response->sendJSONResponse($msg);
			}else{
				$msg['msg'] = "No se pudo encontrar el recurso";
				$this->response->sendJSONResponse($msg);
				$this->output->set_status_header(405);
			} 	
		}else {
			redirect('Home/login', 'refresh');
		}
	}

	public function getEggsHeadersByRoute ($data)
	{
		$allObjects = json_decode($data, true);
		$eggs = $allObjects[0]['Huevos'];
		$eggsHeader = [];
		foreach ($eggs as &$valor) {
			$datos_route = array(
				'id' => $valor['id'],
				'name' => $valor['name'],
				'format' => $valor['formato'],
			);
			array_push($eggsHeader, $datos_route);
		}
		return $eggsHeader;
	}
}
