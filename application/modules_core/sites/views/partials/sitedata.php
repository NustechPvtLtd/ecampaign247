<form class="form-horizontal" role="form" id="siteSettingsForm">
	
		<input type="hidden" name="siteID" id="siteID" value="<?php echo $data['site']->sites_id;?>">

		<div id="siteSettingsWrapper" class="siteSettingsWrapper">
		        			
			<div class="optionPane">
				
				<h6><?php echo $this->lang->line('sitedata_sitedetails')?></h6>
				
				<div class="form-group">
					<label for="name" class="col-sm-3 control-label"><?php echo $this->lang->line('sitedata_label_name')?></label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="siteSettings_siteName" name="siteSettings_siteName" placeholder="<?php echo $this->lang->line('sitedata_label_name')?>" value="<?php echo $data['site']->sites_name;?>">
					</div>
				</div>
				
			</div><!-- /.optionPane -->     				
			
			<div class="optionPane">
			
				<h6><?php echo $this->lang->line('sitedata_publishingdetails')?></h6>
			
				<div class="form-group">
					<label for="server" class="col-sm-3 control-label"><?php echo $this->lang->line('sitedata_label_domain')?></label>
					<div class="col-sm-9">
						<input type="text" class="form-control" id="siteSettings_domain" name="siteSettings_domain" placeholder="<?php echo $this->lang->line('sitedata_label_domain_placeholder')?>" value="<?php echo $data['site']->domain;?>">
                        <span id="publicURL"></span>
					</div>
				</div>

			</div><!-- ./optionPane -->
			
		</div><!-- /.siteSettingsWrapper -->
	
	</form>
    <script>
        $(document).ready(function(){
            $('#siteSettings_domain').keyup(function() {
                if (/^[a-z0-9]{3,}$/i.test($(this).val())) {
                    $.ajax({
                        type: 'POST',
                        url: "<?php echo site_url('sites/checkDomain')?>",
                        data: {domain: $(this).val().toLowerCase()},
                        success: function(res){
                            if (res.error == 0) {
                                $('#publicURL').text(res.errorMessage).css('color','green');
                            }
                            if (res.error == 1) {
                                $('#publicURL').text(res.errorMessage).css('color','red');
                            }
                        },
                        dataType: "JSON",
                        async:false
                    });
                } else {
                    $('#publicURL').text('Domain names can only contain letters and numbers').css('color','red');
                }
            });
        });
    </script>