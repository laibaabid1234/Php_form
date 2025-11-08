<?php 
include('../../connection.php');
if(!isset($_SESSION['user_name']))
{
    header("Location: ../../login.php");
    exit();
}
if($_SESSION['user_role'] != "admin"){
header("Location: form.php");
}
$basePath = '../';
include('../layout/sidebar.php');
include('../layout/navbar.php');
echo "<script>
if (window.history.replaceState) {
  window.history.replaceState(null, null, window.location.href);
}
</script>";
?>

<!-- Main content start -->
 <div class="card">
            <div class="card-header">
              <h4>Add Users Here</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="form-group">
                  <form action="form.php" method="post"  enctype="multipart/form-data">
                    <div class="form-group">
                      <label class="form-label">Name</label>
                       <input type="text" class="form-control" name="name" placeholder="Enter your Name" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                    <div class="form-group">
                      <label class="form-label">Email</label>
                       <input type="text" class="form-control" placeholder="Enter your Email" name="email" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                    <div class="form-group">
                      <label class="form-label">Contact</label>
                       <input type="text" class="form-control" placeholder="Contact Number" name="contact" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                    <div class="form-group">
                    <input type="file" class="form-control" name="image" aria-describedby="basic-addon1">
                    </div>
                    <button type="submit" name="add" class="btn btn-primary mb-4">Submit</button>
                    </form>
                </div>
               
              </div>
            </div>
          </div>

<!-- main content end -->

 <?php
include('../layout/footer.php');
?>