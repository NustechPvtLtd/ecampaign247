<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions
| for sites modules
|
*/

$route['module_name'] = "payment";
$route['default_controller'] = "payment";

$route['paypal'] = "payment/paypal";
