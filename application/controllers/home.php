<?php 

class Home extends CI_Controller {

	
	function __construct()  
	{
		parent::__construct(); 
		$this->load->helper(array('form','date'));
		$this->load->library(array('form_validation','user_authentication'));
		$this->load->library('my_phpmailer');
		
		$this->load->model('user/user_model');	
		$this->load->helper('cookie');
		$this->sms_url= 'http://smsapi.24x7sms.com/api_2.0/SendSMS.aspx?APIKEY=SpdxEeX9K6D';
	} 

	
	function index()
	{   
		$url=$this->uri->segment(1);
		if(isset($url) && $url=='home'){
			redirect('');
		}
		if(isset($_COOKIE['username']))
		{
			$data["username"] = get_cookie('username');
			$data["password"] = get_cookie('password');
			
			$data["sesuserId"]=$this->session->userdata('sesuserId');
			$data["sesuserName"]=$this->session->userdata('sesuserName');
		 //$data["password"] = getcookie('password');
		}else{
		$data["sesuserId"]=$this->session->userdata('sesuserId');
		$data["sesuserName"]=$this->session->userdata('sesuserName');	
		}
		$data["utype_id"]=$this->session->userdata('utype_id');	
		$this->template->load('main','home',$data);
	}
	function about()
	{   
		$data["sesuserId"]=$this->session->userdata('sesuserId');
		$data["sesuserName"]=$this->session->userdata('sesuserName');
		$data["utype_id"]=$this->session->userdata('utype_id');	
		$this->template->load('main','about',$data);
	}
	function privacy()
	{   
		$data["sesuserId"]=$this->session->userdata('sesuserId');
		$data["sesuserName"]=$this->session->userdata('sesuserName');
		$data["utype_id"]=$this->session->userdata('utype_id');	
		$this->template->load('main','privacy',$data);
	}
	function terms()
	{   
		$data["sesuserId"]=$this->session->userdata('sesuserId');
		$data["sesuserName"]=$this->session->userdata('sesuserName');
		$data["utype_id"]=$this->session->userdata('utype_id');	
		$this->template->load('main','terms',$data);
	}
	function vision()
	{   
		$data["sesuserId"]=$this->session->userdata('sesuserId');
		$data["sesuserName"]=$this->session->userdata('sesuserName');
		$data["utype_id"]=$this->session->userdata('utype_id');	
		$this->template->load('main','vision',$data);
	}
	function mission()
	{   
		$data["sesuserId"]=$this->session->userdata('sesuserId');
		$data["sesuserName"]=$this->session->userdata('sesuserName');
		$data["utype_id"]=$this->session->userdata('utype_id');	
		$this->template->load('main','mission',$data);
	}
	function quote()
	{   
		$data["sesuserId"]=$this->session->userdata('sesuserId');
		$data["sesuserName"]=$this->session->userdata('sesuserName');
		$data["utype_id"]=$this->session->userdata('utype_id');	
		$this->template->load('main','quote',$data);
	}
	function assocham_quote()
	{   
		$data["sesuserId"]=$this->session->userdata('sesuserId');
		$data["sesuserName"]=$this->session->userdata('sesuserName');
		$data["utype_id"]=$this->session->userdata('utype_id');	
		$this->template->load('main','assocham_quote',$data);
	}
	function assocham_quoteSecretery()
	{   
		$data["sesuserId"]=$this->session->userdata('sesuserId');
		$data["sesuserName"]=$this->session->userdata('sesuserName');
		$data["utype_id"]=$this->session->userdata('utype_id');	
		$this->template->load('main','assocham_quoteSecretery',$data);
	}
	function mudra_quote()
	{   
		$data["sesuserId"]=$this->session->userdata('sesuserId');
		$data["sesuserName"]=$this->session->userdata('sesuserName');
		$data["utype_id"]=$this->session->userdata('utype_id');	
		$this->template->load('main','mudra_quote',$data);
	}
	function type_of_loan()
	{   
		$data["sesuserId"]=$this->session->userdata('sesuserId');
		$data["sesuserName"]=$this->session->userdata('sesuserName');
		$data["utype_id"]=$this->session->userdata('utype_id');	
		$this->template->load('main','type_of_loan',$data);
	}
	function lead_bank_partners()
	{   
		$data["sesuserId"]=$this->session->userdata('sesuserId');
		$data["sesuserName"]=$this->session->userdata('sesuserName');
		$data["utype_id"]=$this->session->userdata('utype_id');	
		$this->template->load('main','lead_bank_partners',$data);
	}
	function participating_bank_partners()
	{   
		$data["sesuserId"]=$this->session->userdata('sesuserId');
		$data["sesuserName"]=$this->session->userdata('sesuserName');
		$data["utype_id"]=$this->session->userdata('utype_id');	
		$this->template->load('main','participating_bank_partners',$data);
	}
	function nbfc()
	{   
		$data["sesuserId"]=$this->session->userdata('sesuserId');
		$data["sesuserName"]=$this->session->userdata('sesuserName');
		$data["utype_id"]=$this->session->userdata('utype_id');	
		$this->template->load('main','nbfc',$data);
	}
	function insurance()
	{   
		$data["sesuserId"]=$this->session->userdata('sesuserId');
		$data["sesuserName"]=$this->session->userdata('sesuserName');
		$data["utype_id"]=$this->session->userdata('utype_id');	
		$this->template->load('main','insurance',$data);
	}
	function how_to_apply()
	{   
		$data["sesuserId"]=$this->session->userdata('sesuserId');
		$data["sesuserName"]=$this->session->userdata('sesuserName');
		$data["utype_id"]=$this->session->userdata('utype_id');	
		$this->template->load('main','how_to_apply',$data);
	}
	function information_required()
	{   
		$data["sesuserId"]=$this->session->userdata('sesuserId');
		$data["sesuserName"]=$this->session->userdata('sesuserName');
		$data["utype_id"]=$this->session->userdata('utype_id');	
		$this->template->load('main','information_required',$data);
	}
	function documents_required()
	{   
		$data["sesuserId"]=$this->session->userdata('sesuserId');
		$data["sesuserName"]=$this->session->userdata('sesuserName');
		$data["utype_id"]=$this->session->userdata('utype_id');	
		$this->template->load('main','documents_required',$data);
	}
	function track_your_application()
	{   
		$data["sesuserId"]=$this->session->userdata('sesuserId');
		$data["sesuserName"]=$this->session->userdata('sesuserName');
		$data["utype_id"]=$this->session->userdata('utype_id');	
		//$data['status']='none';
		if($this->input->post('refNo')!='' && $this->input->post('mobileNo'))
		{
			$data['refNo']=$this->input->post('refNo');
			$data['mobileNo']=$this->input->post('mobileNo'	);
			$data['status']=$this->user_model->getStatus($data['refNo'],$data['mobileNo']);
			if(empty($data['status'])){
				$data['error']='Application not found please enter valid details';
			}
		}
		$this->template->load('main','track_your_application',$data);
	}
	function faq()
	{   
		$data["sesuserId"]=$this->session->userdata('sesuserId');
		$data["sesuserName"]=$this->session->userdata('sesuserName');
		$data["utype_id"]=$this->session->userdata('utype_id');	
		$this->template->load('main','faq',$data);
	}
	
