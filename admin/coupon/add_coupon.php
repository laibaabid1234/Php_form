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
              <h4>Add Coupon Here</h4>
            </div>
            <div class="card-body">
              <div class="row">
                <div class="form-group">
                  <form action="coupon.php" method="post"  enctype="multipart/form-data">
                    <div class="form-group">
                      <label class="form-label">Coupon Code</label>
                       <input type="text" class="form-control" placeholder="Enter Coupon Code" name="coupon_code" aria-label="Coupon code" aria-describedby="basic-addon1">
                    </div>
                    <div class="form-group">
                      <label class="form-label">Discount(%)</label>
                       <input type="text" class="form-control" placeholder="Enter Discount" name="discount" aria-label="discount" aria-describedby="basic-addon1">
                    </div>
                    <div class="form-group">
                      <label class="form-label">Expiry Date</label>
                       <input type="date" class="form-control" placeholder="Enter Expiry date" name="expiry_date" aria-label="expiry date" aria-describedby="basic-addon1">
                    </div>
                    <div class="form-group">
                      <label class="form-label"> Minimum Order Amount</label>
                      <input type="text" class="form-control" placeholder="Enter Minimum Order Amount" name="order_amount" aria-label="order amount" aria-describedby="basic-addon1">
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