<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions
| for sites modules
|
*/

//die('account');
$route['module_name'] = "account";
//$route['default_controller'] = "account";
//$route['plans'] = 'account/plans/index';
$route['plans/create'] = 'plans/editPlans';




