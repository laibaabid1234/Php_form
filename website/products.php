 <?php 
 include ('layout/header.php');

$limit = 6;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page - 1) * $limit;

// base query
$where = "WHERE 1=1";

// search
if (!empty($_GET['search'])) {
    $search = mysqli_real_escape_string($conn, $_GET['search']);
    $where .= " AND p_name LIKE '%$search%'";
}

// categories
if (!empty($_GET['cat_id'])) {
    $catid = (int)$_GET['cat_id'];
    $where .= " AND cat_id = $catid";
}

if (!empty($_GET['sub_cat'])) {
    $subid = (int)$_GET['sub_cat'];
    $where .= " AND subcat_id = $subid";
}
// preserve a base where-clause (without any price filter) for counting buckets
$base_where = $where;

if(isset($_GET['price']) && $_GET['price'] != null && $_GET['price'] != 'all'){

    $price_range = explode('-', $_GET['price']);
    if(count($price_range) == 2){
        $min_price = (float)$price_range[0];
        $max_price = (float)$price_range[1];
        // apply price filter to main where used for listing/pagination
        $where .= " AND p_price BETWEEN $min_price AND $max_price";
    }
}

// count total rows
$countquery = "SELECT COUNT(id) AS total FROM products $where";
$count_result = mysqli_query($conn, $countquery);
$count_row = mysqli_fetch_assoc($count_result);
$total_records = $count_row['total'];
$total_pages = ceil($total_records / $limit);

// final data query
$query = "SELECT * FROM products $where LIMIT $start_from, $limit";
$result = mysqli_query($conn, $query);



function countProducts($conn, $min, $max, $base_where = "WHERE 1=1") {
    // always count items in the given price bucket, ignoring any current price filter
    $where_clause = $base_where . " AND p_price BETWEEN " . (float)$min . " AND " . (float)$max;
    $sql = "SELECT COUNT(id) AS total FROM products " . $where_clause;
    $result = mysqli_query($conn, $sql);
    if($result){
        $row = mysqli_fetch_assoc($result);
        echo (int)$row['total'];
    } else {
        echo 0;
    }
}



