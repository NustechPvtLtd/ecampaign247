<div class="box box-primary no-top-border">
    <div class="box-header">
        <h4>Payment Summary</h4>
    </div>
    <div class="box-body">
        <p>Dear <?= $name; ?></p>
        <?php if (!isset($error)) { ?>
        <p>Thank you for paying to upgrading your account. Your payment has been successfully processed. Your account account will soon be upgraded.</p>
        <table width="100%" cellspacing="0" cellpadding="0" border="0">
            <tbody>
                <tr>
                    <td></td>
                    <td bgcolor="#ececec" height="1" colspan="6"></td>
                </tr>
                <tr>
                    <td valign="middle" height="31" >Your Payment Status: <?php echo $status; ?></td>
                    <td width="1" bgcolor="#ececec"></td>
                    <td width="7" bgcolor=""></td>
                </tr>
                <tr>
                    <td bgcolor="#e9e9e9" height="1" colspan="7"></td>
                </tr>
                <tr>
                    <td valign="middle" height="31" >Transaction ID: <strong style="color:#000000;font-weight:normal"><?php echo $txnid; ?></strong></td>
                </tr>                            
                <tr>
                    <td bgcolor="#e9e9e9" height="1" colspan="7"></td>
                </tr>
                <tr>
                    <td valign="middle" height="31" >Amount: <strong style="color:#000000;font-weight:normal"><i class="fa fa-inr"></i><?= $amount ?></strong></td>
                </tr>
                <tr>
                    <td bgcolor="#ececec" height="1" colspan="6"></td>
                </tr>
            </tbody></table>
        <?php   
//            $this->ion_auth->logout();
            } else {
                echo $error;
            }
        ?>
    </div>
    <div class="box-footer">
        <ul style="list-style: none;">
            <li>Thank You,</li>
            <li>Administration Team,</li>
            <li><a href="mailto:info@webzero.in">info@webzero.in</a></li>
        </ul>
    </div>
</div>