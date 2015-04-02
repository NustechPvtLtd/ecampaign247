<?php echo form_open('register');?>
    <div class="box box-primary">
        <div class="box-header">
            <h3 class="box-title">Please register</h3>
        </div>
		<div class="box-body">
		    <div class="form-group">
				<div id="infoMessage"><?php echo $message;?></div>
			</div>
			<div class="clearfix"><!-- --></div>
			<div class="form-group col-lg-6">
				<?php echo lang('create_user_fname_label', 'first_name', 'required');?>
				<?php echo form_input($first_name);?>
				<?php echo form_error($first_name['name'],'<p style="color:red">','</p>');?>                              
			</div>
			<div class="form-group col-lg-6">
				<?php echo lang('create_user_lname_label', 'last_name', 'required');?>
				<?php echo form_input($last_name);?>
				<?php echo form_error($last_name['name'],'<p style="color:red">','</p>');?>  
			</div>
			<div class="clearfix"><!-- --></div>
			<div class="form-group col-lg-6">
				<?php echo lang('create_user_email_label', 'email', 'required');?>
				<?php echo form_input($email);?>
				<?php echo form_error($email['name'],'<p style="color:red">','</p>');?>                              
			</div>
			<div class="form-group col-lg-6">
				<?php echo lang('create_user_company_label', 'company', 'required');?>
				<?php echo form_input($company);?>
				<?php echo form_error($company['name'],'<p style="color:red">','</p>');?>  
			</div>
			<div class="clearfix"><!-- --></div>
			<div class="form-group col-lg-6">
				<?php echo lang('create_user_password_label', 'password', 'required');?>
				<?php echo form_input($password);?>
				<?php echo form_error($password['name'],'<p style="color:red">','</p>');?>  
			</div>
			<div class="form-group col-lg-6">
				<?php echo lang('create_user_password_confirm_label', 'password_confirm', 'required');?>
				<?php echo form_input($password_confirm);?>
				<?php echo form_error($password_confirm['name'],'<p style="color:red">','</p>');?>  
			</div>
			<div class="clearfix"><!-- --></div>
		</div>
        <div class="box-footer">
            <div class="pull-left">
                <a class="btn btn-default" href="<?php echo site_url('login'); ?>">Go to login</a>
            </div>
            <div class="pull-right">
                <button data-loading-text="Please wait, processing..." class="btn btn-primary btn-submit" type="submit">Register</button>
            </div>
            <div class="clearfix"><!-- --></div>
        </div>
    </div>
<?php echo form_close();?>         
