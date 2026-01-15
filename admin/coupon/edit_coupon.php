<?php
include('../../connection.php');
if(!isset($_SESSION['user_name']))
{
    header("Location: ../../login.php");
    exit();
}
if(isset($_SESSION['user_role']) && $_SESSION['user_role'] != 'admin')
{
    header("Location: ../../website/index.php");
    exit();
}
$basePath = '../';
if(isset($_GET['id'])&& $_GET['id']!=null)
{
    $id=$_GET['id'];
    $query="select * from coupon where id='$id'";
    $coupon=mysqli_query($conn,$query);
    $editrow=mysqli_fetch_assoc($coupon);
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
              <h4>Edit Coupon Here</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="form-group">
                  <form action="coupon.php" method="post" enctype="multipart/form-data">
                    <div class="form-group">
                      <input type="hidden" class="form-control" value="<?php echo $editrow['id'] ?>" name="id" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                    <div class="form-group">
                      <label class="form-label">Coupon Code</label>
                     <input type="text" class="form-control" value="<?php echo $editrow['coupon_code'] ?>" name="coupon_code" placeholder="Coupon Code" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                    <div class="form-group">
                      <label class="form-label">Discount(%)</label>
                     <input type="number" class="form-control" placeholder="Discount" value="<?php echo $editrow['discount'] ?>" name="discount" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                    <div class="form-group">
                      <label class="form-label">Expiry Date</label>
                     <input type="date" class="form-control" placeholder="Expiry Date" value="<?php echo $editrow['expiry_date'] ?>" name="expiry_date" aria-label="Username" aria-describedby="basic-addon1">
                    </div>
                    <div class="form-group">
                      <label class="form-label"> Minimum Order Amount</label>
                      <input type="text" class="form-control" placeholder="Enter Minimum Order Amount" value="<?php echo $editrow['order_amount'] ?>" name="order_amount" aria-label="order amount" aria-describedby="basic-addon1">
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