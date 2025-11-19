<?php
include('../../connection.php');
if(!isset($_SESSION['user_name']))
{
    header("Location: ../../login.php");
    exit();
}
if(isset($_POST['statusId']) && $_POST['statusId'] != null){
    $Id = $_POST['statusId'];
    $productStatusQuery = "SELECT status FROM products WHERE id = $Id";
    $statusResult = mysqli_query($conn, $productStatusQuery);
    $statusRow = mysqli_fetch_assoc($statusResult);
    $statusId = $statusRow['status'];
    if($statusId==0){
      $statusId=1;
    }else{
      $statusId=0;
    }
    $updateStatusQuery = "UPDATE products SET status = $statusId WHERE id = $Id";
    $statuschanged=mysqli_query($conn, $updateStatusQuery);
    if($statuschanged){
      $statusmessage = "Status updated successfully";
    }else{
      $statusmessage = "Status not updated";  
    }   
    echo json_encode(['statusmessage' => $statusmessage]);
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
    $imagePath=null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $tmp = $_FILES['image']['tmp_name'];
    $origName = basename($_FILES['image']['name']);
    $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
    $allowed = array('jpg','jpeg','png','gif');
    if (in_array($ext, $allowed) && @getimagesize($tmp)) {
      $newName = uniqid('img_', true) . '.' . $ext;
      $uploadDir = __DIR__ . DIRECTORY_SEPARATOR . '../uploads' . DIRECTORY_SEPARATOR;
      if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
      if (move_uploaded_file($tmp, $uploadDir . $newName)) {
        $imagePath = 'uploads/' . $newName;
      }
    }
  }
  if ($imagePath) { 
    $query="update products set p_name='$name', p_price='$price', cat_id='$cat_id', subcat_id='$subcat_id',image='$imagePath' where id='$id'";
  }
  else{
    $query="update products set p_name='$name', p_price='$price', cat_id='$cat_id', subcat_id='$subcat_id' where id='$id'";
  } 
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
    $imagePath=null;
    if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
    $tmp = $_FILES['image']['tmp_name'];
    $origName = basename($_FILES['image']['name']);
    $ext = strtolower(pathinfo($origName, PATHINFO_EXTENSION));
    $allowed = array('jpg','jpeg','png','gif');
    if (in_array($ext, $allowed) && @getimagesize($tmp)) {
      $newName = uniqid('img_', true) . '.' . $ext;
      $uploadDir = __DIR__ . DIRECTORY_SEPARATOR . '../uploads' . DIRECTORY_SEPARATOR;
      if (!is_dir($uploadDir)) mkdir($uploadDir, 0755, true);
      if (move_uploaded_file($tmp, $uploadDir . $newName)) {
        $imagePath = 'uploads/' . $newName;
      }
    }
  }
  if ($imagePath) {
    $query = "INSERT INTO products (p_name, p_price,cat_id,subcat_id,image) VALUES ('$name', '$price','$cat_id','$subcat_id','$imagePath')";
  } else {
    $query = "INSERT INTO products (p_name, p_price,cat_id,subcat_id) VALUES ('$name', '$price','$cat_id','$subcat_id')";
  }
    $data=mysqli_query($conn,$query);
    if($data)
    {
        $msg="New record has been submitted";
    }
}
$query1="SELECT products.id AS p_id, products.p_name,products.image as image, category.name AS cat_name, sub_category.name AS sub_name,products.p_price as p_price, products.status as status FROM products INNER JOIN 
sub_category ON sub_category.id=products.subcat_id INNER JOIN category ON category.id=products.cat_id";
$products=mysqli_query($conn,$query1);

echo "<script>
if (window.history.replaceState) {
  window.history.replaceState(null, null, window.location.href);
}
</script>";
?>
 <!-- [ breadcrumb ] start -->
        <!-- <div class="page-header">
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
        </div> -->
        <!-- [ breadcrumb ] end -->

        <!-- [ Main Content ] start -->
        <div class="row">
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
                        <th>Image</th>
                        <th>Actions</th>
                        <th>Status</th>
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
                      <td><img src="../<?php echo $row['image']; ?>" alt="" width="100px" ></td>         
                      <td> 
                          <a href="edit_products.php?p_id=<?php echo $row['p_id'] ?>" class="btn btn-warning">Edit</a>
                          <form action="products.php" method="post" style="display:inline;">
                            <input type="hidden" name="p_id" value="<?php echo $row['p_id'] ?>">
                            <button type="submit" name="delete"  class="btn btn-danger">Delete</button>
                          </form>
                       </td> 
                        <td>                        
                          <div class="form-check form-switch">
                            <input class="form-check-input toggle" id="toggle_id" value="<?php echo $row['p_id'] ?>" type="checkbox" <?php if($row['status']==1){ echo 'checked'; } ?> name="toggle" role="switch" id="myToggleSwitch">                                              
                          </div>                                                              
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
<script>
   $(document).ready(function(){
    $('.toggle').change(function(){
     var status_id= $(this).val();
        $.ajax({
          url:'products.php',
          type:'post',
          data:{statusId:status_id},
          success:function(response){
            response = JSON.parse(response);
            alert(response.statusmessage);
          }

        });
    });
  
   });
</script>
        
<?php
include('../layout/footer.php');
?>