	function download_form()
	{   
		$data["sesuserId"]=$this->session->userdata('sesuserId');
		$data["sesuserName"]=$this->session->userdata('sesuserName');
		$data["utype_id"]=$this->session->userdata('utype_id');	
		$this->template->load('main','download_form',$data);
	}
	
	function offer_from_partner()
	{   
		$data["sesuserId"]=$this->session->userdata('sesuserId');
		$data["sesuserName"]=$this->session->userdata('sesuserName');
		$data["utype_id"]=$this->session->userdata('utype_id');	
		$this->template->load('main','offer_from_partner',$data);
	}
	
	function emi_calculator()
	{   
		$data["sesuserId"]=$this->session->userdata('sesuserId');
		$data["sesuserName"]=$this->session->userdata('sesuserName');
		$data["utype_id"]=$this->session->userdata('utype_id');	
		$this->template->load('main','emi_calculator',$data);
	}
	
	function circular()
	{   
		$data["sesuserId"]=$this->session->userdata('sesuserId');
		$data["sesuserName"]=$this->session->userdata('sesuserName');
		$data["utype_id"]=$this->session->userdata('utype_id');	
		$this->template->load('main','circular',$data);
	}
	
	function contact_us()
	{   
		$data["sesuserId"]=$this->session->userdata('sesuserId');
		$data["sesuserName"]=$this->session->userdata('sesuserName');
		$data["utype_id"]=$this->session->userdata('utype_id');	
		$this->template->load('main','contact_us',$data);
	}
	
	function sbi()
	{   
		$data["sesuserId"]=$this->session->userdata('sesuserId');
		$data["sesuserName"]=$this->session->userdata('sesuserName');
		$data["utype_id"]=$this->session->userdata('utype_id');	
		$this->template->load('main','sbi',$data);
	}
	
	function sbi_contact()
	{   
		$data["sesuserId"]=$this->session->userdata('sesuserId');
		$data["sesuserName"]=$this->session->userdata('sesuserName');
		$data["utype_id"]=$this->session->userdata('utype_id');	
		$this->template->load('main','sbi_contact',$data);
	}
	
	function yes_bank()
	{   
		$data["sesuserId"]=$this->session->userdata('sesuserId');
		$data["sesuserName"]=$this->session->userdata('sesuserName');
		$data["utype_id"]=$this->session->userdata('utype_id');	
		$this->template->load('main','yes_bank',$data);
	}
	
	function sbh()
	{   
		$data["sesuserId"]=$this->session->userdata('sesuserId');
		$data["sesuserName"]=$this->session->userdata('sesuserName');
		$data["utype_id"]=$this->session->userdata('utype_id');	
		$this->template->load('main','sbh',$data);
	}
	
	function bom()
	{   
		$data["sesuserId"]=$this->session->userdata('sesuserId');
		$data["sesuserName"]=$this->session->userdata('sesuserName');
		$data["utype_id"]=$this->session->userdata('utype_id');	
		$this->template->load('main','bom',$data);
	}
	
	function srei()
	{   
		$data["sesuserId"]=$this->session->userdata('sesuserId');
		$data["sesuserName"]=$this->session->userdata('sesuserName');
		$data["utype_id"]=$this->session->userdata('utype_id');	
		$this->template->load('main','srei',$data);
	}
	
