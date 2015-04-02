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
	
	var ajaxData = {};
	if ($('meta[name=csrf-token-name]').length && $('meta[name=csrf-token-value]').length) {
			var csrfTokenName = $('meta[name=csrf-token-name]').attr('content');
			var csrfTokenValue = $('meta[name=csrf-token-value]').attr('content');
			ajaxData[csrfTokenName] = csrfTokenValue;
	}
	
	$('a.btn-delete-template').on('click', function(){
		var $this = $(this);
		var confirmText = $this.data('confirm-text');
		if (!confirm(confirmText)) {
			return false;
		}
		
		$.post($this.attr('href'), ajaxData, function(){
			$this.closest('.panel-template-box').fadeOut('slow', function(){
				$(this).remove();
			});
		});
		return false;
	});
	
});