?>
 <!-- Shop Start -->
    <div class="container-fluid">
        <div class="row px-xl-5">
            <!-- Shop Sidebar Start -->
            <div class="col-lg-3 col-md-4">
                <!-- Price Start -->
                <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by price</span></h5>
                <div class="bg-light p-4 mb-30">
                    <form action="products.php" method="get" onchange="this.submit()">
                            <?php if (isset($_GET['cat_id'])) { ?>
                                <input type="hidden" name="cat_id" value="<?= $_GET['cat_id'] ?>">
                            <?php } ?>
                            <?php if (isset($_GET['sub_cat'])) { ?>
                                <input type="hidden" name="sub_cat" value="<?= $_GET['sub_cat'] ?>">
                            <?php } ?>
                             <?php if (isset($_GET['search'])) { ?>
                                <input type="hidden" name="search" value="<?= htmlspecialchars($_GET['search']) ?>">    
                            <?php } ?>                          
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" name="price" <?= (isset($_GET['price']) && $_GET['price'] == '0-1000') ? 'checked' : '' ?>  class="custom-control-input" id="price-1" value="0-1000">
                            <label class="custom-control-label" for="price-1">0 - 1000</label>
                            <span class="badge border font-weight-normal">
                                                                <?php 
                                                                    countProducts($conn, 0, 1000, $base_where);
                                                                ?>
                            </span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" name="price" <?= (isset($_GET['price']) && $_GET['price'] == '1000-2000') ? 'checked' : '' ?> class="custom-control-input" id="price-2" value="1000-2000">
                            <label class="custom-control-label" for="price-2">1000 - 2000</label>
                            <span class="badge border font-weight-normal">
                                                             <?php 
                                                                    countProducts($conn, 1000, 2000, $base_where);
                                                                ?>
                            </span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" name="price" <?= (isset($_GET['price']) && $_GET['price'] == '2000-3000') ? 'checked' : '' ?> class="custom-control-input" id="price-3" value="2000-3000">
                            <label class="custom-control-label" for="price-3">2000 - 3000</label>
                            <span class="badge border font-weight-normal">
                                                                <?php 
                                                                    countProducts($conn, 2000, 3000, $base_where);
                                                                ?>
                            </span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" name="price" <?= (isset($_GET['price']) && $_GET['price'] == '3000-4000') ? 'checked' : '' ?> class="custom-control-input" id="price-4" value="3000-4000">
                            <label class="custom-control-label" for="price-4">3000 - 4000</label>
                            <span class="badge border font-weight-normal">
                                                             <?php 
                                                                    countProducts($conn, 3000, 4000, $base_where);
                                                                ?>
                            </span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                            <input type="checkbox" name="price" <?= (isset($_GET['price']) && $_GET['price'] == '4000-5000') ? 'checked' : '' ?> class="custom-control-input" id="price-5" value="4000-5000">
                            <label class="custom-control-label" for="price-5">4000 - 5000</label>
                            <span class="badge border font-weight-normal">
                                                             <?php 
                                                                    countProducts($conn, 4000, 5000, $base_where);
                                                                ?>
                            </span>
                        </div>
                    </form>
                </div>
                <!-- Price End -->
                
                <!-- Color Start -->
                <!-- <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by color</span></h5>
                <div class="bg-light p-4 mb-30">
                    <form>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" checked id="color-all">
                            <label class="custom-control-label" for="price-all">All Color</label>
                            <span class="badge border font-weight-normal">1000</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="color-1">
                            <label class="custom-control-label" for="color-1">Black</label>
                            <span class="badge border font-weight-normal">150</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="color-2">
                            <label class="custom-control-label" for="color-2">White</label>
                            <span class="badge border font-weight-normal">295</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="color-3">
                            <label class="custom-control-label" for="color-3">Red</label>
                            <span class="badge border font-weight-normal">246</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="color-4">
                            <label class="custom-control-label" for="color-4">Blue</label>
                            <span class="badge border font-weight-normal">145</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                            <input type="checkbox" class="custom-control-input" id="color-5">
                            <label class="custom-control-label" for="color-5">Green</label>
                            <span class="badge border font-weight-normal">168</span>
                        </div>
                    </form>
                </div> -->
                <!-- Color End -->

                <!-- Size Start -->
                <!-- <h5 class="section-title position-relative text-uppercase mb-3"><span class="bg-secondary pr-3">Filter by size</span></h5>
                <div class="bg-light p-4 mb-30">
                    <form>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" checked id="size-all">
                            <label class="custom-control-label" for="size-all">All Size</label>
                            <span class="badge border font-weight-normal">1000</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="size-1">
                            <label class="custom-control-label" for="size-1">XS</label>
                            <span class="badge border font-weight-normal">150</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="size-2">
                            <label class="custom-control-label" for="size-2">S</label>
                            <span class="badge border font-weight-normal">295</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="size-3">
                            <label class="custom-control-label" for="size-3">M</label>
                            <span class="badge border font-weight-normal">246</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between mb-3">
                            <input type="checkbox" class="custom-control-input" id="size-4">
                            <label class="custom-control-label" for="size-4">L</label>
                            <span class="badge border font-weight-normal">145</span>
                        </div>
                        <div class="custom-control custom-checkbox d-flex align-items-center justify-content-between">
                            <input type="checkbox" class="custom-control-input" id="size-5">
                            <label class="custom-control-label" for="size-5">XL</label>
                            <span class="badge border font-weight-normal">168</span>
                        </div>
                    </form>
                </div> -->
                <!-- Size End -->
            </div>
            <!-- Shop Sidebar End -->


            <!-- Shop Product Start -->
            <div class="col-lg-9 col-md-8">
                <div class="row pb-3">
                    <div class="col-12 pb-1">
                        <div class="d-flex align-items-center justify-content-between mb-4">
                            <div>
                                <button class="btn btn-sm btn-light"><i class="fa fa-th-large"></i></button>
                                <button class="btn btn-sm btn-light ml-2"><i class="fa fa-bars"></i></button>
                            </div>
                            <div class="ml-2">
                                <!-- <div class="btn-group">
                                    <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">Sorting</button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#">Latest</a>
                                        <a class="dropdown-item" href="#">Popularity</a>
                                        <a class="dropdown-item" href="#">Best Rating</a>
                                    </div>
                                </div> -->
                                <!-- <div class="btn-group ml-2">
                                    <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">Showing</button>
                                    <div class="dropdown-menu dropdown-menu-right">
                                        <a class="dropdown-item" href="#">10</a>
                                        <a class="dropdown-item" href="#">20</a>
                                        <a class="dropdown-item" href="#">30</a>
                                    </div>
                                </div> -->
                            </div>
                        </div>
                    </div>
                    <?php   
                    if($result && mysqli_num_rows($result)>0){
                         while ($editrow = $result->fetch_assoc()) {
                            $productId = $editrow['id'];
                            $productName = $editrow['p_name'];  
                            $productPrice = $editrow['p_price'];
                            $productImage = $editrow['image'];                                         
                    ?>
                    <div class="col-lg-4 col-md-6 col-sm-6 pb-1">
                    <?php 
                        $query="SELECT remaining FROM products where id= $productId";
                        $remainingquery = $conn->query($query);
                        $remainingproducts = $remainingquery->fetch_assoc();
                        $remaining= $remainingproducts['remaining'];  
                     ?>
                        <div class="product-item bg-light mb-4">
                            <div class="product-img position-relative overflow-hidden">
                                <img class="img-fluid" src="../admin/<?php echo $productImage ?>" alt="" style="width:100%; height:250px; object-fit:cover;">
                                <div class="product-action">
                                    <?php if($remaining > 0){ ?>
                                    <a class="btn btn-outline-dark btn-square add_to_cart" data-id="<?php echo $productId ?>" data-price="<?php echo $productPrice ?>" ><i class="fa fa-shopping-cart"></i></a>
                                    <?php }  ?>
                                    <a class="btn btn-outline-dark btn-square add_to_wishlist" data-id="<?php echo $productId ?>" data-price="<?php echo $productPrice ?>"><i class="far fa-heart"></i></a>
                                    <!-- <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-sync-alt"></i></a>
                                    <a class="btn btn-outline-dark btn-square" href=""><i class="fa fa-search"></i></a> -->
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
                   
  

                                
                    </div>
                    <?php } ?>
                    <?php } ?>
                    <?php if($total_pages > 1){ ?>
                    <div class="col-12">
                        <nav>
                           <ul class="pagination justify-content-center">
                                <?php
                              
                                $filters = "";
                                if(isset($_GET['cat_id']) && $_GET['cat_id'] != null){
                                    $filters .= "&cat_id=" . $_GET['cat_id'];
                                }
                                if(isset($_GET['sub_cat']) && $_GET['sub_cat'] != null){
                                    $filters .= "&sub_cat=" . $_GET['sub_cat'];
                                }
                                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                                ?>

                                <!-- Previous Button -->
                                <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                                    <a class="page-link"
                                    href="products.php?page=<?php echo ($page - 1) . $filters; ?>">
                                    Previous
                                    </a>
                                </li> 

                                <!-- Page Numbers -->
                                <?php for($i = 1; $i <= $total_pages; $i++): ?>
                                    <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                                        <a class="page-link"
                                        href="products.php?page=<?php echo $i . $filters; ?>">
                                        <?php echo $i; ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>

                                <!-- Next Button -->
                                <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                                    <a class="page-link"
                                    href="products.php?page=<?php echo ($page + 1) . $filters; ?>">
                                    Next
                                    </a>
                                </li>

                            </ul>

                        </nav>
                        </div>
                    <?php } ?>

                    
                </div>
            </div>
            <!-- Shop Product End -->
        </div>
    </div>
    <!-- Shop End -->


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
 include ('layout/footer.php');
 ?>