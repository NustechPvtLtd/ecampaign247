/**
 * This file is part of the Ecampaign247 application.
 * 
 * @package Ecampaign247
 * @author Nustech Pvt Ltd <info@nustech.com>
 * @link http://ecampaign247.com/
 * @copyright 2013-2014 Ecampaign247 (http://www.ecampaign247.com)
 * @license http://www.ecampaign247.com/license/
 * @since 1.0
 */
jQuery(document).ready(function($){
    
    $('ul.list-forms-nav li a').on('click', function(){
        var $lis = $('ul.list-forms-nav li');
        var $li = $(this).closest('li');
        if (!$li.is('.active')) {
            $lis.removeClass('active');
            $li.addClass('active');
            $('.form-container').hide();
            $($(this).attr('href')).show();
        }
        return false;
    });
});