	function register()
	{   
		$data["sesuserId"]=$this->session->userdata('sesuserId');
		$data["sesuserName"]=$this->session->userdata('sesuserName');
		$data["utype_id"]=$this->session->userdata('utype_id');	
		$this->template->load('main','register',$data);
	}
	function msme_register()
	{   
		$url=$this->uri->segment(1);
		if(isset($url) && $url=='home'){
			redirect('Msme-Register');
		}
		$data["sesuserId"]=$this->session->userdata('sesuserId');
		$data["sesuserName"]=$this->session->userdata('sesuserName');
		$data["utype_id"]=$this->session->userdata('utype_id');	
		$data["state"] = $this->user_model->fetch_state();
		$this->template->load('main','msme_register',$data);
	}
	function msme_otp()
	{   
		$data["sesuserId"]=$this->session->userdata('sesuserId');
		$data["sesuserName"]=$this->session->userdata('sesuserName');
		$data["utype_id"]=$this->session->userdata('utype_id');
		$data["email_id"]=$this->session->userdata('email');	
		$data["password"]=$this->session->userdata('pass');		
		$data["password"]=$this->session->userdata('pass');	
		$data["mob_no"]=$this->session->userdata('mob_no');			
		$this->template->load('main','msme_otp',$data);
	}
	function channel_partner_register()
	{  
		$url=$this->uri->segment(1);
		if(isset($url) && $url=='home'){
			redirect('Channel-Partner-Register');
		}
		$data["sesuserId"]=$this->session->userdata('sesuserId');
		$data["sesuserName"]=$this->session->userdata('sesuserName');
		$data["utype_id"]=$this->session->userdata('utype_id');	
		$this->template->load('main','channel_partner',$data);
	}
	function channel_partner_otp()
	{ 
		//print_r($this->session); exit;
		$data["sesuserId"]=$this->session->userdata('sesuserId');
		$data["sesuserName"]=$this->session->userdata('sesuserName');
		$data["utype_id"]=$this->session->userdata('utype_id');	
		$data["email_id"]=$this->session->userdata('email');	
		$data["password"]=$this->session->userdata('pass');	
		$data["advisor_mob_no"]=$this->session->userdata('mob_no');	
		$this->template->load('main','channel_partner_otp',$data);
	}
	function ajax_call() {
      
        if (isset($_POST) && isset($_POST['city'])) {
            $city = $_POST['city'];
			           $arrCitys = $this->user_model->fetch_city($city);
					   
                     /* foreach ($arrCitys as $citys) {
                $arrCitys[$citys->city] = $citys->city;
            } */
             
       
           // print form_dropdown('city',$arrCitys);
			$values='<option value="">--select--</option> ';
		  foreach($arrCitys as $val){
				 $values.='<option value="'.$val->id.'">'.$val->name.'</option>';
				}
				echo $values;
		exit; 
        }
		/* else {
            redirect('site');
        } */
  	
	}
	
	function msme_registration()
	{  
						
			$data["sesuserId"]=$this->session->userdata('sesuserId');
			$data["sesuserName"]=$this->session->userdata('sesuserName');
			$data["utype_id"]=$this->session->userdata('utype_id');	
			unset($_POST["check"]);
			$check_email["email_id"] = $this->input->post("owner_email");
			
			$this->form_validation->set_rules('enterprise_name', 'Enterprise Name','trim|required|max_length[50]|alpha');
			$this->form_validation->set_rules('constitution',' Legal Entity','trim|required');
			$this->form_validation->set_rules('owner_name','Director Name','trim|required|max_length[50]|alpha');		
			$this->form_validation->set_rules('owner_email','Owner email ID','trim|required|valid_email|is_unique[tbl_user.email_id]');
			$this->form_validation->set_rules('mob_no','Mobile No','trim|required|max_length[10]|numeric|is_unique[tbl_user.mobile_no]');
			$this->form_validation->set_rules('pan_firm', 'PAN of Firm','trim|required|max_length[10]|is_unique[tbl_msme.pan_firm]');
			$this->form_validation->set_rules('address1', 'Address Line 1','trim|required|max_length[500]');
			$this->form_validation->set_rules('state', 'State','trim|required');
			$this->form_validation->set_rules('city', 'City','trim|required');
			$this->form_validation->set_rules('pincode', 'Pincode','trim|required|max_length[6]');
			$this->form_validation->set_rules('latest_audited_turnover', 'Latest Audited Turnover','trim|required|max_length[11]');
			$this->form_validation->set_rules('password','Select Password','trim|required');
			$this->form_validation->set_rules('con_password','Confirm Password','trim|required|matches[password]');
				   
			if($this->form_validation->run())
			{
			
				$dat = $this->user_model->chekuser($check_email);
				if($dat)
				{
					$this->session->set_userdata('error_message',1);
					$this->session->set_flashdata('owner_email',$this->input->post("owner_email"));
					redirect("home/msme_register");
					
				}
				
				$option["name"] = $this->input->post("owner_name");
				$option["email_id"] = $this->input->post("owner_email");
				$option["password"] = $this->user_model->_prep_password($this->input->post("password"));
				$option["mobile_no"] = $this->input->post("mob_no");
				$option["utype_id"] = 1;
				$option["status"] = 0;
				$option["created_dtm"] =date('Y-m-d H:i:s');
				
				//Start email verification code
				$code = '0123456789abcdefghijklmnopqrst';
				$code_length = 15;
				$char_length = strlen($code);
				$random_str = '';
					for ($i = 0; $i < $code_length; $i++) {
						$random_str .= $code[rand(0, $char_length - 1)];
					}
				$email_verification_code = $random_str;
				//End email verification code
				$option["email_verification_code"] =$email_verification_code;
				
				$sdata1=$this->user_model->addUser($option);
				
				//otp start
				$data["sess_uid"]=$this->session->set_userdata('sess_uid',$sdata1);
				$characters = '0123456789';
				$length = 6;
				$charactersLength = strlen($characters);
				$randomString = '';
					for ($i = 0; $i < $length; $i++) {
						$randomString .= $characters[rand(0, $charactersLength - 1)];
					}
				$otp_no = $randomString;
				
				$otp["uid"]  = $sdata1;
				$otp["otp_no"]  = $otp_no;
				$otp["created_date"] =date('Y-m-d H:i:s');
				$otp_data =$this->user_model->generate_otp($otp);
				//end otp
				
				$opt["uid"]  = $sdata1;
				$opt["enterprise_name"] = $this->input->post("enterprise_name");
				$opt["constitution"] = $this->input->post("constitution");
				//$opt["category"] = $this->input->post("category");
				$opt["owner_name"] = $this->input->post("owner_name");
				$opt["owner_email"] = $this->input->post("owner_email");
				$opt["mob_no"] = $this->input->post("mob_no");
				$opt["pan_firm"] = $this->input->post("pan_firm");
				$opt["address1"] = $this->input->post("address1");
				$opt["address2"] = $this->input->post("address2");
				$opt["state"] = $this->input->post("state");
				$opt["city"] = $this->input->post("city");
				$opt["pincode"] = $this->input->post("pincode");
				$opt["landline_no"] = $this->input->post("landline");
				$opt["latest_audited_turnover"] = str_replace(",","",$this->input->post("latest_audited_turnover"));
				$opt["created_dtm"] =date('Y-m-d H:i:s');
				
				$sdata=$this->user_model->addMSME($opt);
				
				if($sdata)
				{
					/* $where_email["u.email_id"] =  $option["email_id"];
					$get_code=$this->user_model->get_verification_code($where_email);
					//print_r($get_code); exit;
					$ver_code = $get_code[0]->email_verification_code;
					$this->sendVerificatinEmail($option["email_id"],$ver_code,$this->input->post("password")); */
					
					$phone_no = $this->input->post("mob_no");
					//$text = $otp_no;
					$text    = rawurlencode('Dear '.$this->input->post("enterprise_name").', Welcome to '.base_url().'  !  '.$otp_no.' is the OTP to verify your mobile no. Verify now to activate your account.');			
					//$url = "http://sms.peakpoint.co/sendsmsv2.asp?user=datagrid&password=data%40%23123&phonenumber=".$phone_no."&sender=DATAGR&track=1&text=".$text;
					$url = $this->sms_url."&MobileNo=".$phone_no."&SenderID=ASSOCH&Message=".$text."&ServiceName=TEMPLATE_BASED";
				    $response = file_get_contents($url); 
					$flag=1;
					$this->sendOTP_Email($this->input->post("owner_email"),$this->input->post("enterprise_name"),$this->input->post("mob_no"),$flag);
					
					$data["email"]=$this->session->set_userdata('email',$option["email_id"]);
					$data["pass"]=$this->session->set_userdata('pass',$this->input->post("password"));
					$data["mob_no"]=$this->session->set_userdata('mob_no',$this->input->post("mob_no"));
					redirect("home/msme_otp",$data);
				}
			}
			else
			{
				$data["sesuserId"]=$this->session->userdata('sesuserId');
				$data["sesuserName"]=$this->session->userdata('sesuserName');
				$data["utype_id"]=$this->session->userdata('utype_id');	
				$data["state"] = $this->user_model->fetch_state();
				$this->template->load('main','msme_register',$data);
			}
		
	}
	
