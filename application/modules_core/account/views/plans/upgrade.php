<div class="box box-primary no-top-border">
    <form action="<?php echo $action; ?>" method="post" name="payuForm">
        <div class="box-header">
            <h4><?php echo 'Please not your transaction ID: '.$txnid;?></h4>
        </div>
        <div class="box-body">
            <input type="hidden" name="key" value="<?php echo $key ?>" />
            <input type="hidden" name="hash" value="<?php echo $hash ?>"/>
            <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
            <input type="hidden" name="surl" value="<?php echo $surl ?>" />
            <input type="hidden" name="furl" value="<?php echo $furl ?>" />
            <input type="hidden" name="curl" value="<?php echo $curl ?>" />
            <input type="hidden" name="productinfo" value="<?php echo htmlspecialchars($productinfo); ?>" />
            <input type="hidden" name="service_provider" value="<?php echo $service_provider ?>" />
            <div class="clearfix"><!-- --></div>
            <div class="form-group col-lg-6">
                <label for="firstname" >First Name</label>
                <input type="text" name="firstname" id="firstname" value="<?php echo (empty($firstname)) ? '' : $firstname; ?>" required="" class="form-control"/>
            </div>
            <div class="form-group col-lg-6">
                <label for="lastname" >Last Name</label>
                <input type="text" name="lastname" id="lastname" value="<?php echo (empty($lastname)) ? '' : $lastname; ?>" required="" class="form-control"/>
            </div>
            <div class="clearfix"><!-- --></div>
            <div class="form-group col-lg-4">
                <label for="email" >Email</label>
                <input type="email" required="" name="email" id="email" value="<?php echo (empty($email)) ? '' : $email; ?>"  class="form-control"/>
            </div>
            <div class="form-group col-lg-4">
                <label for="phone" >Phone</label>
                <input name="phone" value="<?php echo (empty($phone)) ? '' : $phone; ?>" required="" class="form-control"/>
            </div>
            <div class="form-group col-lg-4">
                <label for="amount" >Amount Payable</label>
                <input type="number" name="amount" value="<?php echo (empty($amount)) ? '' : $amount ?>" onkeypress="isNumberKey()" required="" class="form-control" readonly=""/>
            </div>
            <div class="clearfix"><!-- --></div>
            
        </div>
        <div class="clearfix"><!-- --></div>
        <div class="box-footer">
            <div class="pull-left">
                <?php echo anchor(site_url('account/plans'), 'Back to plan list', array('class'=>'btn btn-primary btn-submit')) ;?>
            </div>
            <div class="pull-right">
                <?php echo form_submit('submit', 'Submit',"class='btn btn-primary btn-submit'");?>
            </div>
            <div class="clearfix"><!-- --></div>
        </div>
    </form>
</div>
<script>
    function isNumberKey(evt){
        var charCode = (evt.which) ? evt.which : evt.keyCode
        if (charCode > 31 && (charCode != 46 &&(charCode < 48 || charCode > 57)))
            return false;
        return true;
    }
    $(document).ready(function(){

    });
</script>