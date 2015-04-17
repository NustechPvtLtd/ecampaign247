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
    
    public function index()
    {
        $data['title'] = 'User';
        $data['pageMetaDescription'] = 'ecampaign247.com';
        $data['pageHeading'] = 'User List';
        $data['js'] = array(
            '<script type="text/javascript" src="'.base_url().'assets/js/root.js"></script>',
		    '<script type="text/javascript" src="'.base_url().'assets/js/grid.js"></script>',
		);
        $data['css'] = array(
            '<link rel="stylesheet" type="text/css" href="'.base_url().'assets/css/grid.css" />',
		);

        $this->template->load('main', 'services', 'user/index', $data);
    }
    
    public function ajaxLoadUserGrid()
    {
        $this->load->library(
            "grid",
            array(
                "table"=>"users", 
                "options"=>array(
                )
            )
        );
    }
}