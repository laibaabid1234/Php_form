<?php
include('layout/header.php');
    $cartQuery = "select cart.id as id,cart.quantity as quantity,cart.product_id as product_id,cart.total as total, products.p_name as name, products.p_price as price,products.image as image  from cart inner join products on cart.product_id=products.id where cart.user_id='$_SESSION[id]'";
    $cartResult = mysqli_query($conn, $cartQuery);

?>
 <!-- Checkout Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <form action="proceed_to_checkout.php" method="post">
                <div class="row">
                <div class="col-lg-8">
                    <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Billing Address</span></h5>
                    <div class="bg-light p-30 mb-5">
                        <div class="row">
                    
                            <div class="col-md-6 form-group">
                                <label>First Name</label>
                                <input class="form-control" name="fname" type="text" placeholder="John" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Last Name</label>
                                <input class="form-control" name="lname" type="text" placeholder="Doe" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>E-mail</label>
                                <input class="form-control" type="text" name="email" placeholder="example@email.com" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Mobile No</label>
                                <input class="form-control" type="text" name="contact" placeholder="+123 456 789" required>
                            </div>
                            <div class="col-md-12 form-group">
                                <label>Address Line 1</label>
                                <input class="form-control" type="text" name="address" placeholder="123 Street" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>Country</label>
                                <select class="custom-select" name="country" required>
                                    <option selected value="pk">Pakistan</option>
                                </select>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>City</label>
                                <input class="form-control" type="text" placeholder="New York" name="city" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>State</label>
                                <input class="form-control" type="text" placeholder="New York" name="state" required>
                            </div>
                            <div class="col-md-6 form-group">
                                <label>ZIP Code</label>
                                <input class="form-control" type="text" placeholder="123" name="zip" required>
                            </div>
                        
                        </div>
                    </div>
                
                </div>
                <div class="col-lg-4">
                    <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Order Total</span></h5>
                    <div class="bg-light p-30 mb-5">
                        <div class="border-bottom">
                            <h6 class="mb-3">Products</h6>
                            <?php
                            while($cartRow = mysqli_fetch_assoc($cartResult)){
                                
                                $productQuantity = $cartRow['quantity'];
                                $total=$cartRow['total'];
                                $productId = $cartRow['product_id'];
                                $productName = $cartRow['name'];
                                $productPrice = $cartRow['price'];   
                                $productImage = $cartRow['image'];
                                $cartid = $cartRow['id'];
                                ?>
                            <div class="d-flex justify-content-between">
                                <p><?php echo $productName ?></p>
                                <p class="total_amount"><?php echo $total ?></p>
                                <input type="hidden" value="<?php echo $total ?>" name="product_total[]">
                                <input type="hidden" value="<?php echo $productQuantity ?>" name="product_quantity[]">
                                <input type="hidden" value="<?php echo $productId ?>" name="product_id[]">
                            </div>
                            <?php } ?>
                        
                        </div>
                        <div class="border-bottom pt-3 pb-2">
                            <div class="d-flex justify-content-between mb-3">
                                <h6>Subtotal</h6>
                                <h6 id="subtotal">$150</h6>
                                <input type="hidden" value="<?php echo $total ?>" name="subtotal">
                            </div>
                            <div class="d-flex justify-content-between">
                                <h6 class="font-weight-medium">Tax 10%</h6>
                                <h6 class="font-weight-medium" id="tax">$10</h6>
                                <input type="hidden" value="" name="tax">
                            </div>
                        </div>
                        <div class="pt-2">
                            <div class="d-flex justify-content-between mt-2">
                                <h5>Total</h5>
                                <h5 id="total">$160</h5>
                                <input type="hidden" value="" name="total">
                            </div>
                        </div>
                    </div>
                    <div class="mb-5">
                        <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Payment</span></h5>
                        <div class="bg-light p-30">
                            <div class="form-group mb-4">
                                <div class="custom-control custom-radio">
                                    <input type="radio" class="custom-control-input" value="cash" name="payment" id="banktransfer">
                                    <label class="custom-control-label" for="banktransfer">Cash On Delivery</label>
                                </div>
                            </div>
                            <button class="btn btn-block btn-primary font-weight-bold py-3">Place Order</button>
                        </div>
                    </div>
                </div>
                </div>
            </form>
        </div>
    </div>

    
    <!-- Checkout End -->

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
            var tax = subtotal * 0.10;
            $("#tax").text(tax.toFixed(2));
            $('input[name="tax"]').val(tax.toFixed(2));
            var total = subtotal + tax;
            $("#total").text(total.toFixed(2));
            $('input[name="total"]').val(total.toFixed(2));
        }
        calculateTotals();
    });
</script>
<?php 
include('layout/footer.php');
?>