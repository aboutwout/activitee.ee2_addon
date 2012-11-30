<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Master of Layouts helper functions
 *
 * @package		Activitee
 * @subpackage	Addons
 * @category	Module
 * @author		Wouter Vervloet
 * @link		http://www.baseworks.nl
 */


/**
 * Get cache value, either using the cache method (EE2.2+) or directly from cache array
 *
 * @param       string
 * @param       string
 * @return      mixed
 */
if ( ! function_exists('activitee_get_cache'))
{
	function activitee_get_cache($a)
	{
		$EE =& get_instance();

		if (method_exists($EE->session, 'cache'))
		{
			return $EE->session->cache(ACTIVITEE_NAME, $a);
		}
		else
		{
			return (isset($EE->session->cache[ACTIVITEE_NAME][$a]) ? $EE->session->cache[ACTIVITEE_NAME][$a] : FALSE);
		}
	}
}

// --------------------------------------------------------------

/**
 * Set cache value, either using the set_cache method (EE2.2+) or directly to cache array
 *
 * @param       string
 * @param       string
 * @param       mixed
 * @return      void
 */
if ( ! function_exists('activitee_set_cache'))
{
	function activitee_set_cache($a, $b)
	{
		$EE =& get_instance();

		if (method_exists($EE->session, 'set_cache'))
		{
			$EE->session->set_cache(ACTIVITEE_NAME, $a, $b);
		}
		else
		{
			$EE->session->cache[ACTIVITEE_NAME][$a] = $b;
		}
	}
}