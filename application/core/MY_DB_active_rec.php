<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the DB_active_rec class */
require_once(BASEPATH.'database/DB_active_rec'.EXT);

class MY_DB_active_record extends CI_DB_active_record 
{
	var $ar_findinset			= array();
	var $ar_wherein				= array();
	
	/**
	 * find_in_set
	 *
	 * Generates a WHERE field IN ('item', 'item') SQL query joined with
	 * AND if appropriate
	 *
	 * @param	string	The field to search
	 * @param	array	The values searched on
	 * @return	object
	 */
	public function find_in_set($key = NULL, $values = NULL)
	{
		return $this->_find_in_set($key, $values);
	}
	
	// --------------------------------------------------------------------
	
	
	/**
	 * _find_in_set
	 *
	 * Called by find_in_set
	 *
	 * @param	string	The field to search
	 * @param	array	The values searched on
	 * @param	boolean	If the statement would be IN or NOT IN
	 * @param	string
	 * @return	object
	 */
	protected function _find_in_set($key = NULL, $values = NULL, $not = FALSE, $type = 'AND ')
	{
		if ($key === NULL OR $values === NULL)
		{
			return;
		}

		if ( ! is_array($values))
		{
			$values = array($values);
		}

		$not = ($not) ? ' NOT' : '';

		foreach ($values as $value)
		{
			$this->ar_findinset[] = $value;
		}

		$prefix = (count($this->ar_where) == 0) ? '' : $type;

		$ar_findinset = $prefix . $not . " find_in_set (".$key ."," . implode(", ", $this->ar_findinset) . ") ";
		//die($ar_findinset);

		$this->ar_where[] = $ar_findinset;
		if ($this->ar_caching === TRUE)
		{
			$this->ar_cache_where[] = $ar_findinset;
			$this->ar_cache_exists[] = 'where';
		}

		// reset the array for multiple calls
		$this->ar_findinset = array();
		return $this;
	}

	// --------------------------------------------------------------------	
	
	
	
	// --------------------------------------------------------------------

	/**
	 * Sets the ORDER BY without grave accent value
	 *
	 * @param	string
	 * @param	string	direction: asc or desc
	 * @return	object
	 */
	public function order_by_without_accent($orderby, $direction = '')
	{
		if (strtolower($direction) == 'random')
		{
			$orderby = ''; // Random results want or don't need a field name
			$direction = $this->_random_keyword;
		}
		elseif (trim($direction) != '')
		{
			$direction = (in_array(strtoupper(trim($direction)), array('ASC', 'DESC'), TRUE)) ? ' '.$direction : ' ASC';
		}
		
		$orderby_statement = $orderby.$direction;

		$this->ar_orderby[] = $orderby_statement;
		if ($this->ar_caching === TRUE)
		{
			$this->ar_cache_orderby[] = $orderby_statement;
			$this->ar_cache_exists[] = 'orderby';
		}

		return $this;
	}

	// --------------------------------------------------------------------
	
	
	/**
	 * Where_in_without_grave_ascent
	 *
	 * Generates a WHERE field IN ('item', 'item') SQL query joined with
	 * AND if appropriate
	 *
	 * @param	string	The field to search
	 * @param	array	The values searched on
	 * @return	object
	 */
	public function where_in_without_grave_ascent($key = NULL, $values = NULL)
	{
		return $this->_where_in_without_grave_ascent($key, $values);
	}
	
	
	// --------------------------------------------------------------------

	/**
	 * Where_in
	 *
	 * Called by where_in, where_in_or, where_not_in, where_not_in_or
	 *
	 * @param	string	The field to search
	 * @param	array	The values searched on
	 * @param	boolean	If the statement would be IN or NOT IN
	 * @param	string
	 * @return	object
	 */
	protected function _where_in_without_grave_ascent($key = NULL, $values = NULL, $not = FALSE, $type = 'AND ')
	{
		if ($key === NULL OR $values === NULL)
		{
			return;
		}

		if ( ! is_array($values))
		{
			$values = array($values);
		}

		$not = ($not) ? ' NOT' : '';

		foreach ($values as $value)
		{
			$this->ar_wherein[] = $value;
		}

		$prefix = (count($this->ar_where) == 0) ? '' : $type;

		$where_in = $prefix . $this->_protect_identifiers($key) . $not . " IN (" . implode(", ", $this->ar_wherein) . ") ";

		$this->ar_where[] = $where_in;
		if ($this->ar_caching === TRUE)
		{
			$this->ar_cache_where[] = $where_in;
			$this->ar_cache_exists[] = 'where';
		}

		// reset the array for multiple calls
		$this->ar_wherein = array();
		return $this;
	}

