$(function(){

		//listed to FTP form fields and check if we need to enable the test
    
    	$('.siteSettingsModalButton').click( function(e){
    	
    		e.preventDefault();
    		
    		$('#siteSettings').modal('show');
    		
    		//destroy all alerts
    		$('#siteSettings .alert').fadeOut(500, function(){
    		
    			$(this).remove();
    		
    		})
    		
    		
    		//set the siteID
    		$('input#siteID').val( $(this).attr('data-siteid') );
    		
    		
    		//destroy current forms
    		$('#siteSettings .modal-body-content > *').each(function(){
    			$(this).remove();
    		})
    		
    		
    		//show loader, hide rest
    		$('#siteSettingsWrapper .loader').show();
    		$('#siteSettingsWrapper > *:not(.loader)').hide();
    		
    		
    		//load site data using ajax
    		
    		$.ajax({
    			url: '<?php echo site_url('sites/siteAjax')?>/'+$(this).attr('data-siteid'),
    			type: 'post',
    			dataType: 'json'
    		}).done(function(ret){    			
    			
    			if( ret.responseCode == 0 ) {//error
    			
    				//hide loader, show error message
    				$('#siteSettings .loader').fadeOut(500, function(){
    					
    					$('#siteSettings .modal-alerts').append( $(ret.responseHTML) )
    				
    				})
    				
    				//disable submit button
    				$('#saveSiteSettingsButton').addClass('disabled');
    			
    			
    			} else if( ret.responseCode == 1 ) {//all well :)
    			
    				//hide loader, show data
    				
    				$('#siteSettings .loader').fadeOut(500, function(){
    				
    					$('#siteSettings .modal-body-content').append( $(ret.responseHTML) )
    				
    				})
    				
    				//enable submit button
    				$('#saveSiteSettingsButton').removeClass('disabled');
    			
    			}
    		
    		})
    	
    	} )

    	//browse FTP
    	
    	$('#siteSettings').on('click', '#siteSettingsBrowseFTPButton, .link', function(e){
    		
    		e.preventDefault();
    		
    		//got all we need?
    		
    		if( $('#siteSettings_ftpServer').val() == '' || $('#siteSettings_ftpUser').val() == '' || $('#siteSettings_ftpPassword').val() == '' ) {
    		
    			alert('Please make sure all FTP connection details are present');
    			
    			return false;
    		
    		}
    		
    		
    		//check if this is a deeper level link
    		if( $(this).hasClass('link') ) {
    			
    			if( $(this).hasClass('back') ) {
    			
    				$('#siteSettings_ftpPath').val( $(this).attr('href') );
    			
    			} else {
    			
    				//if so, we'll change the path before connecting
    			
    				if( $('#siteSettings_ftpPath').val().substr( $('#siteSettings_ftpPath').val.length - 1 ) == '/' ) {//prepend "/"
    				
    					$('#siteSettings_ftpPath').val( $('#siteSettings_ftpPath').val()+$(this).attr('href') );
    			
    				} else {
    				
    					$('#siteSettings_ftpPath').val( $('#siteSettings_ftpPath').val()+"/"+$(this).attr('href') );
    				
    				}
    			
    			}
    			
    			
    		}
    		
    		
    		//destroy all alerts
    		
    		$('#ftpAlerts .alert').fadeOut(500, function(){
    		
    			$(this).remove();
    		
    		})
    		
    		//disable button
    		$(this).addClass('disabled');
    		
    		//remove existing links
    		$('#ftpListItems > *').remove();
    		
    		//show ftp section
    		$('#ftpBrowse .loaderFtp').show();
    		$('#ftpBrowse').slideDown(500);

    		
    		theButton = $(this)
    		
    		$.ajax({
    			url: '<?php echo site_url('sites/ftpconnection/connect')?>',
    			type: 'post',
    			dataType: 'json',
    			data: $('form#siteSettingsForm').serializeArray()
    		}).done(function(ret){
    		
    			//enable button
    			theButton.removeClass('disabled');
    			
    			//hide loading
    			$('#ftpBrowse .loaderFtp').hide();
    		
    			if( ret.responseCode == 0 ) {//error
    			
    				$('#ftpAlerts').append( $(ret.responseHTML) )
    			
    			} else if( ret.responseCode == 1 ) {//all good
    			
    				$('#ftpListItems').append( $(ret.responseHTML) )
    			
    			}
    		
    		})
    	
    	});
    	
    	
    	//hide FTP browser
    	$('#siteSettings').on('click', '#ftpListItems .close', function(e){
    	
    		e.preventDefault();
    		
    		$(this).closest('#ftpBrowse').slideUp(500);
    	
    	});
    	
    	
    	//test FTP connection
    	$('#siteSettings').on('click', '#siteSettingsTestFTP', function(){
    	    	
    		//got all we need?
    		
    		if( $('#siteSettings_ftpServer').val() == '' || $('#siteSettings_ftpUser').val() == '' || $('#siteSettings_ftpPassword').val() == '' ) {
    		
    			alert('Please make sure all FTP connection details are present');
    			
    			return false;
    		
    		}
    		
    		
    		//destroy all alerts
    		
    		$('#ftpTestAlerts .alert').fadeOut(500, function(){
    		
    			$(this).remove();
    		
    		})
    		
    		//disable button
    		$(this).addClass('disabled');
    		
    		
    		//show loading indicator
    		
    		$(this).next().fadeIn(500);
    		
    		
    		theButton = $(this)
    		
    		$.ajax({
    			url: '<?php echo site_url('sites/ftpconnection/test')?>',
    			type: 'post',
    			dataType: 'json',
    			data: $('form#siteSettingsForm').serializeArray()
    		}).done(function(ret){
    		    		
    			//enable button
    			theButton.removeClass('disabled');
    			
    			theButton.next().fadeOut(500);
    			    		
    			if( ret.responseCode == 0 ) {//error
    			
    				$('#ftpTestAlerts').append( $(ret.responseHTML) )
    			
    			} else if( ret.responseCode == 1 ) {//all good
    			
    				$('#ftpTestAlerts').append( $(ret.responseHTML) )
    			
    			}
    		
    		})
    	
    	})    

	
	var toDel;
	var delButton;
	
	//delete site button/modal
	$('.deleteSiteButton').click(function(e){
	
		e.preventDefault();
		
		$('#deleteSiteModal .modal-content p').show();
		
		//remove old alerts
		$('#deleteSiteModal .modal-alerts > *').remove();
		
		$('#deleteSiteModal .loader').hide();
		
	
		toDel = $(this).closest('.site');
		delButton = $(this);
		
		
		$('#deleteSiteModal button#deleteSiteButton').show();
	
		$('#deleteSiteModal').modal('show');
		
		$('#deleteSiteModal button#deleteSiteButton').unbind('click').click(function(){
		
			$(this).addClass('disabled');
					
			$('#deleteSiteModal .loader').fadeIn(500);
		
			$.ajax({
				url: '<?php echo site_url('sites/trash')?>/'+delButton.attr('data-siteid'),
				type: 'post',
				dataType: 'json'
			}).done(function(ret){
			
				$('#deleteSiteModal .loader').hide();
				
				$('#deleteSiteModal button#deleteSiteButton').removeClass('disabled');
			    		
				if( ret.responseCode == 0 ) {//error
				
					$('#deleteSiteModal .modal-content p').hide();
					
					$('#deleteSiteModal .modal-alerts').append( $(ret.responseHTML) )
					
				
				} else if( ret.responseCode == 1 ) {//all good
				
					$('#deleteSiteModal .modal-content p').hide();
					
					$('#deleteSiteModal .modal-alerts').append( $(ret.responseHTML) )
					
					$('#deleteSiteModal button#deleteSiteButton').hide();
				
					toDel.fadeOut(800, function(){
					
						$(this).remove();		
						
					})
				
				
				}
			
			})	
				
		
		})
	
	})
	  
})