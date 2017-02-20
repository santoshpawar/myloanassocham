<?php
/**
 * User_Model
 * 
 * @package Users
 */

class Analyst_Model extends CI_Model
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
	
	function addAnalyst($options=array())
	{
       $this->db->insert(TBL_ANALYST, $options);
	   $id=$this->db->insert_id();
		return $id;
	}
	
	function getGridRecord($options = array(),$other=array())
	{
		//print_r($options); die();

		$fields=array();
		$fields[]='t.id';
		$fields[]='t.analyst_name';
		$fields[]='t.analyst_email';
		$this->db->select(implode(',',$fields),false);
		$this->db->from(TBL_ANALYST.' AS t');
				
		foreach($options as $key=>$val)
		{
			$this->db->where($key,$val);
		}
		
		
		// sort
		if(isset($other['sortBy']) && isset($other['sortDirection']))
			$this->db->order_by($other['sortBy'], $other['sortDirection'],false);
		// limit / offset
		if(isset($other['limit']) && isset($other['offset']))
			$this->db->limit($other['limit'], $other['offset']);
		else if(isset($other['limit']))
			$this->db->limit($other['limit']);
		
		
		$this->flexigrid->build_query();
		$return=array();
		$return['record_count']=0;
		//Get contents
		$return['records'] = $this->db->get();
		
		//echo $this->db->last_query(); die();
		
		//Build count query
		$fields=array();
		$fields[]='t.analyst_name';
		$fields[]='t.analyst_email';		
		$this->db->select(implode(',',$fields),false);
		$this->db->from(TBL_ANALYST.' AS t');
				
		foreach($options as $key=>$val)
		{
			$this->db->where($key,$val);
		}
			
		// sort
		if(isset($other['sortBy']) && isset($other['sortDirection']))
			$this->db->order_by($other['sortBy'], $other['sortDirection'],false);
		
				
		$this->flexigrid->build_query(false);
		$record_count = $this->db->get();
		
		//echo $this->db->last_query(); die();
		//Get Record Count
		$return['record_count'] =$record_count->num_rows();
	
		//Return all
		return $return;
	}
	
	function updateAnalyst($options = array(),$where=array())
	{
		// required values
		if(!$this->_required(
			array('id'),
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
		
		$this->db->update(TBL_ANALYST);
		//echo $this->db->last_query(); die();
		return $this->db->affected_rows();
	}
	
	function getAnalyst($options = array(),$other=array())
	{
		$fields=array();
		$fields[]='t.*';
		
		$this->db->select(implode(',',$fields),false);
		$this->db->from(TBL_ANALYST.' AS t');
		
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
    function updateUser($options = array(),$where=array())
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
		//echo $this->db->last_query(); die();
		return $this->db->affected_rows();
	}    
   	public function delete($id)
	{
		$this->db->where('id', $id);
		
		return $this->db->delete(TBL_ANALYST); 
		
	}
	
	

}

?>