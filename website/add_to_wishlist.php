<?php
include('../connection.php');
if(isset($_SESSION['user_role']) && $_SESSION['user_role'] != 'user')
{
    header("Location: ../admin/dashboard.php");
    exit();
}
$user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;

if(isset($_POST['wishlistUpdate']) && $_POST['wishlistUpdate'] == "true"){
    $wishlist_id = $_POST['productId'];
    $price = $_POST['price'];

    if(!$user_id){
        echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
        exit;
    }

    $updateQuery = "UPDATE wishlist SET price='$price' WHERE id='$wishlist_id'";
    if(mysqli_query($conn, $updateQuery)){
        echo json_encode(['status' => 'success', 'message' => 'Wishlist updated successfully']);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to update wishlist']);
    }
    exit;
}

if(isset($_POST['productId'])) {
    $product_id = $_POST['productId'];
    $product_price = $_POST['price'];
    
    if(!$user_id){
        echo json_encode(['status' => 'error', 'message' => 'User not logged in']);
        exit;
    }

    $existingproductQuery = "SELECT * FROM wishlist WHERE user_id='$user_id' AND product_id='$product_id'";
    $existingproductResult = mysqli_query($conn, $existingproductQuery);
    if(mysqli_num_rows($existingproductResult) > 0){
        echo json_encode(['status' => 'error', 'message' => 'Product already in wishlist']);
        exit;
    }

    $cart="INSERT INTO wishlist (user_id, product_id, price) VALUES ('$user_id','$product_id', '$product_price')";
    mysqli_query($conn, $cart);
    $cartCountQuery = "SELECT COUNT(*) AS count FROM wishlist WHERE user_id='$user_id'";
    $cartCountResult = mysqli_query($conn, $cartCountQuery);
    $cartCountRow = mysqli_fetch_assoc($cartCountResult);
    
    echo json_encode(['status' => 'success', 
    'message' => 'Product added to wishlist', 
    'product_id' => $product_id,
    'wishlist_count' => $cartCountRow['count']]);
} else {
    echo json_encode(['status' => 'error', 'message' => 'No product ID provided']);
}

?>