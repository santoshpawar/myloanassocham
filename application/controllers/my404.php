<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed'); 


class my404 extends CI_Controller 
{
    public function __construct() 
    {
        parent::__construct(); 
    } 

    public function index() 
    { 
		/* $data["sesuserId"]=$this->session->userdata('sesuserId');
		$data["sesuserName"]=$this->session->userdata('sesuserName');
		$data["utype_id"]=$this->session->userdata('utype_id');	
        $this->template->load('main','error_404',$data); */
		 $this->output->set_status_header('404');
		$this->template->load('main','error_404');
    } 
} 
?> 