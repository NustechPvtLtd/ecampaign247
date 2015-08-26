<?php
$promo_price='';
(isset($this->session->userdata['complete_profile']))?$complete_profile = $this->session->userdata['complete_profile']:'';

?>
<section class="content">
    <div id="notify-container">
        <?php echo $message;?>
    </div>
    <div class="tabs-container">
        <ul id="yw0" class="nav nav-tabs">
            <li class="active"><a href="<?php echo site_url('account/plans')?>"><span class="glyphicon glyphicon-list"></span> Plans & Features</a></li>
            <li><a href="<?php echo site_url('account/address_details')?>"><span class="glyphicon glyphicon-list"></span> Address</a></li>
        </ul>
        <div class="box box-primary no-top-border">
            <div class="box-body">
                <div class="row">
                    <?php if(!empty($plans)){ 
                        foreach ($plans as $plan){ ?>
                            <div class="col-xs-12 col-md-3">
                            <div class="panel panel-primary">
                                <?php if(abs($plan->discount)){?>
                                <div class="cnrflash">
                                    <div class="cnrflash-inner">
                                        <span class="cnrflash-label">Offer
                                            <br>
                                            <?php if($plan->discount_type=='percentage'){
                                               echo htmlspecialchars(($plan->discount)?abs($plan->discount).'%':'',ENT_QUOTES,'UTF-8').' Off';
                                            }else{
                                               echo 'Flat <i class="fa fa-inr"></i>'.htmlspecialchars(($plan->discount)?abs($plan->discount):'',ENT_QUOTES,'UTF-8').' Off'; 
                                            }?></span>
                                    </div>
                                </div>
                                <?php }?>
                                <div class="panel-heading">
                                    <h3 class="panel-title"><?php echo $plan->name;?></h3>
                                </div>
                                <div class="panel-body">
                                    <table class="table">
                                        <tbody>
                                            <tr class="the-price">
                                                <td>
                                                    <?php 
                                                    if(abs($plan->discount)){
                                                        echo '<i class="fa fa-inr"></i>  ';
                                                        if($plan->discount_type=='percentage'){
                                                            $promo_price = $plan->price - ($plan->price*$plan->discount/100);
                                                        }else{
                                                            $promo_price = $plan->price - $plan->discount;
                                                        }
                                                        echo abs($promo_price) .' <del style="color:#C50000;border: 1px solid #F37878;background-color: rgba(248, 155, 155, 0.67);padding: 5px;}"><i class="fa fa-inr"></i>  '.abs($plan->price).'</del>';
                                                    }else{
                                                        echo $promo_price = abs($plan->price);
                                                    }
                                                    ?>
                                                </td>
                                            </tr>
                                            <tr class="active">
                                                <td>
                                                    <?php echo $plan->description;?>
                                                </td>
                                            </tr>
                                            <tr class="active">
                                                <td>
                                                    Recommended: <?php echo ucfirst($plan->recommended);?>
                                                </td>
                                            </tr>
                                            <tr class="active">
                                                <td>
                                                    <?php echo lang('visitor_count').': '. ucfirst($plan->visitor_count);?>
                                                </td>
                                            </tr>
                                            <tr class="active">
                                                <td>
                                                    <?php echo lang('eccommerce').': '. ucfirst($plan->eccommerce);?>
                                                </td>
                                            </tr>
                                            <tr class="active">
                                                <td>
                                                    <?php echo lang('premium_domain').': '. ucfirst($plan->premium_domain);?>
                                                </td>
                                            </tr>
                                            <tr class="active">
                                                <td>
                                                    Validity: <?php echo $plan->expiration.' '.$plan->expiration_type;?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    <div class="hide_form">
                                        <form action="<?php echo site_url('plans/upgrade');?>" id="upgrade_plan_<?php echo $plan->name;?>" method="POST">
                                            <input name="plan_name" value="<?php echo $plan->name;?>" type="hidden" />
                                            <input name="plan_id" value="<?php echo $plan->plan_id;?>" type="hidden" />
                                            <input name="plan_price" value="<?php echo ($promo_price)?abs($promo_price) : abs($plan->price);?>" type="hidden" />
                                            <input name="plan_discount" value="<?php echo ($plan->discount_type=='percentage') ? abs($plan->price*$plan->discount/100) : abs($plan->discount);?>" type="hidden" />
                                            <input name="plan_ammount" value="<?php echo abs($plan->price);?>" type="hidden" />
                                        </form>
                                    </div>
                                </div>
                                <div class="panel-footer">
                                    <?php if(userdata( 'plan_id' )===$plan->plan_id){?>
                                    <a role="button" class="btn btn-default" href="javascript:void(0)" style="cursor: not-allowed;">Active Plan</a>
                                    <?php } else{ ?>
                                    <a role="button" class="btn btn-primary" onclick="javascript:upgrade('<?= $plan->name;?>')" href="javascript:void(0)" style="cursor: default;">Upgrade</a>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    <?php } }else{ ?>
                        <div id="notify-container" style="margin-left: 15px;">There is no plans to view!</div>
                   <?php }?>

                </div>
            </div>
        </div>
    </div>
    <a id="showUpdateProfileModel" class="hidden" href="#" data-href="<?php echo site_url('user/profile');?>" data-toggle="modal" data-target="#updateProfile">Lode model</a>
    <div class="modal fade small-modal" id="updateProfile" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h4 class="modal-title">Update your Profile</h4>
                </div>
                <div class="modal-body">
                    <div class="alert alert-danger" role="alert">
                        <span class="sr-only" style="position: relative;">Error:</span>
                        Your profile is not completed, please complete your profile before upgrading the account.<br>Click on OK to update your profile!
                    </div>
                </div><!-- /.modal-body -->
                <div class="modal-footer">
                    <button type="button" class="btn btn-default btn-embossed" data-dismiss="modal"><?php echo $this->lang->line('modal_cancelclose')?></button>
                    <a href="javascript:void(0)" class="btn btn-primary btn-embossed btn-ok" id="okBlockConfirm">OK</a>
                </div>
            </div><!-- /.modal-content -->
        </div><!-- /.modal-dialog -->
    </div><!-- /.modal -->
</section>
<script>
function upgrade(plan_name){
    $("#upgrade_plan_"+plan_name).submit();
}

$(document).ready(function(){
    <?php if(isset($complete_profile) && $complete_profile):?>
    $('#showUpdateProfileModel').trigger('click');
    <?php endif;?>
    $('#okBlockConfirm').on('click',function(){
        console.log($('#showUpdateProfileModel').data('href'));
        window.location = $('#showUpdateProfileModel').data('href');
    });
    //    $('#updateProfile').on('show.bs.modal', function(e) {
    //        
    //    });
});
</script>