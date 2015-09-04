<?php defined('BASEPATH') OR exit('No direct script access allowed');
if ( session_status() == PHP_SESSION_NONE ) {
  session_start();
}


require_once("Google/autoload.php");

Class Google {

    public function __construct()
    {
        // Load config
        $this->load->config('googleplus');

        // Load required libraries and helpers
        $this->load->library('session');
        $this->load->helper('url');
        
        $cache_path = $this->config->item('cache_path');
		$GLOBALS['apiConfig']['ioFileCache_directory'] = ($cache_path == '') ? APPPATH .'cache/' : $cache_path;
		
		$this->client = new Google_Client();
		$this->client->setApplicationName($this->config->item('application_name', 'googleplus'));
		$this->client->setClientId($this->config->item('client_id', 'googleplus'));
		$this->client->setClientSecret($this->config->item('client_secret', 'googleplus'));
		$this->client->setRedirectUri($this->config->item('redirect_uri', 'googleplus'));
		$this->client->setDeveloperKey($this->config->item('api_key', 'googleplus'));

		$this->client->addScope("https://www.googleapis.com/auth/userinfo.email");
		
		$this->plus = new Google_Service_Oauth2($this->client);
        
        $this->google_session();
    }

        
    // ------------------------------------------------------------------------
    public function login_url()
    {
        // Create login url
        $url = $this->client->createAuthUrl();

        // Return login url
        return $url;
    }
	    
    // ------------------------------------------------------------------------
    private function google_session()
    {
        // Check if our own session token exists
        if ($this->session->userdata('gl_token'))
        {
            $this->client->setAccessToken($this->session->userdata('gl_token'));
        }
        else
        {
            // We don't have a session, create a new
            $session = $this->get_new_session();
            return $session;
        }
    }
        
    // ------------------------------------------------------------------------
    private function get_new_session()
    {

        if (isset($_GET['code'])) {
            $this->client->authenticate($_GET['code']);
            $token = $this->client->getAccessToken();
            $this->session->set_userdata('gl_token', $token);
            return $token;
         }

        // Could not get a session, so return null
        return NULL;
    }
        
    // ------------------------------------------------------------------------
    public function getUser()
    {
        if ($this->client->getAccessToken()) {
            $userData = $this->plus->userinfo->get();
            return $userData;
        }
    }
    
    // ------------------------------------------------------------------------

    /**
    * Enables the use of CI super-global without having to define an extra variable.
    * I can't remember where I first saw this, so thank you if you are the original author.
    *
    * Copied from the Ion Auth library
    *
    * @access  public
    * @param   $var
    * @return  mixed
    */
    public function __get($var)
    {
        return get_instance()->$var;
    }

}
