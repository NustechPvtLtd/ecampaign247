<?php echo form_open('reset-password/' . $code);?>
	<div class="box box-primary">
		<div class="box-header">
			<h3 class="box-title"><?php echo lang('reset_password_heading');?></h3>
		</div>
		<div class="box-body">
			<div class="form-group">
				<div id="infoMessage"><?php echo $message;?></div>
			</div>
			<div class="clearfix"><!-- --></div>
			<div class="form-group">
				<label for="new_password"><?php echo sprintf(lang('reset_password_new_password_label'), $min_password_length);?></label>
				<?php echo form_input($new_password);?>                             
			</div>
			<div class="form-group">
				<?php echo lang('reset_password_new_password_confirm_label', 'new_password_confirm');?>
				<?php echo form_input($new_password_confirm);?>
			</div>
			<div class="form-group">
				<?php echo form_input($user_id);?>
				<?php echo form_hidden($csrf); ?>
			</div>
			<div class="clearfix"><!-- --></div>
		</div>
		<div class="box-footer">
			<div class="pull-right">
                <?php echo form_submit('submit', lang('reset_password_submit_btn'),"class='btn btn-primary btn-submit'");?>
			</div>
			<div class="clearfix"><!-- --></div>
		</div>
	</div>
<?php echo form_close();?>