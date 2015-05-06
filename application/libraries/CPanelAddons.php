<?php

/**
 * cPanel abstraction class
 */

/**
 * Basic management abstraction of cPanel's Addons via secured cPanel/WHM JSON API.
 *
 * Required PHP 5.2 or newer.
 * Required The cURL and JSON libraries.
 */
class CPanelAddons {

	/**
	 * cPanel full URL (w/ protocol, hostname, subdir)
	 * @var string
	 */
	private $_api;

	/**
	 * cPanel/WHM host name
	 * @var string
	 */
	private $_hostname;

	/**
	 * cPanel/WHM port number
	 * @var integer
	 */
	private $_port;

	/**
	 * cPanel account username
	 * @var string
	 */
	private $_username;

	/**
	 * cPanel account password
	 * @var string
	 */
	private $_password;

	/**
	 * Create FTP User with the domain flag
	 * @var boolean
	 */
	private $_createFTPUser;

	/**
	 * Constructor
	 * Check if required libraries are loaded
	 */
	public function __construct( $params )
	{
		if ( !in_array( 'curl', get_loaded_extensions() ) ) {
			throw new Exception( "cURL not loaded or installed!" );
		}
		if ( !in_array( 'json', get_loaded_extensions() ) ) {
			throw new Exception( "JSON not loaded or installed!" );
		}

// defaults
		$this -> setHostname($params['hostname'] );
		$this -> setLogin( $params['username'], $params['password'] );
		$this -> toggleFTPuser( false );
		isset($params['api']) ? $this -> _api = $params['api'] : $this -> _api = 'json';
		isset($params['port']) ? $this -> _port = $params['port'] : $this -> _port = '2083';
	}

	/**
	 * Set hostname of the cPanel
	 *
	 * @param string $hostname Hostname of the server
	 */
	public function setHostname( $hostname )
	{
		$this -> _hostname = $hostname;
	}

	/**
	 * Setup credential of the cPanel account
	 *
	 * @param string $username Username
	 * @param string $password Password
	 */
	public function setLogin( $username, $password )
	{
		$this -> _username = $username;
		$this -> _password = $password;
	}

	/**
	 * Set/Unset FTP flag for creation user w/ domain name
	 *
	 * @param boolean $hasFTP true if FTP Creation needed, false - otherwise
	 */
	public function toggleFTPuser( $hasFTP )
	{
		if ( is_bool( $hasFTP ) ) {
			$this -> _createFTPUser = $hasFTP;
		}
	}

	/**
	 * Get list of addon domains of the cPanel account
	 *
	 * @link http://docs.cpanel.net/twiki/bin/view/ApiDocs/Api2/ApiAddonDomain#AddonDomain::listaddondomains
	 * @return array List of subdomains w/ extend data
	 */
	public function getList()
	{
		$result = $this -> _api( array (
			'cpanel_jsonapi_apiversion' => 2,
			'cpanel_jsonapi_user' => $this -> _username,
			'cpanel_jsonapi_module' => 'AddonDomain',
			'cpanel_jsonapi_func' => 'listaddondomains'
				) );
		$json = json_decode( $result, true );
// error found?
		if ( !isset( $json['cpanelresult']['data'] ) ) {
			throw new Exception( "cPanel: Can't get domains list!" );
		}
		return $json['cpanelresult']['data'];
	}

