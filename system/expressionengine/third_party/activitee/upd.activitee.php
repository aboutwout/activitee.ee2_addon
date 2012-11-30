<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Activitee Module Install/Update File
 *
 * @package		ExpressionEngine
 * @subpackage	Addons
 * @category	Module
 * @author		Wouter Vervloet
 * @link		http://www.baseworks.nl
 */

require_once PATH_THIRD.'activitee/config.php';

class Activitee_upd {
	
	public $version = ACTIVITEE_VERSION;
	
	private $EE;
	
	/**
	 * Constructor
	 */
	public function __construct()
	{
		$this->EE =& get_instance();
	}
	
	// ----------------------------------------------------------------
	
	/**
	 * Installation Method
	 *
	 * @return 	boolean 	TRUE
	 */
	public function install()
	{
		$mod_data = array(
			'module_name'			=> ACTIVITEE_NAME,
			'module_version'		=> ACTIVITEE_VERSION,
			'has_cp_backend'		=> 'n',
			'has_publish_fields'	=> 'n'
		);
		
		$this->EE->db->insert('modules', $mod_data);
		
    // $action = array();
    // $this->EE->db->insert_batch('actions', $action);

    // $this->EE->load->dbforge();
    
		return TRUE;
	}

	// ----------------------------------------------------------------
	
	/**
	 * Uninstall
	 *
	 * @return 	boolean 	TRUE
	 */	
	public function uninstall()
	{
		$mod_id = $this->EE->db->select('module_id')
								->get_where('modules', array(
									'module_name'	=> ACTIVITEE_NAME
								))->row('module_id');
		
		$this->EE->db->where('module_id', $mod_id)
					 ->delete('module_member_groups');
		
		$this->EE->db->where('module_name', ACTIVITEE_NAME)
					 ->delete('modules');
		
    // $this->EE->load->dbforge();
				
		return TRUE;
	}
	
	// ----------------------------------------------------------------
	
	/**
	 * Module Updater
	 *
	 * @return 	boolean 	TRUE
	 */	
	public function update($current = '')
	{
		// If you have updates, drop 'em in here.
		return TRUE;
	}
	
}
/* End of file upd.activitee.php */
/* Location: /system/expressionengine/third_party/activitee/upd.activitee.php */