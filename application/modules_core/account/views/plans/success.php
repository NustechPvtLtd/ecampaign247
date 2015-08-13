<?php if(!isset($error)){?>
<h3>Thank You. Your order status is  <?php echo $status ;?></h3>
<h4>Your Transaction ID for this transaction is <?php echo $txnid ;?></h4>
<h4>We have received a payment of Rs. <?=$amount?> Your account will soon be upgraded.</h4>
<?php
    //sleep(10);
    $this->ion_auth->logout();
 }else{ 
     echo $error;
 } ?>