	function check_otp_channel()
	{
		$data["utype_id"]=$this->session->userdata('utype_id');	
		//print_r($data["utype_id"]);
		//print_r($_POST); exit;
			//$u_data["uid"] = $this->input->post("uid");
			$u_data["otp_no"] = $this->input->post("otp_no");
			$dat = $this->user_model->check_otp($u_data);
			//print_r($dat); exit;
			if(isset($dat) && ($_POST["otp_no"] == $dat[0]->otp_no))
			{
				/* $user_data["u.uid"] = $u_data["uid"];
				$user = $this->user_model->user_list($user_data);
				//print_r($user); exit;
				if($user)
				{
					$where["uid"] = $user[0]->uid;
					$other["status"] = 1;
					$update_status = $this->user_model->update_status($other,$where);
					$this->session->set_userdata(array('sesuserId'=>$user[0]->uid,'utype_id'=>$user[0]->utype_id,'email_id'=>$user[0]->email_id,'sesuserName'=>$user[0]->name));   //print_r($this->CI->session);
					redirect("home"); 				
					
				} */
				
				    $where_email["u.email_id"] =  $this->input->post("email_id");
					$get_code=$this->user_model->get_verification_code($where_email);
					//print_r($get_code); exit;
					$ver_code = $get_code[0]->email_verification_code;
					$send_email = $this->sendVerificatinEmail($this->input->post("email_id"),$ver_code,base64_decode($this->input->post("password")),$this->input->post("advisor_mob_no"));
					//if($send_email){
					$this->session->set_userdata('send_message',1);
					redirect("home/channel_partner_otp");
					//}
				
				
			}else{
				
				$this->session->set_userdata('error_message',1);
				$this->session->set_flashdata('otp_no',$this->input->post("otp_no"));
				redirect("home/channel_partner_otp");
			}
		//print_r($_POST); exit;
	}
	
	function check_otp_msme()
	{
		$data["utype_id"]=$this->session->userdata('utype_id');	
		//print_r($data["utype_id"]);
		//print_r($_POST); exit;
			//$u_data["uid"] = $this->input->post("uid");
			$u_data["otp_no"] = $this->input->post("otp_no");
			$dat = $this->user_model->check_otp($u_data);
			//print_r($dat); exit;
			if(isset($dat) && ($_POST["otp_no"] == $dat[0]->otp_no))
			{
				/* $user_data["u.uid"] = $u_data["uid"];
				$user = $this->user_model->user_list($user_data);
				//print_r($user); exit;
				if($user)
				{
					$where["uid"] = $user[0]->uid;
					$other["status"] = 1;
					$update_status = $this->user_model->update_status($other,$where);
					$this->session->set_userdata(array('sesuserId'=>$user[0]->uid,'utype_id'=>$user[0]->utype_id,'email_id'=>$user[0]->email_id,'sesuserName'=>$user[0]->name));   //print_r($this->CI->session);
					redirect("home"); 				
					
				} */
				
				    $where_email["u.email_id"] =  $this->input->post("email_id");
					$get_code=$this->user_model->get_verification_code($where_email);
					//print_r($get_code); exit;
					$ver_code = $get_code[0]->email_verification_code;
					$send_email = $this->sendVerificatinEmail($this->input->post("email_id"),$ver_code,base64_decode($this->input->post("password")),$this->input->post("mob_no"));
					//if($send_email){
					$this->session->set_userdata('send_message',1);
					redirect("home/msme_otp");
					//}
				
				
			}else{
				
				$this->session->set_userdata('error_message',1);
				$this->session->set_flashdata('otp_no',$this->input->post("otp_no"));
				redirect("home/msme_otp");
			}
		//print_r($_POST); exit;
	}
	
