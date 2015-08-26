<div class="box box-primary no-top-border">
    <div class="box-header">
        <h4><?php echo lang('plan_header');?></h4>
    </div>
    <div class="box-body">
            <div class="box-info">
                <?php echo $message;?>
            </div>
        <table id="plans-dataTable" class="table table-striped table-bordered  no-wrap" cellspacing="0" width="100%">
            <thead>
                <tr>
                    <th><?php echo lang('plan_name');?></th>
                    <th><?php echo lang('plan_description');?></th>
                    <th><?php echo lang('plan_price');?></th>
                    <th><?php echo lang('plan_promo_price');?></th>
                    <th><?php echo lang('discount');?></th>
                    <th><?php echo lang('expiration');?></th>
                    <th><?php echo lang('plan_recommends');?></th>
                    <th><?php echo lang('plan_status');?></th>
                    <th><?php echo lang('visitor_count');?></th>
                    <th><?php echo lang('eccommerce');?></th>
                    <th><?php echo lang('premium_domain');?></th>
                    <th><?php echo lang('plan_date_added');?></th>
                    <th></th>
                </tr>
            </thead>
            <tfoot>
                <tr>
                    <th><?php echo lang('plan_name');?></th>
                    <th><?php echo lang('plan_description');?></th>
                    <th><?php echo lang('plan_price');?></th>
                    <th><?php echo lang('plan_promo_price');?></th>
                    <th><?php echo lang('discount');?></th>
                    <th><?php echo lang('expiration');?></th>
                    <th><?php echo lang('plan_recommends');?></th>
                    <th><?php echo lang('plan_status');?></th>
                    <th><?php echo lang('visitor_count');?></th>
                    <th><?php echo lang('eccommerce');?></th>
                    <th><?php echo lang('premium_domain');?></th>
                    <th><?php echo lang('plan_date_added');?></th>
                    <th></th>
                </tr>
            </tfoot>
            <tbody>
                <?php if (!empty($plans)):?>
                <?php foreach ($plans as $plan):?>
                    <tr ig="<?php echo $plan->plan_id;?>">
                        <td><?php echo htmlspecialchars($plan->name,ENT_QUOTES,'UTF-8');?></td>
                        <td><span class="plan_description"><?php echo $plan->description;?></span></td>
                        <td><?php echo '<i class="fa fa-inr"></i>'.htmlspecialchars($plan->price,ENT_QUOTES,'UTF-8');?></td>
                        <td><?php 
                            if($plan->discount_type=='percentage'){
                                $promo_price = $plan->price - ($plan->price*$plan->discount/100);
                                echo '<i class="fa fa-inr"></i>'.$promo_price;
                            }else{
                                $promo_price = $plan->price - $plan->discount;
                                echo '<i class="fa fa-inr"></i>'.$promo_price;
                            }
                        ?></td>
                        <td><?php echo ($plan->discount_type=='percentage')? htmlspecialchars(($plan->discount)?$plan->discount.'%':'',ENT_QUOTES,'UTF-8'): '<i class="fa fa-inr"></i>'.htmlspecialchars($plan->discount,ENT_QUOTES,'UTF-8');?></td>
                        <td><?php echo htmlspecialchars($plan->expiration.' '.$plan->expiration_type,ENT_QUOTES,'UTF-8')?></td>
                        <td><?php echo anchor("plans/recommended/".$plan->plan_id.'/'.(($plan->recommended=='yes')?'no':'yes'), ucfirst($plan->recommended)) ;?></td>
                        <td><?php echo anchor("plans/status/".$plan->plan_id.'/'.(($plan->status=='active')?'inactive':'active'), ucfirst($plan->status)) ;?></td>
                        <td><?php echo anchor("plans/visitor_count/".$plan->plan_id.'/'.(($plan->visitor_count=='active')?'inactive':'active'), ucfirst($plan->visitor_count)) ;?></td>
                        <td><?php echo anchor("plans/eccommerce/".$plan->plan_id.'/'.(($plan->eccommerce=='active')?'inactive':'active'), ucfirst($plan->eccommerce)) ;?></td>
                        <td><?php echo anchor("plans/premium_domain/".$plan->plan_id.'/'.(($plan->premium_domain=='active')?'inactive':'active'), ucfirst($plan->premium_domain)) ;?></td>
                        <td><?php echo date("jS M, Y",strtotime($plan->date_added));?></td>
                        <td><?php echo anchor('plans/update/'.$plan->plan_id,'<span class="glyphicon glyphicon-pencil"></span>');?><?php echo anchor('plans/delete/'.$plan->plan_id, '<span class="glyphicon glyphicon-remove"></span>')?></td>
                    </tr>
                <?php endforeach;?>
                <?php endif;?>
            </tbody>
        </table>
    </div>
    <div class="box-footer">
       <?php echo anchor('plans/create', lang('plan_create'), array('class' => 'btn btn-primary'))?> 
    </div>
</div>
<script>
    $(document).ready( function () {
        $("#plans-dataTable").DataTable({
            ordering: true,
            "pageLength": 10,
            responsive: true
        });
    } );
</script>
