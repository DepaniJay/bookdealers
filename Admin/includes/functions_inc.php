<?php

// show any array details
function pr($arr){
    echo '<pre>';
    print_r($arr);
}

function prx($arr){
    echo '<pre>';
    print_r($arr);
    die();
}

// secure any variable values
function get_safe_value($con,$str){
    if($str!=''){
        $str=trim($str);
		return strip_tags(mysqli_real_escape_string($con,$str));
    }
}

function productSoldQtyByProductId($con,$pid){
    $sql="select sum(order_details.qty) as qty from order_details,`orders` where `orders`.id=order_details.order_id and order_details.product_id='$pid' and `orders`.order_status!=4";
    $res = mysqli_query($con,$sql);
    $row=mysqli_fetch_assoc($res);
    return $row['qty'];
}

function productQty($con,$pid){
    $sql="select qty from product where id='$pid'";
    $res = mysqli_query($con,$sql);
    $row=mysqli_fetch_assoc($res);
    return $row['qty'];
}

function validShipRocketToken($con){
    date_default_timezone_set('Asia/Kolkata');
    $row = mysqli_fetch_assoc(mysqli_query($con,"select * from shiprocket_token"));
    $added_on=strtotime($row['added_on']);
    $current_time=strtotime(date('Y-m-d h:i:s'));
    $diff_time=$current_time-$added_on;
    if($diff_time>86400){
		$token=generateShipRocketToken($con);
	}else{
		$token=$row['token'];
	}
	return $token;
}

function generateShipRocketToken($con){
	date_default_timezone_set('Asia/Kolkata');
	$curl = curl_init();
    curl_setopt_array($curl, array(
    CURLOPT_URL => "https://apiv2.shiprocket.in/v1/external/auth/login",
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_ENCODING => "",
    CURLOPT_MAXREDIRS => 10,
    CURLOPT_TIMEOUT => 0,
    CURLOPT_FOLLOWLOCATION => true,
    CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
    CURLOPT_CUSTOMREQUEST => "POST",
    CURLOPT_POSTFIELDS =>"{\n    \"email\": \"jdcoder007@gmail.com\",\n    \"password\": \"jdcodersecondary@007\"\n}",
    CURLOPT_HTTPHEADER => array(
      "Content-Type: application/json"
    ),
  ));
  $SR_login_Response = curl_exec($curl);
  curl_close($curl);
  $SR_login_Response_out = json_decode($SR_login_Response);
  $token = $SR_login_Response_out->{'token'};
  $added_on=date('Y-m-d h:i:s');
  mysqli_query($con,"update shiprocket_token set token='$token',added_on='$added_on' where id=1");
  return $token;
}

