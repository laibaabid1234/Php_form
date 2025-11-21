<?php
include('../connection.php');
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <title>MultiShop - Online Shop Website Template</title>
    <meta content="width=device-width, initial-scale=1.0" name="viewport">
    <meta content="Free HTML Templates" name="keywords">
    <meta content="Free HTML Templates" name="description">

    <!-- Favicon -->
    <link href="img/favicon.ico" rel="icon">

    <!-- Google Web Fonts -->
    <link rel="preconnect" href="https://fonts.gstatic.com">
    <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">  

    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.10.0/css/all.min.css" rel="stylesheet">

    <!-- Libraries Stylesheet -->
    <link href="assets/lib/animate/animate.min.css" rel="stylesheet">
    <link href="assets/lib/owlcarousel/assets/owl.carousel.min.css" rel="stylesheet">

    <!-- Customized Bootstrap Stylesheet -->
    <link href="assets/css/style.min.css" rel="stylesheet">

    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.7.1/jquery.min.js"></script>
</head>

<body>
    <!-- Topbar Start -->
    <div class="container-fluid">
        <div class="row bg-secondary py-1 px-xl-5">
            <div class="col-lg-6 d-none d-lg-block">
                <div class="d-inline-flex align-items-center h-100">
                    <a class="text-body mr-3" href="">About</a>
                    <a class="text-body mr-3" href="">Contact</a>
                    <a class="text-body mr-3" href="">Help</a>
                    <a class="text-body mr-3" href="">FAQs</a>
                </div>
            </div>
            <div class="col-lg-6 text-center text-lg-right">
                <div class="d-inline-flex align-items-center">
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">My Account</button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item" type="button">Sign in</button>
                            <button class="dropdown-item" type="button">Sign up</button>
                        </div>
                    </div>
                    <div class="btn-group mx-2">
                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">USD</button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item" type="button">EUR</button>
                            <button class="dropdown-item" type="button">GBP</button>
                            <button class="dropdown-item" type="button">CAD</button>
                        </div>
                    </div>
                    <div class="btn-group">
                        <button type="button" class="btn btn-sm btn-light dropdown-toggle" data-toggle="dropdown">EN</button>
                        <div class="dropdown-menu dropdown-menu-right">
                            <button class="dropdown-item" type="button">FR</button>
                            <button class="dropdown-item" type="button">AR</button>
                            <button class="dropdown-item" type="button">RU</button>
                        </div>
                    </div>
                </div>
                <div class="d-inline-flex align-items-center d-block d-lg-none">
                    <a href="" class="btn px-0 ml-2">
                        <i class="fas fa-heart text-dark"></i>
                        <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;">0</span>
                    </a>
                    <a href="" class="btn px-0 ml-2">
                        <i class="fas fa-shopping-cart text-dark"></i>
                        <span class="badge text-dark border border-dark rounded-circle" style="padding-bottom: 2px;">
                           0
                        </span>
                    </a>
                </div>
            </div>
        </div>
        <div class="row align-items-center bg-light py-3 px-xl-5 d-none d-lg-flex">
            <div class="col-lg-4">
                <a href="" class="text-decoration-none">
                    <span class="h1 text-uppercase text-primary bg-dark px-2">Multi</span>
                    <span class="h1 text-uppercase text-dark bg-primary px-2 ml-n1">Shop</span>
                </a>
            </div>
            <div class="col-lg-4 col-6 text-left">
                <form action="">
                    <div class="input-group">
                        <input type="text" class="form-control" placeholder="Search for products">
                        <div class="input-group-append">
                            <span class="input-group-text bg-transparent text-primary">
                                <i class="fa fa-search"></i>
                            </span>
                        </div>
                    </div>
                </form>
            </div>
            <div class="col-lg-4 col-6 text-right">
                <p class="m-0">Customer Service</p>
                <h5 class="m-0">+012 345 6789</h5>
            </div>
        </div>
    </div>
    <!-- Topbar End -->


    <!-- Navbar Start -->
    <div class="container-fluid bg-dark mb-30">
        <div class="row px-xl-5">
            <div class="col-lg-3 d-none d-lg-block">
                <a class="btn d-flex align-items-center justify-content-between bg-primary w-100" data-toggle="collapse" href="#navbar-vertical" style="height: 65px; padding: 0 30px;">
                    <h6 class="text-dark m-0"><i class="fa fa-bars mr-2"></i>Categories</h6>
                    <i class="fa fa-angle-down text-dark"></i>
                </a>
                <nav class="collapse position-absolute navbar navbar-vertical navbar-light align-items-start p-0 bg-light" id="navbar-vertical" style="width: calc(100% - 30px); z-index: 999;">
                    <div class="navbar-nav w-100">                      
                        <?php 
                        $sql = "SELECT id, name FROM category";  
                        $result = $conn->query($sql);
                        while ($row = $result->fetch_assoc()) {
                        $categoryId = $row['id'];
                        $categoryName = $row['name'];  ?>
                        <div class="nav-item dropdown dropright">
                            <a href="#" class="nav-link dropdown-toggle" data-toggle="dropdown"><?php echo $categoryName; ?> <i class="fa fa-angle-right float-right mt-1"></i></a>                                    
                        <div class="dropdown-menu position-absolute rounded-0 border-0 m-0">
                        <?php 
                        $subSql = "SELECT id, name FROM sub_category WHERE cat_id = $categoryId";
                        $subResult = $conn->query($subSql);                                        
                        while ($subRow = $subResult->fetch_assoc()) {
                            $subCategoryId = $subRow['id'];
                            $subCategoryName = $subRow['name'];
                            echo '<a class="dropdown-item" href="categoryproducts.php?cat_id='.$categoryId.'&sub_cat='.$subCategoryId.'">'.$subCategoryName.'</a>';
                        }                                    
                        echo '</div>';
                        echo '</div>';
                        }
                        ?>
                        
                        <!-- <a href="" class="nav-item nav-link">Shirts</a>
                        <a href="" class="nav-item nav-link">Jeans</a>
                        <a href="" class="nav-item nav-link">Swimwear</a>
                        <a href="" class="nav-item nav-link">Sleepwear</a>
                        <a href="" class="nav-item nav-link">Sportswear</a>
                        <a href="" class="nav-item nav-link">Jumpsuits</a>
                        <a href="" class="nav-item nav-link">Blazers</a>
                        <a href="" class="nav-item nav-link">Jackets</a>
                        <a href="" class="nav-item nav-link">Shoes</a> -->
                    </div>
                </nav>
            </div>
            <div class="col-lg-9">
                <nav class="navbar navbar-expand-lg bg-dark navbar-dark py-3 py-lg-0 px-0">
                    <a href="" class="text-decoration-none d-block d-lg-none">
                        <span class="h1 text-uppercase text-dark bg-light px-2">Multi</span>
                        <span class="h1 text-uppercase text-light bg-primary px-2 ml-n1">Shop</span>
                    </a>
                    <button type="button" class="navbar-toggler" data-toggle="collapse" data-target="#navbarCollapse">
                        <span class="navbar-toggler-icon"></span>
                    </button>
                    <div class="collapse navbar-collapse justify-content-between" id="navbarCollapse">
                        <div class="navbar-nav mr-auto py-0">
                            <?php 
                            $current_url = $_SERVER['REQUEST_URI'];
                                if($current_url=="/php_form/website/index.php"){?>                      
                                    <a href="index.php" class="nav-item nav-link active">Home</a> 
                                <?php } else { ?>
                                    <a href="index.php" class="nav-item nav-link">Home</a>
                            <?php } ?>
                            <?php 
                            $current_url = $_SERVER['REQUEST_URI'];
                                if($current_url=="/php_form/website/products.php"){?>                      
                                    <a href="products.php" class="nav-item nav-link active">Shop</a> 
                                <?php } else { ?>
                                    <a href="products.php" class="nav-item nav-link">Shop</a>
                            <?php } ?>

                            <?php 
                            $current_url = $_SERVER['REQUEST_URI'];
                                if($current_url=="/php_form/website/checkout.php"){?>                      
                                    <a href="checkout.php" class="nav-item nav-link active">Checkout</a> 
                                <?php } else { ?>
                                    <a href="checkout.php" class="nav-item nav-link">Checkout</a>
                            <?php } ?>
                            
                           <?php 
                            $current_url = $_SERVER['REQUEST_URI'];
                                if($current_url=="/php_form/website/contact.php"){?>                      
                                    <a href="contact.php" class="nav-item nav-link active">Contact</a> 
                                <?php } else { ?>
                                    <a href="contact.php" class="nav-item nav-link">Contact</a>
                            <?php } ?>
                        </div>
                        <div class="navbar-nav ml-auto py-0 d-none d-lg-block">
                            <a href="" class="btn px-0">
                                <i class="fas fa-heart text-primary"></i>
                                <span class="badge text-secondary border border-secondary rounded-circle" style="padding-bottom: 2px;">0</span>
                            </a>
                            <a href="shop.php" class="btn px-0 ml-3">
                                <i class="fas fa-shopping-cart text-primary"></i>
                                <span class="badge text-secondary border border-secondary rounded-circle" id="cartCount" style="padding-bottom: 2px;">
                                     <?php
                                        $user_id = isset($_SESSION['id']) ? $_SESSION['id'] : null;
                                        if($user_id){  
                                            $cartCountQuery = "SELECT COUNT(*) AS count FROM cart WHERE user_id='$user_id'";
                                            $cartCountResult = mysqli_query($conn, $cartCountQuery);
                                            $cartCountRow = mysqli_fetch_assoc($cartCountResult);
                                            echo $cartCountRow['count'];
                                        } else {
                                            echo "0";
                                        }
                                    ?>
                                </span>
                            </a>
                        </div>
                    </div>
                </nav>
            </div>
        </div>
    </div>
    <!-- Navbar End -->