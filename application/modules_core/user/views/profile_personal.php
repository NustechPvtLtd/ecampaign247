<section class="content">
    <div id="notify-container">
        <?php echo $message;?>
    </div>
    <div class="tabs-container">
        <ul id="yw0" class="nav nav-tabs">
            <li class="active"><a href="<?php echo site_url('user/profile')?>"><span class="glyphicon glyphicon-list"></span> Profile</a></li>
        </ul>
        <?php echo form_open(uri_string());?>
            <div class="box box-primary no-top-border">
                <div class="box-body">
                    <div class="clearfix"><!-- --></div>
                    <?php if(!$this->ion_auth->is_admin() || $user_id==$user->id):?>
                    <div class="form-group col-lg-6">
                        <?php echo lang('edit_user_fname_label', 'first_name', 'required');?>
                        <?php echo form_input($first_name);?>
                    </div>
                    <div class="form-group col-lg-6">
                        <?php echo lang('edit_user_lname_label', 'last_name', 'required');?>
                        <?php echo form_input($last_name);?>
                    </div>
                    <div class="clearfix"><!-- --></div>
                    <?php endif;?>
                    <div class="form-group col-lg-6">
                        <?php echo lang('edit_user_email_label', 'email', 'required');?>
                        <?php echo form_input($email);?>
                    </div>
                    <?php if(!$this->ion_auth->is_admin() || $user_id==$user->id):?>
                    <div class="form-group col-lg-6">
                        <?php echo lang('edit_user_phone_label', 'phone', 'required');?>
                        <?php echo form_input($phone);?>
                    </div>
                    <?php endif;?>
                    <?php if($this->ion_auth->is_admin() && $user_id!=$user->id):?>
                    <div class="form-group col-lg-6">
                        <?php echo lang('edit_user_price_plan_label', 'price_plan_id', 'required');?>
                        <?php echo form_dropdown('price_plan_id', $plans, $price_plan_id, ' class="form-control"');?>
                    </div>
                    <?php endif;?>
                    <div class="clearfix"><!-- --></div>
                    <div class="form-group col-lg-6">
                        <?php echo lang('edit_user_password_label', 'password');?>
                        <?php echo form_input($password);?>
                    </div>
                    <div class="form-group col-lg-6">
                        <?php echo lang('edit_user_password_confirm_label', 'password_confirm');?>
                        <?php echo form_input($password_confirm);?>
                    </div>
                    <?php if(!$this->ion_auth->is_admin() || $user_id==$user->id):?>
                    <div class="clearfix"><!-- --></div>
                    <div class="form-group col-lg-12">
                        <?php echo lang('edit_user_company_label', 'company');?>
                        <?php echo form_input($company);?>
                    </div>
                    <?php endif;?>
                    <?php if($this->ion_auth->is_admin() && $user_id!=$user->id):?>
                    <div class="clearfix"><!-- --></div>
                    <div class="form-group col-lg-12">
                        <label for="notes">Notes:(For User plan)</label>
                        <?php echo form_input($notes);?>
                    </div>
                    <?php endif;?>
                    <?php if(!$this->ion_auth->is_admin() || $user_id==$user->id):?>
                    <div class="clearfix"><!-- --></div>
                    <hr>
                    <div class="form-group col-lg-6">
                        <div class="col-lg-2">
                            <img class="img-thumbnail" src="<?php echo base_url('elements');?>/images/uploads/<?= $avatar;?>">
                        </div>
                        <div class="col-lg-10">
                            <button type="button" class="btn btn-primary" id="uploadImageButton"><?= ($avatar)?'Change Avatar':'Upload Avatar'?></button>
                        </div>
                    </div>
                    <?php endif;?>

                    <div class="clearfix"><!-- --></div>
                    <div class="clearfix"><!-- --></div>
                    <?php echo form_hidden($csrf); ?>
                </div>
                <div class="box-footer">
                    <div class="pull-right">
                        <?php echo form_submit('submit', lang('edit_user_submit_btn'),"class='btn btn-primary btn-submit'");?>
                    </div>
                    <div class="clearfix"><!-- --></div>
                </div>
            </div>
        <?php echo form_close();?>
    </div>
</section>
<script>
    <?php if(!$this->ion_auth->is_admin()):?>
    $(function(){
        var btnUpload = $('#uploadImageButton');
        var status = $('#notify-container');
        var files = $('.img-thumbnail');
        new AjaxUpload(btnUpload, {
            contentType: "text/html",
            action: '<?php echo site_url('user/upload_avatar/'); ?>',
            name: 'uploadfile',
            cache: false,
            onSubmit: function(file, ext) {
                if (!(ext && /^(jpg|png|jpeg|gif)$/.test(ext))) {
                    status.text('Only JPG, PNG or GIF files are allowed');
                    return false;
                }
            },
            onComplete: function(file,response) {
                var obj = jQuery.parseJSON(response);
                status.text('Photo Uploaded Sucessfully!');
                if (obj.status === "error") {
                    status.html(obj.message);
                } else {
                    files.fadeOut('slow');
                    files.load();
                    files.fadeIn('slow');
                    files.attr('src','<?php echo base_url();?>' + 'elements/images/uploads/'+'<?= $this->ion_auth->get_user_id();?>' +'/'+ obj.message + '?rand=' + new Date().getTime());
                    $('.img-circle').fadeOut('slow').load().fadeIn('slow');
                    $('.img-circle').attr('src','<?php echo base_url();?>' + 'elements/images/uploads/'+'<?= $this->ion_auth->get_user_id();?>' +'/'+ obj.message + '?rand=' + new Date().getTime());
                    status.html('');
                }

            }
        });
        $.mask.definitions['9'] = '';
        $.mask.definitions['d'] = '[0-9]';
        $('#phone').mask("+91 dd dd dddddd");
        
    });
    <?php endif;?>
</script>