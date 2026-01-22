<?php
include('../connection.php');
include('price_function.php');
if(isset($_SESSION['user_role']) && $_SESSION['user_role'] != 'user')
{
    header("Location: ../admin/dashboard.php");
    exit();
}
$user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;


if(isset($_POST['cartUpdate']) && $_POST['cartUpdate'] == true){
    $cart_id = $_POST['product_Id'];
    $quantity = $_POST['productQuantity'];
    $productPrice = $_POST['price'];
    $productdiscount = $_POST['discount'];
    $cartPrice = getFinalPrice($productPrice, $productdiscount);
    $total= $quantity * $cartPrice;

    if(!$user_id){
        echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
        exit;
    } 
                                                                                               
    $updateQuery = "UPDATE cart SET quantity='$quantity',price='$cartPrice',total='$total' WHERE id='$cart_id'";
    if(mysqli_query($conn, $updateQuery)){
        echo json_encode(['status' => 'success', 'message' => 'Cart updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update cart']);
    }
    exit;
}

if(isset($_POST['productId'])) {
    $product_id = $_POST['productId'];
    $product_price = $_POST['price'];
    $productdiscount = $_POST['discount'];
    $cartPrice = getFinalPrice($product_price, $productdiscount);
    $quantity = 1;
    $total = $cartPrice * $quantity;
    if(!$user_id){
        echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
        exit;
    }

    $existingproductQuery = "SELECT * FROM cart WHERE user_id='$user_id' AND product_id='$product_id'";
    $existingproductResult = mysqli_query($conn, $existingproductQuery);
    if(mysqli_num_rows($existingproductResult) > 0){
        echo json_encode(['status' => 'error', 'message' => 'Product already in cart']);
        exit;
    }

    $cart="INSERT INTO cart (user_id, product_id, quantity,price,total) VALUES ('$user_id','$product_id', 1, $cartPrice,$total)";
    mysqli_query($conn, $cart);
    $cartCountQuery = "SELECT COUNT(*) AS count FROM cart WHERE user_id='$user_id'";
    $cartCountResult = mysqli_query($conn, $cartCountQuery);
    $cartCountRow = mysqli_fetch_assoc($cartCountResult);
    
    echo json_encode(['status' => 'success', 
    'message' => 'Product added to cart', 
    'product_id' => $product_id,
    'cart_count' => $cartCountRow['count']]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No product ID provided']);
}





?>