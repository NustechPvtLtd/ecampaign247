<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

/* load the MX_Controller class */
require APPPATH."third_party/MX/Controller.php";

/* MY_Controller Class
 * Inherit the MX_Controller Class and only accessible for loggedin user
 */
class MY_Controller extends MX_Controller {
    
    function __construct()
    {
        parent::__construct();
        $this->load->library(array('ion_auth','form_validation', 'template'));
//         $this->form_validation->set_ci_reference( $this );
        if (!$this->ion_auth->logged_in())
        {
            redirect('login', 'refresh');
        }
    }
}