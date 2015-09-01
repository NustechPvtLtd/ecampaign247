<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of MY_Session
 *
 * @author NUSTECH
 */
class MY_Session extends CI_Session {
    
    function __construct() 
    {
        parent::__construct();
    }
    
    // --------------------------------------------------------------------

	/**
	 * Fetch a specific item from the session array
	 *
	 * @access	public
	 * @param	string
	 * @return	string
	 */
	function userdata($item)
	{
        if(isset($this->userdata[$item])){
            return $this->userdata[$item];
        } else {
            if(isset($this->userdata['loggedin_as']) && $this->userdata['loggedin_as']=='admin'){
                return ( ! isset($this->userdata['admin'][$item])) ? FALSE : $this->userdata['admin'][$item];
            }else{
                return ( ! isset($this->userdata['user'][$item])) ? FALSE : $this->userdata['user'][$item];
            }
        }
	}

	// --------------------------------------------------------------------

	/**
	 * Fetch all session data
	 *
	 * @access	public
	 * @return	array
	 */
	function all_userdata()
	{
		return $this->userdata;
	}

	// --------------------------------------------------------------------

	/**
	 * Delete a session variable from the "userdata" array
	 *
	 * @access	array
	 * @return	void
	 */
	function unset_userdata($newdata = array())
	{
		if (is_string($newdata))
		{
			$newdata = array($newdata => '');
		}

		if (count($newdata) > 0)
		{
			foreach ($newdata as $key => $val)
			{
                if(isset($this->userdata[$key])){
                    unset($this->userdata[$key]);
                } else {
                    if(isset($this->userdata['loggedin_as']) && $this->userdata['loggedin_as']=='admin'){
                        unset($this->userdata['admin'][$key]);
                    }else{
                        unset($this->userdata['user'][$key]);
                    }
                }
			}
		}

		$this->sess_write();
	}
    
	// --------------------------------------------------------------------

	/**
	 * Delete a session variable from the "userdata" array
	 *
	 * @access	array
	 * @return	void
	 */
	function unset_user_sess()
	{
        unset($this->userdata['user']);

		$this->sess_write();
	}

}
