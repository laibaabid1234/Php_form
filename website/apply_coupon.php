<?php 
include('../connection.php');
$user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

if(isset($_SESSION['user_role']) && $_SESSION['user_role'] != 'user')
{
    header("Location: ../admin/dashboard.php");
    exit();
}
if(!isset($_POST['coupon'])||empty($_POST['coupon'])){
    echo json_encode(["status"=>"error","message"=>"Invalid request"]);
    unset($_SESSION['final_total']);
    unset($_SESSION['discount']);
    unset($_SESSION['coupon']);
    exit;
}

$coupon_code = strtoupper(trim($_POST['coupon']));
$total = $_POST['total'];

$query = "SELECT * FROM coupon WHERE coupon_code='$coupon_code' AND status=1 AND expiry_date >= CURDATE()";
$result = mysqli_query($conn,$query);

if(mysqli_num_rows($result)==0){
    echo json_encode(["status"=>"error","message"=>"Invalid coupon"]);
    exit;
}

$coupon = mysqli_fetch_assoc($result);

if($total < $coupon['order_amount']){
    echo json_encode(["status"=>"error","message"=>"Minimum order amount not met"]);
    exit;
}

$used = mysqli_query($conn,"SELECT id FROM coupon_usage WHERE user_id='$user_id' AND coupon_code='$coupon_code'");

if(mysqli_num_rows($used)>0){
    echo json_encode(["status"=>"error","message"=>"Coupon already used"]);
    exit;
}

$discount = ($total * $coupon['discount']) / 100;
$final    = $total - $discount;

$_SESSION['coupon']   = $coupon_code;
$_SESSION['discount'] = $discount;
$_SESSION['final_total'] = $final; 

mysqli_query($conn,"INSERT INTO coupon_usage(user_id,coupon_code)VALUES('$user_id','$coupon_code')"
);

echo json_encode([
    "status"=>"success",
    "discount"=>round($discount,2),
    "final_total"=>round($final,2)
]);
exit;
?>