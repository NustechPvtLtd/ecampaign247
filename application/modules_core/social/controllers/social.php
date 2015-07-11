<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of social
 *
 * @author NUSTECH
 */
class Social extends MY_Controller {
    public $data = array();
    
    function __construct()
    {
        
        parent::__construct();
        
        $this->load->library('facebook');
        $this->load->library('twitteroauth');
        $this->data['title'] = ucwords(str_replace('_', ' ', $this->router->fetch_class()));
        $this->data['pageMetaDescription'] = $this->router->fetch_class().'|'.$this->router->fetch_method();
    }
    
    public function index()
    {
        $this->load->model('sites/sitemodel');
        $this->data['pageHeading'] = 'Social Media';
        $sites = $this->sitemodel->all();
        if(empty($sites)){
            $this->session->set_flashdata('error', $this->lang->line('sites_site_error1'));
            redirect('/sites/','refresh');
        }
        $this->data['site_url'] = $sites[0]['siteData']->remote_url;
        
        $this->template->load('main', 'social', 'index', $this->data);
    }
    
    public function register_facebook()
    {
        $Fbuser = (new Facebook())->get_user();
        $this->load->model('login/ion_auth_model');
        $userId = $this->ion_auth->get_user_id();
        if ($Fbuser) {
            $facebook = array('fb_token'=>$this->session->userdata('fb_token'));
            
            if($this->session->userdata('li_access_token') && $this->session->userdata('li_access_key')){
                $linkedin = array(
                    'access_token' => $this->session->userdata('li_access_token'),
                    'access_key' => $this->session->userdata('li_access_key'),
                    'access_verifier' => $this->session->userdata('li_access_verifier')
                );
                if($this->session->userdata('tw_access_token') && $this->session->userdata('tw_access_key')){
                    $twitter = array(
                        'access_token' => $this->session->userdata('tw_access_token'),
                        'access_key' => $this->session->userdata('tw_access_key'),
                    );
                    $data = array(
                        'social_account' => json_encode(array(
                            'facebook'=>$facebook,
                            'twitter'=>$twitter,
                            'linkedin'=>$linkedin
                        ))
                    );
                }else{
                    $data = array(
                        'social_account' => json_encode(array(
                            'facebook'=>$facebook,
                            'linkedin'=>$linkedin
                        ))
                    );
                }
            } elseif ($this->session->userdata('tw_access_token') && $this->session->userdata('tw_access_key')){
                $twitter = array(
                    'access_token' => $this->session->userdata('tw_access_token'),
                    'access_key' => $this->session->userdata('tw_access_key'),
                );
                $data = array(
                  'social_account' => json_encode(array(
                      'twitter'=>$twitter,
                      'facebook'=>$facebook
                  ))
                );
            } else {
                $data = array(
                    'social_account' => json_encode(array(
                        'facebook'=>$facebook
                    ))
                  );
            }
            $this->ion_auth_model->update($userId,$data);
            redirect(site_url('social'));
        }
    }
    
    public function register_twitter()
    {
//		$to = new TwitterOAuth( $consumerKey, $consumerSecret );
        $userId = $this->ion_auth->get_user_id();
        if(isset($_GET['register'])){
            $tok = $this-> twitteroauth-> getRequestToken(site_url('social/register_twitter'));
            $this->session->set_userdata( 'oauth_token', $tok['oauth_token']);
            $this->session->set_userdata( 'oauth_token_secret', $tok['oauth_token_secret']);
            
            switch ( $this-> twitteroauth -> http_code ) {
                case 200:
                    /* Build authorize URL and redirect user to Twitter. */
                    $url = $this-> twitteroauth-> getAuthorizeURL( $tok['oauth_token'] );
                    header( 'Location: ' . $url );
                    break;
                default:
                    /* Show notification if something went wrong. */
                    echo 'Could not connect to Twitter. Refresh the page or try again later.';
            }
        }
        
        if ( !isset( $_REQUEST['denied'] ) ) {
            $connection = new TwitterOAuth( $this->session->userdata('oauth_token'), $this->session->userdata('oauth_token_secret') );
            
            if(isset($_REQUEST['oauth_verifier'])){
                $tokenCredentials = $connection -> getAccessToken( $_REQUEST['oauth_verifier'] );
                
                $twitter = array(
                    'access_token' => $tokenCredentials['oauth_token'],
                    'access_key' => $tokenCredentials['oauth_token_secret'],
                );
                if($this->session->userdata('fb_token')){
                    $facebook = array('fb_token'=>$this->session->userdata('fb_token'));
                    if($this->session->userdata('li_access_token') && $this->session->userdata('li_access_key')){
                        $linkedin = array(
                            'access_token' => $this->session->userdata('li_access_token'),
                            'access_key' => $this->session->userdata('li_access_key'),
                            'access_verifier' => $this->session->userdata('li_access_verifier')
                        );
                        $data = array(
                            'social_account' => json_encode(array(
                                'facebook'=>$facebook,
                                'twitter'=>$twitter,
                                'linkedin'=>$linkedin
                            ))
                        );
                    }else{
                        $data = array(
                            'social_account' => json_encode(array(
                                'facebook'=>$facebook,
                                'twitter'=>$twitter
                            ))
                          );
                    }
                }else{
                    $data = array(
                      'social_account' => json_encode(array(
                          'twitter'=>$twitter
                      ))
                    );
                }
                $this->ion_auth_model->update($userId,$data);
                $this->session->set_userdata( 'tw_access_token', $tokenCredentials['oauth_token'] );
                $this->session->set_userdata( 'tw_access_key', $tokenCredentials['oauth_token_secret'] );
                redirect(site_url('social'));
            }
        }
    }
        
