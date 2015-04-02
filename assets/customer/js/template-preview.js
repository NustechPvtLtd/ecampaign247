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
	
	$('body').css({width: 600+'px', overflowY: 'hidden', margin: 0, padding: 0});
	
	$('a').on('click', function(){
		return false
	});
	
	if (isCanvasSupported() && $('meta[name=save-screenshot-url]').length) {
		
		if ($('meta[name=csrf-token-name]').length && $('meta[name=csrf-token-value]').length){
			var csrfTokenName = $('meta[name=csrf-token-name]').attr('content'),
				csrfTokenValue = $('meta[name=csrf-token-value]').attr('content');
			
			var ajaxData = {};
			ajaxData[csrfTokenName] = csrfTokenValue;
			$.ajaxSetup({
				data: ajaxData
			});
		}
		var $div = $('<div />').css({
			position: 'absolute',
			zIndex: 1000,
			width: 100+'%',
			top: 0,
			left: 0,
			height: 20+'px',
			background: '#A82C2A',
			color: '#ffffff',
			textAlign:'center',
			fontWeight: 'bold'
		}).text($('meta[name=wait-message]').attr('content'));
		
		$('body').before($div);
					
		if ($('meta[name=save-screenshot-url]').length) {
			html2canvas(document.body, {
				onrendered: function(canvas) {
					var data = canvas.toDataURL("image/png");
					$.ajax({
						type: 'POST',						
						url: $('meta[name=save-screenshot-url]').attr('content'),
						data: {data:data},
						async: false																													
					}).done(function(){
						$div.remove();
					});					
				}
			});	
		}	
	}
	
});

function isCanvasSupported(){
	var elem = document.createElement('canvas');
	return !!(elem.getContext && elem.getContext('2d'));
}