<?php

(defined('BASEPATH')) OR exit('No direct script access allowed');

/**
 * Description of plans
 *
 * @author NUSTECH
 */
class Plans extends MY_Controller {

    public $data = array();
    public $_salt;
    public $_url;
    public $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";

    function __construct()
    {
        parent::__construct();
        $this->form_validation->set_error_delimiters($this->config->item('error_start_delimiter', 'ion_auth'), $this->config->item('error_end_delimiter', 'ion_auth'));
        $this->load->library('PayUMoney');
        $this->lang->load('auth');
        $this->lang->load('plans');
        $this->load->model('account/plans_model');
        $this->load->model('account/account_upgrade_model');
        $this->data['title'] = ucfirst($this->router->fetch_class());
        $this->data['pageMetaDescription'] = $this->router->fetch_class() . '|' . $this->router->fetch_method();
    }

    function _remap($method, $args)
    {

        switch ($method) {
            case 'status':
                $this->change_status($method, $args);
                break;
            case 'visitor_count':
                $this->change_status($method, $args);
                break;
            case 'eccommerce':
                $this->change_status($method, $args);
                break;
            case 'premium_domain':
                $this->change_status($method, $args);
                break;
            case 'recommended':
                $this->change_status($method, $args);
                break;
            case 'success':
                $this->payment_success($args);
                break;
            case 'failure':
                $this->payment_failure($args);
                break;
            case 'cancel':
                $this->payment_cancel($args);
                break;
            case 'upgrade':
                $this->upgrade_account($args);
                break;
            default:
                if (empty($args)) {
                    $this->$method();
                } else {
                    $this->$method($args[0]);
                }

                break;
        }
    }

    public function index()
    {
        $this->data['pageHeading'] = 'Plans';
        $this->data['message'] = '';
        $this->data['css'] = array(
            '<link href="' . base_url() . 'assets/datatable/css/dataTables.bootstrap.css" type="text/css" rel="stylesheet">',
            '<link href="' . base_url() . 'assets/datatable/css/dataTables.responsive.css" type="text/css" rel="stylesheet">',
            '<style>td.child{text-align:left !important}</style>'
        );
        $this->data['js'] = array(
            '<script type="text/javascript" src="' . base_url() . 'assets/datatable/js/jquery.dataTables.min.js"></script>',
            '<script type="text/javascript" src="' . base_url() . 'assets/datatable/js/dataTables.bootstrap.js"></script>',
            '<script type="text/javascript" src="' . base_url() . 'assets/datatable/js/dataTables.responsive.js"></script>',
            '<script type="text/javascript" src="' . base_url() . 'assets/js/readmore.min.js"></script>',
            '<script>
$(".plan_description").readmore({
speed: 75,
maxHeight: 0,
collapsedHeight:50,
moreLink: \'<a href="#">Read More</a>\',
lessLink: \'<a href="#">Less</a>\',
startOpen: false,

});
</script>'
        );
        $this->data['plans'] = $this->plans_model->get_plans();

        $this->template->load('main', 'account', 'plans/plans', $this->data);
    }

