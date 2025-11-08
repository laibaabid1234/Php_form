<?php
include('../../connection.php');
if(!isset($_SESSION['user_name']))
{
    header("Location: ../../login.php");
    exit();
}
$basePath = '../';
include('../layout/sidebar.php');
include('../layout/navbar.php');

$data=null;
if(isset($_POST['update']) && isset( $_POST['id']) && $_POST['id']!= null){
    $id=$_POST['id'];
    $name=$_POST['p_name'];
    $price=$_POST['p_price'];
    $cat_id=$_POST['cat_id'];
    $subcat_id=$_POST['subcat_id'];
    $query="update products set p_name='$name', p_price='$price', cat_id='$cat_id', subcat_id='$subcat_id' where id='$id'";
    $data=mysqli_query($conn,$query);
   if($data){
       $msg="Changes Saved!";
    }
}
else if(isset($_GET['id'])&& $_GET['id']!=null)
{
    $id=$_GET['id'];
    $query="select * from products where id='$id'";
    $products=mysqli_query($conn,$query);
    $row=mysqli_fetch_assoc($products);
}
else if (isset($_POST['delete']) && isset($_POST['id']) && $_POST['id'] != null) {
    $id = $_POST['id'];
    $delquery = "DELETE FROM products WHERE id = $id";
    $data=mysqli_query($conn,$delquery);
    if($data){
       $msg="Record has been deleted";
    }
}
else if(isset($_POST['add']) && isset($_POST['p_name']) && $_POST['p_name']!= null){
    $name=$_POST['p_name'];
    $price=$_POST['p_price'];
    $cat_id=$_POST['cat_id'];
    $subcat_id=$_POST['subcat_id'];
    $query = "INSERT INTO products (p_name, p_price,cat_id,subcat_id) VALUES ('$name', '$price','$cat_id','$subcat_id')";
    $data=mysqli_query($conn,$query);
    if($data)
    {
        $msg="New record has been submitted";
    }
}
$query1="SELECT products.id AS p_id, products.p_name,category.name AS cat_name, sub_category.name AS sub_name,products.p_price as p_price FROM products INNER JOIN 
sub_category ON sub_category.id=products.subcat_id INNER JOIN category ON category.id=products.cat_id";
$products=mysqli_query($conn,$query1);

echo "<script>
if (window.history.replaceState) {
  window.history.replaceState(null, null, window.location.href);
}
</script>";
?>
 <!-- [ breadcrumb ] start -->
        <div class="page-header">
          <div class="page-block">
            <div class="row align-items-center">
              <div class="col-md-12">
                <ul class="breadcrumb">
                  <li class="breadcrumb-item"><a href="../dashboard/index.html">Home</a></li>
                  <li class="breadcrumb-item"><a href="javascript: void(0)">DataTable</a></li>
                </ul>
              </div>
            </div>
          </div>
        </div>
        <!-- [ breadcrumb ] end -->

        <!-- [ Main Content ] start -->
        <div class="row">

         <?php if ($_SESSION['user_role'] == "admin"){ ?>
            <?Php if(isset($data)&& $data!=null){?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                  <?php echo $msg ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php } ?>

            <?Php if(isset($data1)&& $data1!=null && mysqli_num_rows($data1) > 0){?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                  <?php echo $msg1 ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php } ?>
          
         <!-- Zero config table start -->
          <div class="col-sm-12">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-3">Products Table</h5>
                <a href="add_products.php" class="btn btn-primary">Add New</a>
              </div>
            <!-- Table start -->
              <div class="card-body">
                <div class="dt-responsive table-responsive">
                  <table id="simpletable" class="table table-striped table-bordered nowrap">
                    <thead>
                      <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Category Name</th>
                        <th>Sub Category Name</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php while($row=mysqli_fetch_assoc($products)){  ?>
                    <tr>
                      <td><?php echo $row['p_id'] ?></td>
                      <td><?php echo $row['p_name'] ?></td> 
                      <td><?php echo $row['p_price'] ?></td> 
                      <td><?php echo $row['cat_name'] ?></td> 
                      <td><?php echo $row['sub_name'] ?></td>           
                      <td> 
                          <a href="edit_products.php?p_id=<?php echo $row['p_id'] ?>" class="btn btn-warning">Edit</a>
                          <form action="products.php" method="post" style="display:inline;">
                            <input type="hidden" name="p_id" value="<?php echo $row['p_id'] ?>">
                            <button type="submit" name="delete"  class="btn btn-danger">Delete</button>
                          </form>
                       </td> 
                    </tr>
      
                     <?php } ?>
                    </tbody>
                  </table>
                   <!-- Table end -->
                </div>
              </div>
            </div>
          </div>
          <!-- Zero config table end -->

          <?php }else{ ?>
          <!-- Zero config table start -->
          <div class="col-sm-12">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-3">products Table</h5>
              </div>

            <!-- Table start -->
              <div class="card-body">
                <div class="dt-responsive table-responsive">
                  <table id="simpletable" class="table table-striped table-bordered nowrap">
                    <thead>
                      <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Price</th>
                        <th>Category Name</th>
                        <th>Sub Category Name</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php while($row=mysqli_fetch_assoc($products)){  ?>
                    <tr>
                      <td><?php echo $row['p_id'] ?></td>
                      <td><?php echo $row['p_name'] ?></td> 
                      <td><?php echo $row['p_price'] ?></td> 
                      <td><?php echo $row['cat_name'] ?></td> 
                      <td><?php echo $row['sub_name'] ?></td>          
                    </td> 
                    </tr>
                    <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
            <?php }?>
        
<?php
include('../layout/footer.php');
?>