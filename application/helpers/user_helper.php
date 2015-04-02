<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * User Helpers
 *
 * @package		Application
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Nustech Dev Team
 */

// ------------------------------------------------------------------------

/**
 * userdata
 *
 * Fetches a user session variable
 *
 * @access	public
 * @param	string	the session variable name
 * @param	string	the value of variable
 * @return	string
 */
if ( ! function_exists('userdata'))
{
    function userdata( $key, $val = null ){
      $ci = &get_instance();
      if ( $val !== null ){
        $ci->session->set_userdata( $key, $val );
      } else {
        return $ci->session->userdata( $key );
      }
    }
}

// ------------------------------------------------------------------------
/* End of file language_helper.php */
/* Location: ./system/helpers/language_helper.php */