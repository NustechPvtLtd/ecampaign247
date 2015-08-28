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
    public $_salt;
    public $_url;
    public $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
    
    function __construct()
	{
		parent::__construct();
		
		$this->load->model('domain/domainmodel');
        $this->load->model('sites/sitemodel');
		$this->load->model('domain/users_domains_model');
		$this->load->model('domain/addon_domain_order_model');
		$this->load->model('domain/addon_domain_transaction_model');
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
            $this->data['js'] = array(
                '<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/jquery.validate.min.js"></script>',
                '<script type="text/javascript" src="http://ajax.aspnetcdn.com/ajax/jquery.validate/1.14.0/additional-methods.min.js"></script>'
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
            if(!isset($data['status'])){
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
                echo $data['status'].' : '.$data['message'];
            }
        }
    }
        
    public function bookDomain($site_id)
    {
        if(!empty($_POST['domain'])){
            $this->getContact();
            $url = "https://test.httpapi.com/api/domains/register.json?auth-userid={$this->auth_userid}&api-key={$this->api_key}&domain-name={$_POST['domain']}&years=1&ns={$this->ns1}&ns={$this->ns2}&customer-id={$this->customer_id}&reg-contact-id={$this->reg_contact_id}&admin-contact-id={$this->admin_contact_id}&tech-contact-id={$this->tech_contact_id}&billing-contact-id={$this->billing_contact_id}&invoice-option=PayInvoice";
            $data = $this -> _domainCallAPI( 'GET', $url );
            $user_id = userdata('user_id');
            $data = json_decode($data);
            if($data->status=='Success'){
                if($this->domainmodel->create($site_id, $_POST['domain'], $data)){
                    $domainOk = $this->users_domains_model->create( $site_id, $user_id, $_POST['domain'], 'premiumDomain');
                    echo $data->actionstatusdesc.' for '.$data->actiontypedesc;
                }
            } else {
                echo 'Domain not booked, please try again latter!';
            }
        }
    }
    
    public function add_domain($site_id)
    {
        $this->load->config('payu_money', TRUE);
        $this->_salt = $this->config->item('SALT', 'payu_money');
        $this->_url = $this->config->item('PAYU_BASE_URL', 'payu_money');
        
        if(isset($_POST['siteSettings_adddomain'])){
            $user_id = userdata('user_id');
            $user = $this->ion_auth_model->user($user_id)->result();
            $this->data['key'] = $this->config->item('MERCHANT_KEY', 'payu_money');
            $this->data['surl'] = site_url('domain/addon_success');
            $this->data['furl'] = site_url('domain/addon_failed');
            $this->data['service_provider'] = 'payu_paisa';
            $this->data['txnid'] = $this->_genrate_txnid();
            $this->data['amount'] = floatval(1000);
            $this->data['firstname'] = $user[0]->first_name;
            $this->data['lastname'] = $user[0]->last_name;
            $this->data['email'] = $user[0]->email;
            $this->data['phone'] = $user[0]->phone;
            $this->data['productinfo'] = $_POST['siteSettings_adddomain'];
            $this->data['hash'] = $this->_genrate_hash($this->data);
            $this->data['action'] = $this->_url . '_payment';
            
            $domain_order_data = array(
                'customer_id' => $user[0]->id,
                'addon_domain' => $_POST['siteSettings_adddomain'],
                'subtotal' => floatval(1000),
                'total' => floatval(1000),
                'status' => 'pending',
                'date_added' => date("Y-m-d H:i:s"),
                'last_updated' => date("Y-m-d H:i:s")
            );
            
            $order_id = $this->addon_domain_order_model->create_domain_orders($domain_order_data);
            userdata('domain_order_id', $order_id);
            userdata('site_id', $site_id);
            
            $return['responseCode'] = 0;
            $return['responseHTML'] = $this->load->view('adddomain', $this->data, true);
        } else {
            $temp['header'] = "Add Your Personal Domain";
            $temp['content'] = "Somthing wrong happen, please try again later";
            $return['responseCode'] = 0;
            $return['responseHTML'] = $this->load->view('error', array('data'=>$temp), true);
        }
        echo json_encode( $return );
    }
    
    public function addon_success()
    {
        if(!isset($_POST["txnid"])){
            redirect('/','location');
        }
        $this->load->config('payu_money', TRUE);
        $this->data['pageHeading'] = 'Add-on Domain';
        $this->data['pageMetaDescription'] = $this->router->fetch_class();
        $user_id = userdata('user_id');
        $user = $this->ion_auth_model->user($user_id)->result();
        $status = $_POST["status"];
        $firstname = $_POST["firstname"];
        $amount = $_POST["amount"];
        $txnid = $_POST["txnid"];
        $posted_hash = $_POST["hash"];
        $key = $_POST["key"];
        $productinfo = $_POST["productinfo"];
        $email = $_POST["email"];
        $salt = $this->config->item('SALT', 'payu_money');
        $this->data['name'] = $user[0]->first_name . ' ' . $user[0]->last_name;
        $order_id = $this->session->userdata['domain_order_id'];
        $site_id = $this->session->userdata['site_id'];
        
        If (isset($_POST["additionalCharges"])) {
            $additionalCharges = $_POST["additionalCharges"];
            $retHashSeq = $additionalCharges . '|' . $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        } else {
            $retHashSeq = $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        }
        $hash = hash("sha512", $retHashSeq);
        
        $domain_transaction_data = array(
            'order_id' => $order_id,
            'payment_gateway_name' => 'PayU Money',
            'payment_gateway_transaction_id' => $txnid,
            'payment_gateway_response' => $status,
            'date_added' => date("Y-m-d H:i:s")
        );
        if ($hash != $posted_hash) {
            $domain_transaction_data['status'] = 'invalid';
            $this->data['error'] = "Invalid Transaction. Please try again";
        } else {

            $this->data['status'] = $status;
            $this->data['txnid'] = $txnid;
            $this->data['amount'] = $amount;
            $domain_transaction_data['status'] = 'success';
            
            $domainId = $this->users_domains_model->create($site_id, $user_id, $productinfo, 'addonDomain');
        }
        $this->addon_domain_transaction_model->create_domain_transaction($domain_transaction_data);
        $this->template->load('main', 'domain', 'success', $this->data);
    }
    
    public function addon_failed()
    {
        if(!isset($_POST["txnid"])){
            redirect('/','location');
        }
        $this->load->config('payu_money', TRUE);
        $this->data['pageHeading'] = 'Add-on Domain';
        $this->data['pageMetaDescription'] = $this->router->fetch_class();
        $status = $_POST["status"];
        $firstname = $_POST["firstname"];
        $amount = $_POST["amount"];
        $txnid = $_POST["txnid"];
        $user_id = userdata('user_id');
        $user = $this->ion_auth_model->user($user_id)->result();
        $posted_hash = $_POST["hash"];
        $key = $_POST["key"];
        $productinfo = $_POST["productinfo"];
        $email = $_POST["email"];
        $salt = $this->config->item('SALT', 'payu_money');
        $this->data['name'] = $user[0]->first_name . ' ' . $user[0]->last_name;
        $order_id = $this->session->userdata['domain_order_id'];
        $site_id = $this->session->userdata['site_id'];

        If (isset($_POST["additionalCharges"])) {
            $additionalCharges = $_POST["additionalCharges"];
            $retHashSeq = $additionalCharges . '|' . $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        } else {

            $retHashSeq = $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        }
        $hash = hash("sha512", $retHashSeq);
        
        $domain_transaction_data = array(
            'order_id' => $order_id,
            'payment_gateway_name' => 'PayU Money',
            'payment_gateway_transaction_id' => $txnid,
            'payment_gateway_response' => $status,
            'date_added' => date("Y-m-d H:i:s")
        );
        
        if ($hash != $posted_hash) {
            $domain_transaction_data['status'] = 'invalid';
            $this->data['error'] = "Invalid Transaction. Please try again";
        } else {
            $domain_transaction_data['status'] = 'failed';
            $this->data['status'] = $status;
            $this->data['txnid'] = $txnid;
            $this->data['amount'] = $amount;
        }

        $this->addon_domain_transaction_model->create_domain_transaction($domain_transaction_data);
        $this->template->load('main', 'domain', 'failure', $this->data);
    }
    
    private function getContact()
    {
        $url = "https://test.httpapi.com/api/contacts/default.json?auth-userid={$this->auth_userid}&api-key={$this->api_key}&customer-id={$this->customer_id}&type=Contact";
        $data = $this -> _domainCallAPI( 'GET', $url );
        $data = json_decode($data,TRUE);
        if(!isset($data['status'])){
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
        if(!isset($datajson['status'])){
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
        curl_setopt( $curl, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, 0);
        $output = curl_exec( $curl );
		if(!$output){
			$output = json_encode(array(
				'status'=>'error',
				'message'=>curl_error($curl)
			));
			 
		}
        
		curl_close ( $curl );
		return $output;
    }
    
    private function _genrate_hash($posted)
    {
        $hashVarsSeq = explode('|', $this->hashSequence);
        $hash_string = '';
        foreach ($hashVarsSeq as $hash_var) {
            $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
            $hash_string .= '|';
        }
        $hash_string .= $this->_salt;

        return strtolower(hash('sha512', $hash_string));
    }

    private function _genrate_txnid()
    {
        return substr(hash('sha256', mt_rand() . microtime()), 0, 20);
    }
}
