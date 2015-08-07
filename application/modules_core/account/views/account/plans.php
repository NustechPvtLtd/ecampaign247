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
                                                        echo abs($plan->price);
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
                                </div>
                                <div class="panel-footer">
                                    <a role="button" class="btn btn-success" href="javascript:void(0)" style="cursor: default;"><?php echo (userdata( 'plan_id' )===$plan->plan_id)?'Active Plane':'Upgrade';?></a>
                                </div>
                            </div>
                        </div>
                    <?php }
                    }else{ 
                        echo '<div id="notify-container" style="margin-left: 15px;">There is no plans to view!</div>';
                    }?>

                </div>
            </div>
        </div>
    </div>
</section>