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

function get_safe_value($con,$str){
    if($str!=''){
        $str=trim($str);
        return strip_tags(mysqli_real_escape_string($con,$str));
    }
}

function get_product($con,$limit='',$cat_id='',$product_id='',$search_str='',$sort_order='',$is_best_seller='',$sub_categories=''){
    $sql="select product.*,categories.categories from product,categories where product.status=1";
    if($cat_id!=''){
        $sql.=" and product.categories_id=$cat_id";
    }
    if($product_id!=''){
        $sql.=" and product.id=$product_id";
    }
    if($sub_categories!=''){
        $sql.=" and product.sub_categories_id=$sub_categories";
    }
    if($is_best_seller!=''){
        $sql.=" and product.best_seller=1";
    }
    $sql.=" and product.categories_id=categories.id";

    if($search_str!=''){
        $sql.=" and (product.name like '%$search_str%' or product.description like '%$search_str%')";
    }

    if($sort_order!=''){
        $sql.=$sort_order;
    }else{
        $sql.=" order by product.id desc ";
    }

    if($limit != ''){
        $sql.=" limit $limit";
    }
    $res = mysqli_query($con,$sql);
    $data=array();
    while($row=mysqli_fetch_assoc($res)){
        $data[]=$row;
    }
    return $data;
}

function get_sub_categories_name($con,$sub_categories_id=''){
    $sql="select sub_categories from sub_categories where id='$sub_categories_id'";
    $res = mysqli_query($con,$sql);
    $row=mysqli_fetch_assoc($res);
    return $row['sub_categories'];
}

function wishlist_add($con,$uid,$pid){
    $timestamp=get_current_time();
    mysqli_query($con,"INSERT INTO `wishlist`(`user_id`, `product_id`,`added_on`) VALUES ('$uid','$pid','$timestamp')");
}

function productSoldQtyByProductId($con,$pid){
    $sql="select sum(order_details.qty) as qty from order_details,`orders` where `orders`.id=order_details.order_id and order_details.product_id='$pid' and `orders`.order_status!=4 and ((`orders`.payment_type='payu' and `orders`.payment_status='success') or (`orders`.payment_type='COD' and `orders`.payment_status!=''))";
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

function get_current_time(){
    date_default_timezone_set('Asia/Kolkata');
    $timestamp = date("Y-m-d H:i:s");
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

function best_seller($con,$limit=''){
    $current_year=(date('Y'))-1;
    $sql="select * from product where best_seller='1' and status='1' and added_on='$current_year' order by id desc";

    if($limit != ''){
        $sql.=" limit $limit";
    }
    $res = mysqli_query($con,$sql);
    $data=array();
    while($row=mysqli_fetch_assoc($res)){
        $data[]=$row;
    }

    return $data;
}

function new_product($con,$limit=''){
    $sql="select * from product where status='1' order by id desc";

    if($limit != ''){
        $sql.=" limit $limit";
    }
    $res = mysqli_query($con,$sql);
    $data=array();
    while($row=mysqli_fetch_assoc($res)){
        $data[]=$row;
    }

    return $data;
}
 
function get_data_details($added_on='',$year='',$month='',$day='',$hour='',$min='',$sec=''){

    $order_date_str=$added_on;
	$order_date_str=strtotime($order_date_str);
    if($year!=''){
        $order_date=date('Y',$order_date_str);
    }
    if($month!=''){
        $order_date=date('m',$order_date_str);
    }
    if($day!=''){
        $order_date=date('d',$order_date_str);
    }
    if($hour!=''){
        $order_date=date('H',$order_date_str);
    }
    if($min!=''){
        $order_date=date('i',$order_date_str);
    }
    if($sec!=''){
        $order_date=date('s',$order_date_str);
    }
    if($year!='' && $month!='' && $day!=''){
        $order_date=date('d-M-Y',$order_date_str);
    }
    if($hour!='' && $min!='' && $sec!=''){
        $order_date=date('H:i:s',$order_date_str);
    }
    if($hour!='' && $min!=''){
        $order_date=date('H:i',$order_date_str);
    }
    return $order_date;
}

function get_categories_name($con){
    $sql="select * from categories where status='1'";
    $res=mysqli_query($con,$sql);
    $data=array();
    while($row=mysqli_fetch_assoc($res)){
        $data[]=$row;   
    }
    return $data;
}

function get_new_books_index($con,$limit=''){
    $sql="select * from product where status='1' and book_condition='New'";
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

function get_old_books_index($con,$limit=''){
    $sql="select * from product where status='1' and book_condition='Old'";
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

function rating_calculation($con,$pid){
    $sql="select rating from rating where product_id='$pid'";
    $res=mysqli_query($con,$sql);
    $number_OfRating=mysqli_num_rows($res);
    $final_rating=0;
    if($number_OfRating==0){
        $final_rating=0;
    }else{
        while($row=mysqli_fetch_assoc($res)){
               $final_rating=($final_rating+$row['rating']);
        }
        $final_rating=$final_rating/$number_OfRating;
    }
    return $final_rating;
}

function total_rating_and_reviews($con,$pid){
    $sql="select * from rating where product_id='$pid'";
    $res=mysqli_query($con,$sql);
    $data=array();
    while($row=mysqli_fetch_assoc($res)){
        $data[]=$row;   
    }
    return $data;
}

function get_review_details($con,$uid,$pid,$limit=''){
    $sql="select authentication.firstname,authentication.lastname,rating.review,rating.rating,rating.added_on from rating,authentication where rating.product_id='$pid' and authentication.id=rating.user_id ";
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