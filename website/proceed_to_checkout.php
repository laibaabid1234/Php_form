<?php
if(isset($_POST['subtotal']) && isset($_POST['tax']) && isset($_POST['total'])){
    // echo "<pre>";
    // print_r($_REQUEST);
    // echo "</pre>";
    // exit;
    include('../connection.php');
    $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
    if(!$user_id){
        header('Location: ../login.php');
        exit;
    }

    $subtotal = $_POST['subtotal'];
    $tax = $_POST['tax'];
    $total = $_POST['total'];
    $firstName=$_POST['fname'];
    $lastName=$_POST['lname']; 
    $email=$_POST['email'];
    $address=$_POST['address'];
    $contact=$_POST['contact'];
    $country=$_POST['country'];
    $city=$_POST['city'];
    $province=$_POST['state'];
    $zip=$_POST['zip'];


    $orderQuery = "INSERT INTO orders (user_id, total_amount, tax, first_name,last_name,email,address,contact,country,city,province,zip) 
    VALUES ('$user_id', '$total', '$tax','$firstName','$lastName','$email','$address','$contact','$country','$city','$province','$zip')";
    if(mysqli_query($conn, $orderQuery)){
        $order_id = mysqli_insert_id($conn);
    
        // while($_POST['product_id']){
        //     $product_id = $_POST['product_id'];
        //     $quantity = $_POST['product_quantity'];
        //     $price = $_POST['product_total'];
        //     $orderItemsQuery = "INSERT INTO order_items (order_id, product_id, quantity, total) 
        //     VALUES ('$order_id', '$product_id', '$quantity', '$price')";
        //     mysqli_query($conn, $orderItemsQuery);
        // }
        $product_ids     = $_POST['product_id'];
        $quantities      = $_POST['product_quantity'];
        $totals          = $_POST['product_total'];

        foreach ($product_ids as $index => $product_id) {

            $quantity = $quantities[$index];
            $total    = $totals[$index];

            $orderItemsQuery = "INSERT INTO order_items (order_id, product_id, quantity, total)
                                VALUES ('$order_id', '$product_id', '$quantity', '$total')";
            mysqli_query($conn, $orderItemsQuery);
        }

        $clearCartQuery = "DELETE FROM cart WHERE user_id='$user_id'";
        mysqli_query($conn, $clearCartQuery);
    
    } 
    $message = "Order placed successfully!";
    header('Location:checkout.php?message=' . urlencode($message));
    exit;
} else {
    $message = "Invalid request.";
    header('Location:checkout.php?message=' . urlencode($message));
    exit;
}
?>