	/**
	 * Add an addon domain
	 *
	 * @link http://docs.cpanel.net/twiki/bin/view/ApiDocs/Api2/ApiAddonDomain#AddonDomain::addaddondomain
	 * @param string $domain Valid domain name
	 * @param string $relativeDir Relative directory from /home/UserName/ root
	 * @param string $password Account ftp password for the domain
	 * @return array Output from the cPanel
	 */
	public function add( $domain, $relativeDir, $password = '', $subdomain = NULL )
	{
		$subDomain = explode( '.', $domain );
		if ( count( $subDomain ) < 2 ) {
			throw new Exception( "Invalid domain name!" );
		}
		if ( $subdomain ) {
			$subDomain = $subdomain;
		} else {
			$subDomain = $subDomain[0];
		}
		$result = $this -> _api( array (
			'cpanel_jsonapi_apiversion' => 2,
			'user' => $this -> _username,
			'cpanel_jsonapi_module' => 'AddonDomain',
			'cpanel_jsonapi_func' => 'addaddondomain',
			'newdomain' => $domain,
			'subdomain' => $subDomain,
			'dir' => $relativeDir
				) );
		$json = json_decode( $result, true );
// error found?
		if ( isset( $json['cpanelresult']['data'][0]['result'] ) && trim( $json['cpanelresult']['data'][0]['result'] ) == '0'
		) {
			throw new Exception( "cPanel: " . $json['cpanelresult']['data'][0]['reason'] );
		}
		/**
		 * Create FTP User
		 * @link http://docs.cpanel.net/twiki/bin/view/ApiDocs/Api2/ApiFtp#Ftp::addftp
		 */
		if ( $this -> _createFTPUser ) {
			$result = $this -> _api( array (
				'cpanel_jsonapi_apiversion' => 2,
				'cpanel_jsonapi_user' => $this -> _username,
				'cpanel_jsonapi_module' => 'Ftp',
				'cpanel_jsonapi_func' => 'addftp',
				'user' => $subDomain,
				'pass' => $password,
				'quota' => 0,
				'homedir' => $relativeDir
					) );
		}
		return $json;
	}
    
	/**
	 * Add an sub-domain
	 *
	 * @link http://docs.cpanel.net/twiki/bin/view/ApiDocs/Api2/ApiAddonDomain#SubDomain::addsubdomain
	 * @param string $domain Valid sub-domain name
	 * @param string $relativeDir Relative directory from /home/UserName/ root
	 * @param string $rootdomain root domain name
	 * @return array Output from the cPanel
	 */
	public function addSub( $domain, $relativeDir, $rootdomain )
	{
		$result = $this -> _api( array (
			'cpanel_jsonapi_apiversion' => 2,
			'user' => $this -> _username,
			'cpanel_jsonapi_module' => 'SubDomain',
			'cpanel_jsonapi_func' => 'addsubdomain',
			'domain' => $domain,
			'rootdomain' => $rootdomain,
			'dir' => $relativeDir
				) );
		$json = json_decode( $result, true );

		return $json;
	}
    
    
	/**
	 * Add an sub-domain
	 *
	 * @link http://docs.cpanel.net/twiki/bin/view/ApiDocs/Api2/ApiAddonDomain#SubDomain::addsubdomain
	 * @param string $domain Valid sub-domain name
	 * @param string $rootdomain root domain name
	 * @return array Output from the cPanel
	 */
	public function delSub( $domain, $rootdomain )
	{
		$result = $this -> _api( array (
			'cpanel_jsonapi_apiversion' => 2,
			'user' => $this -> _username,
			'cpanel_jsonapi_module' => 'SubDomain',
			'cpanel_jsonapi_func' => 'delsubdomain',
			'domain' => $domain.'.'.$rootdomain
				) );
		$json = json_decode( $result, true );

		return $json;
	}

	public function saveFile( $relativeDir, $content )
	{
		$result = $this -> _api( array (
			'cpanel_jsonapi_apiversion' => 2,
			'user' => $this -> _username,
			'cpanel_jsonapi_module' => 'Fileman',
			'cpanel_jsonapi_func' => 'savefile',
			'dir' => $relativeDir,
			'filename' => 'index.php',
			'charset' => 'utf-8',
			'content' => $content
				) );
		$json = json_decode( $result, true );
// error found?
		if ( isset( $json['cpanelresult']['data'][0]['result'] ) && trim( $json['cpanelresult']['data'][0]['result'] ) == '0' ) {
			throw new Exception( "cPanel: " . $json['cpanelresult']['data'][0]['reason'] );
		}
		return $json;
	}

