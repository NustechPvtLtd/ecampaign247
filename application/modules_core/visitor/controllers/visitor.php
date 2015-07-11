<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of visitor
 *
 * @author NUSTECH
 */
class visitor extends MY_Controller {
    
    public $data = array();
    function __construct()
	{
		parent::__construct();
		
		$this->load->model('sites/sitemodel');
		$this->load->model('sites/pagemodel');
		$this->load->model('visitor/visitor_count_model');
			
		$this->data['title'] = "Visitor";
		$this->data['pageMetaDescription'] = "Visitor Tracker";
		$this->data['pageHeading'] = "Visitor List";
		
		if(!$this->ion_auth->logged_in()) {
			
			redirect('/login');
		
		}
		if($this->ion_auth->is_admin()) {
			
			redirect('/');
		
		}
			
	}
    
    public function index()
    {
        //grab us some sites
		$sites = $this->sitemodel->all();
        if(empty($sites)){
            $this->session->set_flashdata('error', $this->lang->line('sites_site_error1'));
            redirect('/sites/','refresh');
        }
        $this->data['css'] = array(
            '<link href="'. base_url().'assets/datatable/css/dataTables.bootstrap.css" type="text/css" rel="stylesheet">',
            '<link href="'. base_url().'assets/datatable/css/dataTables.responsive.css" type="text/css" rel="stylesheet">',
            '<style>td.child{text-align:left !important}</style>'
        );
        $this->data['js'] = array(
            '<script type="text/javascript" src="'. base_url().'assets/datatable/js/jquery.dataTables.min.js"></script>',
            '<script type="text/javascript" src="'. base_url().'assets/datatable/js/dataTables.bootstrap.js"></script>',
            '<script type="text/javascript" src="'. base_url().'assets/datatable/js/dataTables.responsive.js"></script>',
        );
        if(!empty($_GET['id'])){
            $this->data['visitors'] = $this->visitor_count_model->get_by_page($_GET['id']);
        }else{
            $this->data['visitors'] = $this->visitor_count_model->get_by_site($sites[0]['siteData']->sites_id);
        }
        $this->template->load('main', 'visitor', 'index', $this->data);
    }
    
    public function actionGetIPDetails( $page_id )
	{
		$ipDetails = $this->visitor_count_model->get_by_site($page_id);
		foreach ( $ipDetails as $key => $value ) {
			$ipDetails[$key]['ip'] = long2ip( $value['ip'] );
		}
		echo json_encode( $ipDetails );
	}
}
