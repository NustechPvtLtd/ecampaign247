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
        $data['pageMetaDescription'] = 'Webzero.in';
        $data['pageHeading'] = 'User List';

        $data['js'] = array(
            '<script type="text/javascript" src="'.base_url().'assets/js/user-grid.js"></script>',
            '<script type="text/javascript" src="'.base_url().'assets/jquery-ui/jquery-ui.min.js"></script>',
		    '<script type="text/javascript" src="'.base_url().'assets/sites/js/jquery.ui.touch-punch.min.js"></script>',
		    '<script type="text/javascript" src="'.base_url().'assets/pagination/jquery.bs_pagination.js"></script>',
		    '<script type="text/javascript" src="'.base_url().'assets/pagination/localization/en.js"></script>',
		    '<script type="text/javascript" src="'.base_url().'assets/filter/jquery.jui_filter_rules.js"></script>',
		    '<script type="text/javascript" src="'.base_url().'assets/filter/localization/en.js"></script>',
		    '<script type="text/javascript" src="'.base_url().'assets/js/moment.js"></script>',
		    '<script type="text/javascript" src="'.base_url().'assets/grid/jquery.bs_grid.js"></script>',
		    '<script type="text/javascript" src="'.base_url().'assets/grid/localization/en.js"></script>',
		);
        $data['css'] = array(
            '<link rel="stylesheet" type="text/css" href="'.base_url().'assets/jquery-ui/jquery-ui.min.css" />',
            '<link rel="stylesheet" type="text/css" href="'.base_url().'assets/pagination/jquery.bs_pagination.css" />',
            '<link rel="stylesheet" type="text/css" href="'.base_url().'assets/filter/jquery.jui_filter_rules.css" />',
            '<link rel="stylesheet" type="text/css" href="'.base_url().'assets/grid/jquery.bs_grid.css" />',
		);

        $this->template->load('main', 'user', 'index', $data);
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
    
    public function getUserData()
    {
        $return = array(
			'total_rows' => null,
			'page_data' => null,
			'error' => null,
			'filter_error' => array(),
			'debug_message' => array()
		);
        $user = $this->ion_auth->user()->row();
        $userID = $user->id;
        $query = "SELECT `users`.`id`, `users`.`username`, `users`.`email`, `users`.`first_name`, `users`.`last_name`, `users`.`company`, `users`.`phone`, `users`.`active` AS `status`, CONCAT(`p`.`first_name`,' ',`p`.`last_name`) AS `parent`, `groups`.`name` AS `role`, `groups`.`description` AS `role_name`
FROM `users` 
JOIN `users_groups` ON `users_groups`.`user_id` = `users`.`id`
JOIN `groups` ON `users_groups`.`group_id`=`groups`.`id`
LEFT JOIN `users` `p` ON `p`.`id`=`users`.`parent_id`
WHERE `users`.`id` <> {$userID} AND `users`.`parent_id` = {$userID}";
        $result = $this->db->query($query);
        if($result->num_rows() > 0){
            $page_data = $result->result_array();
            $total_rows = $result->num_rows();
        }
        $return ['total_rows']=$total_rows;
        $return ['page_data']=$page_data;
        echo json_encode($return);
    }
}