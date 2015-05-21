<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of social_media
 *
 * @author NUSTECH
 */
class Social_media extends MY_Controller {
    public $data = array();
	public $facebook;
	public $accessToken;
	public $consumerKey = 'fIWhCuiueyRVGw38h2bnf9O7d';
	public $consumerSecret = 'JW5aTwqxIO3AF3rm2MMoY7x1AnXW7DMQC7RzypCkaeHgo27NXW';
	public $linkedinApiKey = '7503tsnxnhao1t';
	public $linkedinApiSecret = 'sKWmoBmMb3LrBdHr';
    
    function __construct()
    {
        parent::__construct();
        $this->load->library('facebook');
        $this->data['title'] = ucfirst($this->router->fetch_method());
        $this->data['pageMetaDescription'] = $this->router->fetch_class().'|'.$this->router->fetch_method();
    }
    
    public function index()
    {
        $this->load->model('sites/sitemodel');
        $this->data['pageHeading'] = 'Social Media';
        $sites = $this->sitemodel->all();
        $this->data['site_url'] = $sites[0]['siteData']->remote_url;
        
        $this->template->load('main', 'social_media', 'index', $this->data);
    }
    
    public function register_facebook()
    {
        $Fbuser = (new Facebook())->get_user();
        $this->load->model('login/ion_auth_model');
        $userId = $this->ion_auth->get_user_id();
        if ($Fbuser) {
            $facebook = array('fb_token'=>$this->session->userdata('fb_token'));
            $data = array(
              'social_account' => json_encode(array(
                  'facebook'=>$facebook
              ))
            );
            $this->ion_auth_model->update($userId,$data);
            redirect(site_url('social_media'));
        }
    }
    
    public function post_to_profile()
    {
        $fb = FALSE;
        if ( isset( $_POST['socialMedia'] ) ) {
            foreach ( $_POST['socialMedia'] as $value ) {
                if ( $value == 'facebook' ) {
                    $paramters = array (
                        'message' => $_POST['desc'],
                        'link' => isset( $_POST['link'] ) ? $_POST['link'] : site_url(),
                        'name' => isset( $_POST['title'] ) ? $_POST['title'] : 'Web Zero',
//                        'picture' => $imgPath
                    );
                    $responce = (new Facebook())->publish($paramters);
                    if($responce){
                       redirect(site_url('social_media'));
                    }
                }
                if( $value == 'twitter' ){
                    
                }
                if( $value == 'linkedin' ){
                    
                }
            }
        }
    }
}
