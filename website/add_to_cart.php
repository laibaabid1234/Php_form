<?php
include('../connection.php');
$user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;


if(isset($_POST['cartUpdate']) && $_POST['cartUpdate'] == true){
    $cart_id = $_POST['product_Id'];
    $quantity = $_POST['productQuantity'];
    $price = $_POST['price'];
    $total=$quantity* $price;

    if(!$user_id){
        echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
        exit;
    }

    $updateQuery = "UPDATE cart SET quantity='$quantity',price='$price',total='$total' WHERE id='$cart_id'";
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
    $quantity = 1;
    $total = $product_price * $quantity;
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

    $cart="INSERT INTO cart (user_id, product_id, quantity,price,total) VALUES ('$user_id','$product_id', 1, $product_price,$total)";
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