	/**
	 * Delete an addon domain
	 *
	 * @link http://docs.cpanel.net/twiki/bin/view/ApiDocs/Api2/ApiAddonDomain#AddonDomain::deladdondomain
	 * @param string $domain Valid domain name
	 * @return array Output from the cPanel
	 */
	public function delete( $domain )
	{
		$subDomain = explode( '.', $domain );
		if ( count( $subDomain ) < 2 ) {
			throw new Exception( "Invalid domain name!" );
		}
// first get list of addon domains with extended attributes
		$list = $this -> getList();
		$domainKey = '';
		$fullSubDomain = '';
		$ftpUser = '';
		foreach ( $list as $addon ) {
			if ( $addon['domain'] !== $domain ) {
				continue;
			}
			$domainKey = $addon['domainkey'];
			$fullSubDomain = $addon['fullsubdomain'];
			$ftpUser = $addon['subdomain'];
			break;
		}
		$result = $this -> _api( array (
			'cpanel_jsonapi_apiversion' => 2,
			'cpanel_jsonapi_user' => $this -> _username,
			'cpanel_jsonapi_module' => 'AddonDomain',
			'cpanel_jsonapi_func' => 'deladdondomain',
			'domain' => $domain,
			'subdomain' => $domainKey,
			'fullsubdomain' => $fullSubDomain // undocument parameter!
				) );
		$json = json_decode( $result, true );
// error found?
		if ( isset( $json['cpanelresult']['data'][0]['result'] ) && trim( $json['cpanelresult']['data'][0]['result'] ) == '0'
		) {
			throw new Exception( "cPanel: " . $json['cpanelresult']['data'][0]['reason'] );
		}
		/**
		 * Delete FTP User
		 * @link http://docs.cpanel.net/twiki/bin/view/ApiDocs/Api2/ApiFtp#Ftp::delftp
		 */
		if ( $this -> _createFTPUser ) {
			$result = $this -> _api( array (
				'cpanel_jsonapi_apiversion' => 2,
				'cpanel_jsonapi_user' => $this -> _username,
				'cpanel_jsonapi_module' => 'Ftp',
				'cpanel_jsonapi_func' => 'delftp',
				'user' => $ftpUser,
				'destroy' => 0
					) );
		}
		return $json;
	}

	/**
	 * Check if domain exists on the server
	 *
	 * @param string $domain Valid domain name
	 * @return boolean True if success
	 */
	public function isExists( $domain )
	{
		$isExists = false;
		$subDomain = explode( '.', $domain );
		if ( count( $subDomain ) < 2 ) {
			throw new Exception( "Invalid domain name!" );
		}
        // first get list of addon domains with extended attributes
		$list = $this -> getList();
		foreach ( $list as $addon ) {
			if ( $addon['domain'] === $domain ) {
				$isExists = true;
				break;
			}
		}
		return $isExists;
	}

	/**
	 * Request to cPanel API via json (usign cURL)
	 *
	 * @param string $args Array of URL parameters (ie. module/func)
	 * @return array Output from the cPanel
	 */
	private function _api( $args = array () )
	{
		$path = '';
		switch ( $this -> _api ) {
			case 'json': $path = '/json-api/cpanel?';
				break;
			case 'xml': $path = '/xml-api/cpanel?';
				break;
		}
		$url = 'https://' . $this -> _hostname . ':' . $this -> _port;
		$url .= $path . http_build_query( $args, '', '&' );
        //$pass = base64_encode($this->_username . ":" . $this->_password);
        //$header = array();
		$header[0] = "Authorization: Basic " . base64_encode( $this -> _username . ":" . $this -> _password ) . "\n\r";
		$curl = curl_init();
		curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, 0 );
		curl_setopt( $curl, CURLOPT_SSL_VERIFYHOST, 0 );
		curl_setopt( $curl, CURLOPT_HEADER, 0 );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $curl, CURLOPT_HTTPHEADER, $header );
		curl_setopt( $curl, CURLOPT_URL, $url );
		if ( ($result = curl_exec( $curl )) === false ) {
			throw new Exception( "cURL: " . curl_error( $curl ) );
		}
		curl_close( $curl );
		return $result;
		$curl = curl_init();
        # Create Curl Object
		curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, 0 );
        # Allow self-signed certs
		curl_setopt( $curl, CURLOPT_SSL_VERIFYHOST, 0 );
        # Allow certs that do not match the hostname
		curl_setopt( $curl, CURLOPT_HEADER, 0 );
        # Do not include header in output
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
        # Return contents of transfer on curl_exec

		curl_setopt( $curl, CURLOPT_HTTPHEADER, $header );
        # set the username and password
		curl_setopt( $curl, CURLOPT_URL, $query );
        # execute the query
		$result = curl_exec( $curl );
		if ( $result == false ) {
			error_log( "curl_exec threw error \"" . curl_error( $curl ) . "\" for $query" );
            # log error if curl exec fails
		}
		curl_close( $curl );
	}

}
