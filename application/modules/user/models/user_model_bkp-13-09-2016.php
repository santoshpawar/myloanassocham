<?php

/**
 * User_Model
 * 
 * @package Users
 */

class User_Model extends CI_Model
{
	
	/** Utility Methods **/
	function _required($required, $data)
	{
		foreach($required as $field)
			if(!isset($data[$field])) return false;
			
		return true;
	}
	
	function _default($defaults, $options)
	{
		return array_merge($defaults, $options);
	}
	
	function _prep_password($password)
	{
    	 return sha1($password.$this->config->item('encryption_key'));
	}
                   
	
	function user_list($options = array(),$other=array())
	{
		$fields=array();
		$fields[]='u.uid';
		$fields[]='u.utype_id';
		$fields[]='u.name';
		$fields[]='u.email_id';
		$fields[]='u.status';
		$fields[]='u.mobile_no';
		
		$this->db->select(implode(',',$fields),false);
		$this->db->from(TBL_USER.' AS u');
		foreach($options as $key=>$val)
		{
			
				$this->db->where($key,$val);
		}
       
		// sort
		if(isset($other['sortBy']) && isset($other['sortDirection']))
			$this->db->order_by($other['sortBy'], $other['sortDirection'],false);
		
		//Get contents
		$return = $this->db->get();
		//echo $this->db->last_query();die();
		//Return all
		return $return->result();
	}
	
	function getUsers($options = array(),$other=array())
	{
		$fields=array();
		$fields[]='u.uid';
		$fields[]='u.utype_id';
		$fields[]='u.name';
		$fields[]='u.email_id';
		$fields[]='u.status';
		$fields[]='u.mobile_no';
		
		$this->db->select(implode(',',$fields),false);
		$this->db->from(TBL_USER.' AS u');
		foreach($options as $key=>$val)
		{
			if($key=="u.password")
				$this->db->where($key,$this->_prep_password($val));
			else
				$this->db->where($key,$val);
		}
       
		// sort
		$this->db->where("u.status","1");
		if(isset($other['sortBy']) && isset($other['sortDirection']))
			$this->db->order_by($other['sortBy'], $other['sortDirection'],false);
		
		//Get contents
		$return = $this->db->get();
		//echo $this->db->last_query();die();
		//Return all
		return $return->result();
	}
	
        function chekuser($options = array(),$other=array())
        {
            $fields=array();
            $fields[]='u.email_id';
            $this->db->from(TBL_USER.' AS u');
            foreach($options as $key=>$val)
		{
			if($key=="u.email_id")
				$this->db->where($key,$val);
			else
				$this->db->where($key,$val);
                        if(isset($other['sortBy']) && isset($other['sortDirection']))
			$this->db->order_by($other['sortBy'], $other['sortDirection'],false);
		
		//Get contents
		$return = $this->db->get();
		//echo $this->db->last_query();die();
		//Return all
		return $return->result();
		}
            
        }
		
		function chekuser_mobile_no($options = array(),$other=array())
        {
            $fields=array();
            $fields[]='u.mobile_no';
            $this->db->from(TBL_USER.' AS u');
            foreach($options as $key=>$val)
		{
			if($key=="u.mobile_no")
				$this->db->where($key,$val);
			else
				$this->db->where($key,$val);
                        if(isset($other['sortBy']) && isset($other['sortDirection']))
			$this->db->order_by($other['sortBy'], $other['sortDirection'],false);
		
		//Get contents
		$return = $this->db->get();
		//echo $this->db->last_query();die();
		//Return all
		return $return->result();
		}
            
        }
		
		function addMSME($options = array())
		{
				
			$this->db->insert(TBL_MSME, $options);
			
			//echo $this->db->last_query();die();
			$id=$this->db->insert_id();
			 return $id;
		}
	
		function addUser($options = array())
	{
			
		$this->db->insert(TBL_USER, $options);
		//echo $this->db->last_query();die();
		return $this->db->insert_id();
	}
        
	function fetch_state($options = array())
	{
		$fields=array();
		$fields[]='s.id';
		$fields[]='s.name';
		
		
		$this->db->select(implode(',',$fields),false);
		$this->db->from(TBL_STATES.' AS s');
		foreach($options as $key=>$val)
		{
				$this->db->where($key,$val);
		}
       
		// sort
		if(isset($other['sortBy']) && isset($other['sortDirection']))
			$this->db->order_by($other['sortBy'], $other['sortDirection'],false);
		
		//Get contents
		$return = $this->db->get();
		//echo $this->db->last_query();die();
		//Return all
		return $return->result();
	}
    
