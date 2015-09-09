<?php

Class GetIP
{
	function get_ip_curl() {
		$url = "http://ipecho.net/plain";
		$curl = curl_init();
		curl_setopt( $curl, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
		curl_setopt( $curl, CURLOPT_USERPWD, "username:password" );
		curl_setopt( $curl, CURLOPT_URL, $url );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
        //curl_setopt( $curl, CURLOPT_SSL_VERIFYHOST, 0);
        //curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, 0);
		//exec('curl http://ipecho.net/plain; echo');
        $output = curl_exec( $curl );
        
		curl_close ( $curl );
		return $output;
	}
}

$getIp = new GetIP();
echo "IP is ";
print_r($getIp->get_ip_curl());
echo "</br>";