    public function editPlans($plan_id = '')
    {
        $this->data['pageHeading'] = (!empty($plan_id)) ? 'Edit Plans' : 'Create Plans';
        $this->data['message'] = '';
        $plans = $this->plans_model->get_plans_by_id($plan_id);

        $this->form_validation->set_rules('plan_name', $this->lang->line('plan_name'), 'required');
        $this->form_validation->set_rules('plan_price', $this->lang->line('plan_price'), 'required|numeric');
        $this->form_validation->set_rules('plan_recommends', $this->lang->line('plan_recommends'), 'required');
        $this->form_validation->set_rules('plan_status', $this->lang->line('plan_status'), 'required');
        $this->form_validation->set_rules('discount', $this->lang->line('discount'), 'numeric');
        $this->form_validation->set_rules('expiration_type', $this->lang->line('expiration_type'), 'required');
        $this->form_validation->set_rules('expiration', $this->lang->line('expiration'), 'required|numeric');

        if (isset($_POST) && !empty($_POST)) {
            if ($this->form_validation->run() === TRUE) {
                if ($plans) {
                    $data = array(
                        'plan_id' => $plans->plan_id,
                        'name' => $this->input->post('plan_name'),
                        'price' => $this->input->post('plan_price'),
                        'description' => $this->input->post('plan_description'),
                        'recommended' => $this->input->post('plan_recommends'),
                        'status' => $this->input->post('plan_status'),
                        'discount' => $this->input->post('discount'),
                        'discount_type' => $this->input->post('discount_type'),
                        'expiration_type' => $this->input->post('expiration_type'),
                        'expiration' => $this->input->post('expiration'),
                        'visitor_count' => $this->input->post('visitor_count'),
                        'eccommerce' => $this->input->post('eccommerce'),
                        'premium_domain' => $this->input->post('premium_domain'),
                        'last_updated' => date("Y-m-d H:i:s")
                    );
                    $this->data['message'] = ($this->plans_model->update_plan($data)) ? 'Successfully Update Plan' : 'Something happen, please try again!';
                } else {
                    $data = array(
                        'name' => $this->input->post('plan_name'),
                        'price' => $this->input->post('plan_price'),
                        'description' => $this->input->post('plan_description'),
                        'recommended' => $this->input->post('plan_recommends'),
                        'status' => $this->input->post('plan_status'),
                        'discount' => $this->input->post('discount'),
                        'discount_type' => $this->input->post('discount_type'),
                        'expiration_type' => $this->input->post('expiration_type'),
                        'expiration' => $this->input->post('expiration'),
                        'visitor_count' => $this->input->post('visitor_count'),
                        'eccommerce' => $this->input->post('eccommerce'),
                        'premium_domain' => $this->input->post('premium_domain'),
                        'date_added' => date("Y-m-d H:i:s"),
                        'last_updated' => date("Y-m-d H:i:s")
                    );
                    $this->data['message'] = ($this->plans_model->create_plan($data)) ? 'Successfully Plan Created' : 'Something happen, please try again!';
                }
                redirect(site_url('/plans'), 'refresh');
            }
        }

        $this->data['plan_name'] = array(
            'name' => 'plan_name',
            'id' => 'plan_name',
            'type' => 'text',
            'value' => (isset($plans->name)) ? $this->form_validation->set_value('plan_name', $plans->name) : '',
            'class' => 'form-control',
        );
        $this->data['plan_description'] = array(
            'name' => 'plan_description',
            'id' => 'plan_description',
            'type' => 'textarea',
            'value' => (isset($plans->description)) ? $this->form_validation->set_value('plan_description', $plans->description) : '',
            'rows' => 10,
            'cols' => 6,
            'class' => 'form-control',
        );
        $this->data['plan_price'] = array(
            'name' => 'plan_price',
            'id' => 'plan_price',
            'type' => 'text',
            'value' => (isset($plans->price)) ? $this->form_validation->set_value('plan_price', $plans->price) : 0.0000,
            'class' => 'form-control',
            'onkeypress' => 'return isNumberKey(event)',
        );
        $this->data['plan_recommends'] = (isset($plans->recommended)) ? $this->form_validation->set_value('plan_recommends', $plans->recommended) : '';
        $this->data['plan_status'] = (isset($plans->status)) ? $this->form_validation->set_value('plan_status', $plans->status) : 'inactive';
        $this->data['visitor_count'] = (isset($plans->visitor_count)) ? $this->form_validation->set_value('visitor_count', $plans->visitor_count) : $this->form_validation->set_value('visitor_count', 'inactive');
        $this->data['eccommerce'] = (isset($plans->eccommerce)) ? $this->form_validation->set_value('eccommerce', $plans->eccommerce) : $this->form_validation->set_value('eccommerce', 'inactive');
        $this->data['premium_domain'] = (isset($plans->premium_domain)) ? $this->form_validation->set_value('premium_domain', $plans->premium_domain) : $this->form_validation->set_value('premium_domain', 'inactive');
        $this->data['discount_type'] = (isset($plans->discount_type)) ? $this->form_validation->set_value('discount_type', $plans->discount_type) : '';
        $this->data['discount'] = array(
            'name' => 'discount',
            'id' => 'discount',
            'type' => 'text',
            'value' => (isset($plans->discount)) ? $this->form_validation->set_value('discount', $plans->discount) : '',
            'class' => 'form-control',
            'onkeypress' => 'return isNumberKey(event)',
        );
        $this->data['expiration_type'] = (isset($plans->expiration_type)) ? $this->form_validation->set_value('expiration_type', $plans->expiration_type) : '';
        $this->data['expiration'] = array(
            'name' => 'expiration',
            'id' => 'expiration',
            'type' => 'number',
            'value' => (isset($plans->expiration)) ? $this->form_validation->set_value('expiration', $plans->expiration) : $this->form_validation->set_value('expiration', 0),
            'class' => 'form-control',
            'onkeypress' => 'return isNumberKey(event)',
        );

        $this->data['css'] = array(
            '<link href="' . base_url() . 'assets/redactor/redactor.css" type="text/css" rel="stylesheet">',
        );
        $this->data['js'] = array(
            '<script type="text/javascript" src="' . base_url() . 'assets/redactor/redactor.min.js"></script>',
        );
        $this->template->load('main', 'account', 'plans/edit_plans', $this->data);
    }

