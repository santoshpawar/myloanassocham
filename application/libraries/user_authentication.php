<?php  if (!defined('BASEPATH')) exit('No direct script access allowed');
 
 class User_authentication {
 
	var $CI;
	
	function __construct() {
		$this->CI =& get_instance();
				
		$this->CI->load->database();
		$this->CI->load->helper('authentication_helper');
		$this->CI->load->model('user/user_model');
	}
	
	/**
	 * Attempt to login using the given condition
	 *
	 * Accepts an associative array as input, containing login condition
	 * Example: $this->auth->try_login(array('email'=>$email, 'password'=>dohash($password)))
	 *
	 * @access	public
	 * @param	array	login conditions
	 * @return	boolean
	 */	
	function try_login($condition = array()) {
             //print_r($condition);
		$user = $this->CI->user_model->getUsers($condition);
       // print_r($user);exit; 
		if(!$user){
			return FALSE;
		} else {
			$this->CI->session->set_userdata(array('sesuserId'=>$user[0]->uid,'utype_id'=>$user[0]->utype_id,'email_id'=>$user[0]->email_id,'sesuserName'=>$user[0]->name));   //print_r($this->CI->session);
			return TRUE;
		}
	}
	
	
	/**
	 * Attempt to login using session stored information
	 *
	 * Example: $this->auth->try_session_login()
	 *
	 * @access	public
	 * @return	boolean
	 */
	function try_session_login() {
		if ($this->CI->session->userdata('sesuserId'))
		 {
			$user = $this->CI->user_model->getUsers(array('u.uid'=>$this->CI->session->userdata('sesuserId')));
			if(!$user)
			{
				// Bad session - kill it
				$this->logout();
				return FALSE;
			} 
			else 
			{
				return TRUE;
			}
		} 
		else 
		{
			return FALSE;
		}
	}
	
	
	/**
	 * Logs a user out
	 *
	 * Example: $this->user_authentication->logout()
	 *
	 * @access	public
	 * @return	void
	 */
	 function user_logout() {
		$this->CI->session->unset_userdata(array('sesuserId'=>''));
		
	}
	
	
	/**
	 * Returns a field from the user's table for the logged in user
	 *
	 * Example: $this->authentication->getField('username')
	 *
	 * @access	public
	 * @param	string	field to return
	 * @return	string
	 */
	function getField($field = '') {
		$this->CI->db->select($field);
		$query = $this->CI->db->get_where(TBL_USERS, array('sesuserId'=>$this->CI->session->userdata('sesuserId')), 1, 0);
	  if ($query->num_rows() == 1) {
			$row = $query->row();
			return $row->$field;
		}
	}
	
	/**
	 * Returns the user's role
	 *
	 * Example: $this->authentication->getRole()
	 *
	 * @access	public
	 * @return	string
	 */
	function getRole() {
		$userRole = $this->CI->user_model->getRole($this->CI->session->userdata('sesuserId'));
		return $userRole;
	}
 }
 
 ?>