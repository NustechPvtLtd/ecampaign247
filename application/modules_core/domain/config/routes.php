<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions
| for sites modules
|
*/

$route['module_name'] = "domain";
$route['default_controller'] = "domain";

$route['domain/([0-9]+?)'] = "domain/index/$1";

