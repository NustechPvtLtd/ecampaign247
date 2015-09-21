<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Productsmodel extends CI_Model {

    function __construct()
    {
        parent::__construct();
        
        $this->load->database();
    }
    
	//..............redirect on particular product page when clicks on buynow
    public function buynow($prid)  // Function to get all documents for particular user
	{
		$query=$this->db->query("select * from users_products where product_id='".$prid."' ");
		return $query->result();
    }
	
	//....................get all countries
	public function get_country()
	{
		$query=$this->db->query("select * from country order by name asc");
		return $query->result();
	}
	
	////...........store information when placing an order
	public function proceedetocheckout()
	{
		$transaction_id=$_POST['transaction_id'];
		$price=$_POST['price'];
		$quantity=$_POST['quantity'];
		
		$product_id=$_POST['product_id'];
		$firstname=$_POST['firstname'];
		$lastname=$_POST['lastname'];
		$email=$_POST['email'];
		$phone=$_POST['phone'];
		$amount=$_POST['amount'];
		$blng_street=$_POST['blng_street'];
		$blng_city=$_POST['blng_city'];
		$blng_country=$_POST['blng_country'];
		$blng_state=$_POST['blng_state'];
		$blng_zipcode=$_POST['blng_zipcode'];
		$blng_phone=$_POST['blng_phone'];
		$spng_street=$_POST['spng_street'];
		$spng_city=$_POST['spng_city'];
		$spng_country=$_POST['spng_country'];
		$spng_state=$_POST['spng_state'];
		$spng_zipcode=$_POST['spng_zipcode'];
		$spng_phone=$_POST['spng_phone'];
		
		$res="";
		$query=$this->db->query("insert into customer_details(firstname,lastname,email,phone)values('".$firstname."','".$lastname."','".$email."','".$phone."')");
		
		if(!$query){ $res="no";}
		
		$id=$this->db->insert_id();
		
		$res1="";
		$query1=$this->db->query("insert into customer_orders(customer_id,product_id,transaction_id,price,quantity,amount)values('".$id."','".$product_id."','".$transaction_id."','".$price."','".$quantity."','".$amount."')");
		
		if(!$query1){ $res1="no";}
		
		$res2="";
		$query2=$this->db->query("insert into customer_address(customer_id,street,city,zipcode,country,state,phone,type)values('".$id."','".$blng_street."','".$blng_city."','".$blng_zipcode."','".$blng_country."','".$blng_state."','".$blng_phone."','billing')");
		
		if(!$query2){ $res2="no";}
		
		$res3="";
		$query3=$this->db->query("insert into customer_address(customer_id,street,city,zipcode,country,state,phone,type)values('".$id."','".$spng_street."','".$spng_city."','".$spng_zipcode."','".$spng_country."','".$spng_state."','".$spng_phone."','shipping')");
		
		if(!$query3){ $res3="no";}
		
		if($res=="" && $res1=="" && $res2=="" && $res3=="")
		{
			echo "success";
		}
		else
		{
			echo "fail";	
		}

	}
	
	//................get states according to country
	function get_state_by_country ($country)
	{
        $this->db->select('zone_id, name');
        
        $this->db->where('country_id', $country);
        
        $query = $this->db->get('zone');
        $states = array();

        if($query->result()){
            foreach ($query->result() as $state) {
                $states[$state->zone_id] = $state->name;
            }
            return $states;
        } else {
            return FALSE;
        }
    } 
	
	//.................change order status after payment
	public function success($txnid,$st)
	{
		$query=$this->db->query("update customer_orders set response='".$st."' where transaction_id='".$txnid."' ");
	}
	
	//......................get product order details
	public function getprodctorder($txnid)
	{
		$query=$this->db->query("select * from customer_orders where transaction_id='".$txnid."' ");
		return $res=$query->result();
	}
	
	//...............successfull email for product owner and customer details.	
	public function successfull_purchase($txnid,$firstname,$email)
	{
			$query=$this->db->query("select * from customer_orders where transaction_id='".$txnid."' ");
		    $result=$query->result();
			
			$product_id="";
			$price="";
			$quantity="";
			$amount="";
			foreach($result as $res) //.....get order details
			{
				$product_id=$res->product_id;
				$price=$res->price;
				$quantity=$res->quantity;
				$amount=$res->amount;
			}
			
			$query=$this->db->query("select * from users_products where product_id='".$product_id."' ");
		    $result=$query->result();
			
			$pname="";
			$user_id="";
			foreach($result as $res) //........get product details
			{
				$pname=$res->name;
				$user_id=$res->user_id;
			}
			
			$query=$this->db->query("select * from users where  id='".$user_id."' ");
		    $result=$query->result();
			
			$ownername="";
			$owneremail="";
			foreach($result as $res) //...........get product owner details
			{
				$ownername=$res->first_name;
				$owneremail=$res->email;
			}
			
			$subject="Order Confirmation"; //....subject for email confirmation
			
			$to=$email;
			
			$mail_body = "Hello".$firstname.","."<br>Thank you for your order. This e-mail confirms that we've received your order. <br><br> Below are your order details. <br><br><b>Product Name</b> - ".$pname."<br><br><b>Price</b> - ".$price."<br><br><b>Quantity</b> - ".$quantity."<br><br><b>Total Amount</b> - ".$amount." <br><br>";

			 $headers  ='From: Webzero <info@webzero.in>' . "\r\n" .
	
				'Reply-To: info@webzero.in' . "\r\n" .
	
				'X-Mailer: PHP/' . phpversion() . "\r\n" .
	
				'Content-Type: text/html; charset=ISO-8859-1'."\r\n".
	
				'MIME-Version: 1.0'."\r\n\r\n";
	
			// mail($to, $subject, $mail_body, $headers);
			 
			 
			 $to1=$owneremail;
			 
			 $mail_body1 = "Hello".$ownername.","."<br>Your product has been purchased successfully. <br><br> Below are the customer and order details. <br><br><b>Customer Name</b> - ".$firstname."<br><br><b>Customer Email</b> - ".$email."<br><br><b>Product Name</b> - ".$pname."<br><br><b>Price</b> - ".$price."<br><br><b>Quantity</b> - ".$quantity."<br><br><b>Total Amount</b> - ".$amount." <br><br>";
			 
//          mail($to1, $subject, $mail_body1, $headers);
		 
		
//          $message = $this->load->view($this->config->item('ecommerce_email_templates', 'ion_auth').$this->config->item('successfull_purchase', 'ion_auth'), $data, true);
//			$this->email->clear();
//			$this->email->from($this->config->item('admin_email', 'ion_auth'), $this->config->item('site_title', 'ion_auth'));
//			$this->email->to($user->email);
//			$this->email->subject($this->config->item('site_title', 'ion_auth') . ' - ' . $this->lang->line('email_forgotten_password_subject'));
//			$this->email->message($message);
	}

}

?>