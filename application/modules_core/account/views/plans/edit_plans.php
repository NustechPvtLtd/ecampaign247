<div class="box box-primary no-top-border">
    <?php echo form_open(uri_string());?>
        <div class="box-header">
            <h4><?php echo 'Plans Form';?></h4>
        </div>
        <div class="box-body">
            <div class="box-info">
                <?php echo $message;?>
            </div>
            <div class="clearfix"><!-- --></div>
            <div class="form-group col-lg-6">
                <?php echo lang('plan_name', 'plan_name', 'required');?>
                <?php echo form_input($plan_name);?>
            </div>
            <div class="form-group col-lg-6">
                <?php echo lang('plan_price', 'plan_price', 'required');?>
                <?php echo form_input($plan_price);?>
            </div>
            <div class="clearfix"><!-- --></div>
            <div class="form-group col-lg-12">
                <?php echo lang('plan_description', 'plan_description');?>
                <?php echo form_textarea($plan_description);?>
            </div>
            <div class="clearfix"><!-- --></div>
            <div class="form-group col-lg-6">
                <?php echo lang('plan_recommends', 'plan_recommends', 'required');?>
                <?php echo form_dropdown('plan_recommends', array('yes'=>'Yes','no'=>'No'), $plan_recommends, ' class="form-control"');?>
            </div>
            <div class="form-group col-lg-6">
                <?php echo lang('plan_status', 'plan_status', 'required');?>
                <?php echo form_dropdown('plan_status',array('active'=>'Active','inactive'=>'Inactive'), $plan_status,'class="form-control"');?>
            </div>
        </div>
        <div class="box-footer">
            <div class="pull-right">
                <?php echo form_submit('submit', 'Submit',"class='btn btn-primary btn-submit'");?>
            </div>
            <div class="clearfix"><!-- --></div>
        </div>
    <?php echo form_close();?>
</div>
<script>
    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode != 46 &&(charCode < 48 || charCode > 57)))
            return false;
        return true;
    }
    $(document).ready(function(){
       $('#plan_description').redactor(); 
    });
</script>