	function email_checking_partner()
	{
		$check_email["email_id"] = $this->input->post("advisor_email");
		$dat = $this->user_model->chekuser($check_email);
			if($dat)
			{
				echo "1";
				
			}else{
				echo "0";
			}
	}
	
	function mobile_checking_partner()
	{
		$check_mobile["mobile_no"] = $this->input->post("advisor_mob_no");
		$dat = $this->user_model->chekuser_mobile_no($check_mobile);
			if($dat)
			{
				echo "1";
				
			}else{
				echo "0";
			}
	}
	
	function pan_checking_partner()
	{
		$check_pan["advisor_pan"] = $this->input->post("advisor_pan");
		$dat = $this->user_model->chek_channel_pan($check_pan);
			if($dat)
			{
				echo "1";
				
			}else{
				echo "0";
			}
	}
	
	function pan_checking_msme()
	{
		$check_pan["pan_firm"] = $this->input->post("pan_firm");
		$dat = $this->user_model->chek_msme_pan($check_pan);
			if($dat)
			{
				echo "1";
				
			}else{
				echo "0";
			}
	}
	
	function pan_checking_loan_app()
	{
		$check_pan["pan_enterprise"] = $this->input->post("pan_enterprise");
		$dat = $this->user_model->chek_loan_app_pan($check_pan);
			if($dat)
			{
				echo "1";
				
			}else{
				echo "0";
			}
	}
	
	function mobile_checking_msme()
	{
		$check_mobile["mobile_no"] = $this->input->post("mob_no");
		$dat = $this->user_model->chekuser_mobile_no($check_mobile);
			if($dat)
			{
				echo "1";
				
			}else{
				echo "0";
			}
	}
	
	function email_checking_msme()
	{
		$check_email["email_id"] = $this->input->post("owner_email");
		$dat = $this->user_model->chekuser($check_email);
			if($dat)
			{
				echo "1";
				
			}else{
				echo "0";
			}
	}
	
	function channel_partner_registration()
	{  
			$data["sesuserId"]=$this->session->userdata('sesuserId');
			$data["sesuserName"]=$this->session->userdata('sesuserName');
			$data["utype_id"]=$this->session->userdata('utype_id');	
			unset($_POST["check"]);
			$check_email["email_id"] = $this->input->post("advisor_email");
			
			$this->form_validation->set_rules('advisor_name', 'Advisor Name','trim|required|max_length[50]|alpha');
			$this->form_validation->set_rules('advisor_mob_no','Advisor Mobile No','trim|required|max_length[10]|numeric|is_unique[tbl_user.mobile_no]');
			$this->form_validation->set_rules('advisor_email','Advisor Email Id','trim|required|valid_email|is_unique[tbl_user.email_id]');
			$this->form_validation->set_rules('advisor_pan', 'Advisor PAN','trim|required|max_length[10]|is_unique[tbl_channel_partner.advisor_pan]');
			$this->form_validation->set_rules('password','Select Password','trim|required');
			$this->form_validation->set_rules('con_password','Confirm Password','trim|required|matches[password]');
				   
			if($this->form_validation->run())
			{
			
				$dat = $this->user_model->chekuser($check_email);
				if($dat)
				{
					$this->session->set_userdata('error_message',1);
					$this->session->set_flashdata('advisor_email',$this->input->post("advisor_email"));
					redirect("home/channel_partner_register");
					
				}
				//exit;
				$option["name"] = $this->input->post("advisor_name");
				$option["email_id"] = $this->input->post("advisor_email");
				$option["password"] = $this->user_model->_prep_password($this->input->post("password"));
				$option["mobile_no"] = $this->input->post("advisor_mob_no");
				$option["utype_id"] = 2;
				$option["status"] = 0;
				$option["created_dtm"] =date('Y-m-d H:i:s');
				
				//Start email verification code
				$code = '0123456789abcdefghijklmnopqrst';
				$code_length = 15;
				$char_length = strlen($code);
				$random_str = '';
					for ($i = 0; $i < $code_length; $i++) {
						$random_str .= $code[rand(0, $char_length - 1)];
					}
				$email_verification_code = $random_str;
				//End email verification code
				$option["email_verification_code"] =$email_verification_code;			
				$sdata1=$this->user_model->addUser($option);
				
				
				//otp start
				$data["sess_uid"]=$this->session->set_userdata('sess_uid',$sdata1);
				$characters = '0123456789';
				$length = 6;
				$charactersLength = strlen($characters);
				$randomString = '';
					for ($i = 0; $i < $length; $i++) {
						$randomString .= $characters[rand(0, $charactersLength - 1)];
					}
				$otp_no = $randomString;
				
				$otp["uid"]  = $sdata1;
				$otp["otp_no"]  = $otp_no;
				$otp["created_date"] =date('Y-m-d H:i:s');
				$otp_data =$this->user_model->generate_otp($otp);
				//end otp
				
				$opt["uid"]  = $sdata1;
				$opt["advisor_name"] = $this->input->post("advisor_name");
				$opt["advisor_mob_no"] = $this->input->post("advisor_mob_no");
				$opt["advisor_email"] = $this->input->post("advisor_email");
				$opt["advisor_pan"] = $this->input->post("advisor_pan");
				$opt["status"] = 0;
				$opt["created_dtm"] =date('Y-m-d H:i:s');
				
				$sdata=$this->user_model->addPatner($opt);
				
				
				if($sdata)
				{
					/* $where_email["u.email_id"] =  $option["email_id"];
					$get_code=$this->user_model->get_verification_code($where_email);
					//print_r($get_code); exit;
					$ver_code = $get_code[0]->email_verification_code;
					$this->sendVerificatinEmail($option["email_id"],$ver_code,$this->input->post("password")); */
					
					$phone_no = $this->input->post("advisor_mob_no");
					//$text = $otp_no;
					
					
					$text    = rawurlencode('Dear '.$this->input->post("advisor_name").', Welcome to '.base_url().'  !  '.$otp_no.' is the OTP to verify your mobile no. Verify now to activate your account.');			
					//$url = "http://sms.peakpoint.co/sendsmsv2.asp?user=datagrid&password=data%40%23123&phonenumber=".$phone_no."&sender=DATAGR&track=1&text=".$text;
					 $url = $this->sms_url."&MobileNo=".$phone_no."&SenderID=ASSOCH&Message=".$text."&ServiceName=TEMPLATE_BASED";
					  $response = file_get_contents($url);  
					

					
					$this->sendOTP_Email($this->input->post("advisor_email"),$this->input->post("advisor_name"),$this->input->post("advisor_mob_no"));
					
					$data["email"]=$this->session->set_userdata('email',$option["email_id"]);
					$data["pass"]=$this->session->set_userdata('pass',$this->input->post("password"));
					$data["mob_no"]=$this->session->set_userdata('mob_no',$this->input->post("advisor_mob_no"));
					//print_r($data); exit;
					redirect("home/channel_partner_otp",$data);
				}
			}
			else
			{
				$this->template->load('main','channel_partner',$data);
			}
		
	}
	
	
	function verify($verificationText=NULL){  
		  $noRecords = $this->user_model->verifyEmailAddress($verificationText);  
		  if ($noRecords > 0){
		   $error = 'Email Verified Successfully! Now you can login <a href="'.base_url().'" >'.base_url().'</a>'; 
		  }else{
		   //$error = array( 'error' => "Sorry Unable to Verify Your Email!"); 
		   $error = 'Your account already is activated! you can login <a href="'.base_url().'" >'.base_url().'</a>'; 
		  }
		  $data['errormsg'] = $error; 
		  //print_r($data); //exit;
		  $this->load->view('mail_message.php', $data);   
		 }


