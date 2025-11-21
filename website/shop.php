<?php
include('layout/header.php');
?>
  <!-- Cart Start -->
    <div class="container-fluid">
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
                        $cartQuery = "select cart.id as id,cart.quantity as quantity,cart.product_id as product_id, products.p_name as name, products.p_price as price,products.image as image  from cart inner join products on cart.product_id=products.id where cart.user_id='$_SESSION[id]'";
                        $cartResult = mysqli_query($conn, $cartQuery);
                        while($cartRow = mysqli_fetch_assoc($cartResult)){
                            
                            $productQuantity = $cartRow['quantity'];
                            $productId = $cartRow['product_id'];
                            $productName = $cartRow['name'];
                            $productPrice = $cartRow['price'];   
                            $productImage = $cartRow['image'];
                            $cartid = $cartRow['id'];
                        ?>

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
                                    <input type="text" class="form-control form-control-sm bg-secondary border-0 text-center p_quantity" value="1">
                                    <div class="input-group-btn">
                                        <button class="btn btn-sm btn-primary btn-plus">
                                            <i class="fa fa-plus"></i>
                                        </button>
                                    </div>
                                </div>
                            </td>
                            <td class="align-middle total_amount"><?php echo $productPrice ?></td>
                            <td class="align-middle"><button class="btn btn-sm btn-danger" data-id="<?php echo $cartid ?>"><i class="fa fa-times"></i></button></td>
                        </tr>

                        <?php } ?>
                        
                    </tbody>
                </table>
            </div>
            <div class="col-lg-4">
                <form class="mb-30" action="">
                    <div class="input-group">
                        <input type="text" class="form-control border-0 p-4" placeholder="Coupon Code">
                        <div class="input-group-append">
                            <button class="btn btn-primary">Apply Coupon</button>
                        </div>
                    </div>
                </form>
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Cart Summary</span></h5>
                <div class="bg-light p-30 mb-5">
                    <div class="border-bottom pb-2">
                        <div class="d-flex justify-content-between mb-3">
                            <h6>Subtotal</h6>
                            <h6>$150</h6>
                        </div>
                        <div class="d-flex justify-content-between">
                            <h6 class="font-weight-medium">Shipping</h6>
                            <h6 class="font-weight-medium">$10</h6>
                        </div>
                    </div>
                    <div class="pt-2">
                        <div class="d-flex justify-content-between mt-2">
                            <h5>Total</h5>
                            <h5>$160</h5>
                        </div>
                        <button class="btn btn-block btn-primary font-weight-bold my-3 py-3">Proceed To Checkout</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Cart End -->

    <script>
    $(document).ready(function(){
       $(".btn-plus").on('click', function(){
            var quantityInput = $(this).closest(".quantity").find(".p_quantity");
            var currentQuantity = parseInt(quantityInput.val());
            if(isNaN(currentQuantity)) currentQuantity = 0;
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
        });


        $(".btn-danger").on('click', function(){
            var cartId = $(this).data("id");
            alert(cartId);
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
                    } else {
                        alert(response.message);
                    }
                }
            });
        });
    });
    </script>
 <?php 
include('layout/footer.php');
?>