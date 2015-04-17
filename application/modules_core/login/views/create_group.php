<div class="col-lg-4">
<?php echo form_open("create-group");?>
	<div class="box box-primary">
		<div class="box-header">
			<p class="box-title"><?php echo lang('create_group_subheading');?></p>
		</div>
		<div class="box-body">
			<div class="form-group">
				<div id="infoMessage"><?php echo $message;?></div>
			</div>
			<div class="clearfix"><!-- --></div>
			<div class="form-group">
            <?php echo lang('create_group_name_label', 'group_name');?> 
            <?php echo form_input($group_name);?>                             
			</div>
			<div class="form-group">
            <?php echo lang('create_group_desc_label', 'description');?>
            <?php echo form_input($description);?>
			</div>
			<div class="clearfix"><!-- --></div>
		</div>
		<div class="box-footer">
			<div class="pull-right">
				<?php echo form_submit('submit', lang('create_group_submit_btn'),'class="btn btn-primary btn-submit"');?>
			</div>
			<div class="clearfix"><!-- --></div>
		</div>
	</div>
<?php echo form_close();?>
</div>