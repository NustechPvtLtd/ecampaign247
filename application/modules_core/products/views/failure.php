<div class="box box-primary no-top-border">
    <div class="box-header">
        <h4>Payment Summary</h4>
    </div>
    <div class="box-body">
        <p>Dear <?php echo $name; ?>,</p>
        <?php if (!isset($error)) { ?>
        <p>Due to some reason transaction is unsuccessful. If amount is deducted from your account, it will return in few days. If you still face the problem please contact our team with your transaction id.</p>
        <table width="100%" cellspacing="0" cellpadding="0" border="0">
            <tbody>
                <tr>
                    <td></td>
                    <td bgcolor="#ececec" height="1" colspan="6"></td>
                </tr>
                
                <tr>	
                		<td colspan="6">
                        		<table width="100%" border="1" align="center">
                                      <tr>
                                        <td width="10%" class="fontsizenone headingordertbl" align="center">Item</td>
                                        <td width="60%" align="center" class="headingordertbl">Description</td>
                                        <td width="10%" align="center" class="headingordertbl">Unit Cost</td>
                                        <td width="10%" align="center" class="headingordertbl">Quantity</td>
                                        <td width="10%" align="center" class="headingordertbl">Total</td>
                                      </tr>
                                     
                                      <?php foreach($result as $res) 
									  {
										  
											$product=$res->product_id;
								
											$query=$this->db->query("select * from users_products where product_id='".$product."' ");
											$pro=$query->result();
											
											$name="";
											$description="";
											foreach($pro as $pro) 
											{ 
													$name=$pro->name;
													$description=$pro->description;
											}
									?> 
                                      
                                              <tr>
                                                <td align="center"><?php echo $name; ?></td>
                                                <td align="center" class="paddingbig"><?php echo $description; ?></td>
                                                <td align="center"><i class="fa fa-inr"></i><?php echo $res->price; ?></td>
                                                <td align="center"><?php echo $res->quantity; ?></td>
                                                <td align="center"><i class="fa fa-inr"></i><?php echo $res->amount; ?></td>
                                              </tr>
                                      
                                      <?php } ?>
                                      
                            </table>

                        </td>
                </tr> 
                
                <tr>
                    <td height="10" colspan="7"></td>
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
                    <td valign="middle" height="31" >Amount: <strong style="color:#000000;font-weight:normal"><i class="fa fa-inr"></i><?php echo $amount ?></strong></td>
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