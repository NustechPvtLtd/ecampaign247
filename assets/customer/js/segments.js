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
	var segmentConditionsIndex = $('.conditions-container .item').length, 
		$segmentConditionsTemplate = $('#condition-template');
	
	$('.btn-add-condition').on('click', function(){
		var html = $segmentConditionsTemplate.html();
		html = html.replace(/\{index\}/g, segmentConditionsIndex);
		$('.conditions-container').append(html);
		$('.btn-show-segment-subscribers').hide();
		++segmentConditionsIndex;
		return false;
	});
	
	$(document).on('click', '.btn-remove-condition', function(){
		$(this).closest('.item').remove();
		$('.btn-show-segment-subscribers').hide();
		return false;
	});
	
	$('.btn-show-segment-subscribers').on('click', function(){
		var $this = $(this);
		$this.button('loading');
		$.get($this.attr('href'), {}, function(html){
			$('#subscribers-wrapper').html(html);
			$('.subscribers-wrapper').show();
			$this.button('reset');
			$this.hide();
		});
		return false;
	});
	
	$(document).on('click', 'ul#subscribers-pagination li a', function(){
		$.get($(this).attr('href'), {}, function(html){
			$('#subscribers-wrapper').html(html);
			$('.subscribers-wrapper').show();
		});
		return false;
	});
	
    $(document).on('click', 'a.copy-segment', function() {
		$.post($(this).attr('href'), ajaxData, function(){
			window.location.reload();
		});
		return false;
	});
});