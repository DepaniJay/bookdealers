<?php

require('connection_inc.php');
require('functions_inc.php');
require('add_to_cart_inc.php');

$pid = get_safe_value($con,$_POST['pid']);
$qty = get_safe_value($con,$_POST['qty']);
$type = get_safe_value($con,$_POST['type']);

$productSoldQtyByProductId=productSoldQtyByProductId($con,$pid);
$productQty=productQty($con,$pid);

$pending_qty=$productQty-$productSoldQtyByProductId;

if($qty<1){
    
}else{
    if($qty>$pending_qty){
        echo "not_available";
        die();
    }
    $obj = new add_to_cart();
    
    if($type == 'add'){
        $obj->addProduct($pid,$qty);
    }
    
    if($type == 'remove'){
        $obj->removeProduct($pid);
    }
    
    if($type == 'update'){
        $obj->updateProduct($pid,$qty);
    }
}
echo $obj->totalProduct();
?>