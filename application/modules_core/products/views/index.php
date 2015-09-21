<?php 
	   foreach($result as $res)
	   { 
?>
		 <div class="row">
                    <div class="col-md-2">
                    	  <div class="row productname">
								<?php echo $res->name;?> 
                          </div>
                          
                           <div class="row">
                           		<div class="col-md-10">
									<img src="<?php echo $res->image1; ?>" width="100%" height="100px" class="imageborderradius" />
                                </div>    
                           </div>
                            
                    </div>
                    
                    <div class="col-md-6">
                     	 <div class="row productname">
								Description
                          </div>
                          
                          <div class="row">
                          		<?php echo $res->description;?> 
                          </div>      
                    </div>
                    
                    <div class="col-md-2 productprice"><i class="fa fa-inr"></i> <?php echo $res->price;?></div>
                    
                    <div class="col-md-2 col-sm-4  col-xs-6">
                    
                            <label class="Quanity">Quantity:</label>
                            
                    		<select id="quantity" name="quantity" class="a-native-dropdown form-control" autocomplete="off" onchange="changettl(this.value)">
                            
                            	 <?php for($i=1; $i<31; $i++) { ?>
                                        <option value="<?php echo $i; ?>"><?php echo $i; ?></option>
                                 <?php } ?>
                           </select>
                     </div>
         </div> 
         
         <div class="row">&nbsp;</div>
         
          <div class="row">
                <div class="box-header">
                    <h4 class="mediumfont"><?php echo 'Please note your transaction ID: '.$txnid;?></h4>
                </div>
         </div>   

         
         <div class="row">
        
        		 <div class="box box-primary no-top-border">
                        
                        <div class="box-header">
                           
                        </div>
            
                        <div class="box-body">
                        	 
                             <input type="hidden" name="transaction_id" id="transaction_id" value="<?php echo $txnid;?>"/>
                             <input type="hidden" name="product_id" id="product_id" value="<?php echo $product_id;?>"/>
                                                 
  							 <form  method="post" name="payuForm" id="payuForm" action="<?php echo $action; ?>">

									 <input type="hidden" name="key" value="<?php echo $key ?>" />
                                    <input type="hidden" id="hash" name="hash" value="<?php echo $hash ?>"/>
                                    <input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
                                    <input type="hidden" name="surl" value="<?php echo $surl ?>" />
                                    <input type="hidden" name="furl" value="<?php echo $furl ?>" />
                                    <input type="hidden" name="curl" value="<?php echo $curl ?>" />
                                    <input type="hidden" name="productinfo" value="<?php echo $productinfo;?>"/>
                                    <input type="hidden" name="service_provider" value="<?php echo $service_provider ?>"/>
                                 
                                    <div class="form-group col-lg-6">
                                        <label for="firstname" >First Name<span class="required">*</span></label>
                                        <input type="text" name="firstname" id="firstname" required="" class="form-control" onkeypress="removeredclass(this.id)" autocomplete='off'/>
                                    </div>
                                    <div class="form-group col-lg-6">
                                        <label for="lastname" >Last Name<span class="required">*</span></label>
                                        <input type="text" name="lastname" id="lastname" required="" class="form-control" onkeypress="removeredclass(this.id)" autocomplete='off'/>
                                    </div>
                                    <div class="clearfix"><!-- --></div>
                                    <div class="form-group col-lg-4">
                                        <label for="email" >Email<span class="required">*</span></label>
                                        <input type="email" required="" name="email" id="email" class="form-control" onkeypress="removeredclass(this.id)" autocomplete='off'/>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="phone" >Phone<span class="required">*</span></label>
                                        <input name="phone" id="phone" required="" class="form-control" maxlength="10" onkeypress="removeredclass(this.id)" autocomplete='off'/>
                                    </div>
                                    <div class="form-group col-lg-4">
                                        <label for="amount" >Amount Payable<span class="required">*</span></label>
                                        <input type="hidden" value="<?php echo $res->price;?>" name="price" id="price" />
                                        <input type="number" id="amount" name="amount"onkeypress="isNumberKey()" value="<?php echo $res->price;?>" required="" class="form-control" readonly=""/>
                                    </div>
                                    
                                  <!--  <input name="subform" id="subform" type="submit" value="Proceed To Checkout" class="btn btn-primary btn-submit"/>-->
                                    
                              </form>      
                       
                                    <div class="form-group col-lg-6">
                                    
                                        <div class="form-group">
                                           Billing Address 
                                        </div>
                                        
                                        <div class="form-group">
                                          &nbsp;
                                        </div>
                                        
                                        <div class="form-group">
                                             <label for="blng_street" class="required">Billing Street<span class="required">*</span></label> 
                                             <input type="text" name="blng_street" value="" id="blng_street" class="form-control" required="" onkeyup="shippingequal(this.id)" autocomplete='off' onkeypress="removeredclass(this.id)"/>
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="blng_city" class="required">Billing City<span class="required">*</span></label>                            
                                            <input type="text" name="blng_city" value="" id="blng_city" class="form-control city" required="" onkeyup="shippingequal(this.id)" autocomplete='off' onkeypress="removeredclass(this.id)"/>
                                        </div>
                                                                                
                                        <div class="form-group">
                                            <label for="blng_country" class="required">Billing Country<span class="required">*</span></label>                            
                                            <select name="blng_country" id="blng_country" class="form-control" onChange="get_state(this.value,this.id);" required="" onclick="shippingequal(this.id)"/>
													<!--<option value="" selected="selected">please select</option>-->
                                                    <?php  foreach($country as $con) { ?>
                                                    		<option value="<?php echo $con->country_id; ?>" <?php if($con->name=='India') { ?> selected="selected" <?php } ?>><?php echo $con->name; ?></option>
                                                    <?php } ?>        
                                            </select>        
                                        </div>
                                        
                                        <div class="form-group">
                                            <label for="blng_state" class="required">Billing State<span class="required">*</span></label>                           
                                            <select name="blng_state" id="blng_state" class="form-control" required="" onclick="shippingequal(this.id)">
                                            		<option value="" selected="selected">please select</option>
                                            </select>      
                                        </div>
                                        
                                        <div class="form-group">
                                             <label for="blng_zipcode" class="required">Billing Zipcode<span class="required">*</span></label>                            
                                             <input type="text" name="blng_zipcode" value="" id="blng_zipcode" class="form-control" required="" onkeyup="shippingequal(this.id)" autocomplete='off' maxlength="6" onkeypress="removeredclass(this.id)"/>
                                        </div>
                                        
                                        <div class="form-group">
                                           <label for="blng_phone">Billing Phone<span class="required">*</span></label>                            
                                           <input type="text" name="blng_phone" value="" id="blng_phone" class="form-control" onkeyup="shippingequal(this.id)" autocomplete='off' maxlength="10" onkeypress="removeredclass(this.id)"/> 
                                        </div>
                                    </div>
                                    
                                    <div class="form-group col-lg-6">
                                    
                                        <div class="form-group">
                                           Shipping Address
                                        </div>
                                        
                                        <div class="form-group">
                                            <input name="shippingequal" id="shippingequal"  type="checkbox" onclick="shippingequal(this.id)" /> If shipping address is same as billing address
                                        </div>
                                        
                                        <div class="form-group">
                                           <label for="spng_street" class="required">Shipping Street<span class="required">*</span></label>                           
                                           <input type="text" name="spng_street" value="" id="spng_street" class="form-control" required="" onkeypress="removeredclass(this.id)"/> 
                                        </div>
                                        
                                        <div class="form-group">
                                              <label for="spng_city" class="required">Shipping City<span class="required">*</span></label>                            
                                              <input type="text" name="spng_city" value="" id="spng_city" class="form-control city" required="" onkeypress="removeredclass(this.id)"/> 
                                        </div>
                                                                                
                                        <div class="form-group">
                                          <label for="spng_country" class="required">Shipping Country<span class="required">*</span></label>                            
                                           		 <select name="spng_country" id="spng_country" class="form-control" onChange="get_state(this.value,this.id);" required="" onclick="shippingequal(this.id)">
													<!--<option value="" selected="selected">please select</option>-->
                                                    <?php  foreach($country as $con) { ?>
                                                    		<option value="<?php echo $con->country_id; ?>"  <?php if($con->name=='India') { ?> selected="selected" <?php } ?>><?php echo $con->name; ?></option>
                                                    <?php } ?>        
                                            </select>    
                                        </div>
                                        
                                        <div class="form-group">
                                              <label for="spng_state" class="required">Shipping State<span class="required">*</span></label>                            
                                             	 <select name="spng_state" id="spng_state" class="form-control" required="" onclick="shippingequal(this.id)">
                                              		<option value="" selected="selected">please select</option>
											    </select>        
                                        </div>
                                        
                                        <div class="form-group">
                                           <label for="spng_zipcode" class="required">Shipping Zipcode<span class="required">*</span></label>                            
                                           	<input type="text" name="spng_zipcode" value="" id="spng_zipcode" class="form-control" required="" maxlength="6" onkeypress="removeredclass(this.id)"/> 
                                        </div>
                                        
                                        <div class="form-group">
                                             <label for="spng_phone">Shipping Phone<span class="required">*</span></label>    
                                             <input type="text" name="spng_phone" value="" id="spng_phone" class="form-control" maxlength="10" onkeypress="removeredclass(this.id)"/>  
                                        </div>
                                    </div>
                                    
                             <div class="box-footer">
                                    <div class="pull-left">
                                       
                                    </div>
                                    <div class="pull-right">
                                        <?php //echo form_submit('submit', 'Proceed To Checkout',"class='btn btn-primary btn-submit'");?>
                                        
                                        <input name="subform" id="subform" type="button" value="Proceed To Checkout" class="btn btn-primary btn-submit" onclick="return savedata()" />
                                        
                                    </div>
                                    <div class="clearfix"></div>
                            </div>
                    </div>
                    
                    <div class="clearfix"><!-- --></div>
    		
		</div>
    </div> 

<?php	
	   }	
