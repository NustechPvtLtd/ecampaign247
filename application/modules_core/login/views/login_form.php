<?php echo form_open('login/index');?>
	<div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title">Please login</h3>
		</div>
		<div class="box-body">
			<div class="form-group">
				<div id="infoMessage"><?php echo $message;?></div>
			</div>
			<div class="clearfix"><!-- --></div>
			<div class="form-group">
				<?php echo lang('login_identity_label', 'identity');?>
				<?php echo form_input($identity);?>                              
			</div>
			<div class="form-group">
				<?php echo lang('login_password_label', 'password');?>
				<?php echo form_input($password);?>
			</div>
			<div class="form-group">
				<?php echo lang('login_remember_label', 'remember');?>
				<?php echo form_checkbox('remember', '1', FALSE, 'id="remember"');?>
			</div>
			<div class="clearfix"><!-- --></div>
		</div>
		<div class="box-footer">
			<div class="pull-left">
				<a class="btn btn-default" href="<?php echo base_url();?>index.php/forgot-password"><?php echo lang('login_forgot_password');?></a>
				<a class="btn btn-default" href="<?php echo site_url('register');?>">Register</a>
			</div>
			<div class="pull-right">
				<button data-loading-text="Please wait, processing..." class="btn btn-primary btn-submit" type="submit">Login</button>
			</div>
			<div class="clearfix"><!-- --></div>
		</div>
	</div>
<?php echo form_close();?>