function placeShipRocketOrder($con,$token,$order_id){
	$row_order=mysqli_fetch_assoc(mysqli_query($con,"select `orders`.*,authentication.firstname,authentication.lastname,authentication.email,authentication.mobile from `orders`,authentication where `orders`.id=$order_id and `orders`.user_id=authentication.id"));
	
	$order_date_str=$row_order['added_on'];
	$order_date_str=strtotime($order_date_str);
	$order_date=date('Y-m-d h:i',$order_date_str);

	$firstname=$row_order['firstname'];
	$lastname=$row_order['lastname'];
	$email=$row_order['email'];
	$mobile=$row_order['mobile'];

	$address=$row_order['address'];
	$pincode=$row_order['pincode'];
	$city=$row_order['city'];
	$state=$row_order['state'];
	$country=$row_order['country'];

	$length=$row_order['length'];
	$breadth=$row_order['breadth'];
	$height=$row_order['height'];
	$weight=$row_order['weight'];

	$payment_type=$row_order['payment_type'];
	if($payment_type=='payu'){
		$payment_type='Prepaid';
	}

	$total_price=$row_order['total_price'];
	
	$res=mysqli_query($con,"select order_details.*,product.name from order_details,product where product.id=order_details.product_id and order_details.order_id='$order_id'");
	$html='';
	
	while($row=mysqli_fetch_assoc($res)){
		$sku=rand(111111,999999);
		$html.='{
		  "name": "'.$row['name'].'",
		  "sku": "'.$sku.'",
		  "units": '.$row['qty'].',
		  "selling_price": "'.$row['price'].'",
		  "discount": "",
		  "tax": "",
		  "hsn": ""
		},';
	}
	$html=rtrim($html,",");
	
	$curl = curl_init();
	  curl_setopt_array($curl, array(
		CURLOPT_URL => "https://apiv2.shiprocket.in/v1/external/orders/create/adhoc",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS =>'{"order_id": "'.$order_id.'",
	  "order_date": "'.$order_date.'",
	  "pickup_location": "Jd",
	  "billing_customer_name": "'.$firstname.'",
	  "billing_last_name": "'.$lastname.'",
	  "billing_address": "'.$address.'",
	  "billing_address_2": "",
	  "billing_city": "'.$city.'",
	  "billing_pincode": "'.$pincode.'",
	  "billing_state": "'.$state.'",
	  "billing_country": "'.$country.'",
	  "billing_email": "'.$email.'",
	  "billing_phone": "'.$mobile.'",
	  "shipping_is_billing": true,
	  "shipping_customer_name": "",
	  "shipping_last_name": "",
	  "shipping_address": "",
	  "shipping_address_2": "",
	  "shipping_city": "",
	  "shipping_pincode": "",
	  "shipping_country": "",
	  "shipping_state": "",
	  "shipping_email": "",
	  "shipping_phone": "",
	  "order_items": [
		'.$html.'
	  ],
	  "payment_method": "'.$payment_type.'",
	  "shipping_charges": 0,
	  "giftwrap_charges": 0,
	  "transaction_charges": 0,
	  "total_discount": 0,
	  "sub_total": "'.$total_price.'",
	  "length": '.$length.',
	  "breadth": '.$breadth.',
	  "height": '.$height.',
	  "weight": '.$weight.'
		}',
    CURLOPT_HTTPHEADER => array(
      "Content-Type: application/json",
	   "Authorization: Bearer $token"
    ),
  ));
  $SR_login_Response = curl_exec($curl);
  curl_close($curl);
  $SR_login_Response_out = json_decode($SR_login_Response);
  $ship_order_id=$SR_login_Response_out->order_id;
  $ship_shipment_id=$SR_login_Response_out->shipment_id;

  mysqli_query($con,"update `orders` set ship_order_id='$ship_order_id', ship_shipment_id='$ship_shipment_id' where id='$order_id'");
//   echo '<pre>';
//   print_r($SR_login_Response);
}


function cancelShipRocketOrder($token,$ship_order_id){
	
	$curl = curl_init();
	curl_setopt_array($curl,array(
		CURLOPT_URL => "https://apiv2.shiprocket.in/v1/external/orders/cancel",
		CURLOPT_RETURNTRANSFER => true,
		CURLOPT_ENCODING => "",
		CURLOPT_MAXREDIRS => 10,
		CURLOPT_TIMEOUT => 0,
		CURLOPT_FOLLOWLOCATION => true,
		CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
		CURLOPT_CUSTOMREQUEST => "POST",
		CURLOPT_POSTFIELDS => "{\n	\"ids\": [".$ship_order_id."]\n}",
		CURLOPT_HTTPHEADER => array(
			"Content-Type: application/json",
			"Authorization: Bearer $token"
		),
	));

	$response= curl_exec($curl);
	curl_close($curl);
}

function isAdmin(){
	if($_SESSION['admin_level']=='Admin'){
		moveCurrentPageToOtherPage('admin_index.php');
	}
}


function dashboard_users($con,$uid=''){
	$res=mysqli_query($con,"select * from `authentication` where status='1'");
	$count=mysqli_num_rows($res);
	return $count;
}

function dashboard_completed_orders($con,$uid=''){

	if($uid!=''){
		$sql="select DISTINCT(`orders`.id) from order_details,product,`orders`,order_status where `orders`.order_status=order_status.id and product.id=order_details.product_id and `orders`.id=order_details.order_id and product.added_by='$uid' and `orders`.order_status='5'";
	}else{
		$sql="select * from `orders` where order_status='5'";
	}
	$res=mysqli_query($con,$sql);
	$count=mysqli_num_rows($res);
	return $count;
}

