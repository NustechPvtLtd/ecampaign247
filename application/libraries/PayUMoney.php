<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of PayUMoney
 *
 * @author NUSTECH
 */

class PayUMoney {
    
    public $_salt;
    public $_url;
    public $hashSequence = "key|txnid|amount|productinfo|firstname|email|udf1|udf2|udf3|udf4|udf5|udf6|udf7|udf8|udf9|udf10";
    public $params;
    const SUCCESS = 1;
	const FAILURE = 0;
    
    public function __construct()
    {
        
        $this->load->config('payu_money', TRUE);
        $this->_salt = $this->config->item('SALT', 'payu_money');
        $this->_url = $this->config->item('PAYU_BASE_URL', 'payu_money');
        $this->params['key'] = $this->config->item('MERCHANT_KEY', 'payu_money');
        $this->params['surl'] = $this->config->item('PAYU_SUCCESS_URL', 'payu_money');
        $this->params['furl'] = $this->config->item('PAYU_FAILURE_URL', 'payu_money');
        $this->params['curl'] = $this->config->item('PAYU_CANCEL_URL', 'payu_money');
        $this->params['service_provider'] = 'payu_paisa';
    }
    
    /**
	 * __get
	 *
	 * Enables the use of CI super-global without having to define an extra variable.
	 *
	 * I can't remember where I first saw this, so thank you if you are the original author. -Militis
	 *
	 * @access	public
	 * @param	$var
	 * @return	mixed
	 */
	public function __get($var)
	{
		return get_instance()->$var;
	}
    
    public function pay($params = null)
    {
        if ( is_array( $params ) ) foreach ( $params as $key => $value )
			$this->params[$key] = $value;
        
		$this->params['txnid'] = $this->_genrate_txnid();

		$error = $this->check_params();
		
		if ( $error === true ) {
			$this->params['hash'] = $this->_genrate_hash( $this->params );
			$result = $this->_curl_call( $this->_url . '_payment', http_build_query( $this->params ) );

			$transaction_id = ($result['curl_status'] === self::SUCCESS) ? $result['result'] : null;
			
			if ( empty( $transaction_id ) ) return array ( 
				'status' => self::FAILURE, 
				'data' => $result['error'] );
			
			return array ( 
				'status' => self::SUCCESS, 
				'data' => $this->_url . '_payment_options?mihpayid=' . $transaction_id );
		} else {
			return array ( 'status' => self::FAILURE, 'data' => $error );
		}
    }
    
    public static function reverse_hash ( $params, $salt, $status )
	{
		$posted = array ();
		$hash_string = null;
		
		if ( ! empty( $params ) ) foreach ( $params as $key => $value )
			$posted[$key] = htmlentities( $value, ENT_QUOTES );
		
		$additional_hash_sequence = 'base_merchantid|base_payuid|miles|additional_charges';
		$hash_vars_seq = explode( '|', $additional_hash_sequence );
		
		foreach ( $hash_vars_seq as $hash_var )
			$hash_string .= isset( $posted[$hash_var] ) ? $posted[$hash_var] . '|' : '';
		
		$hash_sequence = "udf10|udf9|udf8|udf7|udf6|udf5|udf4|udf3|udf2|udf1|email|firstname|productinfo|amount|txnid|key";
		$hash_vars_seq = explode( '|', $hash_sequence );
		$hash_string .= $salt . '|' . $status;
		
		foreach ( $hash_vars_seq as $hash_var ) {
			$hash_string .= '|';
			$hash_string .= isset( $posted[$hash_var] ) ? $posted[$hash_var] : '';
		}
		
		return strtolower( hash( 'sha512', $hash_string ) );
	}
    
    private function _genrate_txnid(){
        return substr(hash('sha256', mt_rand() . microtime()), 0, 20);
    }
    
    private function _genrate_hash($posted){
        if(empty($posted['hash']) && sizeof($posted) > 0) {
            if(
                    empty($posted['key'])
                    || empty($posted['txnid'])
                    || empty($posted['amount'])
                    || empty($posted['firstname'])
                    || empty($posted['email'])
                    || empty($posted['phone'])
                    || empty($posted['productinfo'])
                    || empty($posted['surl'])
                    || empty($posted['furl'])
                    || empty($posted['service_provider'])
            ) {
                $formError = 1;
            } else {
                $hashVarsSeq = explode('|', $this->hashSequence);
                $hash_string = '';
                foreach($hashVarsSeq as $hash_var) {
                    $hash_string .= isset($posted[$hash_var]) ? $posted[$hash_var] : '';
                    $hash_string .= '|';
                }
                $hash_string .= $this->_salt;

                return strtolower(hash('sha512', $hash_string));
            }
          } elseif(!empty($posted['hash'])) {
            return $posted['hash'];
          }
    }
    
    private function check_params ()
	{
		if ( empty( $this->params['key'] ) ) return $this->error( 'key' );
		if ( empty( $this->params['txnid'] ) ) return $this->error( 'txnid' );
		if ( empty( $this->params['amount'] ) ) return $this->error( 'amount' );
		if ( empty( $this->params['firstname'] ) ) return $this->error( 'firstname' );
		if ( empty( $this->params['email'] ) ) return $this->error( 'email' );
		if ( empty( $this->params['phone'] ) ) return $this->error( 'phone' );
		if ( empty( $this->params['productinfo'] ) ) return $this->error( 'productinfo' );
		if ( empty( $this->params['surl'] ) ) return $this->error( 'surl' );
		if ( empty( $this->params['furl'] ) ) return $this->error( 'furl' );
		
		return true;
	}

	private function error ( $key )
	{
		return 'Mandatory parameter ' . $key . ' is empty';
	}
    
    private function _curl_call($url, $data ){
		
		$ch = curl_init();

		//set the url, number of POST vars, POST data
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 0);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 0);
        
        $output = curl_exec( $ch );
		if(curl_errno( $ch ) ){
			$c_error = curl_error( $ch );
			
			if ( empty( $c_error ) ) $c_error = 'Server Error';
			
			return array ( 'curl_status' => self::FAILURE, 'error' => $c_error );
		}
        
		curl_close ( $ch );
        $o = trim( $output );
		return array ( 'curl_status' => self::SUCCESS, 'result' => $o );
    }
}
