<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions
| for customer modules
|
*/

$route['module_name'] = "customer";
$route['default_controller'] = 'customer';
$route['user'] = "customer/user/index";