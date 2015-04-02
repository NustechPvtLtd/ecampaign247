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
	
    var $extraRecipientsTemplate    = $('#extra-recipients-template');
    if ($extraRecipientsTemplate.length) {
        var extraRecipientsCounter = $extraRecipientsTemplate.data('count');
        $('a.btn-add-extra-recipients').on('click', function(){
            var $html = $($extraRecipientsTemplate.html().replace(/__#__/g, extraRecipientsCounter));
            $('#extra-list-segment-container').append($html);
            $html.find('input, select').removeAttr('disabled');
            extraRecipientsCounter++;
            return false;
        });
        
        $(document).on('click', 'a.remove-extra-recipients', function(){
            $(this).closest('.form-group').remove();
            return false;
        });
        
        $(document).on('change', '#extra-list-segment-container .col-list select', function(){
            var list_id = $(this).val();

    		var $segments = $(this).closest('div.form-group').find('.col-segment select');
    		var url = $segments.data('url');
    		$segments.html('');
    		
    		if (!list_id) {
    			$segments.attr('disabled', true);
    			return;
    		}
    		
    		$.get(url, {list_id: list_id}, function(json){
    				
    			if (typeof json.segments == 'object' && json.segments.length > 0) {
    				for (var i in json.segments) {
    					$segments.append($('<option/>').val(json.segments[i].segment_id).html(json.segments[i].name));
    				}	
    			}
    			
    		}, 'json');
    		
    		$segments.removeAttr('disabled'); 
        });
    }

	$('#Campaign_list_id').on('change', function(){
		var list_id = $(this).val();

		var $segments = $('select#Campaign_segment_id');
		var url = $segments.data('url');
		$segments.html('');
		
		//var subscribers_url = $(this).data('url');
		var subscribers_url = $segments.data('subscribersurl');
		var getlistuid_url = $(this).data('getlisturl');
		
		if (!list_id) {
			$('#Campaign_segment_id').attr('disabled', true);
			return;
		}
		
		$.get(url, {list_id: list_id}, function(json){
				
			if (typeof json.segments == 'object' && json.segments.length > 0) {
				for (var i in json.segments) {
					$segments.append($('<option/>').val(json.segments[i].segment_id).html(json.segments[i].name));
				}	
			}
			
		}, 'json');
		
		$.get(getlistuid_url, {list_id: list_id}, function(data){
			ajaxData['list_uid'] = data;
			$.post(subscribers_url+'?list_uid='+data, ajaxData, function(data){
				$('.list-subscribers').html(data);
			});
		});
		
		$('#Campaign_segment_id').removeAttr('disabled');
	});
	
	$('#Campaign_segment_id').on('change', function(){
		var list_id = $("#Campaign_list_id").find(':selected').val();

		var segment_id = $(this).val();
		var url = $(this).data('subscribersurl');
		var getSegmentUid_url = $(this).data('getsegmentuidurl');
		
		var getlistuid_url = $("#Campaign_list_id").data('getlisturl');
		var list_uid='';
		var segment_uid='';
		
		$.get(getlistuid_url, {list_id: list_id}, function(data){
			list_uid = data;
		}).done(function(){
			$.get(getSegmentUid_url, {segment_id: segment_id}, function(data){
				segment_uid = data;
			}).done(function(){
				if(segment_uid!='' && list_uid!=''){
					$.get(url+'?list_uid='+list_uid+'&segment_uid='+segment_uid, function(data){
						$('.list-subscribers').html(data);
					});
				}
			});
		});
	});
	
	$('a.load-selected').on('click', function(){
		var $select = $('select#CustomerEmailTemplate_template_id');
		
		if ($select.val() == '') {
			alert('Please select a template first!');
			return false;
		}
		$('#selected_template_id').val($select.val());
		$(this).closest('form').submit();
		return false;
	});
	
    var $sendAt = $('#Campaign_send_at'), 
        $displaySendAt = $('#Campaign_sendAt'),
        $fakeSendAt = $('#fake_send_at');
	
    if ($sendAt.length && $displaySendAt.length && $fakeSendAt.length) {

        $fakeSendAt.datetimepicker({
			format: $fakeSendAt.data('date-format') || 'yyyy-mm-dd hh:ii:ss',
			autoclose: true,
            language: $fakeSendAt.data('language') || 'en',
            showMeridian: true
		}).on('changeDate', function(e) {
            syncDateTime();
		}).on('blur', function(){
            syncDateTime();
		});
        
        $displaySendAt.on('focus', function(){
            $('#fake_send_at').datetimepicker('show');
        });
        
        function syncDateTime() {
            var date = $fakeSendAt.val();
            if (!date) {
                return;
            }
            $displaySendAt.val('').addClass('spinner');
            $.get($fakeSendAt.data('syncurl'), {date: date}, function(json){
                $displaySendAt.removeClass('spinner');
                $displaySendAt.val(json.localeDateTime);
                $sendAt.val(json.utcDateTime);
            }, 'json');
        }
        syncDateTime();
	}

	$(document).on('click', 'a.pause-sending, a.unpause-sending', function() {
		if (!confirm($(this).data('message'))) {
			return false;
		}
		$.post($(this).attr('href'), ajaxData, function(){
			window.location.reload();
		});
		return false;
	});
    
    $(document).on('click', 'a.copy-campaign', function() {
		$.post($(this).attr('href'), ajaxData, function(){
			window.location.reload();
		});
		return false;
	});
    
    $(document).on('click', 'a.check-spam-score', function(){
        var $this = $(this), $parent = $this.closest('td');
        $parent.empty().text($this.data('message'));
        $.post($this.attr('href'), ajaxData, function(json){
            $parent.empty().text(json.message);
        }, 'json');
        return false;
    });
    
    $(document).on('click', 'a.resume-campaign-sending', function() {
        if (!confirm($(this).data('message'))) {
			return false;
		}
		$.post($(this).attr('href'), ajaxData, function(){
			window.location.reload();
		});
		return false;
	});
    
    $('a.btn-remove-attachment').on('click', function(){
        var $this = $(this);
        if (!confirm($this.data('message'))) {
			return false;
		}
        
        $this.closest('.form-group').fadeOut('slow', function(){
            $(this).remove();
        });
        
        $.post($this.attr('href'), ajaxData, function(){
			
		});
        return false;
    });
    
    $('button.btn-plain-text').on('click', function(){
        var $this = $(this), 
            $container = $('.plain-text-version');
        
        if ($('.template-click-actions-container').is(':visible')) {
            $('button.btn-template-click-actions').trigger('click');
        }
        
        if (!$container.is(':visible')){
            $container.slideDown('slow', function(){
                $this.text($this.data('hidetext'));
            });
            $container.find('textarea').eq(0).focus();
        } else {
            $container.slideUp('slow', function(){
                $this.text($this.data('showtext'));
            });
            $this.blur();
        }
        
        return false;
    });
    
    $('button.btn-template-click-actions').on('click', function(){
        var $this = $(this), 
            $container = $('.template-click-actions-container');
        
        if ($('.plain-text-version').is(':visible')) {
            $('button.btn-plain-text').trigger('click');
        }
        
        if (!$container.is(':visible')){
            $container.slideDown('slow');
        } else {
            $container.slideUp('slow');
            $this.blur();
        }
        
        return false;
    });
    
	$(document).on('click', 'a.btn-template-click-actions-remove', function(){
		if ($(this).data('url-id') > 0 && !confirm($(this).data('message'))) {
			return false;
		}
		$(this).closest('.template-click-actions-row').fadeOut('slow', function() {
            $('button.btn-template-click-actions span.count').text(parseInt($('button.btn-template-click-actions span.count').text()) - 1);
			$(this).remove();
		});
		return false;
	});
	
    $('a.btn-template-click-actions-add').on('click', function(){
		var currentIndex = -1;
		$('.template-click-actions-row').each(function(){
			if ($(this).data('start-index') > currentIndex) {
				currentIndex = $(this).data('start-index');
			}
		});
		currentIndex++;
        var tpl = $('#template-click-actions-template').html();
		tpl = tpl.replace(/\{index\}/g, currentIndex);
		var $tpl = $(tpl);
		$('.template-click-actions-list').append($tpl);
		
		$tpl.find('.has-help-text').popover();
		$('button.btn-template-click-actions span.count').text(parseInt($('button.btn-template-click-actions span.count').text()) + 1);
		return false;	
	});
    
    //
    $('button.btn-template-click-actions-list-fields').on('click', function(){
        var $this = $(this), 
            $container = $('.template-click-actions-list-fields-container');
        
        if ($('.plain-text-version').is(':visible')) {
            $('button.btn-plain-text').trigger('click');
        }
        
        if (!$container.is(':visible')){
            $container.slideDown('slow');
        } else {
            $container.slideUp('slow');
            $this.blur();
        }
        
        return false;
    });
    
	$(document).on('click', 'a.btn-template-click-actions-list-fields-remove', function(){
		if ($(this).data('url-id') > 0 && !confirm($(this).data('message'))) {
			return false;
		}
		$(this).closest('.template-click-actions-list-fields-row').fadeOut('slow', function() {
            $('button.btn-template-click-actions-list-fields span.count').text(parseInt($('button.btn-template-click-actions-list-fields span.count').text()) - 1);
			$(this).remove();
		});
		return false;
	});
	
    $('a.btn-template-click-actions-list-fields-add').on('click', function(){
		var currentIndex = -1;
		$('.template-click-actions-list-fields-row').each(function(){
			if ($(this).data('start-index') > currentIndex) {
				currentIndex = $(this).data('start-index');
			}
		});
		currentIndex++;
        var tpl = $('#template-click-actions-list-fields-template').html();
		tpl = tpl.replace(/\{index\}/g, currentIndex);
		var $tpl = $(tpl);
		$('.template-click-actions-list-fields-list').append($tpl);
		
		$tpl.find('.has-help-text').popover();
		$('button.btn-template-click-actions-list-fields span.count').text(parseInt($('button.btn-template-click-actions-list-fields span.count').text()) + 1);
		return false;	
	});
    //
    
	$(document).on('click', 'a.btn-campaign-open-actions-remove', function(){
		if ($(this).data('action-id') > 0 && !confirm($(this).data('message'))) {
			return false;
		}
		$(this).closest('.campaign-open-actions-row').fadeOut('slow', function() {
            $(this).remove();
		});
		return false;
	});
	
    $('a.btn-campaign-open-actions-add').on('click', function(){
		var currentIndex = -1;
		$('.campaign-open-actions-row').each(function(){
			if ($(this).data('start-index') > currentIndex) {
				currentIndex = $(this).data('start-index');
			}
		});
		currentIndex++;
        var tpl = $('#campaign-open-actions-template').html();
		tpl = tpl.replace(/\{index\}/g, currentIndex);
		var $tpl = $(tpl);
		$('.campaign-open-actions-list').append($tpl);
		$tpl.find('.has-help-text').popover();
		return false;	
	});
    
    //
    $(document).on('click', 'a.btn-campaign-open-list-fields-actions-remove', function(){
		if ($(this).data('action-id') > 0 && !confirm($(this).data('message'))) {
			return false;
		}
		$(this).closest('.campaign-open-list-fields-actions-row').fadeOut('slow', function() {
            $(this).remove();
		});
		return false;
	});
	
    $('a.btn-campaign-open-list-fields-actions-add').on('click', function(){
		var currentIndex = -1;
		$('.campaign-open-list-fields-actions-row').each(function(){
			if ($(this).data('start-index') > currentIndex) {
				currentIndex = $(this).data('start-index');
			}
		});
		currentIndex++;
        var tpl = $('#campaign-open-list-fields-actions-template').html();
		tpl = tpl.replace(/\{index\}/g, currentIndex);
		var $tpl = $(tpl);
		$('.campaign-open-list-fields-actions-list').append($tpl);
		$tpl.find('.has-help-text').popover();
		return false;	
	});
    //
    
    if ($('#CampaignOption_autoresponder_event').length) {
        $('#CampaignOption_autoresponder_event').on('change', function(){
            var $this = $(this);
            if ($this.val() == 'AFTER-CAMPAIGN-OPEN') {
                $('#CampaignOption_autoresponder_open_campaign_id').closest('div').fadeIn();
            } else {
                $('#CampaignOption_autoresponder_open_campaign_id').closest('div').fadeOut();
            }
        });
    }
	
    $('#CampaignTemplate_only_plain_text').on('change', function(){
        var $this = $(this);
        if ($this.val() == 'yes') {
            $('#CampaignTemplate_auto_plain_text').val('yes').closest('div').hide();
            $('.btn-plain-text').hide();
            $('#CampaignTemplate_content').closest('div').hide();
            $('#CampaignTemplate_plain_text').closest('div').show();
        } else {
            $('#CampaignTemplate_auto_plain_text').val('yes').closest('div').show();
            $('.btn-plain-text').show();
            $('#CampaignTemplate_plain_text').closest('div').hide();
            $('#CampaignTemplate_content').closest('div').show();
        }
    });
    
    if ($('.circliful-graph').length) {
        $('.circliful-graph').circliful();
    }
    
    $("#Campaign_add_list").on('click',function(){
    	if($(this).is(':checked')) {
	        $(".target-list").show();  
	        $(".list-subscribers").show();
	        var count = $("#Campaign_list_id option").length;
	        if(count<=1){
	        	alert("You don't have any list to select, Please add list first!");
	        	$(this).prop('checked', false);
	        	$(".target-list").hide();
	        }
    	} else {
	        $(".target-list").hide();
	        $(".list-subscribers").hide();
	        $(".list-subscribers").html('');
	        $("#Campaign_list_id").find(':selected').removeAttr("selected");
	        $("#Campaign_list_id option[value='']").attr("selected", "selected");
	        $("#Campaign_segment_id").find(':selected').removeAttr("selected");
	        $("#Campaign_segment_id option[value='']").attr("selected", "selected");
    	}
    });

    $(document).on('click', '#select_all',function(event) {  //on click
        if(this.checked) { // check select status
            $('.bulk-select').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"              
            });
        }else{
            $('.bulk-select').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1"                      
            });        
        }
    });

    $(document).on('click', '.bulk-select',function(event) {  //on click
        if($('#select_all').is(':checked')) {
        	$('#select_all').prop('checked', false);
        }
    });
    
    if($("#Campaign_add_list").is(':checked')) {
        $(".target-list").show();  // checked
        var list_id = $("#Campaign_list_id").find(':selected').val();
        var segment_id = $("#Campaign_segment_id").find(':selected').val();
        var subscribers_url = $("#Campaign_segment_id").data('subscribersurl');
		var getlistuid_url = $("#Campaign_list_id").data('getlisturl');
		var getSegmentUid_url = $("#Campaign_segment_id").data('getsegmentuidurl');
		var list_uid = '';
		var segment_uid = '';
        if(list_id!='') {
        	$.get(getlistuid_url, {list_id: list_id}, function(data){
    			ajaxData['list_id'] = list_id;
    			list_uid = data
    		}).done(function(){
    			if(segment_id!='') {
    				$.get(getSegmentUid_url, {segment_id: segment_id}, function(data){
    					segment_uid = data;
    				}).done(function(){
						$.get(subscribers_url+'?list_uid='+list_uid+'&segment_uid='+segment_uid, function(data){
							$('.list-subscribers').html(data);
						});
    				});
    			} else {
    				$.get(subscribers_url+'?list_uid='+list_uid, function(data){
						$('.list-subscribers').html(data);
					});
    			}
    		});
        }
	}
});