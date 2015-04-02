<?php $this->load->view("shared/header.php");?>

<body class="login">
    
    <div class="container">
    
    	<div class="row">
    	
    		<div class="col-md-4 col-md-offset-4">
    		
    			<h2 class="text-center">
    				<?php echo $this->lang->line('login_sitetitle')?>
    			</h2>
    			
    			<!--<p><?php echo lang('login_subheading');?></p>-->
    			
    			<?php if( isset($message) && $message != '' ):?>
    			<div class="alert alert-success">
    				<button data-dismiss="alert" class="close fui-cross" type="button"></button>
    				<?php echo $message;?>
    			</div>
    			<?php endif;?>
    			    		
    			<form role="form" action="<?php echo site_url("auth/reset_password/".$code);?>" method="post">
    			
    				<?php echo form_input($user_id);?>
    				<?php echo form_hidden($csrf); ?>
    				
    				<div class="input-group">
    					<span class="input-group-btn">
    						 <button class="btn"><span class="fui-user"></span></button>
    					</span>
    			    	<input type="password" class="form-control" pattern="^.{8}.*$" id="new" value="" name="new" placeholder="Your new password">
   					</div>
   					
    			  	<div class="input-group">
    			  		<span class="input-group-btn">
    			  			 <button class="btn"><span class="fui-lock"></span></button>
    			  		</span>
    			  		<input type="password" class="form-control"  pattern="^.{8}.*$" id="new_confirm" value="" name="new_confirm" placeholder="Repeat your new password">
   					</div>
   					    			 	
    			  	<button type="submit" class="btn btn-primary btn-block"><?php echo lang('reset_password_submit_btn');?> <span class="fui-triangle-right-large"></span></button>
    			  	
    			  	<hr class="dashed light">
    			  	
    			</form>
    		
    		</div><!-- /.col -->
    	
    	</div><!-- /.row -->
    
    </div><!-- /.container -->
    

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
    <script src="<?php echo base_url();?>js/application.js"></script>
  </body>
</html>
