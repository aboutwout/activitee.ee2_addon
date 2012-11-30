<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Activitee Module Front End File
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Module
 * @author		Wouter Vervloet
 * @link		http://www.baseworks.nl
 */

require_once PATH_THIRD.'activitee/config.php';

class Activitee {
	
	public $return_data;
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->EE =& get_instance();
	  $this->EE->load->helper('activitee_helper');
	}
	
	public function entries()
	{
	  $this->EE->TMPL->tagparams['activitee_on'] = 'yes';
	  
	  $sql = "SELECT entry_id, title, entry_date, recent_comment_date, GREATEST(entry_date, recent_comment_date) AS last_activity FROM exp_channel_titles ORDER BY last_activity DESC";

    $query = $this->EE->db->query($sql);
    
    if ($query->num_rows() > 0)
    {

      $entry_ids = array();

      foreach ($query->result() as $row)
      {
        $entry_ids[] = $row->entry_id;
      }

  		$results = array();

      // debug($l_query->result());

  		foreach ($query->result() as $row)
  		{
  		  $results[$row->entry_id] = array(
  		    'entry_id' => $row->entry_id,
  		    'last_activity' => $row->last_activity,
  		  );
  		}

      // uasort($results, 'activitee_by_rating');

  		activitee_set_cache('results', $results);

  		$orderby = $this->_fetch_param('orderby');

			$par = 'fixed_order';
			$this->EE->TMPL->tagdata['orderby'] = '';
			$this->EE->TMPL->tagdata['sort'] = '';

      // if ($entry_id_param = $this->_fetch_param('entry_id') AND strtolower(substr($entry_id_param, 0, 3)) === 'not')
      // {
      //   $entry_id_vals = substr($entry_id_param, 3);
      // }

  		$this->EE->TMPL->tagparams[$par] = implode('|', array_keys($results));

      
    }
	
		if ( ! class_exists('channel'))
		{
			require_once PATH_MOD.'channel/mod.channel'.EXT;
		}

		// --------------------------------------
		// Create new Channel instance
		// --------------------------------------
		$channel = new Channel;

		// --------------------------------------
		// Let the Channel module do all the heavy lifting
		// --------------------------------------

		return $channel->entries();
  }
  

	
  /**
  * Helper function for getting a parameter
  * @access		private
  * @param    $key string 
  * @param    $default_value mixed 
  * @return   mixed string|boolean
  **/	
  private function _fetch_params()
  {
    $approved = array();

    $params = $this->EE->TMPL->tagparams ? $this->EE->TMPL->tagparams : array();    

    foreach ($params as $param => $value)
    {
      if ( in_array($param, $this->_allowed_params) OR strstr($param, 'search:') !== FALSE )
      {
        $approved[$param] = $value;
      }
    }
    
    return $approved;
  }	
  

  /**
  * Helper function for getting a parameter
  * @access		private
  * @param    $key string 
  * @param    $default_value mixed 
  * @return   mixed string|boolean
  **/	
  private function _fetch_param($key='', $default_value = FALSE)
  {
    $val = $this->EE->TMPL->fetch_param($key);

    if ($val === '' OR $val === FALSE)
    {
      return $default_value;
    }

    return $val;
  }	

  /**
  * Helper function for getting a parameter that
  * should return an array value.
  * @access		private
  * @param    $key string 
  * @param    $default_value mixed
  * @return   array
  **/	 
  private function _fetch_array_param($key='', $default_value = array())
  {
    $val = trim($this->_fetch_param($key), '|');
    return ($val == '') ? $default_value : explode('|', $val);
  }

  /**
  * Helper function for getting a parameter that
  * should return a boolean value.
  * @access		private
  * @param    $key string 
  * @param    $default_value mixed
  * @return   bool
  **/	 
  private function _fetch_bool_param($key='', $default_value = FALSE)
  {
    $val = $this->_fetch_param($key, $default_value);

    return in_array($val, array('y', 'yes', '1', 'true', 'on', TRUE));
  }	

  /**
  * Log message to the template log
  * @access		private
  * @param    $message string
  * @return   void
  **/  
  private function _log($message='')
  {
    if ( ! $message) return;

    $this->EE->TMPL->log_item('--> '.ACTIVITEE_NAME.' : '.$message);

  }

	
}
/* End of file mod.activitee.php */
/* Location: /system/expressionengine/third_party/activitee/mod.activitee.php */