		 /* function sendVerificationEmail(){  
		  $this->sendVerificatinEmail("msme@gmail.com","13nRGi7UDv4CkE7JHP1o");
		  $this->load->view('mail_message.php', $data);   
		 } */
		 
		 
	function sendVerificatinEmail($email,$verificationText,$password="",$phone_no=""){
  //echo $phone_no; exit;
		        $mail = new PHPMailer;
				$mail->isSMTP(); 
				$mail->Host = 'smtp.gmail.com';    // Specify main and backup SMTP servers
				$mail->SMTPAuth = true; // Enable SMTP authentication
				$mail->Username = 'assocham01@gmail.com'; // SMTP username
				$mail->Password = 'om123456';   
				$mail->SMTPSecure = 'ssl';         // Enable TLS encryption, `ssl` also accepted
				$mail->Port = 465;                 // TCP port to connect to
				$mail->FromName = 'MyLoanassocham';
				$mail->addAddress($email);
				//$mail->AddAddress($options["email_id"]);  			   // Add a recipient
				$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
				$mail->IsHTML(true);                                  // Set email format to HTML
				$mail->SMTPKeepAlive = true;   
				// Set email format to HTML
				
				$mail->Subject = 'Email Verification';
				$mail->Body    = '<table width="80%" style="border:1px solid #ff9800;padding:3px;">
				<tr>
					<td height="70" colspan="2"><img src="'.base_url().'assets/front/images/logo.png"/></td>
				</tr>
				<tr>
					<td style="background-color:#db0c1e;padding: 15px;color: #ffffff;" colspan="2">
						<p>Dear user,</p>
						<p style="display:block; margin:0; padding-top:10px;">Your Email Id : '.$email.'</p>
						<p style="display:block; margin:0; padding-top:10px;">Your Password : '.$password.'</p>
						<p style="display:block; margin:0; padding-top:10px;">Please click to active below link.</p>
						<a href="'.base_url().'home/verify/'.$verificationText.'" target="_blank">'.base_url().'home/verify/'.$verificationText.'</a>

						<p>Looking forward to more opportunities to be of service to you.<br/><br/><br/>
							<br/>Sincerely,
							<br/>MyLoanAssocham  Team
						</p>

					</td>
				</tr>
				<tr>
					<td height="30" align="left" style="font-size:11px;color:#666">Contact us at : 0011-00000000</td>
					<td align="right" style="font-size:11px;color:#666">Addrss : Office No. 124 , road ABC, Delhi</td>
				</tr>
			</table>';
				
				
				
				 $text    = urlencode('Your Email Id : '.$email."\n".'Your Password : '.$password."\n".'Please click to active below link.'."\n".base_url().'home/verify/'.$verificationText);
				
				//$text = $otp_no;
				 $url = $this->sms_url."&MobileNo=".$phone_no."&SenderID=ASSOCH&Message=".$text."&ServiceName=TEMPLATE_BASED";
				 $response = file_get_contents($url); 
		  
				  //echo $mail->Body;die();
				 $mail->Send();
		 
				
		  
		 }
		 
