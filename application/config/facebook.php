<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$config['facebook_app_id']              = '753839294737173';
$config['facebook_app_secret']          = 'a8f34c91280b399acbe66007228b32dd';
$config['facebook_login_type']          = 'web';
$config['facebook_login_redirect_url']  = site_url('social/register_facebook');
$config['facebook_logout_redirect_url'] = site_url('example/logout');
$config['facebook_permissions']         = array('email', 'public_profile', 'publish_actions');
