<?php
include('../../connection.php');
if(!isset($_SESSION['user_name']))
{
    header("Location: ../../login.php");
    exit();
}
$basePath = '../';
if(isset($_GET['id'])&& $_GET['id']!=null)
{
    $id=$_GET['id'];
    $query="select * from users where id='$id'";
    $user=mysqli_query($conn,$query);
    $editrow=mysqli_fetch_assoc($user);
}
include('../layout/sidebar.php');
include('../layout/navbar.php');
echo "<script>
if (window.history.replaceState) {
  window.history.replaceState(null, null, window.location.href);
}
</script>";
?>

<!-- main content start -->
  <div class="card">
            <div class="card-header">
              <h4>Edit Users Here</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="form-group">
                  <form action="form.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
            
                      <input type="hidden" class="form-control" value="<?php echo $editrow['id'] ?>" name="id" placeholder="Name" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                    <div class="form-group">
                      <label class="form-label">Name</label>
                     <input type="text" class="form-control" value="<?php echo $editrow['name'] ?>" name="name" placeholder="Name" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                    <div class="form-group">
                      <label class="form-label">Email</label>
                     <input type="text" class="form-control" placeholder="Email" value="<?php echo $editrow['email'] ?>" name="email" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                    <div class="form-group">
                      <label class="form-label">Contact</label>
                        <input type="text" class="form-control" placeholder="Contact" value="<?php echo $editrow['contact'] ?>" name="contact" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                    <div class="form-group">
                    <input type="file" class="form-control" name="image" aria-describedby="basic-addon1">
                    </div>
                  <button class="btn btn-primary" type="submit" name="update">Update</button>
                    </form>
                </div>
               
              </div>
            </div>
          </div>
 <!-- main content end -->

 <?php
include('../layout/footer.php');
?>