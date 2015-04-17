<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Description of subdomain
 *
 * @author NUSTECH
 */
class subdomain extends CI_Controller {

    public $data = array();
    
	function __construct()
	{
		parent::__construct();
		
		$this->load->model('sites/sitemodel');
		$this->load->model('sites/usermodel');
		$this->load->model('sites/pagemodel');
			
		$this->data['pageTitle'] = $this->lang->line('sites_page_title');
			
	}
    
    public function index($subdomain)
    {
        
    }
}
