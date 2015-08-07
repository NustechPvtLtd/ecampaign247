<?php  (defined('BASEPATH')) OR exit('No direct script access allowed');
class Services extends MY_Controller {
    
    function __construct()
    {
        parent::__construct();
        $group = array('comp-admin', 'end-user');
        if (!$this->ion_auth->in_group($group)){
            $this->session->set_flashdata('message', 'You must be a Company Admin OR a End User to view this page');
            redirect('/');
        }
    }
    
    function index()
    {
        $data['title'] = 'Home';
        $data['pageMetaDescription'] = 'webzero.in';
        $data['pageHeading'] = 'Services';
        $data['css'] = array(
            '<link rel="stylesheet" type="text/css" href="'.base_url().'assets/customer/css/style.css"/>'
        );
        $this->template->load('main', 'services', 'services/index', $data);
    }
}