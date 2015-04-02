<?php echo form_open('login/forgot_password');?>
	<div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title"><?php echo lang('forgot_password_heading');?></h3>
		</div>
		<div class="box-body">
			<div class="form-group">
				<div id="infoMessage"><?php echo $message;?></div>
			</div>
			<div class="clearfix"><!-- --></div>
			<div class="form-group">
				<label for="email"><?php echo sprintf(lang('forgot_password_email_label'), $identity_label);?></label>
				<?php echo form_input($email);?>                           
			</div>
		</div>
		<div class="box-footer">
			<div class="pull-left">
				<a class="btn btn-default" href="<?php echo base_url();?>index.php/login"><?php echo lang('login_submit_btn');?></a>
			</div>
			<div class="pull-right">
				<button data-loading-text="Please wait, processing..." class="btn btn-primary btn-submit" type="submit"><?php echo lang('forgot_password_submit_btn');?></button>
			</div>
			<div class="clearfix"><!-- --></div>
		</div>
	</div>
<?php echo form_close();?>