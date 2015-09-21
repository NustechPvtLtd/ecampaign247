<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

class Products extends MX_Controller {

    public $data = array();
    public $_salt;
    public $_url;
    public $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";

    function __construct()
    {
        
        parent::__construct();
        $this->load->database();
        $this->load->library('template');
//		$this->load->library('ion_auth');
        $this->load->library('PayUMoney');
        $this->data['title'] = $this->router->fetch_method();
        $this->data['pageMetaDescription'] = $this->router->fetch_class() . '-' . $this->router->fetch_method();
    }


    // get selected product details using product id
    public function buynow()
    {
        $productid = $_GET['pid'];

        $this->load->model('products/productsmodel');

        $this->load->config('payu_money', TRUE);
        $this->_salt = $this->config->item('SALT', 'payu_money');
        $this->_url = $this->config->item('PAYU_BASE_URL', 'payu_money');
        $this->data['key'] = $this->config->item('MERCHANT_KEY', 'payu_money');
        $this->data['surl'] = site_url('products/success');
        $this->data['furl'] = site_url('products/failure');
        $this->data['curl'] = site_url('products/cancel');
        $this->data['service_provider'] = 'payu_paisa';

        //  $this->data['amount'] = floatval(59);
//        $this->data['firstname'] = 'shubhangee';
//        $this->data['lastname'] = 'kadu';
//        $this->data['email'] ='shubhangee@nustech.com';
//        $this->data['phone'] = '9049970237';

        $this->data['productinfo'] = "product";

        $this->data['txnid'] = $this->_genrate_txnid();
        $this->data['hash'] = $this->_genrate_hash($this->data);
        $this->data['action'] = $this->_url . '_payment';

        $this->data['result'] = $this->productsmodel->buynow($productid);

        $this->data['country'] = $this->productsmodel->get_country();

        $this->data['Heading'] = 'Buy Now';

        $this->data['pageHeading'] = 'Buy Now';

        $this->data['product_id'] = $productid;

        $this->data['css'] = array(
            '<link href="' . base_url() . '/elements/css/ecommerce.css" rel="stylesheet">'
        );

        $this->template->load('ecommerce', 'products', 'index', $this->data);
    }

    function getnewhash()
    {
        $transaction_id = $_POST['transaction_id'];

        $this->load->config('payu_money', TRUE);
        $this->_salt = $this->config->item('SALT', 'payu_money');
        $this->_url = $this->config->item('PAYU_BASE_URL', 'payu_money');
        $this->data['key'] = $this->config->item('MERCHANT_KEY', 'payu_money');
        $this->data['surl'] = site_url('products/success');
        $this->data['furl'] = site_url('products/failure');
        $this->data['curl'] = site_url('products/cancel');
        $this->data['service_provider'] = 'payu_paisa';

        $customer_orders = $query = $this->db->query("select * from customer_orders where transaction_id='" . $transaction_id . "' ");
        $crows = $customer_orders->result();
        foreach ($crows as $crows) {
            $uid = $crows->customer_id;
            $this->data['amount'] = $crows->amount;
        }

        $user = $query = $this->db->query("select * from customer_details where id='" . $uid . "' ") or die(mysql_error());
        $urows = $user->result();
        ;
        foreach ($urows as $urows) {

            $this->data['firstname'] = $urows->firstname;
            $this->data['lastname'] = $urows->lastname;
            $this->data['email'] = $urows->email;
            $this->data['phone'] = $urows->phone;
        }

        $this->data['productinfo'] = "product";

        $this->data['txnid'] = $transaction_id;

        echo $this->_genrate_hash($this->data);
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

    public function proceedetocheckout()
    {
        $this->load->model('products/productsmodel');

		$this->productsmodel->proceedetocheckout();

    }

    //.........function to generate transaction id
    private function _genrate_txnid()
    {
        return substr(hash('sha256', mt_rand() . microtime()), 0, 20);
    }

    public function get_state($country)
    {
        $this->load->model('products/productsmodel');

        $result = $this->productsmodel->get_state_by_country($country);
        return $this->output->set_content_type('application/json')
                        ->set_output(json_encode($result));
    }

    //................function for payment successfull
    public function success()
    {
        if (empty($_POST)) {
            redirect(site_url('account/plans'), 'refresh');
        }

        $status = $_POST["status"];
        $firstname = $_POST["firstname"];
        $amount = $_POST["amount"];
        $txnid = $_POST["txnid"];
        $posted_hash = $_POST["hash"];
        $key = $_POST["key"];
        $productinfo = $_POST["productinfo"];
        $email = $_POST["email"];
        $salt = $this->config->item('SALT', 'payu_money');

        if (isset($_POST["additionalCharges"])) {
            $additionalCharges = $_POST["additionalCharges"];
            $retHashSeq = $additionalCharges . '|' . $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        } else {
            $retHashSeq = $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        }

        $hash = hash("sha512", $retHashSeq);

        $st = "";
        if ($hash != $posted_hash) {
            $plan_transaction_data['status'] = 'invalid';
            $this->data['error'] = "Invalid Transaction. Please try again";
        } else {
            $this->data['status'] = $status;
            $this->data['txnid'] = $txnid;
            $this->data['amount'] = $amount;
            $st = "success";

            $this->load->model('products/productsmodel');

            $this->productsmodel->successfull_purchase($txnid, $firstname, $email);
        }

        $this->data['name'] = $firstname;

        $this->load->model('products/productsmodel');

        $this->productsmodel->success($txnid, $st);

        $this->data['result'] = $this->productsmodel->getprodctorder($txnid);

        $this->template->load('ecommerce', 'products', 'success', $this->data);
    }

    //..............function for payment failure
    public function failure()
    {
        if (empty($_POST)) {
            redirect(site_url('account/plans'), 'refresh');
        }

        $status = $_POST["status"];
        $firstname = $_POST["firstname"];
        $amount = $_POST["amount"];
        $txnid = $_POST["txnid"];
        $posted_hash = $_POST["hash"];
        $key = $_POST["key"];
        $productinfo = $_POST["productinfo"];
        $email = $_POST["email"];
        $salt = $this->config->item('SALT', 'payu_money');

        if (isset($_POST["additionalCharges"])) {
            $additionalCharges = $_POST["additionalCharges"];
            $retHashSeq = $additionalCharges . '|' . $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        } else {
            $retHashSeq = $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        }

        $hash = hash("sha512", $retHashSeq);

        $st = "";
        if ($hash != $posted_hash) {
            $plan_transaction_data['status'] = 'invalid';
            $this->data['error'] = "Invalid Transaction. Please try again";
        } else {
            $this->data['status'] = $status;
            $this->data['txnid'] = $txnid;
            $this->data['amount'] = $amount;
            $st = "failed";
        }

        $this->data['name'] = $firstname;

        $this->load->model('products/productsmodel');

        $this->productsmodel->success($txnid, $st);

        $this->data['result'] = $this->productsmodel->getprodctorder($txnid);

        $this->template->load('ecommerce', 'products', 'failure', $this->data);
    }

    public function cancel()
    {
        echo "cancel";
    }

}
