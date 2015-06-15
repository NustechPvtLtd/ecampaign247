<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');


/**
 * Description of payment
 *
 * @author NUSTECH
 */
class payment  extends MX_Controller {
    function __construct()
	{
		parent::__construct();
			
        $this->data['title'] = $this->router->fetch_method();
        $this->data['pageMetaDescription'] = $this->router->fetch_class().'-'.$this->router->fetch_method();
        $this->load->library(array('ion_auth'));
	}
    
    public function paypal()
    {
        $path = 'public_html/'.$this->ion_auth->get_user_id().'/paypal';
        $absPath = './'.$this->ion_auth->get_user_id().'/paypal';
        if (!is_dir($absPath)) {
            mkdir($absPath,0777);
        }
        if(!empty($_REQUEST)){
            write_file($absPath.'/paypal.txt',$_REQUEST);
        }
    }
}
