<?php (defined('BASEPATH')) OR exit('No direct script access allowed');

class User extends MY_Controller {
    
    public $data = array();
    function __construct()
    {
        parent::__construct();
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->lang->load('auth');
        $this->data['title'] = $this->router->fetch_method();
        $this->data['pageMetaDescription'] = $this->router->fetch_class().'|'.$this->router->fetch_method();
    }
    
    public function index()
    {
        
        $group = array('comp-admin', 'admin', 'sub-admin');
        if (!$this->ion_auth->in_group($group)){
            $this->session->set_flashdata('message', 'You must be a Company Admin OR a Application Admin to view this page');
            redirect('/');
        }
        
        $this->data['pageHeading'] = 'User List';
        $this->data['js'] = array(
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
        $this->data['css'] = array(
            '<link rel="stylesheet" type="text/css" href="'.base_url().'assets/jquery-ui/jquery-ui.min.css" />',
            '<link rel="stylesheet" type="text/css" href="'.base_url().'assets/pagination/jquery.bs_pagination.css" />',
            '<link rel="stylesheet" type="text/css" href="'.base_url().'assets/filter/jquery.jui_filter_rules.css" />',
            '<link rel="stylesheet" type="text/css" href="'.base_url().'assets/grid/jquery.bs_grid.css" />',
		);

        $this->template->load('main', 'user', 'index', $this->data);
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
    
    public function profile($id = NULL)
    {
        $this->load->model('account/plans_model');
        if($id){
           $user = $this->ion_auth->user($id)->row();
        }else{
           $user = $this->ion_auth->user()->row(); 
        }
        $this->data['user_id'] = $this->ion_auth->get_user_id();
        //validation rule
       if(!$this->ion_auth->is_admin()){
            $this->form_validation->set_rules('first_name', $this->lang->line('edit_user_validation_fname_label'), 'required');
            $this->form_validation->set_rules('last_name', $this->lang->line('edit_user_validation_lname_label'), 'required');
       }
       if($this->ion_auth->is_admin() && $this->data['user_id']!=$user->id){
            $this->form_validation->set_rules('price_plan_id', $this->lang->line('edit_user_validation_price_plan_label'), 'required');
       }
        if(!$this->ion_auth->is_admin()){
            $this->form_validation->set_rules('company', $this->lang->line('edit_user_validation_company_label'));
            $this->form_validation->set_rules('phone', $this->lang->line('edit_user_validation_phone_label'), 'required');
        }
        $this->form_validation->set_rules('email', $this->lang->line('edit_user_validation_email_label'), 'required');
        $this->data['message'] ='';
		if (isset($_POST) && !empty($_POST))
		{
            
			// do we have a valid request?
//			if ($this->_valid_csrf_nonce() === FALSE )
//			{
//				show_error($this->lang->line('error_csrf'));
////                redirect('user/profile','location');
//			}
            
            //update the password if it was posted
			if ($this->input->post('password'))
			{
				$this->form_validation->set_rules('password', $this->lang->line('edit_user_validation_password_label'), 'required|min_length[' . $this->config->item('min_password_length', 'ion_auth') . ']|max_length[' . $this->config->item('max_password_length', 'ion_auth') . ']|matches[password_confirm]');
				$this->form_validation->set_rules('password_confirm', $this->lang->line('edit_user_validation_password_confirm_label'), 'required');
			}
            
            if ($this->form_validation->run() === TRUE)
			{
                if(!$this->ion_auth->is_admin() || $this->data['user_id']==$user->id){
                    $data = array(
                        'first_name' => $this->input->post('first_name'),
                        'last_name'  => $this->input->post('last_name'),
                        'company'    => $this->input->post('company'),
                        'phone'      => $this->input->post('phone'),
                    );
                }

				//update the password if it was posted
				if ($this->input->post('password'))
				{
					$data['password'] = $this->input->post('password');
				}
                
				if ($this->input->post('price_plan_id'))
				{
					$data['price_plan_id'] = $this->input->post('price_plan_id');
				}
                
				if ($this->input->post('notes'))
				{
					$data['notes'] = $this->input->post('notes');
				}

                //check to see if we are updating the user
			    if($this->ion_auth->update($user->id, $data))
			    {
			    	//redirect them back to the admin page if admin, or to the base url if non admin
				    $this->data['message'] =  $this->ion_auth->messages() ;
                    ($this->ion_auth->is_admin())?redirect('/','location'):userdata('complete_profile',FALSE);
			    }
			    else
			    {
			    	//redirect them back to the admin page if admin, or to the base url if non admin
				    $this->data['message'] = $this->ion_auth->errors();
			    }
			}
            else
            {
                $this->data['message'] = validation_errors();
            }
        }
        
        //display the edit user form
//		$this->data['csrf'] = $this->_get_csrf_nonce();

		//pass the user to the view
		$this->data['user'] = $user;
        $this->data['first_name'] = array(
			'name'  => 'first_name',
			'id'    => 'first_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('first_name', $user->first_name),
            'class' => 'form-control',
		);
		$this->data['last_name'] = array(
			'name'  => 'last_name',
			'id'    => 'last_name',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('last_name', $user->last_name),
            'class' => 'form-control',
		);
		$this->data['email'] = array(
			'name'      => 'email',
			'id'        => 'email',
			'type'      => 'email',
			'value'     => $this->form_validation->set_value('email', $user->email),
            'class'     => 'form-control',
            'READONLY'  => true
		);
		$this->data['company'] = array(
			'name'  => 'company',
			'id'    => 'company',
			'type'  => 'text',
			'value' => $this->form_validation->set_value('company', $user->company),
            'class' => 'form-control',
		);
		$this->data['notes'] = array(
			'name'  => 'notes',
			'id'    => 'notes',
			'value' => $this->form_validation->set_value('notes'),
			'type'  => 'text',
            'class' => 'form-control',
		);
		$this->data['phone'] = array(
			'name'          => 'phone',
			'id'            => 'phone',
			'type'          => 'text',
			'value'         => $this->form_validation->set_value('phone', $user->phone),
            'class'         => 'form-control',
            'placeholder'   => '+91 00 00 000000'
		);
		$this->data['password'] = array(
			'name' => 'password',
			'id'   => 'password',
			'type' => 'password',
            'class' => 'form-control',
		);
		$this->data['password_confirm'] = array(
			'name' => 'password_confirm',
			'id'   => 'password_confirm',
			'type' => 'password',
            'class' => 'form-control',
		);
        $this->data['price_plan_id'] = (isset($user->price_plan_id))?$this->form_validation->set_value('price_plan_id',$user->price_plan_id):'';
        foreach ($this->plans_model->get_plans() as $plan) {
            $plans[$plan->plan_id] = $plan->name;
        }
        $this->data['plans'] = $plans;

        $this->data['avatar'] = (($id)?$id:$user->id).'/'.$user->avatar;
        $this->data['js'] = array(
            '<script type="text/javascript" src="'.base_url().'assets/js/ajaxupload.3.5.js"></script>',
            '<script type="text/javascript" src="'.base_url().'assets/js/jquery.maskedinput.js"></script>',
            );
        $this->data['pageHeading'] = 'My Profile';
        $this->template->load('main', 'user', 'profile_personal', $this->data);
        
    }
    
    public function upload_avatar()
    {
        $userID = $this->ion_auth->get_user_id();
        
        //if the upload path does not exist, create it
        if( !file_exists( './'.$this->config->item('images_uploadDir').'/'.$userID ) ) {
            mkdir('./'.$this->config->item('images_uploadDir').'/'.$userID, 0777, true);
        }

        $config['upload_path'] = './'.$this->config->item('images_uploadDir').'/'.$userID.'/';
        $config['allowed_types'] = $this->config->item('upload_allowed_types');
        $config['max_size']	= $this->config->item('upload_max_size');
        $config['max_width']  = $this->config->item('upload_max_width');
        $config['max_height']  = $this->config->item('upload_max_height');

        $this->load->library('upload', $config);

        if ( ! $this->upload->do_upload('uploadfile')) {
            $return['status'] = 'error';
            $return['message'] = $this->upload->display_errors();
        } else {
            $imageData=$this->upload->data();
            $data['avatar'] = $imageData['raw_name'].$imageData['file_ext'];
            if($this->ion_auth->update($userID, $data))
            {
                $avatar = userdata( 'avatar' );
                if(!empty($avatar)){
                    unlink($config['upload_path'].$avatar);
                    userdata( 'avatar', $data['avatar']);
                }
                
                $return['status'] = 'success';
                $return['message'] = $data['avatar'];
            }
        }
        echo json_encode($return);
    }
    
    function _get_csrf_nonce()
	{
		$this->load->helper('string');
		$key   = random_string('alnum', 8);
		$value = random_string('alnum', 20);
		$this->session->set_flashdata('csrfkey', $key);
		$this->session->set_flashdata('csrfvalue', $value);

		return array($key => $value);
	}

	function _valid_csrf_nonce()
	{
		if ($this->input->post($this->session->flashdata('csrfkey')) !== FALSE &&
			$this->input->post($this->session->flashdata('csrfkey')) == $this->session->flashdata('csrfvalue'))
		{
			return TRUE;
		}
		else
		{
			return FALSE;
		}
	}
}