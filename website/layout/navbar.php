<?php
include('../connection.php');
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
   <nav class="navbar navbar-expand-lg navbar-dark bg-primary">
  <div class="container-fluid">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent"
      aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav me-auto mb-2 mb-lg-0">
    <li class="nav-item dropdown">
        <a class="nav-link" href="#" id="categoryDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
        Category
        </a>
        <ul class="dropdown-menu" aria-labelledby="categoryDropdown">
        <?php 
            $sql = "SELECT id, name FROM category";  
            $result = $conn->query($sql);

            while ($row = $result->fetch_assoc()) {
                $categoryId = $row['id'];
                $categoryName = $row['name'];
                
                echo '<li class="dropdown-submenu position-relative">';
                echo '<a class="dropdown-item dropdown-toggle" href="products.php?cat_id='.$categoryId.'"">'.$categoryName.'</a>';
                echo '<ul class="dropdown-menu">';
                
                // Fetch sub-categories for this category
                $subSql = "SELECT id, name FROM sub_category WHERE cat_id = $categoryId";
                $subResult = $conn->query($subSql); 
                
                while ($subRow = $subResult->fetch_assoc()) {
                  $subCategoryId = $subRow['id'];
                    $subCategoryName = $subRow['name'];
                    echo '<li><a class="dropdown-item" href="products.php?cat_id='.$categoryId.'?sub_cat='.$subCategoryId.'">'.$subCategoryName.'</a></li>';
                }

                echo '</ul>'; // close subcategory menu
                echo '</li>'; // close category item
            }
        ?>
        </ul>
    </li>
    </ul>

<style>
/* Extra CSS for nested dropdowns */
.dropdown-submenu .dropdown-menu {
  top: 0;
  left: 100%;
  margin-top: -1px;
}
.dropdown-submenu:hover > .dropdown-menu {
  display: block;
}
</style>

      <form class="d-flex">
        <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-light" type="submit">Search</button>
      </form>
    </div>
  </div>
</nav>

<style>
/* Extra CSS for nested dropdowns */
.dropdown-submenu .dropdown-menu {
  top: 0;
  left: 100%;
  margin-top: -1px;
}
.dropdown-submenu:hover > .dropdown-menu {
  display: block;
}
</style>

</body>
</html>