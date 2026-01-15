<?php
include('layout/header.php');
$user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
$cartCountQuery = "SELECT COUNT(*) AS count FROM cart WHERE user_id='$user_id'";
$cartCountResult = mysqli_query($conn, $cartCountQuery);
$cartCountRow = mysqli_fetch_assoc($cartCountResult);
$cartCount = $cartCountRow['count'];

$query = "SELECT * FROM products";
$result = mysqli_query($conn, $query);
$row = $result->fetch_assoc();
$productId = $row['id'];           

// $query="SELECT remaining FROM products where id= $productId";
// $remainingquery = $conn->query($query);
// $remainingproducts = $remainingquery->fetch_assoc();
// $remaining= $remainingproducts['remaining'];  

echo "<script>
if (window.history.replaceState) {
  window.history.replaceState(null, null, window.location.href);
}
</script>";
?>
  <!-- Cart Start -->
    <div class="container-fluid">
         <?php if($cartCount > 0){ ?>
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Quantity</th>
                            <th>Total</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        <?php 
                        $cartQuery = "select cart.id as id,cart.quantity as quantity,cart.product_id as product_id,cart.total 
                        as total, products.p_name as name, products.p_price as price,products.image as image ,
                        products.remaining as remaining from cart inner join products on cart.product_id=products.id 
                        where cart.user_id='$_SESSION[id]'";
                        $cartResult = mysqli_query($conn, $cartQuery);
                        while($cartRow = mysqli_fetch_assoc($cartResult)){
                            
                            $productQuantity = $cartRow['quantity'];
                            $total= $cartRow['total'];
                            $productId = $cartRow['product_id'];
                            $productName = $cartRow['name'];
                            $productPrice = $cartRow['price'];   
                            $productImage = $cartRow['image'];
                            $cartid = $cartRow['id'];
                            $remaining = $cartRow['remaining']; ?>

                        <tr>
                            <td class="align-middle"><img src=" <?php echo  $productImage ?>" alt="" style="width: 50px;"> <?php echo $productName ?></td>
                            <td class="align-middle price"><?php echo $productPrice ?></td>
                            <td class="align-middle">
                                <div class="input-group quantity mx-auto" style="width: 100px;">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-minus" >
                                        <i class="fa fa-minus"></i>
                                        </button>
                                    </div>
                                    <input type="text" class="form-control form-control-sm bg-secondary border-0 text-center p_quantity" data-remaining=<?php echo $remaining; ?> value="<?php echo $productQuantity; ?>">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-plus" data-remaining=<?php echo $remaining; ?>>
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle total_amount"><?php echo $total ?></td>
                            <td class="align-middle"><button class="btn btn-sm btn-danger" data-id="<?php echo $cartid ?>"><i class="fa fa-times"></i></button></td>
                        </tr>
                        <?php } ?>
                        
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">

                <form class="mb-3">
                    <div class="input-group">
                        <input type="text" id="coupon_code" class="form-control" placeholder="Coupon Code">
                        <div class="input-group-append">
                            <button type="button" id="apply_coupon" class="btn btn-primary">Apply Coupon</button>                       
                        </div>
                    </div>
                </form>        
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart Summary</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Subtotal</h6>
                            <h6 id="subtotal"></h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">10% Tax</h6>
                            <h6 class="font-weight-medium" id="tax"></h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <span id="discount"></span>
                            <span id="final_total"></span>
                            <h5 id="total"></h5>
                            

                        </div>
                        <a class="btn btn-block btn-primary font-weight-bold my-3 py-3" href="checkout.php">Proceed To Checkout</a>
                    </div>
                </div>
            </div>
        </div>
        <?php } else { ?>
            <div class="container">
                <div class="text-center py-5">
                <h2>Your cart is empty.</h2>
                </div>
            </div>
        <?php } ?>
    </div>
    <!-- Cart End -->

    <script>
    $(document).ready(function(){

        var subtotal=0;
        function calculateTotals(){
            subtotal = 0;
            $(".total_amount").each(function(){
                var amount = parseFloat($(this).text());
                subtotal += amount;
            });
            $("#subtotal").text(subtotal.toFixed(2));
            $("#subtotal_input").val(subtotal.toFixed(2));
            var tax = subtotal * 0.10;
            $("#tax").text(tax.toFixed(2));
            var total = subtotal + tax;
            $("#total").text(total.toFixed(2));
        }
        calculateTotals();


       $(".btn-plus").on('click', function(){
            var quantityInput = $(this).closest(".quantity").find(".p_quantity");       
            var currentQuantity = parseInt(quantityInput.val());
            
            var remaining = quantityInput.data('remaining');
            if(isNaN(currentQuantity)) currentQuantity = 0;
            if(remaining <= currentQuantity){ 
                alert('Cannot add more than available stock');
                return;
            }
            quantityInput.val(currentQuantity + 1).change();
        });

         $(".btn-minus").on('click', function(){
            var quantityInput = $(this).closest(".quantity").find(".p_quantity");
            var currentQuantity = parseInt(quantityInput.val());
            if(currentQuantity <= 1) return;
            quantityInput.val(currentQuantity - 1).change();
        });
        
        $(".p_quantity").on('change', function(){
            var quantity = $(this).val();
            var price = $(this).closest("tr").find(".price").text();
            price = parseFloat(price);
            quantity = parseInt(quantity);
            var total = quantity * price;
            $(this).closest("tr").find(".total_amount").text(total);
            calculateTotals();

             $.ajax({
                url: 'add_to_cart.php',
                type: 'post',
                data: {
                    productQuantity: quantity,
                    price: price,
                    product_Id: $(this).closest("tr").find(".btn-danger").data("id"),
                    cartUpdate: true
                },
                success: function(response){
                    response = JSON.parse(response);
                    if(response.status === 'success'){
                        console.log('Cart updated successfully');
                    } else {
                        alert(response.message);
                    }
                }
             });
            
        });

        $(".btn-danger").on('click', function(){
            var cartId = $(this).data("id");
            var row = $(this).closest("tr");
            $.ajax({
                url: 'remove_from_cart.php',
                type: 'post',
                data: {cartId: cartId},
                success: function(response){
                    response = JSON.parse(response);
                    if(response.status === 'success'){
                        row.remove();
                        $("#cartCount").text(response.cart_count);
                        alert(response.message);
                         calculateTotals();
                    } else {
                        alert(response.message);
                    }
                }
            });
        });

        $("#apply_coupon").on("click", function(){

            var coupon = $("#coupon_code").val();
            var total  = parseFloat($("#total").text());
            $.ajax({
                url: 'apply_coupon.php',
                type: 'post',
                data: {
                    coupon: coupon,
                    total: total
                },
                success: function(response){
                    response = JSON.parse(response);
                    if(response.status == "error"){
                        alert(response.message);
                        return;
                    }
                    if(response.status == "success"){
                        $("#discount").text(response.discount);
                        $("#final_total").text(response.final_total);
                        $("#total").text(response.final_total);
                    }
                }
            });
    });


});


//     $("#apply_coupon").on("click", function(){
//     alert("Button clicked");
// });

</script>
 <?php 
include('layout/footer.php');
?>