<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions
| for sites modules
|
*/

$route['module_name'] = "sites";
$route['default_controller'] = "sites";

$route['sites/([0-9]+?)'] = "sites/site/$1";

$route['settings'] = "sites/configuration/index";
