<?php 
class Login extends CI_Controller { 

	function __construct() 
	{
		parent::__construct();
		$this->load->library('user_agent');
		$this->load->model('user/user_model');
		$this->load->library(array('form_validation','user_authentication'));
		$this->load->helper(array('flexigrid','phpmailer'));
	}
	
	function index()
	{
		$this->form_validation->set_rules('email_id', 'email_id', 'trim|required|_check_login');
			$this->form_validation->set_rules('password', 'password', 'trim|required');
			if($this->form_validation->run())
			{
				// the form has successfully validated
				$username=$this->input->post('email_id');
				$password=$this->input->post('password');
				$remember=$this->input->post('remember');
				/* if($this->user_authentication->try_login(array('u.email_id' => $username, 'u.password' => $password)))
				{
					$op_wh["u.uid"]=$this->session->userdata('sesuserId');
					redirect('home');	
					
				}else{ 
				
				redirect('user/login');
				} */
				
				if($remember ==1)
					{
						
						 setcookie('username', $username, time() + (864000 * 30), "/");
						 setcookie('password', $password, time() + (864000 * 30), "/"); 
					} 
				if(is_numeric($this->input->post('email_id'))){
					if($this->user_authentication->try_login(array('u.mobile_no' => $username, 'u.password' => $password)))
					{

						$op_wh["u.uid"]=$this->session->userdata('sesuserId');
						$message = "You have successfully loggedin" ;
						$class = "succ";	
						$redirect = "manage/dashboard";
						
					}
					else{ 
				
						$message = "Please check your credential" ;
						$class = "err";
						$redirect = "";
					}
				}else{
					if($this->user_authentication->try_login(array('u.email_id' => $username, 'u.password' => $password)))
					{

						$op_wh["u.uid"]=$this->session->userdata('sesuserId');
						$message = "You have successfully loggedin" ;
						$class = "succ";	
						$redirect = "manage/dashboard";
						
					}
					else
					{ 
				
						$message = "Please check your credential" ;
						$class = "err";
						$redirect = "";
					}	
					
				}
				
           


            echo(json_encode(array('message'=>$message,'class'=>$class,'redirect'=>$redirect, 'username'=>$username)));

            unset($message,$class);

			}

	}
	
	function user_logout()
	{
		//echo "Rj";exit;
		$this->user_authentication->user_logout();
		redirect('home');
	}
	function updateUrl()
	{
		$current_url=$_REQUEST["current_url"];
		$this->session->set_userdata(array('current_url'=>$current_url));
		
	}

	
	function _check_login($username)
	{
		
		if($this->input->post('password')=='')
		{
			return true;
		}
		if($this->input->post('password'))
		{
			$username = $this->input->post('email_id', true);
    		$password = $this->input->post('password', true);
			$user = $this->user_model->getUsers(array('u.email_id' => $username, 'u.password' => $password));
			if($user) return true;
		}
		
		$this->form_validation->set_message('_check_login', 'Your username / password combination is invalid.');
		return false;
	}
        
        function forgetpass()
        {
            
                   $this->load->view('manage/forgetpass');
            
        }
      
        	
}

/* End of file main.php */
/* Location: ./application/modules/adminstrator/controllers/authenticat.php */