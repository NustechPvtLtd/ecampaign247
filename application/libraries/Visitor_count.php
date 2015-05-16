<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/**
 * Description of Visitor Count
 *
 * @author NUSTECH
 */
class Visitor_count {
	/*  Your API Details  */
	/*	 * ******************* */

	public $api_id = "id18531";
	public $api_key = "857780186-867883885-288849783";
	public $api_url = "http://api.myip.ms";

    /**
	 * __construct
	 *
	 * @return void
	 **/
	public function __construct()
	{
		$this->load->model('visitor/visitor_count_model');
	}
    
    /**
	 * __call
	 *
	 * Acts as a simple way to call model methods without loads of stupid alias'
	 *
	 **/
	public function __call($method, $arguments)
	{
		if (!method_exists( $this->visitor_count_model, $method) )
		{
			throw new Exception('Undefined method Visitor_count::' . $method . '() called');
		}

		return call_user_func_array( array($this->visitor_count_model, $method), $arguments);
	}

	/**
	 * __get
	 *
	 * Enables the use of CI super-global without having to define an extra variable.
	 *
	 *
	 * @access	public
	 * @param	$var
	 * @return	mixed
	 */
	public function __get($var)
	{
		return get_instance()->$var;
	}
    
    /**
     * Visitor
     * Create and update the visitor counter for specific page
     * 
     * @access public
     * @param string $ip_address ip address of visitor
     * @param int $site_id visited site id
     * @param int $page_id visited page id
     * @param string $page_url visited page url
     */
	public function visitors( $ip_address, $site_id, $page_id, $page_url )
	{
		$ip = ip2long( $ip_address );
//        long2ip($ip);

		try {
			if ( !$this-> visitor_count_model-> find($ip, $site_id, $page_id ) ) {
				$geoLocation = $this -> getWhoIs( $ip_address );
                $data = array(
                    'site_id' => $site_id,
                    'page_id' => $page_id,
                    'visitor_ip' => $ip,
                    'page_url' => $page_url,
                    'hitcount' => 1
                );
                isset( $geoLocation -> isp ) ? $data['isp'] = $geoLocation -> isp : '';
				isset( $geoLocation -> city ) ? $data['city'] = $geoLocation -> city : '';
				isset( $geoLocation -> country ) ? $data['country'] = $geoLocation -> country : '';
				isset( $geoLocation -> regionName ) ? $data['region'] = $geoLocation -> regionName : '';
				isset( $geoLocation -> lon ) ? $data['longitude'] = $geoLocation -> lon : '';
				isset( $geoLocation -> lat ) ? $data['latitude'] = $geoLocation -> lat : '';
				isset( $geoLocation -> countryCode ) ? $data['country_code'] = strtolower( $geoLocation -> countryCode ) : '';
				isset( $geoLocation -> zip ) ? $data['zipcode'] = $geoLocation -> zip : '';
				if ( $this-> visitor_count_model-> create_visitor($data) ) {
                    $this->session->set_userdata('current_page', $page_url);
				}
			} else {
				$hit = $this-> visitor_count_model-> find($ip, $site_id, $page_id ) -> hitcount;
				$hitcount = 1 + $hit;
                $session =  $this->session->userdata('current_page');
				if ( !isset( $session ) ) {
					$this-> visitor_count_model-> update( $ip, $site_id, $page_id, $hitcount );
					$this->session->set_userdata('current_page', $page_url);
				} elseif ( $session != $page_url ) {
					$this-> visitor_count_model-> update( $ip, $site_id, $page_id, $hitcount );
					$this->session->set_userdata('current_page', $page_url);
				}
			}
		} catch ( Exception $ex ) {
			return $ex->getTraceAsString();
		}
	}

	public function getGeoLocation( $ip )
	{
		$curl = curl_init();
		// Set some options - we are passing in a useragent too here
		curl_setopt_array( $curl, array (
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => 'http://www.telize.com/geoip/' . $ip
		) );
		// Send the request & save response to $resp
		$resp = curl_exec( $curl );
		// Close request to clear up some resources
		curl_close( $curl );
		return json_decode( $resp );
//        echo $resp;
	}

	public function getWhoIs( $ip )
	{
		$curl = curl_init();
		// Set some options - we are passing in a useragent too here
		curl_setopt_array( $curl, array (
			CURLOPT_RETURNTRANSFER => 1,
            CURLOPT_URL => 'http://ip-api.com/json/'.$ip
		) );
		// Send the request & save response to $resp
		$resp = curl_exec( $curl );
		// Close request to clear up some resources
		curl_close( $curl );
//        echo $resp;
		return json_decode( $resp );
	}

	public function getMachinDetail( $ip )
	{

		$url = $this -> create_api_url( $ip, $this -> api_id, $this -> api_key, $this -> api_url );
//	$data = file_get_contents($url); // get data from myip.ms
//   	$arr  = json_decode($data, true);
		$curl = curl_init();
		// Set some options - we are passing in a useragent too here
		curl_setopt_array( $curl, array (
			CURLOPT_RETURNTRANSFER => 1,
			CURLOPT_URL => $url
		) );
		// Send the request & save response to $resp
		$resp = curl_exec( $curl );
		// Close request to clear up some resources
		curl_close( $curl );
		return json_decode( $resp, TRUE );
	}

	private function create_api_url( $query, $api_id, $api_key, $api_url, $timestamp = '' )
	{
		$url = "";
		if ( !$timestamp ) {
			$timestamp = gmdate( "Y-m-d_H:i:s" );
		}
		if ( trim( $query ) != '' ) {
			$url = $api_url . "/" . $query . '/api_id/' . $api_id . '/api_key/' . $api_key;
			$signature = md5( $url . '/timestamp/' . $timestamp );
			$url .= '/signature/' . $signature . '/timestamp/' . $timestamp;
		}
		return $url;
	}

}