    public function register_linkedin()
    {
        $userId = $this->ion_auth->get_user_id();
        if(isset($_GET['register'])){
            # Now we retrieve a request token. It will be set as $linkedin->request_token
            $token = (new Linkedin())->get_request_token();
            $oauth_data = array(
                'oauth_request_token' => $token['oauth_token'],
                'oauth_request_token_secret' => $token['oauth_token_secret']
            );
            $this->session->set_userdata($oauth_data);
            
            # With a request token in hand, we can generate an authorization URL, which we'll direct the user to
            $request_link = (new Linkedin())->get_authorize_URL($token);
            
            header( "Location: " . $request_link );
        }else{
            $LinkedInOAuth = new Linkedin();
            $this->session->set_userdata('oauth_verifier', $this->input->get('oauth_verifier'));
            
            $tokens = $LinkedInOAuth->get_access_token($this->input->get('oauth_verifier'));
            $access_data = array(
                'oauth_access_token' => $tokens['oauth_token'],
                'oauth_access_token_secret' => $tokens['oauth_token_secret']
            );
            $this->session->set_userdata($access_data);
            /*
            * Store Linkedin info in a session
            */
            $auth_data = array('linked_in' => serialize($LinkedInOAuth->token), 'oauth_secret' => $this->input->get('oauth_verifier'));

            $this->session->set_userdata(array('auth' => $auth_data));
            $linkedin = array(
                'access_token' => $tokens['oauth_token'],
				'access_key' => $tokens['oauth_token_secret'],
				'access_verifier' => $this->input->get('oauth_verifier')
            );
            if($this->session->userdata('fb_token')){
                $facebook = array('fb_token'=>$this->session->userdata('fb_token'));
                if($this->session->userdata('tw_access_token') && $this->session->userdata('tw_access_key')){
                    $twitter = array(
                        'access_token' => $this->session->userdata('tw_access_token'),
                        'access_key' => $this->session->userdata('tw_access_key'),
                    );
                    $data = array(
                        'social_account' => json_encode(array(
                            'facebook'=>$facebook,
                            'twitter'=>$twitter,
                            'linkedin'=>$linkedin
                        ))
                    );
                }else{
                    $data = array(
                        'social_account' => json_encode(array(
                            'facebook'=>$facebook,
                            'linkedin'=>$linkedin
                        ))
                    );
                }
            } elseif ($this->session->userdata('tw_access_token') && $this->session->userdata('tw_access_key')){
                $twitter = array(
                    'access_token' => $this->session->userdata('tw_access_token'),
                    'access_key' => $this->session->userdata('tw_access_key'),
                );
                $data = array(
                  'social_account' => json_encode(array(
                      'twitter'=>$twitter,
                      'linkedin'=>$linkedin
                  ))
                );
            } else {
                $data = array(
                  'social_account' => json_encode(array(
                      'linkedin'=>$linkedin
                  ))
                );
            }
            $this->ion_auth_model->update($userId,$data);
            $this->session->set_userdata( 'li_access_token', $this->session->userdata('oauth_access_token') );
            $this->session->set_userdata( 'li_access_key', $this->session->userdata('oauth_access_token_secret') );
            $this->session->set_userdata( 'li_access_verifier', $this->input->get('oauth_verifier'));
            redirect(site_url('social'));
        }
    }
    public function post_to_profile()
    {
        $return = array();
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
                       $return['facebook'] = $responce;
                    }
                }
                if ( isset( $_POST['title'] ) ) {
                    if ( isset( $_POST['desc'] ) ) {
                        $msg = isset( $_POST['link'] ) ? $_POST['title'] . ' ' . $_POST['desc'] . ' ' . $_POST['link'] : $_POST['title'] . ' ' . $_POST['desc'] . ' ' . site_url();
                    } else {
                        $msg = isset( $_POST['link'] ) ? $_POST['title'] . ' ' . $_POST['link'] : $_POST['title'] . ' ' . site_url();
                    }
                } else {
                    $msg = isset( $_POST['link'] ) ? $_POST['link'] : site_url();
                }
                
                if( $value == 'twitter' ){
                    $tw = TRUE;
                    $connection = new TwitterOAuth( $this->session->userdata( 'tw_access_token'), $this->session->userdata( 'tw_access_key'));
                    /*$connection->ssl_verifypeer = TRUE;
                    $connection->content_type = 'application/x-www-form-urlencoded';*/
                    $connection -> get( 'account/verify_credentials' );
                    $responce = $connection -> post( 'statuses/update', array ( 'status' => $msg/*, 'media[]' => $imgPath*/ ) );
                    if($responce){
                        $return['twitter'] = $responce;
                    }
                }
                if( $value == 'linkedin' ){
                    
                }
            }
            redirect(site_url('social'));
        }else{
            redirect(site_url('social'),'refresh');
        }
    }
    
    public function disconnect_account($account)
    {
        $query = $this->db->select('social_account')
                  ->where('id', $this->ion_auth->get_user_id())
                  ->get('users');
        if ($query->num_rows() === 1)
		{
			$social_account = $query->row();
            $social_account = json_decode($social_account->social_account);
            
            if($account=='facebook'){
                unset($social_account->facebook);
                $this->session->unset_userdata('fb_token');
            } elseif ($account=='twitter') {
                unset($social_account->twitter);
                $this->session->unset_userdata(array(
                    'tw_access_token'      => '',
                    'tw_access_key'        => '',
                ));
            } else {
                unset($social_account->twitter);
                $this->session->unset_userdata(array(
                    'li_access_token'      => '',
                    'li_access_key'        => '',
                    'li_access_verifier'   => '',
                ));
            }
            $this->db->update('users',array('social_account' => json_encode($social_account)), array('id' => $this->ion_auth->get_user_id()));
        }
        redirect(site_url('social'));
    }
}