	function fetch_city_name($options = array())
	{
		$fields=array();
		$fields[]='c.id';
		$fields[]='c.name';
		
		
		$this->db->select(implode(',',$fields),false);
		$this->db->from(TBL_CITIES.' AS c');
		foreach($options as $key=>$val)
		{
				$this->db->where($key,$val);
		}
       
		// sort
		if(isset($other['sortBy']) && isset($other['sortDirection']))
			$this->db->order_by($other['sortBy'], $other['sortDirection'],false);
		
		//Get contents
		$return = $this->db->get();
		//echo $this->db->last_query();die();
		//Return all
		return $return->result();
	}
	
	function fetch_city($state) {
	
        $query = $this->db->query("SELECT id,name FROM tbl_cities WHERE state_id = '{$state}'");
	
         //echo $this->db->last_query(); exit;
        if ($query->num_rows > 0) {
            return $query->result();
        }
    }
        
	function chekuser_forgot_password($options = array(),$other=array())
	{
		$fields=array();
		$fields[]='u.*';
		$this->db->select(implode(',',$fields),false);
		$this->db->from(TBL_USER.' AS u');
		foreach($options as $key=>$val)
		{
			if($key=="u.email_id")
				//$this->db->where($key,$this->_prep_password($val));//(earlier used but having problem email converted to password format)
				$this->db->where($key,$val);
			else
				$this->db->where($key,$val);
						if(isset($other['sortBy']) && isset($other['sortDirection']))
			$this->db->order_by($other['sortBy'], $other['sortDirection'],false);
		}
	
		//Get contents
		$return = $this->db->get();
		//echo $this->db->last_query();die();
		//Return all
		return $return->result();
	}
	function generate_otp($options = array())
		{
				
			$this->db->insert(TBL_OTP_HISTORY, $options);
			//echo $this->db->last_query();die();
			return $this->db->insert_id();
		}
		
		function check_otp($options = array(),$other=array())
        {
            $fields=array();
            $fields[]='c.uid';
            $this->db->from(TBL_OTP_HISTORY.' AS c');
            foreach($options as $key=>$val)
		{
			if($key=="c.uid")
				$this->db->where($key,$val);
			else
				$this->db->where($key,$val);
                        if(isset($other['sortBy']) && isset($other['sortDirection']))
			$this->db->order_by($other['sortBy'], $other['sortDirection'],false);
		
		//Get contents
		$return = $this->db->get();
		//echo $this->db->last_query();die();
		//Return all
		return $return->result();
		}
            
        }
		
		function update_otp($options=array(),$other=array())
		{
			   // print_r($options);
			foreach($options as $key=>$val)
			{
				$this->db->set($key,$val);
			}
			
			foreach($other as $key=>$val)
			{
				$this->db->where($key,$val);
			}
			
			$this->db->update(TBL_OTP_HISTORY);
			//echo $this->db->last_query(); die();
			return $this->db->affected_rows();
		}
		function update_status($options=array(),$other=array())
		{
			   // print_r($options);
			foreach($options as $key=>$val)
			{
				$this->db->set($key,$val);
			}
			
			foreach($other as $key=>$val)
			{
				$this->db->where($key,$val);
			}
			
			$this->db->update(TBL_USER);
			//echo $this->db->last_query(); die();
			return $this->db->affected_rows();
		}
	// add notification
	
	function addPatner($options = array())
	{
			
		$this->db->insert(TBL_CHANNEL_PARTNER, $options);
		
		//echo $this->db->last_query();die();
		 $id=$this->db->insert_id();
		 return $id;
	}
	
	function Login($options = array())
	{
		// required values
		if(!$this->_required(
			array('email_id', 'userPassword'),
			$options)
		) return false;
		$userName=$options['email_id'];
		$userPassword=$options['userPassword'];
		$user = $this->GetUsers(array('email_id' => $userName, 'userPassword' => $userPassword));
		if(!$user) return false;
		return true;
	}
        
        function update_pass($options=array(),$other=array())
	{
           // print_r($options);
		foreach($options as $key=>$val)
		{
			$this->db->set($key,$val);
		}
		
		foreach($other as $key=>$val)
		{
			$this->db->where($key,$val);
		}
		
		$this->db->update(TBL_USER);
		//echo $this->db->last_query(); die();
		return $this->db->affected_rows();
	}
	
   
	
}

?>