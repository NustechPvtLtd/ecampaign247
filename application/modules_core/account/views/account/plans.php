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
                                                    <h1>
                                                        <?php 
                                                        if(abs($plan->discount)){
                                                            if($plan->discount_type=='percentage'){
                                                                $promo_price = $plan->price - ($plan->price*$plan->discount/100);
                                                            }else{
                                                                $promo_price = $plan->price - $plan->discount;
                                                            }
                                                            echo '<del><i class="fa fa-inr"></i>'.abs($plan->price).'</del> <i class="fa fa-inr"></i>'.abs($promo_price);
                                                        }else{
                                                            echo '<i class="fa fa-inr"></i>'.abs($plan->price);
                                                        }
                                                        ?><span class="subscript"></span>
                                                    </h1>
                                                    <small></small>
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
                                                    Validity: <?php echo $plan->expiration.' '.$plan->expiration_type;?>
                                                </td>
                                            </tr>
                                        </tbody>
                                    </table>
                                </div>
                                <div class="panel-footer">
                                    <a role="button" class="btn btn-success" href="javascript:void(0)" style="cursor: default;"><?php echo (abs($plan->price)==0)?'Active Plane':'Upgrade';?></a>
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