<?php
include('../connection.php');
if(isset($_SESSION['user_role']) && $_SESSION['user_role'] != 'user')
{
    header("Location: ../admin/dashboard.php");
    exit();
}
if(isset($_POST['wishlistId'])) {   
    $wishlist_id = $_POST['wishlistId'];
    $deleteQuery = "DELETE FROM wishlist WHERE id='$wishlist_id'";
    if(mysqli_query($conn, $deleteQuery)){
        $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
        $wishlistCountQuery = "SELECT COUNT(*) AS count FROM wishlist WHERE user_id='$user_id'";
        $wishlistCountResult = mysqli_query($conn, $wishlistCountQuery);
        $wishlistCountRow = mysqli_fetch_assoc($wishlistCountResult);
        echo json_encode(['status' => 'success', 'message' => 'Product removed from wishlist', 'wishlist_count' => $wishlistCountRow['count']]);
    } else {
        echo json_encode(['status' => 'error', 'message' => 'Failed to remove product from wishlist']);
    }
} else {
    echo json_encode(['status' => 'error', 'message' => 'No wishlist ID provided']);
}
?>