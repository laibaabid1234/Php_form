<?php
include('layout/header.php');
?>

  <!-- wishlist Start -->
   
    <div class="container-fluid">
        <div class="row px-xl-5">
            <div class="col-lg-8 table-responsive mb-5">
                <table class="table table-light table-borderless table-hover text-center mb-0">
                    <thead class="thead-dark">
                        <tr>
                            <th>Products</th>
                            <th>Price</th>
                            <th>Action</th>
                            <th>Remove</th>
                        </tr>
                    </thead>
                    <tbody class="align-middle">
                        <?php 
                        $wishlistQuery = "select wishlist.id as id, wishlist.product_id as product_id, products.p_name as name, products.p_price as price from wishlist inner join products on wishlist.product_id=products.id where wishlist.user_id='$_SESSION[id]'";
                        $wishlistResult = mysqli_query($conn, $wishlistQuery);
                        while($wishlistRow = mysqli_fetch_assoc($wishlistResult)){                           
                            $productId = $wishlistRow['product_id'];
                            $productName = $wishlistRow['name'];
                            $productPrice = $wishlistRow['price'];   
                            $wishlistid = $wishlistRow['id'];
                        ?>
                        <tr>
                            <td class="align-middle"><?php echo $productName ?></td>
                            <td class="align-middle price"><?php echo $productPrice ?></td>
                              <?php 
                                $query="SELECT remaining FROM products where id= $productId";
                                $remainingquery = $conn->query($query);
                                $remainingproducts = $remainingquery->fetch_assoc();
                                $remaining= $remainingproducts['remaining'];  
                                if($remaining > 0){ ?>
                            <td class="align-middle add_to_cart" data-id="<?php echo $productId ?>" data-price="<?php echo $productPrice ?>" ><a href="" class="btn btn-primary">Add to Cart</a></td>
                              <?php } else { ?>  
                            <td class="align-middle" ><button class="btn btn-primary disabled">Add to Cart</button></td>
                             <?php } ?>
                            <td class="align-middle"><button class="btn btn-sm btn-danger" data-id="<?php echo $wishlistid ?>"><i class="fa fa-times"></i></button></td>
                        </tr>
                        <?php } ?>                       
                    </tbody>
                </table>
            </div>
           
        </div>
    </div>
    <!-- wishlist End -->
<script>
    $(document).ready(function(){
        $(".add_to_cart").click(function(){
            var productId = $(this).data("id");
            var productPrice = $(this).data("price");
            $.ajax({
                url: 'add_to_cart.php',
                type: 'post',
                data: {productId: productId, price: productPrice},
                success: function(response){
                    response = JSON.parse(response);
                    alert(response.message);

                    if(response.status === 'success'){
                    $("#cartCount").text(response.cart_count);
                    }
                }
            });
        });
    });
</script>

<script>
    $(".btn-danger").on('click', function(){
            var wishlistId = $(this).data("id");
            var row = $(this).closest("tr");
            $.ajax({
                url: 'remove_from_wishlist.php',
                type: 'post',
                data: {wishlistId: wishlistId},
                success: function(response){
                    response = JSON.parse(response);
                    if(response.status === 'success'){
                        row.remove();
                        $("#wishlist_count").text(response.wishlist_count);
                        alert(response.message);
                    } else {
                        alert(response.message);
                    }
                }
            });
        });
</script>

<?php 
include('layout/footer.php');
?>