function dashboard_new_orders($con,$uid=''){
	
	if($uid!=''){
		$sql="select DISTINCT(`orders`.id) from order_details,product,`orders`,order_status where `orders`.order_status=order_status.id and product.id=order_details.product_id and `orders`.id=order_details.order_id and product.added_by='$uid' and (`orders`.order_status='1' or `orders`.order_status='2' or `orders`.order_status='3')";
	}else{
		$sql="select * from `orders` where (order_status='1' or order_status='2' or order_status='3')";
	}
	$res=mysqli_query($con,$sql);
	$count=mysqli_num_rows($res);
	return $count;
}

function dashboard_earnings($con,$uid=''){

	$earnings=0;
	if($uid!=''){
		$sql="select order_details.* from order_details,product,`orders` where order_details.order_id=orders.id and order_details.product_id=product.id and product.added_by='$uid' and orders.order_status='5'";
		$res=mysqli_query($con,$sql);
		while($row=mysqli_fetch_assoc($res)){
			$earnings=$earnings+(($row['price']*5)/100);
		}

	}else{
		$sql="select old_total_price from `orders` where order_status='5'";
		$res=mysqli_query($con,$sql);
		while($row=mysqli_fetch_assoc($res)){
			$earnings=$earnings+(($row['old_total_price']*5)/100);
		}
	}
	
	return $earnings;
}

function dashboard_messages($con,$limit=''){
	$sql="select * from contact_us order by id desc";
	
	if($limit != ''){
		$sql.=" limit $limit";
    }
	$res=mysqli_query($con,$sql);
	$data=array();
    while($row=mysqli_fetch_assoc($res)){
        $data[]=$row;
    }
    return $data;
}

function dashboard_contact_us($con){
	$res=mysqli_num_rows(mysqli_query($con,"select * from contact_us"));
	return $res;
}

function dashboard_user_profile($con,$uid){
	$sql="select * from admin_users where id='$uid'";
	$res=mysqli_query($con,$sql);
	$data=array();
    while($row=mysqli_fetch_assoc($res)){
        $data[]=$row;
    }
    return $data;
}

function dashboard_books($con,$uid){
	$sql=mysqli_query($con,"select qty from product where added_by='$uid'");
	$total_qty=0;
	while($row=mysqli_fetch_assoc($sql)){
		$total_qty=$total_qty+$row['qty'];
	}

	$used_qty="select sum(order_details.qty) as qty from order_details,`orders`,product where `orders`.id=order_details.order_id and order_details.product_id=product.id and product.added_by='$uid' and `orders`.order_status!=4 and ((`orders`.payment_type='payu' and `orders`.payment_status='success') or (`orders`.payment_type='COD' and `orders`.payment_status!=''))";
    $res = mysqli_query($con,$used_qty);
    $used_qty_row=mysqli_fetch_assoc($res);
	$used_user_qty=$used_qty_row['qty'];

	$remaining_qty=$total_qty-$used_user_qty;

	return $remaining_qty;
}

function get_current_time(){
    date_default_timezone_set('Asia/Kolkata');
    $timestamp = date("Y-m-d H:i:s");
    return $timestamp;
}

function get_current_year(){
    date_default_timezone_set('Asia/Kolkata');
    $timestamp = date('Y');
    return $timestamp;
}

function moveCurrentPageToOtherPage($str){
	$str=trim($str);
	?>
		<script>
			window.location.href='<?php echo $str; ?>';
		</script>
	<?php
}


function smtp_mailer($to,$subject,$body){
	$mail = new PHPMailer(); 
	// $mail->SMTPDebug  = 3;
	$mail->IsSMTP(); 
	$mail->SMTPAuth = true; 
	$mail->SMTPSecure = 'tls'; 
	$mail->Host = "smtp.gmail.com";
	$mail->Port = 587; 
	$mail->IsHTML(true);
	$mail->CharSet = 'UTF-8';
	$mail->Username = "jdcoder007@gmail.com";
	$mail->Password = "jdcodersecondary@007";
	$mail->SetFrom("jdcoder007@gmail.com");
	$mail->Subject = $subject;
	$mail->Body =$body;
	$mail->AddAddress($to);
	$mail->SMTPOptions=array('ssl'=>array(
		'verify_peer'=>false,
		'verify_peer_name'=>false,
		'allow_self_signed'=>false
	));
	if(!$mail->Send()){
		echo $mail->ErrorInfo;
	}else{
		return 'Sent';
	}
}
?>