	// --------------------------------------------------------------------
	
	// --------------------------------------------------------------------

	/**
	 * Where
	 *
	 * Generates the WHERE without ascent portion of the query. Separates
	 * multiple calls with AND
	 *
	 * @param	mixed
	 * @param	mixed
	 * @return	object
	 */
	public function where_without_ascent($key, $value = NULL, $escape = TRUE)
	{
		return $this->_where_without_ascent($key, $value, 'AND ', $escape);
	}

	// --------------------------------------------------------------------
	
	
	// --------------------------------------------------------------------

	/**
	 * Where
	 *
	 * Called by where() or or_where()
	 *
	 * @param	mixed
	 * @param	mixed
	 * @param	string
	 * @return	object
	 */
	protected function _where_without_ascent($key, $value = NULL, $type = 'AND ', $escape = NULL)
	{
		if ( ! is_array($key))
		{
			$key = array($key => $value);
		}

		// If the escape value was not set will will base it on the global setting
		

		foreach ($key as $k => $v)
		{
			$prefix = (count($this->ar_where) == 0 AND count($this->ar_cache_where) == 0) ? '' : $type;

			if (is_null($v) && ! $this->_has_operator($k))
			{
				// value appears not to have been set, assign the test to IS NULL
				$k .= ' IS NULL';
			}

			if ( ! is_null($v))
			{
				if ($escape === TRUE)
				{
					$k = $this->_protect_identifiers($k, FALSE);

					$v = ' '.$v;
				}
				
				if ( ! $this->_has_operator($k))
				{
					$k .= ' = ';
				}
			}
			else
			{
				$k = $this->_protect_identifiers($k, FALSE);
			}

			$this->ar_where[] = $prefix.$k.$v;

			if ($this->ar_caching === TRUE)
			{
				$this->ar_cache_where[] = $prefix.$k.$v;
				$this->ar_cache_exists[] = 'where';
			}

		}
		return $this;
	}

	// --------------------------------------------------------------------
	
	/**
	 * Select Greatest
	 *
	 * Generates a SELECT GREATEST(field) portion of a query
	 *
	 * @access	public
	 * @param	string	the field
	 * @param	string	an alias
	 * @return	object
	 */
	function select_greatest($select = '', $alias = '')
	{
		return $this->_max_min_avg_sum_greatest($select, $alias, 'GREATEST');
	}

	// --------------------------------------------------------------------
	
	/**
	 * Processing Function for the five functions :
	 *
	 *	select_max()
	 *	select_min()
	 *	select_avg()
	 *  select_sum()
	 *  select_greatest()
	 *
	 * @access	public
	 * @param	string	the field
	 * @param	string	an alias
	 * @return	object
	 */
	function _max_min_avg_sum_greatest($select = '', $alias = '', $type = 'MAX')
	{
		if ( ! is_string($select) OR $select == '')
		{
			$this->display_error('db_invalid_query');
		}

		$type = strtoupper($type);

		if ( ! in_array($type, array('MAX', 'MIN', 'AVG', 'SUM','GREATEST')))
		{
			show_error('Invalid function type: '.$type);
		}

		if ($alias == '')
		{
			$alias = $this->_create_alias_from_table(trim($select));
		}

		$sql = $type.'('.$this->_protect_identifiers(trim($select)).') AS greatest';

		$this->ar_select[] = $sql;

		if ($this->ar_caching === TRUE)
		{
			$this->ar_cache_select[] = $sql;
			$this->ar_cache_exists[] = 'select';
		}

		return $this;
	}

}

?>