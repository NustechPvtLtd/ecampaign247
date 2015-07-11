<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of domain
 *
 * @author NUSTECH
 */
class Domain extends MY_Controller {
    
    private $api_key = 'an0awERdunNrnU6vPMVqYKkGOOWqnVPI';
    private $auth_userid = 598891;
    private $ns1 = 'ns1.artwork.mysitehosted.com';
    private $ns2 = 'ns2.artwork.mysitehosted.com';
    private $customer_id = 12909763;
    private $reg_contact_id ;
    private $admin_contact_id ;
    private $tech_contact_id ;
    private $billing_contact_id ;
    public $data = array();
    
    function __construct()
	{
		parent::__construct();
		
		$this->load->model('domain/domainmodel');
        $this->load->model('sites/sitemodel');
		$this->load->library('table');
        $this->load->helper('form');
		$this->data['title'] =  ucfirst($this->router->fetch_class());
		$this->data['pageTitle'] = ucfirst($this->router->fetch_class());
		if(!$this->ion_auth->logged_in()) {
			redirect('/login');
		}
	}
    
    public function index($site_id=FALSE)
    {
        $this->data['pageHeading'] = 'Premium Domain';
        $this->data['pageMetaDescription'] = $this->router->fetch_class();
        $site_id = $this->sitemodel->getSiteId($this->ion_auth->get_user_id());

        if($site_id){
            $siteData = $this->sitemodel->getSite($site_id);
            if( $siteData == false ) {

                $this->session->set_flashdata('error', $this->lang->line('sites_site_error1'));

                redirect('/domain/', 'refresh');

            }
            $this->data['css'] = array(
                '<link href="'.base_url().'assets/sites/css/builder.css" rel="stylesheet">',
                '<link href="'.base_url().'assets/sites/css/style.css" rel="stylesheet">'
            );
            $this->data['siteData'] = $siteData['site'];
            $this->template->load('main', 'domain', 'sitedomain', $this->data);
        }else{
            redirect(site_url('sites'));
            /*$this->data['css'] = array(
                '<link href="'.base_url().'assets/sites/less/flat-ui.css" rel="stylesheet">'
            );
            $this->data['sites'] = $this->sitemodel->all();
            $this->template->load('sites', 'domain', 'sites', $this->data);*/
        }
    }
    public function checkDomainAvalability(){
        if(!empty($_POST['siteID']) && !empty($_POST['domainname']) && !empty($_POST['tlds'])){
            $tld = "";
            foreach ($_POST['tlds'] as $key => $value) {
                $tld.='&tlds=' . $value;
            }
            $this->getContact();
            $url = "https://test.httpapi.com/api/domains/available.json?auth-userid={$this->auth_userid}&api-key={$this->api_key}&domain-name={$_POST['domainname']}{$tld}";
            $data = $this -> _domainCallAPI( 'GET', $url );
            $data = json_decode($data,TRUE);
            $priceArray = $this->getPrice();
            if(is_array($data) && !isset($data['response'])){
                $table = array();
                foreach ($data as $key => $value) {
                    if($value['status']=='available'){
                        $classkey = $value['classkey'];
                        if(array_key_exists($classkey, $priceArray)){
                            $table[]=  array_merge(
                                    array(form_radio('domain', $key),'name'=>$key),
                                    array(
                                        $value['status'],
                                        $priceArray[$classkey]['addnewdomain'][1].' INR'
                                    )
                                );
                        }
                    }
                }
                
                $tmpl = array (
                        'table_open'          => '<table border="1" cellpadding="4" cellspacing="0" class="table  table-bordered">',

                        'heading_row_start'   => '<tr>',
                        'heading_row_end'     => '</tr>',
                        'heading_cell_start'  => '<th>',
                        'heading_cell_end'    => '</th>',

                        'row_start'           => '<tr>',
                        'row_end'             => '</tr>',
                        'cell_start'          => '<td>',
                        'cell_end'            => '</td>',

                        'row_alt_start'       => '<tr>',
                        'row_alt_end'         => '</tr>',
                        'cell_alt_start'      => '<td>',
                        'cell_alt_end'        => '</td>',

                        'table_close'         => '</table>'
                  );

                $this->table->set_template($tmpl);
                $this->table->set_heading('#','Name', 'Status', 'Price');
                echo $this->table->generate($table);
            }  else {
                echo $data['response'].' : '.$data['message'];
            }
        }
    }
        
    public function bookDomain($site_id)
    {
        if(!empty($_POST['domain'])){
            $this->getContact();
            $url = "https://test.httpapi.com/api/domains/register.json?auth-userid={$this->auth_userid}&api-key={$this->api_key}&domain-name={$_POST['domain']}&years=1&ns={$this->ns1}&ns={$this->ns2}&customer-id={$this->customer_id}&reg-contact-id={$this->reg_contact_id}&admin-contact-id={$this->admin_contact_id}&tech-contact-id={$this->tech_contact_id}&billing-contact-id={$this->billing_contact_id}&invoice-option=PayInvoice";
            $data = $this -> _domainCallAPI( 'GET', $url );

            $data = json_decode($data);
            if($data->status=='Success'){
                if($this->domainmodel->create($site_id, $_POST['domain'], $data)){
                    echo $data->actionstatusdesc.' for '.$data->actiontypedesc;
                }
            }
        }
    }
    
    private function getContact()
    {
        $url = "https://test.httpapi.com/api/contacts/default.json?auth-userid={$this->auth_userid}&api-key={$this->api_key}&customer-id={$this->customer_id}&type=Contact";
        $data = $this -> _domainCallAPI( 'GET', $url );
        $data = json_decode($data,TRUE);
        if(!isset($data['response'])){
            foreach ($data as $value) {
                $this->reg_contact_id = $value['registrant'];
                $this->admin_contact_id = $value['admin'];
                $this->tech_contact_id = $value['tech'];
                $this->billing_contact_id = $value['billing'];
            }
        }
    }
    
    private function getPrice()
    {
        $url = "https://test.httpapi.com/api/products/customer-price.json?auth-userid={$this->auth_userid}&api-key={$this->api_key}";
        $data = $this -> _domainCallAPI('GET', $url);
        $datajson = json_decode($data, TRUE);
        if(!isset($datajson['response'])){
            return $datajson;
        }  else {
            return false;
        }
        
    }
    
    private function _domainCallAPI( $method, $url, $data = false )
	{
		$curl = curl_init();
		switch ( $method ) {
			case "POST":{
				curl_setopt( $curl, CURLOPT_POST, 1 );
				if ( $data ) {
					curl_setopt( $curl, CURLOPT_POSTFIELDS, $data );
				}
			}
				break;
			case "PUT":{
				curl_setopt( $curl, CURLOPT_PUT, 1 );
			}
				break;
			default:{
				if ( $data ){
					$url = sprintf( "%s?%s", $url, http_build_query( $data ) );
				}
			}
		}
		// Optional Authentication: - Need not touch this
		curl_setopt( $curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
		curl_setopt( $curl, CURLOPT_USERPWD, "username:password" );
		curl_setopt( $curl, CURLOPT_URL, $url );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
//        curl_setopt( $curl, CURLOPT_SSL_VERIFYHOST, 0);
//        curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, 0);
        $output = curl_exec( $curl );
		if(!$output){
			$output = json_encode(array(
				'response'=>'error',
				'message'=>curl_error($curl)
			));
			 
		}
        
		curl_close ( $curl );
		return $output;
    }
}
