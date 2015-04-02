<?php $this->load->view("shared/header.php");?>

<body>
  	
  	<?php $this->load->view("shared/nav.php");?>   
  	
    <div class="container-fluid">
    	
    	<div class="row">
    	
    		<div class="col-md-9 col-sm-8">
    	
		    	<h1><span class="fui-gear"></span> <?php echo $this->lang->line('settings_heading')?></h1>
    	
    		</div><!-- /.col -->
    		
    		<div class="col-md-3 col-sm-4 text-right">
    		
    		    
    		
    		</div><!-- /.col -->
    	
    	</div><!-- /.row -->
    	
    	<hr class="dashed margin-bottom-30">
    	
    	<div class="row">
    	
    		<div class="col-md-12">
    		
    			<ul class="nav nav-tabs nav-append-content">
					<li class="active"><a href="#appSettings"><span class="fui-gear"></span> <?php echo $this->lang->line('settings_tab_applicationsettings')?></a></li>
				</ul> <!-- /tabs -->
      	
				<div class="tab-content">
								
					<div class="tab-pane active" id="appSettings">
						
						<div class="row">
						
							<div class="col-md-8">
							
								<?php if( $this->session->flashdata('error') == '' && $this->session->flashdata('success') == '' ):?>
							
								<div class="alert alert-warning">
									<button type="button" class="close fui-cross" data-dismiss="alert"></button>
									<h4><?php echo $this->lang->line('settings_warning_heading')?></h4>
									<p>
										<?php echo $this->lang->line('settings_warning_message')?>
									</p>
								</div>
								
								<?php else:?>
								
									<?php if( $this->session->flashdata('error') != '' ):?>
									<div class="alert alert-error">
									<button type="button" class="close fui-cross" data-dismiss="alert"></button>
									<h4>Error</h4>
									<?php echo $this->session->flashdata('error');?>
									</div>
									<?php endif;?>
									
									<?php if( $this->session->flashdata('success') != '' ):?>
									<div class="alert alert-success">
									<button type="button" class="close fui-cross" data-dismiss="alert"></button>
									<h4>Success!</h4>
									<?php echo $this->session->flashdata('success');?>
									</div>
									<?php endif;?>
								
								<?php endif;?>
							
								<form class="form-horizontal settingsForm" role="form" id="settingsForm" method="post" action="<?php echo site_url('configuration/update')?>">
									<?php foreach( $settings as $configItem ):?>
									<div class="form-group">
										<label for="<?php echo $configItem->config_name;?>" class="col-sm-3 control-label"><?php echo $configItem->config_name;?> <?php if( $configItem->config_required == 1 ):?>*<?php endif;?></label>
										<div class="col-sm-9">
											<textarea class="form-control" name="<?php echo $configItem->config_name;?>" id="<?php echo $configItem->config_name;?>"><?php echo $configItem->config_value;?></textarea>
											<div class="settingDescription">
												<?php echo $configItem->config_description;?>
											</div>
										</div>
									</div>
									<?php endforeach;?>
									<div class="form-group">
										<div class="col-sm-offset-3 col-sm-9">
											<p class="text-danger">
											<?php echo $this->lang->line('settings_requiredfields');?>
											</p>
											<button type="submit" class="btn btn-primary btn-wide"><span class="fui-check"></span> <?php echo $this->lang->line('settings_button_update')?></button>
										</div>
									</div>
								</form>
							
							</div><!-- /.col -->
							
							<div class="col-md-4">
							
								<div class="alert alert-info configHelp" id="configHelp" data-spy="affix" data-offset-top="200">
									<button type="button" class="close fui-cross" data-dismiss="alert"></button>
									<div>
										<h4>
											<?php echo $this->lang->line('settings_confighelp_heading')?>
										</h4>
										<p>
											<?php echo $this->lang->line('settings_confighelp_message')?>
										</p>
									</div>
								</div>
							
							</div><!-- /.col -->
						
						</div><!-- /.row -->							
												
					</div>
      	
				</div> <!-- /tab-content -->
    		
    		</div><!-- /.col -->
    	
    	</div><!-- /.row -->
    	
    </div><!-- /.container -->
	
	
	
	<!-- modals -->
	
	<!-- Modal -->
		
	<?php $this->load->view("shared/modal_account.php");?> 
	
	<!-- /modals -->

	

    <!-- Load JS here for greater good =============================-->
    <script src="<?php echo base_url();?>js/jquery-1.8.3.min.js"></script>
    <script src="<?php echo base_url();?>js/jquery-ui-1.10.3.custom.min.js"></script>
    <script src="<?php echo base_url();?>js/jquery.ui.touch-punch.min.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap-select.js"></script>
    <script src="<?php echo base_url();?>js/bootstrap-switch.js"></script>
    <script src="<?php echo base_url();?>js/flatui-checkbox.js"></script>
    <script src="<?php echo base_url();?>js/flatui-radio.js"></script>
    <script src="<?php echo base_url();?>js/jquery.tagsinput.js"></script>
    <script src="<?php echo base_url();?>js/flatui-fileinput.js"></script>
    <script src="<?php echo base_url();?>js/jquery.placeholder.js"></script>
    <script src="<?php echo base_url();?>js/jquery.zoomer.js"></script>
    <script src="<?php echo base_url();?>js/application.js"></script>
    <script>
    $(function(){
    
    	$('.userSites .site iframe').each(function(){
    	    	
    		theHeight = $(this).attr('data-height')*0.25;
    		
    		//alert($(this).closest('.tab-pane').innerWidth())
    		    	    	
    		$(this).zoomer({
    			zoom: 0.25,
    			height: theHeight,
    			width: $(this).closest('.tab-pane').width(),
    			message: "",
    			messageURL: "<?php echo site_url('sites')?>/"+$(this).attr('data-siteid')
    		});
    		
    		$(this).closest('.site').find('.zoomer-cover > a').attr('target', '');
    	
    	})
    	
    	//set the width for the configHelp
	    $('.configHelp').width( $('.configHelp').width() )
    	    	
    	//help info
    	$('form.settingsForm textarea').focus(function(){
	    	
	    	$('#configHelp > div:first').html( $(this).next().html() );
	    	
	    	$('#configHelp').fadeIn(500);
	    	
	    	//set the width for the configHelp
	    	$('.configHelp').width( $('.configHelp').width() )
	    	
    	})
    	
    	$('form.settingsForm textarea').blur(function(){
	    	
	    	$('#configHelp').hide();
	    	
    	})
    
    });
    	    
    </script>
    <script>
    <?php $this->load->view("shared/js_sitesettings.php");?>
    </script>
    <script>
    <?php $this->load->view("shared/js_users.php");?>
    </script>
    <script>
    <?php $this->load->view("shared/js_account.php");?>
    </script>
  </body>
</html>