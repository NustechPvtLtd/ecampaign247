<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/**
 * Breadcrumb Helpers
 *
 * @package		Application
 * @subpackage	Helpers
 * @category	Helpers
 * @author		Nustech Dev Team
 */

// ------------------------------------------------------------------------

/**
 * create_breadcrumb
 *
 * Create breadcrumb from url
 *
 * @access	public
 * @return	link
 */
if(!function_exists('create_breadcrumb')){
    function create_breadcrumb(){
        $ci = &get_instance();
        $i=1;
        $uri = $ci->uri->segment($i);
        $link = '<ul class="breadcrumb">';
        while($uri != ''){
            $prep_link = '';
            for($j=1; $j<=$i;$j++){
                $prep_link .= $ci->uri->segment($j).'/';
            }
     
          if($ci->uri->segment($i+1) == ''){
            $link.='<li  class="active">';
            $link.=$ci->uri->segment($i).'</li>';
          }else{
            $link.='<li><a href="'.site_url($prep_link).'">';
            $link.=$ci->uri->segment($i).'</a><span class="divider"></span></li> ';
          }
     
          $i++;
          $uri = $ci->uri->segment($i);
          }
            $link .= '</ul>';
        return $link;
    }
}