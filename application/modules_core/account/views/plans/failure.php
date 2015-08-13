<?php if(!isset($error)){?>
<h3>Thank You. Your order status is  <?php echo $status ;?></h3>
<h4>Your transaction id for this transaction is  <?php echo $txnid ;?>. You may try some time later.</h4>
<?php }else{ 
     echo $error;
 } ?>
