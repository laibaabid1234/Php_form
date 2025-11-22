<?php
include('../connection.php');
if(isset($_POST['cartId'])) {   
    $cart_id = $_POST['cartId'];
    $deleteQuery = "DELETE FROM cart WHERE id='$cart_id'";
    if(mysqli_query($conn, $deleteQuery)){
        $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
        $cartCountQuery = "SELECT COUNT(*) AS count FROM cart WHERE user_id='$user_id'";
        $cartCountResult = mysqli_query($conn, $cartCountQuery);
        $cartCountRow = mysqli_fetch_assoc($cartCountResult);
        echo json_encode(['status' => 'success', 'message' => 'Product removed from cart', 'cart_count' => $cartCountRow['count']]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to remove product from cart']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No cart ID provided']);
}
?>