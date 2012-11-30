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

if (! defined('ACTIVITEE_VERSION'))
{
  define('ACTIVITEE_VERSION', '0.1');
  define('ACTIVITEE_NAME', 'Activitee');
  define('ACTIVITEE_DOCS', 'http://www.baseworks.nl/addons/activitee');
  define('ACTIVITEE_DESCRIPTION', 'Order entries on most recent activity.');
  define('ACTIVITEE_SETTINGS_EXISTS', 'n');
}

$config['name'] = ACTIVITEE_NAME;
$config['version'] = ACTIVITEE_VERSION;
$config['description'] = ACTIVITEE_DESCRIPTION;
$config['nsm_addon_updater']['versions_xml'] = '';