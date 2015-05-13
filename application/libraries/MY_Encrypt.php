<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class MY_Encrypt extends CI_Encrypt
{
    function encode($string, $key = "", $url_safe = TRUE) {
        $ret = parent::encode($string, $key);

        if ($url_safe) {
            $ret = strtr($ret, array('+' => '.', '=' => '_', '/' => '~'));
        }

        return $ret;
    }

    function decode($string, $key = "") {
        $string = strtr($string, array('.' => '+', '_' => '=', '~' => '/'));
        return parent::decode($string, $key);
    }
}