<style>
    #socialMedia li {
        display: inline-block;
        list-style: outside none none;
        padding-right: 10px;
    }
    .postCustomContentDiv{
        border-radius: 10px;
        overflow: auto;
        padding: 10px;
    }
    #socialMedia > ul {
        padding-left: 0;
    }
    .linksocial {
        margin-bottom: 5px;
    }
</style>    
<div class="container-fluid">
    <div style="display:inline-block" class="col-sm-6 columns">
        <?php if(!$this->session->userdata('fb_token')):?>
        <div class="linksocial">
            <a href="<?php echo $this->facebook->login_url();?>">
                <img class="img-responsive" src="<?php echo base_url('assets')?>/img/facebook_button.png" alt="Connect with Facebook"/>
            </a>
        </div>
        <?php else :?>
        <div class="linksocial">
            <a href="<?php echo site_url('social/disconnect_account/facebook')?>">
                Click to disconnect Facebook
            </a>
        </div>
        <?php endif;?>
        <?php if(!$this->session->userdata('tw_access_token') || !$this->session->userdata('tw_access_key')):?>
            <div class="linksocial">
                <a href="<?php echo site_url('social/register_twitter?register=TRUE')?>">
                    <img class="img-responsive" src="<?php echo base_url('assets')?>/img/twitter_button.png" alt="Connect with Twitter"/>
                </a>
            </div>
        <?php else :?>
        <div class="linksocial">
            <a href="<?php echo site_url('social/disconnect_account/twitter')?>">
                Click to disconnect Twitter
            </a>
        </div>
        <?php endif;?>
        <?php if(!$this->session->userdata('li_access_token') || !$this->session->userdata('li_access_key')):?>
<!--            <div class="linksocial">
                <a href="<?php // echo site_url('social/register_linkedin?register=TRUE')?>">
                    <img class="img-responsive" src="<?php // echo base_url('assets')?>/img/linkedin_button.png" alt="Connect with LinkedIn"/>
                </a>
            </div>-->
        <?php endif;?>
    </div>
    <div class="col-sm-6 columns ">
        <a href="#" id="postCustomLink">Click here to post your custom content on Social Media</a>
        <div class="postCustomContentDiv bg-gray" style="display: none;">
            <form method="POST" action="<?php echo site_url('social/post_to_profile')?>" class="postContent">
                <div class="form-group">
                    <span id="socialMedia">
                        <ul>
                            <li>
                                <input type="checkbox" name="socialMedia[]" id="socialMedia_0" value="facebook">
                                <label for="socialMedia_0">Facebook</label>
                            </li>
                            <li>
                                <input type="checkbox" name="socialMedia[]" id="socialMedia_1" value="twitter">
                                <label for="socialMedia_1">Twitter</label>
                            </li>
<!--                            <li>
                                <input type="checkbox" name="socialMedia[]" id="socialMedia_2" value="linkedin"> 
                                <label for="socialMedia_2">LinkedIn</label>
                            </li>-->
                        </ul>                                                                                                           </span>  
                </div>
                <div class="form-group">
                    <input type="text" id="title" name="title" value="" required="required" class="form-control" placeholder="Title">
                </div>
<!--                <div class="form-group">
                    <div style="width:130px" id="logImg">
                    </div>
                    <input type="button" value="Upload Social Logo" name="yt0" class="btn bg-light-blue big " id="changeLogo" style="font-weight:bold">
                    <div style="display:none" id="logoImg_em_"></div>
                </div>-->
                <input type="hidden" id="link" name="link" value="<?php echo $site_url;?>">
                <div class="form-group">
                    <textarea id="desc" name="desc" placeholder="Description" class="form-control"></textarea>
                </div>
                <div class="form-group">
                    <input type="submit" value="Post" name="yt1" class="btn big btn-submit bg-primary pull-right"  disabled>
                </div>
            </form>
        </div>
    </div>
</div>
<script>
$('document').ready(function(){
    $('#postCustomLink').click(function(){
       $('.postCustomContentDiv').toggle(); 
    });
    var checkboxes = $("input[type='checkbox']"),
    submitButt = $("input[type='submit']");

    checkboxes.click(function() {
        submitButt.attr("disabled", !checkboxes.is(":checked"));
    });
});
</script>