<?php 
include('../../connection.php');
$basePath = '../';
if(!isset($_SESSION['user_name']))
{
    header("Location: ../../login.php");
    exit();
}
if(isset($_GET['id'])&& $_GET['id']!=null)
{
    $id=$_GET['id'];
    $query="select * from users where id='$id'";
    $user=mysqli_query($conn,$query);
    $row=mysqli_fetch_assoc($user);
}
else if(isset($_POST['updateprofile']) && isset( $_POST['id']) && $_POST['id']!= null){
    $id = $_POST['id'];
    $name=$_POST['name'];
    $userName=$_POST['user_name'];
    $password=$_POST['password'];
    $confirmPassword=$_POST['confirm_password'];

    $ConfirmPasswordError=null;
    $PasswordlengthError=null;
    $emptyPasswordError=null;
   
    //password check
    if(!empty($password) || !empty($confirmPassword))
    {
        if($password!==$confirmPassword){
         $ConfirmPasswordError="Confirm password must be same as password!";
        }
        else if(strlen($password)<= 8){
         $PasswordlengthError="Password length must be greater than 8 characters!";
         }
        else{
        $query="update users set name='$name',password='$password',user_name='$userName' where id='$id'";
        $data=mysqli_query($conn,$query);
          if($data) {
          $_SESSION['user_name'] = $userName;
          $msg="Your changes have been successfully saved.";}
        }   
    }
    //end
    else{
        $query="update users set name='$name',user_name='$userName' where id='$id'";
        $data=mysqli_query($conn,$query);
          if($data) {
          $_SESSION['user_name'] = $userName;
          $msg="Your changes have been successfully saved.";}
      }
  }
  else if(isset($_FILES['image']) && isset($_POST['id']) && $_POST['id']!= null){
    $id=$_POST['id'];
    $res = mysqli_query($conn, "SELECT image FROM users WHERE id='$id'");
    $old = mysqli_fetch_assoc($res)['image'];

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
     $query = "UPDATE users set image='$imagePath' where id='$id'";
     $data1=mysqli_query($conn,$query);
  }
}

include('../layout/sidebar.php');
include('../layout/navbar.php');
?>
<!-- main content start -->
                   <!-- alert -->
                  <?Php if(isset($data)&& $data!=null){?>
                  <div class="alert alert-warning alert-dismissible fade show" role="alert">
                  <?php echo $msg ?>
                  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                  </div>
                  <?php } ?>
                  <!-- end -->
                   
                  <div class="card">
                    <div class="card-header">
                      <h4>User Profile</h4>
                    </div>
                  <div class="card-body">
                    <div class="row">
                      <form action="user-profile.php" method="POST" enctype="multipart/form-data">
                      <div class="d-flex align-items-center gap-3">
                          <input type="hidden" class="form-control" value="<?php echo $_SESSION['id']; ?>" name="id" >
                          <img src="../<?php echo $imagePath; ?>" class="rounded-circle border" width="120" height="120" style="object-fit: cover;">
                          <div>
                              <label class="btn btn-outline-primary btn-sm mb-2">
                                  <i class="bi bi-camera"></i> Change Photo
                                  <input type="file" name="image" class="d-none" onchange="this.form.submit()">
                              </label>
                              <small class="text-muted d-block">JPG, PNG only</small>
                          </div>
                      </div>
                      </form>
                      
                      <form action="user-profile.php" method="POST">
                      <div class="form-group">
                        <input type="hidden" class="form-control" value="<?php echo $row['id']; ?>" name="id" placeholder="Name" aria-label="Username" aria-describedby="basic-addon1">
                      </div>
                      <div class="form-group">
                        <label class="form-label">Name</label>
                        <input type="text" class="form-control" value="<?php echo $row['name'] ?>" name="name" placeholder="Name" aria-label="Username" aria-describedby="basic-addon1">
                      </div>
                      <div class="form-group">
                        <label class="form-label">Username</label>
                        <input type="text" class="form-control" placeholder="Username" value="<?php echo $row['user_name'] ?>" name="user_name" aria-label="Username" aria-describedby="basic-addon1">
                      </div> 
                      <div class="form-group">
                        <label class="form-label">Email</label>
                        <input type="text" class="form-control" placeholder="Contact" value="<?php echo $row['email'] ?>" name="email" aria-label="Username" aria-describedby="basic-addon1" readonly disable>
                      </div>
                      <div class="form-group">
                        <label class="form-label">New Password</label>
                        <input type="password" class="form-control" placeholder="New Password" name="password" aria-label="Username" aria-describedby="basic-addon1">
                      </div>                   
                        <?Php if(isset($PasswordlengthError)!=null){?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <?php echo $PasswordlengthError ?>
                        </div>
                        <?php } ?>
                                     
                      <div class="form-group">
                        <label class="form-label">Confirm Password</label>
                        <input type="password" class="form-control" placeholder="Confirm Password" name="confirm_password" aria-label="Username" aria-describedby="basic-addon1">
                      </div>
                        <?Php if(isset($ConfirmPasswordError)!=null){?>
                        <div class="alert alert-warning alert-dismissible fade show" role="alert">
                        <?php echo $ConfirmPasswordError ?>
                        </div>
                        <?php } ?>
                        
                        <button class="btn btn-primary" type="submit" name="updateprofile">Update Profile</button>
                      </form>
                    </div>
              </div>
            </div>
          </div>
 <!-- main content end -->

 <?php
include('../layout/footer.php');
?>