?>	 
        
<script>
	function isNumberKey(evt){
		var charCode = (evt.which) ? evt.which : evt.keyCode
		if (charCode > 31 && (charCode != 46 &&(charCode < 48 || charCode > 57)))
			return false;
		return true;
	}
	
	function changettl(value)
	{
		var price=document.getElementById('price').value;
		
		var ttl=value*price;
		
		var ttl1=Math.floor(ttl * 10000) / 10000;
		
		document.getElementById('amount').value=ttl1;
	}
</script>
        
<script>

	 window.onload = function() 
	 {
		var blng=$('#blng_country').val();
	    var shp=$('#spng_country').val();
		
		get_state(blng,'blng_country');
		get_state(shp,'spng_country');
	 }

	function get_state(value,id){ 
		if(value!==''){
			var post_url = "<?php echo site_url('products/get_state');?>/"+value;
			$.ajax({
				type: "GET",
				url: post_url,
				success: function(states)
				{
					if(id=='spng_country')
					{
						$('#spng_state').empty();
						$.each(states,function(id,state)
						{
							var opt = $('<option />');
							opt.val(id);
							opt.text(state);
							$('#spng_state').append(opt);
						});
					}
					else
					{
					   $('#blng_state').empty();
						$.each(states,function(id,state)
						{
							var opt = $('<option />');
							opt.val(id);
							opt.text(state);
							$('#blng_state').append(opt);
						}); 
					}
				}
			}); //end AJAX
		}
	}
	
	function savedata()
	{
		var firstname=$('#firstname').val();
		var lastname=$('#lastname').val();
		var email=$('#email').val();
		var phone=$('#phone').val();
		var amount=$('#amount').val();
		var blng_street=$('#blng_street').val();
		var blng_city=$('#blng_city').val();
		var blng_country=$('#blng_country').val();
		var blng_state=$('#blng_state').val();
		var blng_zipcode=$('#blng_zipcode').val();
		var blng_phone=$('#blng_phone').val();
		var spng_street=$('#spng_street').val();
		var spng_city=$('#spng_city').val();
		var spng_country=$('#spng_country').val();
		var spng_state=$('#spng_state').val();
		var spng_zipcode=$('#spng_zipcode').val();
		var spng_phone=$('#spng_phone').val();
		var transaction_id=$('#transaction_id').val();
		var price=$('#price').val();
		var quantity=$('#quantity').val();
		var product_id=$('#product_id').val();
		
		var phoneno = /^\+?([0-9]{0,2})\)?([0-9]{10})$/;
		
		
		
		if(firstname=="" || lastname=="" || email=="" || phone=="" || amount=="" || blng_street=="" || blng_city=="" || blng_country=="" || blng_state=="" || blng_zipcode=="" || spng_street=="" || spng_city=="" || spng_country=="" || spng_state=="" || spng_zipcode=="")
		{
			alert("Please enter all highlighted fields");
			
			
			if(firstname=="") { $('#firstname').addClass('emptyfield');  }
			if(lastname=="") { $('#lastname').addClass('emptyfield');  }
			if(email=="") { $('#email').addClass('emptyfield');  }
			if(phone=="") { $('#phone').addClass('emptyfield');  }
			if(amount=="") { $('#amount').addClass('emptyfield');  }
			if(blng_street=="") { $('#blng_street').addClass('emptyfield');  }
			if(blng_city=="") { $('#blng_city').addClass('emptyfield');  }
			if(blng_country=="") { $('#blng_country').addClass('emptyfield');  }
			if(blng_state=="") { $('#blng_state').addClass('emptyfield');  }
			if(blng_zipcode=="") { $('#blng_zipcode').addClass('emptyfield');  }
			if(blng_phone=="") { $('#blng_phone').addClass('emptyfield');  }
			if(spng_street=="") { $('#spng_street').addClass('emptyfield');  }
			if(spng_city=="") { $('#spng_city').addClass('emptyfield');  }
			if(spng_country=="") { $('#spng_country').addClass('emptyfield');  }
			if(spng_state=="") { $('#spng_state').addClass('emptyfield');  }
			if(spng_zipcode=="") { $('#spng_zipcode').addClass('emptyfield');  }
			if(spng_phone=="") { $('#spng_phone').addClass('emptyfield');  }
			
			return false;
		}	
	    else
		{	
				
			var regex = /^([a-zA-Z0-9_.+-])+\@(([a-zA-Z0-9-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        
			var emailvalid= regex.test(email);
			
			if(emailvalid==false)
			{
				alert("Please enter valid email address");
				$('#email').addClass('emptyfield');
				return false;
			}
			
			if (!(phone.match(phoneno))) 
			{
				alert("Please enter valid phone number");
				$('#phone').addClass('emptyfield');
				return false;
			}
						
			var checkpin=/^\d*$/;
        
			var pricevalid= checkpin.test(blng_zipcode);
			
			if(pricevalid==false)
			{
				alert("Please enter valid zipcode");
				$('#blng_zipcode').addClass('emptyfield');
				return false;
			}
			
			var pricevalid1= checkpin.test(spng_zipcode);
			
			if(pricevalid1==false)
			{
				alert("Please enter valid zipcode");
				$('#spng_zipcode').addClass('emptyfield');
				return false;
			}
			
			if (!(blng_phone.match(phoneno))) 
			{
				alert("Please enter valid phone number");
				$('#blng_phone').addClass('emptyfield');
				return false;
			}
			
			if (!(spng_phone.match(phoneno))) 
			{
				alert("Please enter valid phone number");
				$('#spng_phone').addClass('emptyfield');
				return false;
			}

		
			var post_url = "<?php echo site_url('products/proceedetocheckout');?>";
			
			$.ajax({
					type: "post",
					url: post_url,
					data: {firstname:firstname,lastname:lastname,email:email,phone:phone,amount:amount,blng_street:blng_street,blng_city:blng_city,blng_country:blng_country,blng_state:blng_state,blng_zipcode:blng_zipcode,blng_phone:blng_phone,spng_street:spng_street,spng_city:spng_city,spng_country:spng_country,spng_state:spng_state,spng_zipcode:spng_zipcode,spng_phone:spng_phone,transaction_id:transaction_id,price:price,quantity:quantity,product_id:product_id},
					success: function(response)
					{
						var res=response.trim();
						if(res=="fail")
						{
							alert("Something went wrong! Please check your input");
						}
						else
						{
							
							var post_url = "<?php echo site_url('products/getnewhash');?>";
							$.ajax({
							type: "post",
							url: post_url,
							data: { transaction_id:transaction_id},
							success: function(resp)
							{
								var resp=resp.trim();
								$('#hash').val(resp);
								$('#payuForm').submit();
							}
						  });
						
						  
						}
					}
					
				}); //end AJAX
		}
		
	}
	
	function shippingequal(id)
	{
		//document.getElementById(id).className = "form-control";
		
		document.getElementById(id).classList.remove("emptyfield");
		
		if(document.getElementById('shippingequal').checked==true) 
		{
				var blng_street=$('#blng_street').val();
				var blng_city=$('#blng_city').val();
				var blng_country=$('#blng_country').val();
				var blng_zipcode=$('#blng_zipcode').val();
				var blng_phone=$('#blng_phone').val();
				
				$('#spng_street').val(blng_street);
				$('#spng_city').val(blng_city);
				$('#spng_country').val(blng_country);
				$('#spng_zipcode').val(blng_zipcode);
				$('#spng_phone').val(blng_phone);
				
				if(id=='blng_country')
				{
					get_state(blng_country,"spng_country");
				}
				
				if(id=='blng_street')
				{
					document.getElementById('spng_street').classList.remove("emptyfield");
				}
				
				if(id=='blng_city')
				{
					document.getElementById('spng_city').classList.remove("emptyfield");
				}
				
				if(id=='blng_country')
				{
					document.getElementById('spng_country').classList.remove("emptyfield");
				}
				
				if(id=='blng_zipcode')
				{
					document.getElementById('spng_zipcode').classList.remove("emptyfield");
				}
				
				if(id=='blng_phone')
				{
					document.getElementById('spng_phone').classList.remove("emptyfield");
				}
				
				if(id=='blng_state')
				{
					document.getElementById('spng_state').classList.remove("emptyfield");
				}
				
				setTimeout(function () {setnewstate()}, 500);

	    } 
	}
	
	function setnewstate()
	{ 
		document.getElementById('spng_state').classList.remove("emptyfield");
		var blng_state=$('#blng_state').val();
		$('#spng_state').val(blng_state);
	}
	
	function removeredclass(id)
	{
		document.getElementById(id).classList.remove("emptyfield");
	}

</script>
