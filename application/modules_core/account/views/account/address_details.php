<section class="content">
    <div id="notify-container">
        <?php echo $message;?>
    </div>
    <div class="tabs-container">
        <ul id="yw0" class="nav nav-tabs">
            <li><a href="<?php echo site_url('account/plans')?>"><span class="glyphicon glyphicon-list"></span> Plans & Features</a></li>
            <li class="active"><a href="<?php echo site_url('account/address_details')?>"><span class="glyphicon glyphicon-list"></span> Address</a></li>
        </ul>
        <?php echo form_open(uri_string());?>
            <div class="box box-primary no-top-border">
                <div class="box-body">
                    <div class="clearfix"><!-- --></div>
                    <div class="form-group col-lg-6">
                        <div class="form-group">
                            <?php echo lang('edit_blng_heading');?>
                        </div>
                        <div class="form-group">
                            <?php echo lang('edit_blng_street_label', 'blng_street', 'required');?>
                            <?php echo form_input($blng_street);?>
                        </div>
                        <div class="form-group">
                            <?php echo lang('edit_blng_city_label', 'blng_city', 'required');?>
                            <?php echo form_input($blng_city);?>
                        </div>
                        <div class="form-group">
                            <?php echo lang('edit_blng_state_label', 'blng_state', 'required');?>
                            <?php echo form_dropdown('blng_state', $states, $blng_state, 'id="blng_state" class="form-control"');?>
                        </div>
                        <div class="form-group">
                            <?php echo lang('edit_blng_zipcode_label', 'blng_zipcode', 'required');?>
                            <?php echo form_input($blng_zipcode);?>
                        </div>
                        <div class="form-group">
                            <?php echo lang('edit_blng_country_label', 'blng_country', 'required');?>
                            <?php echo form_dropdown('blng_country', $country, $blng_country,'id="blng_country" class="form-control" onChange="get_state(this.value,this.id);"');?>
                        </div>
                        <div class="form-group">
                            <?php echo lang('edit_blng_phone_label', 'blng_phone');?>
                            <?php echo form_input($blng_phone);?>
                        </div>
                    </div>
                    <div class="form-group col-lg-6">
                        <div class="form-group">
                            <?php echo lang('edit_spng_heading');?>
                        </div>
                        <div class="form-group">
                            <?php echo lang('edit_spng_street_label', 'spng_street', 'required');?>
                            <?php echo form_input($spng_street);?>
                        </div>
                        <div class="form-group">
                            <?php echo lang('edit_spng_city_label', 'spng_city', 'required');?>
                            <?php echo form_input($spng_city);?>
                        </div>
                        <div class="form-group">
                            <?php echo lang('edit_spng_state_label', 'spng_state', 'required');?>
                            <?php echo form_dropdown('spng_state', $states, $spng_state, 'id="spng_state" class="form-control"');?>
                        </div>
                        <div class="form-group">
                            <?php echo lang('edit_spng_zipcode_label', 'spng_zipcode', 'required');?>
                            <?php echo form_input($spng_zipcode);?>
                        </div>
                        <div class="form-group">
                            <?php echo lang('edit_spng_country_label', 'spng_country', 'required');?>
                            <?php echo form_dropdown('spng_country', $country, $spng_country, 'id="spng_country" class="form-control" onChange="get_state(this.value,this.id);"');?>
                        </div>
                        <div class="form-group">
                            <?php echo lang('edit_spng_phone_label', 'spng_phone');?>
                            <?php echo form_input($spng_phone);?>
                        </div>
                    </div>
                </div>
                <div class="box-footer">
                    <div class="pull-right">
                        <?php echo form_submit('submit', lang('edit_address_submit_btn'),"class='btn btn-primary btn-submit'");?>
                    </div>
                    <div class="clearfix"><!-- --></div>
                </div>
            </div>
        <?php echo form_close();?>
    </div>
</section>
<script>
    function get_state(value,id){
        if(value!==''){
            var post_url = "<?php echo site_url('account/get_state');?>/"+value;
            $.ajax({
                type: "GET",
                url: post_url,
                success: function(states)
                {
                    if(id=='spng_country'){
                        $('#spng_state').empty();
                        $.each(states,function(id,state)
                        {
                            var opt = $('<option />');
                            opt.val(id);
                            opt.text(state);
                            $('#spng_state').append(opt);
                        });
                    }else{
                       $('#blng_state').empty();
                        $.each(states,function(id,state)
                        {
                            var opt = $('<option />');
                            opt.val(id);
                            opt.text(state);
                            $('#blng_state').append(opt);
                        }); 
                    }
                }
            }); //end AJAX
        }
    }
    $(document).ready(function(){
        $.mask.definitions['9'] = '';
        $.mask.definitions['d'] = '[0-9]';
        $('#blng_phone').mask("+91 dd dd dddddd");
        $('#spng_phone').mask("+91 dd dd dddddd");
        $('#blng_zipcode').mask("ddd ddd");
        $('#spng_zipcode').mask("ddd ddd");
        $(".city").bind("keyup", function(event) {
            var regex = /^[a-zA-Z\s]+$/;
            if (!regex.test($(this).val())) {
                $(this).val('');
            } 
        });
    });
</script>