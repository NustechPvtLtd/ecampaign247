<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
$config['api_id'] = '753839294737173';
$config['app_secret'] = 'a8f34c91280b399acbe66007228b32dd';
$config['redirect_url'] = site_url('social_media/register_facebook');
$config['permissions'] = array(
  'email',
  'user_location',
  'user_birthday',
  'publish_actions'
);