    public function deletePlans($plan_id)
    {
        if ($this->plans_model->delete_plan($plan_id)) {
            $this->data['message'] = 'Plan successfully deleted';
        } else {
            $this->data['message'] = 'Something happen, please try again!';
        }
        redirect(site_url('/plans'), 'refresh');
    }

    public function change_status($attributes, $arg)
    {

        $data = array(
            'plan_id' => $arg[0],
            $attributes => $arg[1],
            'last_updated' => date("Y-m-d H:i:s")
        );

        $this->data['message'] = ($this->plans_model->update_plan($data)) ? 'Successfully Update Plan' : 'Something happen, please try again!';
        redirect(site_url('/plans'), 'refresh');
    }

    public function payment_success()
    {
        $user = $this->ion_auth_model->user()->result();
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
        $plan_id = userdata('upgrade_plan_id');
        
        If (isset($_POST["additionalCharges"])) {
            $additionalCharges = $_POST["additionalCharges"];
            $retHashSeq = $additionalCharges . '|' . $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        } else {
            $retHashSeq = $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        }
        $hash = hash("sha512", $retHashSeq);

        if ($hash != $posted_hash) {
            $account_upgrade = array(
                'user_id' => $user[0]->id,
                'upgrade_by' => 'self',
                'notes' => "Invalid Transaction. Please try again",
                'upgrade_from' => $user[0]->price_plan_id,
                'upgrade_to' => $plan_id,
                'date' => time()
            );
            $this->data['error'] = "Invalid Transaction. Please try again";
        } else {

            $this->data['status'] = $status;
            $this->data['txnid'] = $txnid;
            $this->data['amount'] = $amount;
            
            $account_upgrade = array(
                'user_id' => $user[0]->id,
                'upgrade_by' => 'self',
                'notes' => $_POST["productinfo"],
                'upgrade_from' => $user[0]->price_plan_id,
                'upgrade_to' => $plan_id,
                'date' => time()
            );
            $data['price_plan_id'] = $plan_id;
            $user = $this->ion_auth_model->update($user[0]->id, $data);
        }
        $this->account_upgrade_model->account_upgrade($account_upgrade);
        $this->template->load('main', 'account', 'plans/success', $this->data);
    }

