<?php

/**
 * User_Model
 * 
 * @package Users
 */

class Loan_application_model extends CI_Model
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
         
	function addEnterprise_Details($options = array())
	{	
		$this->db->insert(TBL_ENTERPRISE_PROFILE,$options);
		//echo $this->db->last_query(); die();
		return $this->db->insert_id();	
	}
	function add_message($options = array())
	{	
		$this->db->insert(TBL_MESSAGE,$options);
		//echo $this->db->last_query(); die();
		return $this->db->insert_id();	
	}
	function addCompose_message($options = array())
	{	
		$this->db->insert(TBL_MESSAGE_INBOX,$options);
		//echo $this->db->last_query(); die();
		return $this->db->insert_id();	
	}	
	
	function getMessage($table,$options=array(),$other=array())
	{
		$fields=array();
		$fields[]='t.*';
		
		$this->db->select(implode(',',$fields),false);
		$this->db->from($table.' AS t');
		$this->db->join(TBL_MESSAGE.' As msg','msg.msg_id = t.message_id','INNER');
		
		foreach($options as $key=>$val)
		{
			$this->db->where($key,$val);
		}
		if(isset($other["list"]))
		{
			$this->db->where($other["list"]);
			
		}
		if(isset($other["post_to"]))
		{
			//echo "rj";exit;
			$this->db->order_by('t.massage_sent_time','DESC');
		}
		if(isset($other["limit"]))
		{
			//echo "rj";exit;
			$this->db->limit(1);
		}	
		// sort
		if(isset($other['sortBy']) && isset($other['sortDirection']))
			$this->db->order_by($other['sortBy'], $other['sortDirection'],false);
		$this->db->order_by('t.id','ASC');
		//Get contents
		$return = $this->db->get();
		//echo $this->db->last_query();die();
		//Return all
		return $return->result();
	}
	
	function addBank_status($options = array())
	{	
		$this->db->insert(TBL_BANK_APPLICATION,$options);
		//echo $this->db->last_query(); die();
		return $this->db->insert_id();	
	}
	function addBank_filter($options = array())
	{	
		$this->db->insert(TBL_BANK_FILTER,$options);
		//echo $this->db->last_query(); die();
		return $this->db->insert_id();	
	}
	function updateEnterprise_Details($options=array(),$other=array())
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
			
			$this->db->update(TBL_ENTERPRISE_PROFILE);
			//echo $this->db->last_query(); die();
			return $this->db->affected_rows();
		}
	
	function addLoan_requirement($options = array())
	{	
		$this->db->insert(TBL_LOAN_REQUIREMENT,$options);
		//echo $this->db->last_query(); die();
		return $this->db->insert_id();	
	} 
	
	function addLoan_application($options = array())
	{	
		$this->db->insert(TBL_LOAN_APPLICATION,$options);
		//echo $this->db->last_query(); die();
		return $this->db->insert_id();	
	}
	
	function addEnterprise_background($options = array())
	{	
		$this->db->insert(TBL_ENTERPRISE_BACKGROUND,$options);
		//echo $this->db->last_query(); die();
		return $this->db->insert_id();	
	}
	
	function addOwner_details($options = array())
	{	
	//print_r($options); exit;
		 foreach($options as $key=>$val)
			{
				$options[$key] = $val;
				$this->db->insert(TBL_OWNER_DETAILS,$options);
				return $this->db->insert_id();	
			}
	
		
	}
	function addBusiness_details($options = array())
	{	
		$this->db->insert(TBL_BUSINESS_DETAILS,$options);
		//echo $this->db->last_query(); die();
		return $this->db->insert_id();	
	}
	
	function addSecurity_details($options = array())
	{	
		$this->db->insert(TBL_SECURITY_DETAILS,$options);
		//echo $this->db->last_query(); die();
		return $this->db->insert_id();	
	}
	
	function addupload_doc($options = array())
	{	
		$this->db->insert(TBL_UPLOAD_DOCUMENTS,$options);
		//echo $this->db->last_query(); die();
		return $this->db->insert_id();	
	}
	function updateupload($options = array(),$where=array(),$table)
	{
		// required values
		if($table=="TBL_UPLOAD_DOCUMENTS"){
		if(!$this->_required(
			array('application_id'),
			$where)
		) return false;
		}else{
		if(!$this->_required(
			array('upload_id'),
			$where)
		) return false;	
		}
		// set values for updating
		foreach($options as $key=>$val)
		{
			$this->db->set($key,$val);
		}
		
		// set where clause for updating
		foreach($where as $key=>$val)
		{
			$this->db->where($key,$val);
		}
		if($table=="TBL_UPLOAD_DOCUMENTS"){
		$this->db->update(TBL_UPLOAD_DOCUMENTS);
		}else{
		$this->db->update(TBL_UPLOAD_DOCUMENTS_ADDMORE);	
		}
		//echo $this->db->last_query(); die();
		return $this->db->affected_rows();
	}
	function updateupload_addmore($options = array(),$where=array(),$table)
	{
		// required values
		
		if(!$this->_required(
			array('upload_id'),
			$where)
		) return false;	
		
		// set values for updating
		foreach($options as $key=>$val)
		{
			$this->db->set($key,$val);
		}
		
		// set where clause for updating
		foreach($where as $key=>$val)
		{
			$this->db->where($key,$val);
		}
		
		$this->db->update(TBL_UPLOAD_DOCUMENTS_ADDMORE);	
		
		//echo $this->db->last_query(); die();
		return $this->db->affected_rows();
	}
	
	function update_analyst_document($options = array(),$where=array(),$table)
	{
		// required values
		
		if(!$this->_required(
			array('application_id'),
			$where)
		) return false;	
		
		// set values for updating
		foreach($options as $key=>$val)
		{
			$this->db->set($key,$val);
		}
		
		// set where clause for updating
		foreach($where as $key=>$val)
		{
			$this->db->where($key,$val);
		}
		
		$this->db->update(TBL_ANALYST_DOCUMENTS);	
		
		//echo $this->db->last_query(); die();
		return $this->db->affected_rows();
	}
	
	function getTblRecords($table)
	{
		$fields=array();
		$fields[]='t.*';
		
		$this->db->select(implode(',',$fields),false);
		$this->db->from($table.' AS t');
		
		// sort
		if(isset($other['sortBy']) && isset($other['sortDirection']))
			$this->db->order_by($other['sortBy'], $other['sortDirection'],false);
		
		//Get contents
		$return = $this->db->get();
		//echo $this->db->last_query();die();
		//Return all
		return $return->result();
	}
	function update_analyst_director_document($options = array(),$where=array(),$table)
	{
		// required values
		
		if(!$this->_required(
			array('application_id'),
			$where)
		) return false;	
		
		// set values for updating
		foreach($options as $key=>$val)
		{
			$this->db->set($key,$val);
		}
		
		// set where clause for updating
		foreach($where as $key=>$val)
		{
			$this->db->where($key,$val);
		}
		
		$this->db->update(TBL_ANALYST_DIRECTOR_DOCUMENTS);	
		
		//echo $this->db->last_query(); die();
		return $this->db->affected_rows();
	}
	
	function chekuser($options = array(),$other=array())
        {
            $fields=array();
            $fields[]='e.owner_email';
            $this->db->from(TBL_ENTERPRISE_PROFILE.' AS u');
            foreach($options as $key=>$val)
			{
				if($key=="e.owner_email")
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
	
}

?>