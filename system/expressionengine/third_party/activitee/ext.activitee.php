<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Activitee Extension
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Extension
 * @author		Wouter Vervloet
 * @link		http://www.baseworks.nl
 */

require_once PATH_THIRD.'activitee/config.php';

class Activitee_ext {
	
	public $settings 		= array();

	public $name			= ACTIVITEE_NAME;
	public $description		= ACTIVITEE_DESCRIPTION;
	public $version			= ACTIVITEE_VERSION;
	public $docs_url		= ACTIVITEE_DOCS;
	public $settings_exist	= ACTIVITEE_SETTINGS_EXISTS;
	
	private $EE;
	
	/**
	 * Constructor
	 *
	 * @param 	mixed	Settings array or empty string if none exist.
	 */
	public function __construct($settings = '')
	{
		$this->EE =& get_instance();
		$this->settings = $settings;
	}
	
	public function channel_entries_query_result(&$obj, $query_result)
	{
	  if (isset($this->EE->TMPL->tagparams['activitee_on']))
	  {
	    $results = activitee_get_cache('results');

	    if (count($results) > 0)
	    {
	      foreach ($query_result as &$q_row)
	      {
	        if (isset($results[$q_row['entry_id']]))
	        {
            $q_row['last_activity'] = $results[$q_row['entry_id']]['last_activity'];
	        }
	      }
	    }
	  }
	  return $query_result;
	}
	
	public function channel_entries_tagdata($tagdata, $row, &$obj)
	{
	  // A little bit of cheating to enable date
	  // formatting for the last_activity variable.
	  if (isset($row['last_activity']))
	  {
	    if ($row['last_activity'] === $row['entry_date'])
	    {
	      $tagdata = str_replace('last_activity', 'entry_date', $tagdata);
	    } 
	    elseif ($row['last_activity'] === $row['recent_comment_date'])
	    {
	      $tagdata = str_replace('last_activity', 'recent_comment_date', $tagdata);	      
	    }
	  }
	  return $tagdata;
	}
	
	private function _match_date_vars($str='')
	{
	  if (strpos($str, 'format=') === FALSE) return;
	
		if (preg_match_all("/".LD."([^".RD."]*?)\s+format=[\"'](.*?)[\"']".RD."/s", $str, $matches, PREG_SET_ORDER))
		{
			for ($j = 0, $tot = count($matches); $j < $tot; $j++)
			{
				$matches[$j][0] = str_replace(array(LD,RD), '', $matches[$j][0]);

				$this->date_vars[$matches[$j][1]][$matches[$j][0]] = array_merge(array($matches[$j][2]), $this->EE->localize->fetch_date_params($matches[$j][2]));
			}
		}
		else
		{
			// make sure we don't try to parse date variables again on further calls to parse_variables() or parse_variables_row()
			$this->date_vars = FALSE;
		}
		
	}
	
	/**
	 * Activate Extension
	 *
	 * This function enters the extension into the exp_extensions table
	 *
	 * @see http://codeigniter.com/user_guide/database/index.html for
	 * more information on the db class.
	 *
	 * @return void
	 */
	public function activate_extension()
	{
		// Setup custom settings in this array.
		$this->settings = array();
		
		$hooks = array(
			'channel_entries_query_result'	=> 'channel_entries_query_result',
			'channel_entries_tagdata' => 'channel_entries_tagdata'
		);

		foreach ($hooks as $hook => $method)
		{
			$data = array(
				'class'		=> __CLASS__,
				'method'	=> $method,
				'hook'		=> $hook,
				'settings'	=> serialize($this->settings),
				'version'	=> $this->version,
				'enabled'	=> 'y'
			);

			$this->EE->db->insert('extensions', $data);			
		}
	}	


	/**
	 * Disable Extension
	 *
	 * This method removes information from the exp_extensions table
	 *
	 * @return void
	 */
	function disable_extension()
	{
		$this->EE->db->where('class', __CLASS__);
		$this->EE->db->delete('extensions');
	}


	/**
	 * Update Extension
	 *
	 * This function performs any necessary db updates when the extension
	 * page is visited
	 *
	 * @return 	mixed	void on update / false if none
	 */
	function update_extension($current = '')
	{
		if ($current == '' OR $current == $this->version)
		{
			return FALSE;
		}
	}	
	
}

/* End of file ext.activitee.php */
/* Location: /system/expressionengine/third_party/activitee/ext.activitee.php */