		function sendOTP_Email($email,$name="",$phone_no="",$flag=""){
  //echo $phone_no; exit;
		        $mail = new PHPMailer;
				$mail->isSMTP(); 
				$mail->Host = 'smtp.gmail.com';    // Specify main and backup SMTP servers
				$mail->SMTPAuth = true; // Enable SMTP authentication
				$mail->Username = 'assocham01@gmail.com'; // SMTP username
				$mail->Password = 'om123456';   
				$mail->SMTPSecure = 'ssl';         // Enable TLS encryption, `ssl` also accepted
				$mail->Port = 465;                 // TCP port to connect to
				$mail->FromName = 'MyLoanassocham';
				$mail->addAddress($email);
				//$mail->AddAddress($options["email_id"]);  			   // Add a recipient
				$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
				$mail->IsHTML(true);                                  // Set email format to HTML
				$mail->SMTPKeepAlive = true;   
				// Set email format to HTML
				if(isset($flag) && $flag!=""){
				$mail->Subject = 'OTP send';
				$mail->Body    = '<table width="80%" style="border:1px solid #ff9800;padding:3px;">
				<tr>
					<td height="70" colspan="2"><img src="'.base_url().'assets/front/images/logo.png"/></td>
				</tr>
				<tr>
					<td style="background-color:#db0c1e;padding: 15px;color: #ffffff;" colspan="2">
						<p>Dear '.$name.',</p>
						<p>Welcome to the myloan assocham Website. Your One Time Password (OTP) has been generated and sent on your registered mobile number '.$phone_no.'</p>
						<p>Please click below link to verify OTP.</p>
						<a href="'.base_url().'home/msme_otp" target="_blank">'.base_url().'home/msme_otp</a><br/>
						<p> Else, Mobile number would not be verified</p>
						<p>Looking forward to more opportunities to be of service to you.<br/><br/><br/>
							<br/>Sincerely,
							<br/>Assocham Finance
						</p>

					</td>
				</tr>
				<tr>
					<td height="30" align="left" style="font-size:11px;color:#666">Contact us at : 0011-00000000</td>
					<td align="right" style="font-size:11px;color:#666">Addrss : Office No. 124 , road ABC, Delhi</td>
				</tr>
			</table>';		
				}else{
					$mail->Subject = 'OTP send';
				$mail->Body    = '<table width="80%" style="border:1px solid #ff9800;padding:3px;">
				<tr>
					<td height="70" colspan="2"><img src="'.base_url().'assets/front/images/logo.png"/></td>
				</tr>
				<tr>
					<td style="background-color:#db0c1e;padding: 15px;color: #ffffff;" colspan="2">
						<p>Dear '.$name.',</p>
						<p>Welcome to the myloan assocham Website. Your One Time Password (OTP) has been generated and sent on your registered mobile number '.$phone_no.'</p>
						<p>Please click below link to verify OTP.</p>
						<a href="'.base_url().'home/channel_partner_otp" target="_blank">'.base_url().'home/channel_partner_otp</a><br/>
						<p>Else, Mobile number would not be verified</p>
						<p>Looking forward to more opportunities to be of service to you.<br/><br/><br/>
							<br/>Sincerely,
							<br/>Assocham Finance
						</p>

					</td>
				</tr>
				<tr>
					<td height="30" align="left" style="font-size:11px;color:#666">Contact us at : 0011-00000000</td>
					<td align="right" style="font-size:11px;color:#666">Addrss : Office No. 124 , road ABC, Delhi</td>
				</tr>
			</table>';		
					
				}
				  //echo $mail->Body;die();
				 $mail->Send();
		 }
	
	function resend_otp_partner($uid=null)
	{
		//echo $uid; print_r($_POST); exit;
			$u_data["uid"] = $uid;
			$dat = $this->user_model->user_list($u_data);
			//print_r($dat); exit;
			$characters = '0123456789';
			$length = 6;
			$charactersLength = strlen($characters);
			$randomString = '';
				for ($i = 0; $i < $length; $i++) {
					$randomString .= $characters[rand(0, $charactersLength - 1)];
				}
			$otp_no = $randomString;
			
			$where["uid"] = $uid;
			$other["otp_no"] = $otp_no;
			$otp_data_update = $this->user_model->update_otp($other,$where);
			//$otp_data =$this->user_model->generate_otp($otp);
		//print_r($_POST); exit;
			if($otp_data_update)
			{
				$phone_no = $dat[0]->mobile_no;
				$text = rawurlencode("Your OTP is ".$otp_no);
				$url = $this->sms_url."&MobileNo=".$phone_no."&SenderID=ASSOCH&Message=".$text."&ServiceName=TEMPLATE_BASED";
				$response = file_get_contents($url);
				$this->session->set_userdata('resend_message',1);
				$this->session->set_flashdata('otp_no',$this->input->post("otp_no"));
				redirect("home/channel_partner_otp");
			}
	}
	
	function resend_otp_msme($uid=null)
	{
		//echo $uid; print_r($_POST); exit;
			$u_data["uid"] = $uid;
			$dat = $this->user_model->user_list($u_data);
			//print_r($dat); exit;
			$characters = '0123456789';
			$length = 6;
			$charactersLength = strlen($characters);
			$randomString = '';
				for ($i = 0; $i < $length; $i++) {
					$randomString .= $characters[rand(0, $charactersLength - 1)];
				}
			$otp_no = $randomString;
			
			$where["uid"] = $uid;
			$other["otp_no"] = $otp_no;
			$otp_data_update = $this->user_model->update_otp($other,$where);
			//$otp_data =$this->user_model->generate_otp($otp);
		//print_r($_POST); exit;
			if($otp_data_update)
			{
				$phone_no = $dat[0]->mobile_no;
				$text = rawurlencode("Your OTP is ".$otp_no);
				$url = $this->sms_url."&MobileNo=".$phone_no."&SenderID=ASSOCH&Message=".$text."&ServiceName=TEMPLATE_BASED";
				$response = file_get_contents($url);
				$this->session->set_userdata('resend_message',1);
				$this->session->set_flashdata('otp_no',$this->input->post("otp_no"));
				redirect("home/msme_otp");
			}
	}
	
