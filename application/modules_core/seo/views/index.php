<div class="info_content">
    <?php echo $message;?>
</div>
<div class="box box-primary no-top-border">				
    <div class="box-header">
        <h4>Update SEO information for your page: </h4>
    </div>
    
    <?php echo form_open(uri_string(),array('class' => 'form-horizontal', 'id' => 'pageSettingsForm', 'role' => "form")); ?>
    <div class="box-body">
        <div class="optionPane">
            <input type="hidden" name="siteID" id="siteID" value="<?php echo $siteData['site']->sites_id?>">
            <input type="hidden" name="pageID" id="pageID" value="<?php if( isset($pagesData['index']) ){ echo $pagesData['index']->pages_id; }?>">
            <input type="hidden" id="link" name="link" value="<?php echo $siteData['site']->remote_url;?>">
            <input type="hidden" name="pageName" id="pageName" value="">

            <div class="form-group">
                <label for="name" class="col-sm-3"><?php echo $this->lang->line('modal_pagesettings_pagetitle')?>:</label>
                <div class="col-sm-9">
                    <input type="text" class="form-control" id="pageData_title" name="pageData_title" placeholder="Page title" value="<?php if( isset($pagesData['index']) ){ echo $siteData['site']->sites_name; }?>">
                </div>
            </div>

            <div class="form-group">
                <label for="name" class="col-sm-3"><?php echo $this->lang->line('modal_pagesettings_pagedescription')?>:</label>
                <div class="col-sm-9">
                    <textarea class="form-control" id="pageData_metaDescription" name="pageData_metaDescription" placeholder="Page meta description"><?php if( isset($pagesData['index']) ){ echo $pagesData['index']->pages_meta_description; }?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="name" class="col-sm-3"><?php echo $this->lang->line('modal_pagesettings_pagekeywords')?>:</label>
                <div class="col-sm-9">
                    <textarea class="form-control" id="pageData_metaKeywords" name="pageData_metaKeywords" placeholder="Page meta keywords"><?php if( isset($pagesData['index']) ){ echo $pagesData['index']->pages_meta_keywords; }?></textarea>
                </div>
            </div>

            <div class="form-group">
                <label for="name" class="col-sm-3"><?php echo $this->lang->line('modal_pagesettings_pageheaderincludes')?>:</label>
                <div class="col-sm-9">
                    <textarea class="form-control" id="pageData_headerIncludes" name="pageData_headerIncludes" rows="7" placeholder="Additional code you'd like to include in the <head> section"><?php if( isset($pagesData['index']) ){ echo $pagesData['index']->pages_header_includes; }?></textarea>
                </div>
            </div>
        </div>
        <div class="optionPane social_btn_group">
            <div class="form-group col-sm-6" style="margin-left:0; margin-right:0;">
                <?php if(!$this->session->userdata('fb_token')):?>
                <a class="btn btn-primary facebook_btn" href="<?php echo $this->facebook->login_url();?>"><span><i class="fa fa-facebook"></i></span>Connect with Facebook</a>
                <?php else:?>
                <a class="btn btn-primary facebook_btn" href="javascript:post_to_facebook();"><span><i class="fa fa-facebook"></i></span>Share with Facebook</a>
                <?php endif;?>
            </div>
                <div class="clearfix"></div>
<!--            <div class="form-group col-sm-6" style="margin-left:0; margin-right:0;">
                <a class="btn btn-primary google_btn"><span><i class="fa fa-google-plus"></i></span>Share with Google+</a>
            </div>-->

            <div class="form-group col-sm-6" style="margin-left:0; margin-right:0;">
                <?php if(!$this->session->userdata('tw_access_token') || !$this->session->userdata('tw_access_key')):?>
                <a class="btn btn-primary twitter_btn" href="<?php echo site_url('social/register_twitter?register=TRUE')?>"><span><i class="fa fa-twitter"></i></span>Connect with Twitter</a>
                <?php else:?>
                <a class="btn btn-primary twitter_btn" href="javascript:post_to_twitter();"><span><i class="fa fa-twitter"></i></span>Share with Twitter</a>
                <?php endif;?>
            </div>

<!--            <div class="form-group col-sm-6" style="margin-left:0; margin-right:0;">
                <a class="btn btn-primary linkedIn_btn"><span><i class="fa fa-linkedin"></i></span>Share with LinkedIn</a>
            </div>-->
        </div>
    </div>
    <div class="box-footer">
        <div class="pull-right">
            <?php echo form_submit('submit', 'Submit',"class='btn btn-primary btn-submit'");?>
        </div>
        <div class="clearfix"><!-- --></div>
    </div>
</form>
</div>
<script>
    function post_to_facebook(){
        $.blockUI();
        jQuery.ajax({
            url: "<?php echo site_url('social/post_to_facebook');?>",
            type: "POST",
            data: ({desc:$('#pageData_metaDescription').val(), link:$('#link').val(), title:$('#pageData_title').val()}),
            dataType: "html",
            success: function(msg){
                $.unblockUI();
                alert('Your page details successfully share to your facebook profile.');
            }
        });
    }
    
    function post_to_twitter(){
        $.blockUI();
        jQuery.ajax({
            url: "<?php echo site_url('social/post_to_twitter');?>",
            type: "POST",
            data: ({desc:$('#pageData_metaDescription').val(), link:$('#link').val(), title:$('#pageData_title').val()}),
            dataType: "html",
            success: function(msg){
                $.unblockUI();
                alert('Your page details successfully share to your twitter profile.');
            }
        });
    }
</script>