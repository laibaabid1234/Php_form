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
    $name=$_POST['name'];
    $email=$_POST['email'];
    $contact=$_POST['contact'];   
    $imagePath=null;
    // Email check for edit form
    if ($email != null && trim($email) != "") {
        $emailQuery = "SELECT * FROM users WHERE email='$email' AND id != '$id'";
        $data1 = mysqli_query($conn, $emailQuery);
        if ($data1) {
            if (mysqli_num_rows($data1) > 0) {
              $msg1 = "Email Address should be unique!";
            }
        }
    }
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
        $imagePath = '../uploads/' . $newName;
      }
    }
  }
   if ($imagePath) { 
    $query="update users set name='$name',email='$email',contact='$contact',image='$imagePath' where id='$id'";
   }
   else{
    $query="update users set name='$name',email='$email',contact='$contact' where id='$id'";
   }
   $data=mysqli_query($conn,$query);
   if($data){
       $msg="Record has been updated";
    }
}

else if (isset($_POST['delete']) && isset($_POST['id']) && $_POST['id'] != null) {
    $id = $_POST['id'];
    $delquery = "DELETE FROM users WHERE id = $id";
    $data=mysqli_query($conn,$delquery);
    if($data){
       $msg="Record has been deleted";
    }
}
else if(isset($_POST['add']) && isset($_POST['name']) && $_POST['name']!= null){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $contact=$_POST['contact'];
    $imagePath=null;
    
    //email check
    if($email !=null || $email !=" " )
    {
        $emailQuery="select * from users where email='$email'";
        $data1=mysqli_query($conn,$emailQuery);
        if($data1) {
            if (mysqli_num_rows($data1) > 0) {
              $msg1="Email Address should be unique!";
                
            } 
        }
    }
    //end
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
        $imagePath = '../uploads/' . $newName;
      }
    }
  }
  if ($imagePath) {    
     $query = "INSERT INTO users (name, email, contact, image) VALUES ('$name', '$email', '$contact','$imagePath')";
  } else {
    $query = "INSERT INTO users (name, email, contact) VALUES ('$name', '$email', '$contact')";
  }
   $data=mysqli_query($conn,$query);
    if($data)
    {
        $msg="New record has been submitted";
    }
}
echo "<script>
if (window.history.replaceState) {
  window.history.replaceState(null, null, window.location.href);
}
</script>";
$query1="select * from users";
$users=mysqli_query($conn,$query1);
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
                <h5 class="mb-3">Users Table</h5>
              <a href="add_users.php" class="btn btn-primary">Add New</a>
              </div>

              <div class="card-body">
                <div class="dt-responsive table-responsive">
                  <table id="simpletable" class="table table-striped table-bordered nowrap">
                    <thead>
                      <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact</th>                       
                        <th>Image</th>
                        <th>Actions</th>
                      </tr>
                    </thead>
                    <tbody>
                       <?php while($row=mysqli_fetch_assoc($users)){  ?>
                            <tr>
                                <td><?php echo $row['id'] ?></td>
                                <td><?php echo $row['name'] ?></td>
                                <td><?php echo $row['email'] ?></td>
                                <td><?php echo $row['contact'] ?></td>                               
                                <td><img src="../<?php echo $row['image']; ?>" alt="" width="100px" ></td>
                                <td> 
                                    <a href="edit_users.php?id=<?php echo $row['id'] ?>"  class="btn btn-warning">Edit</a>
                                     <form method="POST" action="form.php" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                                        <button type="submit" name="delete"  class="btn btn-danger">Delete</button>
                                    </form>
                                </td> 
                            </tr>
                        <?php } ?>
                    </tbody>
                  </table>
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
                <h5 class="mb-3">Users Table</h5>
              </div>

              <div class="card-body">
                <div class="dt-responsive table-responsive">
                  <table id="simpletable" class="table table-striped table-bordered nowrap">
                    <thead>
                      <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Contact</th>
                        <th>Image</th>                       
                      </tr>
                    </thead>
                    <tbody>
                       <?php while($row=mysqli_fetch_assoc($users)){  ?>
                            <tr>
                                <td><?php echo $row['id'] ?></td>
                                <td><?php echo $row['name'] ?></td>
                                <td><?php echo $row['email'] ?></td>
                                <td><?php echo $row['contact'] ?></td>
                                <td><img src="../<?php echo $row['image']; ?>" alt="" width="100px"></td>

                            </tr>
                        <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div> <?php } ?>
           

        
<?php
include('../layout/footer.php');
?>