	function forgetpass()
        {
			$data["sesuserId"]=$this->session->userdata('sesuserId');
			$data["sesuserName"]=$this->session->userdata('sesuserName');
			$data["utype_id"]=$this->session->userdata('utype_id');	
           $this->template->load('main','forgetpass',$data);
                   //$this->load->view('main','forgetpass');
            
        }

		
		function insertfor_pass_record()
        {
           //echo 
           	//echo('kk');
			//print_r($_POST); exit;
			$data["sesuserId"]=$this->session->userdata('sesuserId');
			$data["sesuserName"]=$this->session->userdata('sesuserName');
			$data["utype_id"]=$this->session->userdata('utype_id');	
           
			$this->form_validation->set_rules('email_id1','Email Id','trim|required|valid_email');
			if($this->form_validation->run())
			{
                   $alphabet = "abcdefghijklmnopqrstuwxyzABCDEFGHIJKLMNOPQRSTUWXYZ0123456789";
                   $pass = array(); //remember to declare $pass as an array
                   $alphaLength = strlen($alphabet) - 1; //put the length -1 in cache
                   for ($i = 0; $i < 8; $i++) {
                   $n = rand(0, $alphaLength);
                   $pass[] = $alphabet[$n];
                         }
                   $pass_fog=(implode($pass));
                  
                  // $options_t["u.username"]=$_REQUEST['uname'];
				   $options_t["u.email_id"]=$_REQUEST['email_id1'];
                   $em = $this->user_model->chekuser_forgot_password($options_t); 
                  //print_r($em);die('kk');
                   if(empty($em)){
                                             
                       //echo"<script language=javascript> alert(\"OOPS! email is not registed try again with different email!\");window.history.back();</script>";
                       $this->session->set_userdata('notification',1);
					   $this->session->set_flashdata('email_id',$this->input->post("email_id1"));
						redirect('home/forgetpass');
                   }
                   else
				   {
                   
                   	$options["email_id"]=$_REQUEST['email_id1'];
					$email_id=$options["email_id"];
                	$options["password"]=$this->user_model->_prep_password($pass_fog);
					//$options["status"]=2;
					$opt_where["email_id"]=$_REQUEST['email_id1'];
					//$opt_where["username"]=$_REQUEST['uname'];
					$add_pass=$this->user_model->update_pass($options,$opt_where);
					
				   	//redirect('manage/login');
                  	$mail = new PHPMailer;
					$mail->isSMTP(); 
					$mail->Host = 'smtp.gmail.com';    // Specify main and backup SMTP servers
					$mail->SMTPAuth = true; // Enable SMTP authentication
					$mail->Username = 'assocham01@gmail.com'; // SMTP username
					$mail->Password = 'om123456';    
					$mail->SMTPSecure = 'ssl';         // Enable TLS encryption, `ssl` also accepted
					$mail->Port = 465;                 // TCP port to connect to
					$mail->FromName = 'MyLoanassocham';
					$mail->addAddress($email_id);
					//$mail->AddAddress($options["email_id"]);  			   // Add a recipient
					$mail->WordWrap = 50;                                 // Set word wrap to 50 characters
					$mail->IsHTML(true);                                  // Set email format to HTML
					$mail->SMTPKeepAlive = true;
		
					$mail->Subject = 'New Password Request';
							$mail->Body    = '<table width="80%" style="border:1px solid #ff9800;padding:3px;">
									<tr>
										<td height="70" colspan="2"><img src="'.base_url().'assets/front/images/logo.png"/></td>
									</tr>
									<tr>
										<td style="background-color:#db0c1e;padding: 15px;color: #ffffff;" colspan="2">
											<p>Dear '.$em[0]->name.',</p>
											
											<p style="display:block; margin:0; padding-top:10px;">In order to reset your password you must do the following 2 things:</p>
												<p style="display:block; margin:0; padding-top:10px;">1. <b>Using the attached Link, Email_Id and Password (below)</b> you must log in to the system and</p>
												<p style="display:block; margin:0; padding-top:10px;">2. You must change your password.</p>				
												<p style="display:block; margin:0; padding-top:10px;">Please click on the following link to access the system:<br />
												<a href="'.base_url().'" target="_blank">'.base_url().'</a></p> 
													
												
												<p style="display:block; margin:0; padding-top:10px;">Your Email is: '.$em[0]->email_id.'</p>
												<p style="display:block; margin:0; padding-top:10px;">Your new password is: '.$pass_fog.'</p>
											<p>Looking forward to more opportunities to be of service to you.<br/><br/><br/>
												<br/>Sincerely,
												<br/>MyLoanAssocham  Team
											</p>

										</td>
									</tr>
									<tr>
										<td height="30" align="left" style="font-size:11px;color:#666">Contact us at : 0011-00000000</td>
										<td align="right" style="font-size:11px;color:#666">Addrss : Office No. 124 , road ABC, Delhi</td>
									</tr>
								</table>';
					//echo $mail->Body;die();
					//print_r($mail);exit;
					if(!$mail->Send()) 
					{
						  // $this->session->set_flashdata('notification', 'Please check your email to find new password');
						  //echo $mail->Body;die();
							echo 'Message could not be sent.';
							echo 'Mailer Error: ' . $mail->ErrorInfo;
							exit;
					} 
					else{
					
						//echo $mail->Body;die();
						 $this->session->set_userdata('error_message',1);
						 $this->session->set_flashdata('email_id',$this->input->post("email_id1"));
						 //$this->session->set_flashdata('notification', 'Please check your email to find new password');
						redirect('home/forgetpass');
					}

					
				}
			}
			else
			{
				$this->template->load('main','forgetpass',$data);
			}
            
        }
		
	
		
} 

/* End of file main.php */
/* Location: ./system/application/controllers/home.php */
?>
