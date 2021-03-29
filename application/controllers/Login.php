<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Login extends CI_Controller
{
    public function __construct(){
		parent:: __construct(); 
		$this->load->database();
		$this->load->library(array('session', 'phpmailer_lib'));
        $this->load->model('LoginModel');
        $this->load->helper('login_rules');
    }
    
    public function login_user()
	{
        if ($this->input->is_ajax_request()) {

            /* Datos de formulario*/
            $data = $this->input->post('data');
            $rut = $data['rut'];
            $pass = $data['passwd'];

             /* Cargar datos para la validación de formulario*/
            $rules = get_rules_login();
            $this->form_validation->set_error_delimiters('', '');
            $this->form_validation->set_data($data);
            $this->form_validation->set_rules($rules);

            /*Validación de formulario
            Si el formulario no es valido*/
            if($this->form_validation->run() == FALSE){
                if(form_error('rut')) $msg['rut'] = form_error('rut');
                if(form_error('passwd')) $msg['passwd'] = form_error('passwd');
                $this->response->sendJSONResponse($msg);
                $this->output->set_status_header(400);  /*Algunos o todos los campos estan vacios */ 
            }else{ 
            /*Si el formulario es valido*/
                //Verificar si el usuario existe
                if ($user_data = $this->LoginModel->checkUser($rut)) {
                    //Verificar que el usuario se encuentra habilitado
                    if ($user_data->state !=1) {
                        $msg['msg']="Usuario no tiene permisos para acceder al sistema.";
                        $this->response->sendJSONResponse($msg);
                        $this->output->set_status_header(401);
                    } else {
                        //Verificar si la password esta correcta
                        $result = password_verify($pass, $user_data->password);
                        if ($result) {
                            //Credenciales correctas: Crear variables de session
                            $data = array(
                                'id' => $user_data->id,
                                'rut' => $user_data->rut,
                                'full_name' => $user_data->full_name,
                                'email' =>  $user_data->email,
                                'rango' => $user_data-> rol_id,
                            );
                            $this->session->set_userdata($data);
                            $msg['msg']="Inicio de Sesión exitoso.";
                            $this->response->sendJSONResponse($msg);
                        } else {
                            $msg['msg'] = "El rut o la clave es inválida. Reintente.";
                            $this->response->sendJSONResponse($msg);
                            $this->output->set_status_header(401);
                        }
                    }
                } else {
                    $msg['msg']="El usuario no se encuentra registrado.";
                    $this->response->sendJSONResponse($msg);
                    $this->output->set_status_header(401);
                }
            }
        }else{
            $msg['msg']="No se pudo encontrar el recurso.";
            $this->response->sendJSONResponse($msg);
            $this->output->set_status_header(404);
        }
    }

    public function recovery($code)
	{
        if (isset($code)) {
            //Recuperar el usuario
            //Si no lo encuentra
            if (!$user = $this->LoginModel->get_user_with_code($code)) {
                $data['mensaje'] ='El código de recuperación de contraseña no es válido. Por favor solicite uno nuevo.';
                $this->load->view('login', $data);
            } else {
                $current = date("Y-m-d H:i:s");
                if (strtotime($current) > strtotime($user->date_recovery)) {
                    $data['mensaje'] = 'El código de recuperación de contraseña ha expirado. Por favor solicite uno nuevo.';
                    $this->load->view('login', $data);
                } else {
                    $data['email'] = $user->email;
                    $this->load->view('recovery', $data);
                }
            }
        } else {
            redirect('Home/login', 'refresh');
        }
	}

    public function recovery_email()
    {
        /* Variables a utilizar */
        $msg = array();
        $fdate_recovery = date("Y-m-d H:i:s", strtotime('+24 hours'));
        $code = $this->create_random_code();

        /* Datos de formulario*/
        $data = $this->input->post('data'); 
        $email = $data['email_rec'];
     
        /* Cargar datos para la validación de formulario*/
        $rules = get_rules_recovery();
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($data);
        $this->form_validation->set_rules($rules);

        /*Validación de formulario
            Si el formulario no es valido*/
        if($this->form_validation->run() == FALSE){
            if(form_error('email_rec')) $msg['email'] = form_error('email_rec');
            $this->response->sendJSONResponse($msg);
            $this->output->set_status_header(400);  /*Algunos o todos los campos estan vacios */ 
        }else{ 
            /*Si el formulario es válido 
                Verificar si el usuario se encuentra registrado
                    Si el usuario no se encuentra registrado*/
            if (!$user = $this->LoginModel->get_user($email)) {
                $msg['msg'] = 'El correo electrónico no se encuentra registrado en el sistema.';
                $this->response->sendJSONResponse($msg);
                $this->output->set_status_header(400);
            } else {
                    /*Si el usuario se encuentra registrado
                      Verificar si esta habilitado */
                if ($user->state !=1) {
                    $msg['msg']="Usuario no tiene permisos para acceder al sistema.";
                    $this->response->sendJSONResponse($msg);
                    $this->output->set_status_header(401);
                }else{
                    if ($recovery = $this->LoginModel->recovery_password($user->id, $code, $fdate_recovery)) {
                        $this->phpmailer_lib->send_recovery($email, $user->full_name, $code);
                        $msg['msg'] = 'Se ha enviado un correo electrónico con las instrucciones para el cambio de tu contraseña. Por favor verifica la información enviada.';
                        $this->response->sendJSONResponse($msg);
                    } else {
                        $msg['msg'] = 'No se pudo recuperar la cuenta. Si los errores persisten comuniquese con el administrador del sitio.';
                        $this->response->sendJSONResponse($msg);
                    }
                }
            }
        }
    }

    public function new_password()
	{
        /* Variables a utilizar */
        $msg = array();

        /* Datos de formulario*/
        $data = $this->input->post('data');
        $email = $data['email'];
        $passwd = $data['passwd'];

        $data_pass = array(
            'passwd' => $data['passwd'],
            'passwd_rep' => $data['passwd_rep'],
        );

        /* Cargar datos para la validación de formulario*/
        $rules = get_rules_new_password();
        $this->form_validation->set_error_delimiters('', '');
        $this->form_validation->set_data($data_pass);
        $this->form_validation->set_rules($rules);

        /*Validación de formulario
        Si el formulario no es valido*/
        if($this->form_validation->run() == FALSE){
            if(form_error('passwd')) $msg['passwd'] = form_error('passwd');
            if(form_error('passwd_rep')) $msg['passwd_rep'] = form_error('passwd_rep');
            $this->response->sendJSONResponse($msg);
            $this->output->set_status_header(400);  /*Algunos o todos los campos estan vacios */ 
        }else{
            /* Obtener los datos del usuario */
            $user = $this->LoginModel->get_user($email);

            /*Actualizar la contraseña*/
            if ($update = $this->LoginModel->new_password($email, $passwd)) {
                $msg['msg']="La contraseña se actualizó con éxito.";
                $this->response->sendJSONResponse($msg);
            } else {
                $msg['msg'] = "No se pudo cargar el recurso.";
                $this->response->sendJSONResponse($msg);
                $this->output->set_status_header(404);
            }
        }
    }

    public function create_random_code()
    {
        $chars = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijkmnopqrstuvwxyz0123456789";
        srand((double)microtime()*1000000);
        $i = 0;
        $pass = '' ;
    
        while ($i <= 7) {
            $num = rand() % 33;
            $tmp = substr($chars, $num, 1);
            $pass = $pass . $tmp;
            $i++;
        }
        return time().$pass;
    }

    public function logout()
	{
		//Para cerrar sesion me pide los indices del actual userdata
		$vars = array('rut','full_name','email','rangoo','usuario','is_logged');
		$this->session->unset_userdata($vars);
		$this->session->sess_destroy();
        $msg['msg']=".";
        $this->response->sendJSONResponse($msg);
	}
}