    public function payment_failure()
    {
        $status = $_POST["status"];
        $firstname = $_POST["firstname"];
        $amount = $_POST["amount"];
        $txnid = $_POST["txnid"];
        $user = $this->ion_auth_model->user()->result();
        $posted_hash = $_POST["hash"];
        $key = $_POST["key"];
        $productinfo = $_POST["productinfo"];
        $email = $_POST["email"];
        $salt = $this->config->item('SALT', 'payu_money');
        $this->data['name'] = $user[0]->first_name . ' ' . $user[0]->last_name;
        $plan_id = userdata('upgrade_plan_id');

        If (isset($_POST["additionalCharges"])) {
            $additionalCharges = $_POST["additionalCharges"];
            $retHashSeq = $additionalCharges . '|' . $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        } else {

            $retHashSeq = $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;
        }
        $hash = hash("sha512", $retHashSeq);

        if ($hash != $posted_hash) {
            $this->data['error'] = "Invalid Transaction. Please try again";
        } else {

            $this->data['status'] = $status;
            $this->data['txnid'] = $txnid;
            $this->data['amount'] = $amount;
        }
        $account_upgrade = array(
            'user_id' => $user[0]->id,
            'upgrade_by' => 'self',
            'notes' => "Payment failed.",
            'upgrade_from' => $user[0]->price_plan_id,
            'upgrade_to' => $plan_id,
            'date' => time()
        );
        $this->account_upgrade_model->account_upgrade($account_upgrade);
        $this->template->load('main', 'account', 'plans/failure', $this->data);
    }

    public function payment_cancel()
    {
        var_dump($_REQUEST);
    }

    public function upgrade_account()
    {
        $this->data['pageHeading'] = 'Payment Description';
        $this->data['message'] = '';
        $this->load->config('payu_money', TRUE);
        $user = $this->ion_auth_model->user()->result();
        if (!$user[0]->phone || !$user[0]->first_name) {
            userdata('complete_profile', TRUE);
            redirect('account/plans', 'location');
        }
        if (empty($_POST['plan_price'])) {
            redirect('account/plans', 'location');
        }
        $this->_salt = $this->config->item('SALT', 'payu_money');
        $this->_url = $this->config->item('PAYU_BASE_URL', 'payu_money');
        $this->data['key'] = $this->config->item('MERCHANT_KEY', 'payu_money');
        $this->data['surl'] = $this->config->item('PAYU_SUCCESS_URL', 'payu_money');
        $this->data['furl'] = $this->config->item('PAYU_FAILURE_URL', 'payu_money');
        $this->data['curl'] = $this->config->item('PAYU_CANCEL_URL', 'payu_money');
        $this->data['service_provider'] = 'payu_paisa';
        $this->data['txnid'] = $this->_genrate_txnid();
        $this->data['amount'] = floatval($_POST['plan_price']);
        $this->data['firstname'] = $user[0]->first_name;
        $this->data['lastname'] = $user[0]->last_name;
        $this->data['email'] = $user[0]->email;
        $this->data['phone'] = $user[0]->phone;

        $json_data = json_encode(array(
            "paymentParts" => array(
                "name" => $_POST['plan_name'],
                "description" => "Plan upgradation",
                "value" => $_POST['plan_price'],
                "isRequired" => "true",
                "settlementEvent" => "EmailConfirmation"
            ),
            "paymentIdentifiers" => array(
                "field" => "plan_id",
                "value" => $_POST['plan_id']
            )
        ));
        userdata('upgrade_plan_id', $_POST['plan_id']);
        $this->data['productinfo'] = "Plan upgraded to " . $_POST['plan_name'];
        $this->data['hash'] = $this->_genrate_hash($this->data);
        $this->data['action'] = $this->_url . '_payment';

        $this->template->load('main', 'account', 'plans/upgrade', $this->data);
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
