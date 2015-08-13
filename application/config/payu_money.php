<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/** 
 * Sandbox / Test Mode
 * -------------------------
 * TRUE means you'll be hitting PayU Money's sandbox/test servers.  FALSE means you'll be hitting the live servers.
 */
$config['Sandbox'] = TRUE;


/*
 * PayU Money Gateway API Credentials
 * ------------------------------
 * These are your PayU API credentials for working with the PayU gateway directly.
 * These are used any time you're using the parent PayU class within the library.
 * 
 * We're using shorthand if/else statements here to set both Sandbox and Production values.
 * Your sandbox values go on the left and your live values go on the right.
 * 
 */
$config['MERCHANT_ID'] = $config['Sandbox'] ? 4929338 : 'PRODUCTION_MERCHANT_ID_GOES_HERE';
$config['MERCHANT_KEY'] = $config['Sandbox'] ? 'KbubL1' : 'PRODUCTION_MERCHANT_KEY_GOES_HERE';
$config['SALT'] = $config['Sandbox'] ? 'OEoDQoL8' : 'PRODUCTION_SALT_GOES_HERE';
$config['PAYU_BASE_URL'] = $config['Sandbox'] ? 'https://test.payu.in/' : 'https://secure.payu.in/';
$config['PAYU_SUCCESS_URL'] = site_url('plans/success');
$config['PAYU_FAILURE_URL'] = site_url('plans/failure');
$config['PAYU_CANCEL_URL'] = site_url('plans/cancel');


/* End of file payumoney.php */
/* Location: ./system/application/config/payumoney.php */