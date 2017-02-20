<?php

/**
 * User_Model
 * 
 * @package Users
 */

class Admin_Model extends CI_Model
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
	
    public function delete($id,$other=array())
	{
		if($other["tables"]=="TBL_MSME"){
		$table="tbl_msme";	
		$this->db->where('id', $id);
		}else if($other["tables"]=="TBL_CHANNEL_PARTNER"){
		$table="tbl_channel_partner";	
		$this->db->where('id', $id);
		}else if($other["tables"]=="TBL_ANALYST"){
		$table="tbl_analyst";	
		$this->db->where('id', $id);
		}else if($other["tables"]=="TBL_BANK_MASTER"){
		$table="tbl_bank_master";	
		$this->db->where('bank_id', $id);
		}else if($other["tables"]=="TBL_ADMIN"){
		$table="tbl_admin";	
		$this->db->where('id', $id);
		}else if($other["tables"]=="TBL_BANK_EMPLOYEE"){
		$table="tbl_bank_employee";	
		$this->db->where('bank_id', $id);	
		}else if($other["tables"]=="TBL_USER"){
		$table="tbl_user";	
		$this->db->where('uid', $id);	
		}
		return $this->db->delete($table); 
		
	}     
	function getUsers($options = array(),$other=array())
	{
		$fields=array();
		$fields[]='u.uid';
		$fields[]='u.utype_id';
		$fields[]='u.name';
		$fields[]='u.email_id';
		$fields[]='u.mobile_no';
		$fields[]='u.status';
		
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
		
	public function getRecords($tbl_name,$condition=FALSE,$select=FALSE,$order_by=FALSE,$start=FALSE,$limit=FALSE)
	{
		if($select!="")
		{$this->db->select($select);}
		
		if(count($condition)>0 && $condition!="")
		{ $condition=$condition; }
		else
		{$condition=array();}
		if(count($order_by)>0 && $order_by!="")
		{
			foreach($order_by as $key=>$val)
			{$this->db->order_by($key,$val);}
		}
		if($limit!="" || $start!="")
		{ $this->db->limit($limit,$start);}
		
		$rst=$this->db->get_where($tbl_name,$condition);
		//echo $this->db->last_query();die();
		return $rst->result_array();
	} 	
	function getMSMEArray($options = array(),$other=array())
	{
	

		$fields=array();
		$fields[]='ms.uid';
		
		
		$this->db->select(implode(',',$fields),false);
		$this->db->from(TBL_MSME.' AS ms');
		
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
		return $this->object_2_array($return->result());
	}
	function standard_array_compare($options = array(),$other=array())
	{
		if (count($op1) < count($op2)) 
		{
			return -1; // $op1 < $op2
		} 
		elseif (count($op1) > count($op2)) 
		{
			return 1; // $op1 > $op2
		}
		foreach ($op1 as $key => $val) 
		{
			if (!array_key_exists($key, $op2)) 
			{
				return null; // uncomparable
			}
			 elseif ($val < $op2[$key]) 
			 {
				return -1;
			 } 
			elseif ($val > $op2[$key]) 
			{
				return 1;
			}
		}
		return 0; // $op1 == $op2
	}
	function object_2_array($result)
	{
		$newar=array();
		foreach($result as $key=>$val)
		{
			array_push($newar,$val->uid);
		}
		return implode(",",$newar);
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
	
	function updatePassword($options = array(),$where=array())
	{
		// required values
		if(!$this->_required(
			array('uid'),
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
		
		$this->db->update(TBL_USER);
		return $this->db->affected_rows();
	}
	function getUserDetails($options = array(),$other=array())
	{
		//print_r($other);die("this");
	

		$fields=array();
		$fields[]='usr.*';
				
		$this->db->select(implode(',',$fields),false);
		if($other["tables"]=="TBL_MSME"){
		$this->db->from(TBL_MSME.' AS usr');
		}else if($other["tables"]=="TBL_CHANNEL_PARTNER"){
		$this->db->from(TBL_CHANNEL_PARTNER.' AS usr');
		}else if($other["tables"]=="TBL_ANALYST"){
		$this->db->from(TBL_ANALYST.' AS usr');
		}else if($other["tables"]=="TBL_BANK_MASTER"){
		$this->db->from(TBL_BANK_MASTER.' AS usr');
		}else if($other["tables"]=="TBL_ADMIN"){
		$this->db->from(TBL_ADMIN.' AS usr');	
		}else if($other["tables"]=="TBL_BANK_EMPLOYEE"){
		$this->db->from(TBL_BANK_EMPLOYEE.' AS usr');	
		}else if($other["tables"]=="TBL_ENTERPRISE_PROFILE"){
		$this->db->from(TBL_ENTERPRISE_PROFILE.' AS usr');	
		}else if($other["tables"]=="TBL_LOAN_APPLICATION"){
		$this->db->from(TBL_LOAN_APPLICATION.' AS usr');	
		}else if($other["tables"]=="TBL_BANK_FILTER"){
		$this->db->from(TBL_BANK_FILTER.' AS usr');	
		}
		
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
	
	function getbank($other=array())
	{
		//print_r($other);die("this");
	

		$fields=array();
		$fields[]='usr.*';
				
		$this->db->select(implode(',',$fields),false);
		
		 if($other["tables"]=="TBL_BANK_MASTER"){
		$this->db->from(TBL_BANK_MASTER.' AS usr');
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
	
	
	function getLoanDetails($options = array(),$other=array())
	{
		//print_r($other);die("this");
	

		$fields=array();
		$fields[]='usr.*';
				
		$this->db->select(implode(',',$fields),false);
		if($other["tables"]=="TBL_ENTERPRISE_PROFILE"){
		$this->db->from(TBL_ENTERPRISE_PROFILE.' AS usr');
		}else if($other["tables"]=="TBL_LOAN_REQUIREMENT"){
		$this->db->from(TBL_LOAN_REQUIREMENT.' AS usr');
		}else if($other["tables"]=="TBL_ENTERPRISE_BACKGROUND"){
		$this->db->from(TBL_ENTERPRISE_BACKGROUND.' AS usr');
		}else if($other["tables"]=="TBL_OWNER_DETAILS"){
		$this->db->from(TBL_OWNER_DETAILS.' AS usr');
		}else if($other["tables"]=="TBL_BANKING_CREDIT_FACILITIES"){
		$this->db->from(TBL_BANKING_CREDIT_FACILITIES.' AS usr');	
		}else if($other["tables"]=="TBL_UPLOAD_DOCUMENTS"){
		$this->db->from(TBL_UPLOAD_DOCUMENTS.' AS usr');	
		}else if($other["tables"]=="TBL_UPLOAD_DOCUMENTS_ADDMORE"){
		$this->db->from(TBL_UPLOAD_DOCUMENTS_ADDMORE.' AS usr');	
		}else if($other["tables"]=="TBL_UPLOAD_DOCUMENTS_OWNER"){
		$this->db->from(TBL_UPLOAD_DOCUMENTS_OWNER.' AS usr');	
		}
		else if($other["tables"]=="TBL_ANALYST_DOCUMENTS"){
		$this->db->from(TBL_ANALYST_DOCUMENTS.' AS usr');	
		}else if($other["tables"]=="TBL_ANALYST_DIRECTOR_DOCUMENTS"){
		$this->db->from(TBL_ANALYST_DIRECTOR_DOCUMENTS.' AS usr');	
		}
		else if($other["tables"]=="TBL_LOAN_APPLICATION"){
		$this->db->from(TBL_LOAN_APPLICATION.' AS usr');	
		}
		else if($other["tables"]=="TBL_BANK_APPLICATION"){
		$this->db->from(TBL_BANK_APPLICATION.' AS usr');	
		}
		else if($other["tables"]=="TBL_UPLOAD_DOCUMENTS_ADDITIONAL"){
		$this->db->from(TBL_UPLOAD_DOCUMENTS_ADDITIONAL.' AS usr');	
		}
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
	function updateUserDetails($table,$options=array(),$other=array())
	{
		// set values for updating
		foreach($options as $key=>$val)
		{
			$this->db->set($key,$val);
		}
		
		// set where clause for updating
		foreach($other as $key=>$val)
		{
			$this->db->where($key,$val);
		}
		
		$this->db->update($table);
		
		//echo $this->db->last_query(); die();
		return $this->db->affected_rows();
	}
	
	public function delete_details($tables,$id)
	 { 
		
	  $tables = array($tables);
	 
	  if($tables[0]=="tbl_upload_documents_addmore"){
		  //echo"first";
	  $this->db->where('upload_id',$id);
	  }else if($tables[0]=="tbl_upload_documents_additional"){
		  //echo"first";
	  $this->db->where('upload_ids',$id);
	  }else if($tables[0]=="tbl_upload_documents_owner"){
		  //echo"first";
	  $this->db->where('upload_id',$id);
	  }
	  
	  else{
		   $this->db->where('application_id',$id);
		   //echo"second";
	  }
	  
	  //echo $this->db->last_query(); die();
	  return $this->db->delete($tables);
	  //echo $this->db->last_query(); die();
	 }
	 
	 function getMessage_total($options = array(),$other=array())
	{
		//print_r($options);die("this");
	

		$fields=array();
		$fields[]='msg_inbox.*';
		$fields[]='msg.msg_id';
		$fields[]='msg.status';
		$fields[]='msg_inbox.is_read';
		
		$this->db->select(implode(',',$fields),false);
		$this->db->from(TBL_MESSAGE_INBOX.' AS msg_inbox');
		$this->db->join(TBL_MESSAGE.' As msg','msg.msg_id = msg_inbox.message_id','left');
		$this->db->join(TBL_LOAN_APPLICATION.' As loan','loan.application_id = msg_inbox.application_id','left');
		if($this->session->userdata('utype_id')==4){
		$this->db->join(TBL_ANALYST_DOCUMENTS.' As analyst', 'analyst.application_id=loan.application_id','INNER');
		}
		
		if(isset($other["list"]))
		{
			$this->db->where($other["list"]);
			
		}
		foreach($options as $key=>$val)
		{
			$this->db->where($key,$val);
		}
		$this->db->where('msg_inbox.is_read','0');		
		// sort
		if(isset($other['sortBy']) && isset($other['sortDirection']))
			$this->db->order_by($other['sortBy'], $other['sortDirection'],false);
		$this->db->group_by('msg.msg_id');
		//Get contents
		$return = $this->db->get();
		$count = $return->num_rows();
		//echo $this->db->last_query();die();
		//Return all
		return $count;
	}
		 
	
		  


   
	
}

?>