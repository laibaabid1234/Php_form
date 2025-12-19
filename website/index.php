<?php
include('layout/header.php');
?>
   <!-- Carousel Start -->
    <div class="container-fluid mb-3">
        <div class="row px-xl-5">
            <div class="col-lg-8">
                <div id="header-carousel" class="carousel slide carousel-fade mb-30 mb-lg-0" data-ride="carousel">
                    <ol class="carousel-indicators">
                            <li data-target="#header-carousel" data-slide-to="0" class="active"></li>
                            <li data-target="#header-carousel" data-slide-to="1"></li>
                            <li data-target="#header-carousel" data-slide-to="2"></li>
                    </ol>    
                    <div class="carousel-inner">
                        <?php 
                        $sql = "SELECT id, name,image FROM category";  
                        $result = $conn->query($sql);
                        $active = "active"; 
                        while ($row = $result->fetch_assoc()) {
                        $categoryId = $row['id'];
                        $categoryName = $row['name'];
                        $categoryimage = $row['image']; 
                        ?>
                        <div class="carousel-item position-relative <?php echo $active; ?>" style="height: 430px;">
                            <img class="position-absolute w-100 h-100" src="../admin/<?php echo $categoryimage;?>" style="object-fit: cover;">
                            <div class="carousel-caption d-flex flex-column align-items-center justify-content-center">
                                <div class="p-3" style="max-width: 700px;">
                                    <h1 class="display-4 text-white mb-3 animate__animated animate__fadeInDown"><?php echo $categoryName;?></h1>
                                    <?php 
                                  echo '<a class="btn btn-outline-light py-2 px-4 mt-3 animate__animated animate__fadeInUp" href="products.php?cat_id='.$categoryId.'">Shop Now</a>';
                                echo '</div>';
                            echo '</div>';
                       echo '</div>';
                       $active = "";
                        } ?>                   
                    </div>
                </div>
            </div>
          <div class="col-lg-4">
                <div class="product-offer mb-30" style="height: 200px;">
                    <img class="img-fluid" src="assets/img/offer-1.jpg" alt="">
                    <div class="offer-text">
                        <h6 class="text-white text-uppercase">Save 20%</h6>
                        <h3 class="text-white mb-3">Special Offer</h3>
                        <a href="" class="btn btn-primary">Shop Now</a>
                    </div>
                </div>
                <div class="product-offer mb-30" style="height: 200px;">
                    <img class="img-fluid" src="assets/img/offer-2.jpg" alt="">
                    <div class="offer-text">
                        <h6 class="text-white text-uppercase">Save 20%</h6>
                        <h3 class="text-white mb-3">Special Offer</h3>
                        <a href="" class="btn btn-primary">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Carousel End -->


    <!-- Featured Start -->
    <div class="container-fluid pt-5">
        <div class="row px-xl-5 pb-3">
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-check text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">Quality Product</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-shipping-fast text-primary m-0 mr-2"></h1>
                    <h5 class="font-weight-semi-bold m-0">Free Shipping</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fas fa-exchange-alt text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">14-Day Return</h5>
                </div>
            </div>
            <div class="col-lg-3 col-md-6 col-sm-12 pb-1">
                <div class="d-flex align-items-center bg-light mb-4" style="padding: 30px;">
                    <h1 class="fa fa-phone-volume text-primary m-0 mr-3"></h1>
                    <h5 class="font-weight-semi-bold m-0">24/7 Support</h5>
                </div>
            </div>
        </div>
    </div>
    <!-- Featured End -->


    <!-- Categories Start -->
    <div class="container-fluid pt-5">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Categories</span></h2>
        <div class="row px-xl-5 pb-3">
            <?php 
            $featuredsql = "SELECT * FROM category WHERE is_featured=1 LIMIT 4";  
            $featuredresult = $conn->query($featuredsql);
            while ($row = $featuredresult->fetch_assoc()) {
            $featuredId = $row['id'];
            $featuredName = $row['name'];
            $featuredimage = $row['image']; 
            ?>
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
               <?php echo'<a class="text-decoration-none" href="products.php?cat_id='.$featuredId .'">' ?>
                    <div class="cat-item d-flex align-items-center mb-4">
                        <div class="overflow-hidden" style="width: 100px; height: 100px; overflow: hidden;">
                            <img class="" style="width: 100%; height: 100%; object-fit: cover; object-position: center; display: block;" src="../admin/<?php echo $featuredimage ?>" alt="">
                        </div>
                        <div class="flex-fill pl-3">
                            <h6><?php echo $featuredName ?></h6>
                        </div>
                    </div>
                </a>
            </div>
            <?php } ?>
        </div>
    </div>
    <!-- Categories End -->


    <!-- Products Start -->
    <div class="container-fluid pt-5 pb-3">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Featured Products</span></h2>
        <div class="row px-xl-5">
            <?php 
            $featuredproductsql = "SELECT * FROM products WHERE is_featured=1 LIMIT 4";  
            $featuredproductresult = $conn->query($featuredproductsql);
            while ($row = $featuredproductresult->fetch_assoc()) {
            $productId = $row['id'];
            $productName = $row['p_name'];
            $productPrice = $row['p_price'];
            $productImage = $row['image'];
            ?>
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
            <?php 
            $query="SELECT remaining FROM products where id= $productId";
            $remainingquery = $conn->query($query);
            $remainingproducts = $remainingquery->fetch_assoc();
            $remaining= $remainingproducts['remaining'];  ?>           
                <div class="product-item bg-light mb-4">
                    <div class="product-img position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="../admin/<?php echo $productImage?>" alt="" style="width:100%; height:250px; object-fit:cover;">
                        <div class="product-action">
                             <?php if($remaining > 0){ ?>
                            <a class="btn btn-outline-dark btn-square add_to_cart" data-id="<?php echo $productId ?>" data-price="<?php echo $productPrice ?>" ><i class="fa fa-shopping-cart"></i></a>
                            <?php }  ?>
                            <a class="btn btn-outline-dark btn-square add_to_wishlist" data-id="<?php echo $productId ?>" data-price="<?php echo $productPrice ?>"><i class="far fa-heart"></i></a>
                        </div>
                    </div>
                    <div class="text-center py-4">
                        <a class="h6 text-decoration-none text-truncate" href=""><?php echo "$productName" ?></a>
                        <div class="d-flex align-items-center justify-content-center mt-2">
                            <h5>$123.00</h5><h6 class="text-muted ml-2"></h6>
                        </div>
                         <?php if($remaining > 0){ ?>
                            <p class="text-success">In stock</p>
                        <?php } else { ?>
                            <p class="text-danger">Out of stock</p>
                        <?php } ?>                 
                        <div class="d-flex align-items-center justify-content-center mb-1">
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <!-- <small>(99)</small> -->
                        </div>
                    </div>
                </div>
            </div>
            <?php } ?>
        </div>
    </div>
    <!-- Products End -->


    <!-- Offer Start -->
    <div class="container-fluid pt-5 pb-3">
        <div class="row px-xl-5">
            <div class="col-md-6">
                <div class="product-offer mb-30" style="height: 300px;">
                    <img class="img-fluid" src="assets/img/offer-1.jpg" alt="">
                    <div class="offer-text">
                        <h6 class="text-white text-uppercase">Save 20%</h6>
                        <h3 class="text-white mb-3">Special Offer</h3>
                        <a href="" class="btn btn-primary">Shop Now</a>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <div class="product-offer mb-30" style="height: 300px;">
                    <img class="img-fluid" src="assets/img/offer-2.jpg" alt="">
                    <div class="offer-text">
                        <h6 class="text-white text-uppercase">Save 20%</h6>
                        <h3 class="text-white mb-3">Special Offer</h3>
                        <a href="" class="btn btn-primary">Shop Now</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Offer End -->


    <!-- Products Start -->
    <div class="container-fluid pt-5 pb-3">
        <h2 class="section-title position-relative text-uppercase mx-xl-5 mb-4"><span class="bg-secondary pr-3">Recent Products</span></h2>
        <div class="row px-xl-5">
            <?php 
            $recentproductsql = "SELECT * FROM products ORDER BY id DESC LIMIT 4";  
            $recentproductresult = $conn->query($recentproductsql);
            while ($row = $recentproductresult->fetch_assoc()) {
            $productId = $row['id'];
            $productName = $row['p_name'];
            $productPrice = $row['p_price'];
            $productImage = $row['image'];
            ?>
            <div class="col-lg-3 col-md-4 col-sm-6 pb-1">
            <?php 
            $query="SELECT remaining FROM products where id= $productId";
            $remainingquery = $conn->query($query);
            $remainingproducts = $remainingquery->fetch_assoc();
            $remaining= $remainingproducts['remaining'];  
            if($remaining > 0){ ?>
                <div class="product-item bg-light mb-4">
                    <div class="product-img position-relative overflow-hidden">
                        <img class="img-fluid w-100" src="../admin/<?php echo $productImage ?>" alt="" style="width:100%; height:250px; object-fit:cover;">
                        <div class="product-action">
                            <?php if($remaining > 0){ ?>
                            <a class="btn btn-outline-dark btn-square add_to_cart" data-id="<?php echo $productId ?>" data-price="<?php echo $productPrice ?>" ><i class="fa fa-shopping-cart"></i></a>
                            <?php }  ?>
                            <a class="btn btn-outline-dark btn-square add_to_wishlist" data-id="<?php echo $productId ?>" data-price="<?php echo $productPrice ?>"><i class="far fa-heart"></i></a>        
                        </div>
                    </div>
                    <div class="text-center py-4">
                        <a class="h6 text-decoration-none text-truncate" href=""><?php echo $productName ?></a>
                        <div class="d-flex align-items-center justify-content-center mt-2">
                            <h5><?php echo $productPrice ?></h5><h6 class="text-muted ml-2"></h6>
                        </div>
                          <?php if($remaining > 0){ ?>
                            <p class="text-success">In stock</p>
                          <?php } else { ?>
                            <p class="text-danger">Out of stock</p>
                          <?php } ?>
                        <div class="d-flex align-items-center justify-content-center mb-1">
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>
                            <small class="fa fa-star text-primary mr-1"></small>                          
                        </div>
                    </div>
                </div>

            <?php } ?>
            </div>
            <?php } ?>
        </div>
    </div>
    <!-- Products End -->


    <!-- Vendor Start -->
    <div class="container-fluid py-5">
        <div class="row px-xl-5">
            <div class="col">
                <div class="owl-carousel vendor-carousel">
                    <div class="bg-light p-4">
                        <img src="assets/img/vendor-1.jpg" alt="">
                    </div>
                    <div class="bg-light p-4">
                        <img src="assets/img/vendor-2.jpg" alt="">
                    </div>
                    <div class="bg-light p-4">
                        <img src="assets/img/vendor-3.jpg" alt="">
                    </div>
                    <div class="bg-light p-4">
                        <img src="assets/img/vendor-4.jpg" alt="">
                    </div>
                    <div class="bg-light p-4">
                        <img src="assets/img/vendor-5.jpg" alt="">
                    </div>
                    <div class="bg-light p-4">
                        <img src="assets/img/vendor-6.jpg" alt="">
                    </div>
                    <div class="bg-light p-4">
                        <img src="assets/img/vendor-7.jpg" alt="">
                    </div>
                    <div class="bg-light p-4">
                        <img src="assets/img/vendor-8.jpg" alt="">
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- Vendor End -->
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
    $(document).ready(function(){
        $(".add_to_wishlist").click(function(){
            var productId = $(this).data("id");
            var productPrice = $(this).data("price");
            $.ajax({
                url: 'add_to_wishlist.php', 
                type: 'post',
                data: {productId: productId, price: productPrice},
                success: function(response){
                    response = JSON.parse(response);
                    alert(response.message);

                    if(response.status === 'success'){
                    $("#wishlist_count").text(response.wishlist_count);
                    }
                }
            });
        });
    });
  </script>  
     <?php 
     include('layout/footer.php');
     ?>