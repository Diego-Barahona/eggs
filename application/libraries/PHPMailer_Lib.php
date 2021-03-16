<?php
defined('BASEPATH') OR exit('No direct script access allowed');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

class PHPMailer_Lib
{
    private $CI;

	public function __construct() {
		$this->CI =& get_instance();
        $this->CI->load->helper('email');
        log_message('Debug', 'PHPMailer class is loaded.');
	}

    public function load(){
        // Include PHPMailer library files
        require_once APPPATH.'third_party/PHPMailer/Exception.php';
        require_once APPPATH.'third_party/PHPMailer/PHPMailer.php';
        require_once APPPATH.'third_party/PHPMailer/SMTP.php';
        
        $mail = new PHPMailer;
        return $mail;
    }

    public function send($email_to,$title,$body){

        require_once APPPATH.'third_party/PHPMailer/Exception.php';
        require_once APPPATH.'third_party/PHPMailer/PHPMailer.php';
        require_once APPPATH.'third_party/PHPMailer/SMTP.php';

        $mail = new PHPMailer;
        
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host     = 'smtp.gmail.com';
        $mail->SMTPAuth = true;
        $mail->Username = 'picamaderomuebles@gmail.com';
        $mail->Password = 'Zkb?Wx8.ihxi';
        $mail->SMTPSecure = 'tls';
        $mail->Port     = 587;
        
        $mail->setFrom('picamaderomuebles@gmail.com', 'Picamadero');
        $mail->addReplyTo('picamaderomuebles@gmail.com', 'Picamadero');
        
        // Add a recipient
        $mail->addAddress($email_to);

        // Email subject
        $mail->Subject =$title;
        
        // Set email format to HTML
        $mail->isHTML(true);
        
        // Email body content
        $mail->Body = $body;
        
        // Send email
        if(!$mail->send()){
            return $mail->ErrorInfo;
        }else{
            return true;
        }
    }

    public function send_recovery($email_to,$name,$codigo){

        require_once APPPATH.'third_party/PHPMailer/Exception.php';
        require_once APPPATH.'third_party/PHPMailer/PHPMailer.php';
        require_once APPPATH.'third_party/PHPMailer/SMTP.php';

        $template = file_get_contents("application/views/admin/recovery_email.php", true);
        $template = str_replace("{{name}}", $name, $template);
        $template = str_replace("{{action_url_2}}", '<b>'.base_url() .'login/recovery/'.$codigo.'</b>', $template);
        $template = str_replace("{{action_url_1}}", base_url() .'login/recovery/'.$codigo, $template);
        $template = str_replace("{{year}}", date('Y'), $template);
        $template = str_replace("{{operating_system}}", get_os(), $template);
        $template = str_replace("{{browser_name}}", get_brow(), $template);
        
    
        $mail = new PHPMailer;
        $mail->CharSet = "UTF-8";
        
        // SMTP configuration
        $mail->isSMTP();
        $mail->Host = 'smtp.googlemail.com';  //gmail SMTP server
        $mail->SMTPAuth = true;
        $mail->Username = '';   //username
        $mail->Password = '';   //password
        $mail->SMTPSecure = 'ssl';
        $mail->Port = 465; 
        
        $mail->setFrom('baraippox835@gmail.com', 'Sistema recuperación de contraseña Eggs');
        //$mail->addReplyTo('picamaderomuebles@gmail.com', 'Picamadero');
        
        // Add a recipient
        $mail->addAddress($email_to);

        // Email subject
        $mail->Subject ="Recuperación de contraseña - Eggs";
        
        // Set email format to HTML
        $mail->isHTML(true);
        
        // Email body content
        $mail->Body = $template;
        $env = 'no';
        $noenv = 'so';
        // Send email
        if(!$mail->send()){
            return $mail->ErrorInfo;
        }else{
            return true;
        }
    }
}