<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class User extends MY_Controller {
    
    function __construct()
    {
        parent::__construct();
        $group = array('comp-admin', 'admin', 'sub-admin');
        if (!$this->ion_auth->in_group($group)){
            $this->session->set_flashdata('message', 'You must be a Company Admin OR a Application Admin to view this page');
            redirect('/');
        }
    }
    
    function index()
    {
        $data['title'] = 'User';
        $data['pageMetaDescription'] = 'ecampaign247.com';
        $data['pageHeading'] = 'User List';
        $this->template->load('main', 'services', 'user/index', $data);
    }    
}