<?php 
class Login extends CI_Controller { 

	function __construct() 
	{
		parent::__construct();
		$this->load->library('user_agent');
		$this->load->model('manage/admin_model');
		$this->load->library(array('form_validation','authentication'));
		$this->load->helper(array('flexigrid','phpmailer'));
	}
	
	function index()
	{
		//echo $uri;
		//CHECKING FOR LOGIN IN IE 8 AND REST OF THE MODERN BROWSER LIKE MOZILLA - MODIFIED BY DHIRAJ 10.04.2015
		if (preg_match("/(?i)msie [1-8]\.0/",$_SERVER['HTTP_USER_AGENT']))
	  	{
	   		$this->load->view('manage/login_rest');
	  	}
	  	else
	  	{
			
		
		/*check flage value for front end user not admin by dhiraj 24022015*/
		$data["segment"] = $this->uri->segment(3);
		//echo $data["segment"];	
		//echo $this->session->userdata('userId');die();
		if($this->session->userdata('userId')!='')
		{
			redirect('manage/dashboard/');
		}
		else
		{
				
				$this->form_validation->set_rules('email_id', 'email_id', 'trim|required');
				$this->form_validation->set_rules('temp', 'temp', 'callback__check_login');
				$this->form_validation->set_rules('password', 'password', 'trim|required');
				if($this->form_validation->run())
				{
					// the form has successfully validated
					$username=$this->input->post('email_id');
					$password=$this->input->post('password');
					if(is_numeric($this->input->post('email_id'))){
					if($this->authentication->try_login(array('u.mobile_no' => $username, 'u.password' => $password)))
					{
						$op_wh["u.uid"]=$this->session->userdata('userId');
								
						$log_det=$this->admin_model->getUsers($op_wh);
						if($log_det[0]->status==0)
						{
							$this->authentication->logout();
							 $this->session->set_flashdata('block', 'Your status is now inactive - please contact your Administrator to be reinstated.');
							redirect('manage/login',$data);
							exit();
						}
						else
						{								
							redirect('manage/dashboard/');	
								
						}
							 
					} 
					}else{
					if($this->authentication->try_login(array('u.email_id' => $username, 'u.password' => $password)))
					{
						$op_wh["u.uid"]=$this->session->userdata('userId');
								
						$log_det=$this->admin_model->getUsers($op_wh);
						if($log_det[0]->status==0)
						{
							$this->authentication->logout();
							 $this->session->set_flashdata('block', 'Your status is now inactive - please contact your Administrator to be reinstated.');
							redirect('manage/login',$data);
							exit();
						}
						else
						{								
							redirect('manage/dashboard/');	
								
						}
							 
					} 	
					}
					redirect('manage/login',$data);
					
				}
				//print_r($data);exit;
				$this->load->view('manage/login',$data);
			}
		}	
	}
	
	function logout()
	{//print_r($this->session);echo "ssss----------";
		$this->authentication->logout();
		//print_r($this->session);die("sssss");
		redirect('manage/login');
	}
	

	
	function _check_login($username)
	{
		
		if($this->input->post('password')=='')
		{
			return true;
		}
		
		if($this->input->post('password'))
		{
			if(is_numeric($this->input->post('email_id', true))){
			$username = $this->input->post('email_id', true);
    		$password = $this->input->post('password', true);
			$user = $this->admin_model->getUsers(array('u.mobile_no' => $username, 'u.password' => $password));
			if($user) return true;
			}else{
			$username = $this->input->post('email_id', true);
    		$password = $this->input->post('password', true);
			$user_type=$this->input->post('user_type');
			$user = $this->admin_model->getUsers(array('u.email_id' => $username, 'u.password' => $password));
			if($user) return true;	
				
			}
		}
		
		$this->form_validation->set_message('_check_login', 'Your username / password combination is invalid.');
		return false;
	}
        
        function forgetpass()
        {
            
                   $this->load->view('manage/forgetpass');
            
        }
      function insertfor_pass_record()
        {
           
                   $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
                   $pass = array(); //remember to declare $pass as an array
                   $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
                   for ($i = 0; $i < 8; $i++) {
                   $n = rand(0, $alphaLength);
                   $pass[] = $alphabet[$n];
                         }
                   $pass_fog=(implode($pass));
                  
                   $options_t["u.email_id"]=$_REQUEST['email_id'];
                   $em = $this->admin_model->chekuser($options_t); 
                   if(empty($em)){
                                             
                       echo"<script language=javascript> alert(\"OOPS! email is not registered try again with different email!\");window.history.back();</script>";
                   }
                   else
				   {
                   
                   	$options["email_id"]=$_REQUEST['email_id'];
                	$options["password"]=$this->admin_model->_prep_password($pass_fog);
					$options["status"]=1;
					$opt_where["email_id"]=$_REQUEST['email_id'];
					$add_pass=$this->admin_model->update_pass($options,$opt_where);
							
					 $this->session->set_flashdata('notification', 'Please check your email to find new password');
					
				}
				
                
                  
                redirect('manage/login');
			
            
        }
        	
}

/* End of file main.php */
/* Location: ./application/modules/adminstrator/controllers/authenticat.php */