<?php 
include('../../connection.php');

$limit = 1;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page - 1) * $limit; 

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

if(isset($_POST['statusId']) && $_POST['statusId'] != null){
    $Id = $_POST['statusId'];
    $couponStatusQuery = "SELECT status FROM coupon WHERE id = $Id";
    $statusResult = mysqli_query($conn, $couponStatusQuery);
    $statusRow = mysqli_fetch_assoc($statusResult);
    $statusId = $statusRow['status'];
    if($statusId==0){
      $statusId=1;
    }else{
      $statusId=0;
    }
    $updateStatusQuery = "UPDATE coupon SET status = $statusId WHERE id = $Id";
    $statuschanged=mysqli_query($conn, $updateStatusQuery);
    if($statuschanged){
      $statusmessage = "Status updated successfully";
    }else{
      $statusmessage = "Status not updated";  
    }   
    echo json_encode(['statusmessage' => $statusmessage]);
    exit();
}

else if(isset($_POST['add']) && isset($_POST['coupon_code']) && $_POST['coupon_code']!= null){
    $couponcode=$_POST['coupon_code'];
    $discount=$_POST['discount'];
    $expiry_date=$_POST['expiry_date'];
    $order_amount=$_POST['order_amount'];
    $query = "INSERT INTO coupon (coupon_code, discount, expiry_date, order_amount) VALUES ('$couponcode','$discount', '$expiry_date','$order_amount')";
    $data=mysqli_query($conn,$query);
    if($data)
    {
        $msg="New record has been submitted";
    }
}
else if(isset($_POST['update']) && isset( $_POST['id']) && $_POST['id']!= null){
    $id=$_POST['id'];
    $couponcode=$_POST['coupon_code'];
    $discount=$_POST['discount'];
    $expiry_date=$_POST['expiry_date'];
    $order_amount=$_POST['order_amount'];
    
    $query="update coupon set coupon_code='$couponcode', discount='$discount', expiry_date='$expiry_date', order_amount='$order_amount' where id='$id'";
    $data=mysqli_query($conn,$query);
    if($data){
        $msg="Changes Saved!";
    }
}
else if (isset($_POST['delete']) && isset($_POST['id']) && $_POST['id'] != null) {
    $id = $_POST['id'];
    $delquery = "DELETE FROM coupon WHERE id = $id";
    $data=mysqli_query($conn,$delquery);
    if($data){
       $msg="Record has been deleted";
    }
}
// count total rows
$countquery = "SELECT COUNT(id) AS total FROM coupon";
$count_result = mysqli_query($conn, $countquery);
$count_row = mysqli_fetch_assoc($count_result);
$total_records = $count_row['total'];
$total_pages = ceil($total_records / $limit);

$query1="select * from coupon LIMIT $start_from, $limit";
$coupon=mysqli_query($conn,$query1);

echo "<script>
if (window.history.replaceState) {
  window.history.replaceState(null, null, window.location.href);
}
</script>";
?>
        <div class="row">
            <?Php if(isset($data)&& $data!=null){?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                  <?php echo $msg ?>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            <?php } ?>
         <!-- Zero config table start -->
          <div class="col-sm-12">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-3">Coupon Table</h5>
              <a href="add_coupon.php" class="btn btn-primary">Add New</a>
              </div>

              <div class="card-body">
                <div class="dt-responsive table-responsive">
                  <table id="simpletable" class="table table-striped table-bordered nowrap">
                    <thead>
                      <tr>
                        <th>Id</th>
                        <th>Coupon Code</th>
                        <th>Discount</th>
                        <th>Expiry Date</th>                       
                        <th>Order Amount</th>
                        <th>Status</th>
                        <th>Action</th>
                      </tr>
                    </thead>
                    <tbody>
                       <?php while($row=mysqli_fetch_assoc($coupon)){  ?>
                            <tr>
                                <td><?php echo $row['id'] ?></td>
                                <td><?php echo $row['coupon_code'] ?></td>
                                <td><?php echo $row['discount'] ?></td>
                                <td><?php echo $row['expiry_date'] ?></td>
                                <td><?php echo $row['order_amount'] ?></td>                              
                                <td>                        
                                <div class="form-check form-switch">
                                    <input class="form-check-input toggle" id="toggle_id" value="<?php echo $row['id'] ?>" type="checkbox" 
                                    <?php if($row['status']==1){ echo 'checked'; } ?> name="toggle" role="switch">                                              
                                </div>                                                              
                                </td> 
                                <td class="d-flex flex-wrap gap-1"> 
                                    <a href="edit_coupon.php?id=<?php echo $row['id'] ?>" class="btn btn-warning">Edit</a>
                                    <form action="coupon.php" method="post" style="display:inline;">
                                        <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                                        <button type="submit" name="delete"  class="btn btn-danger">Delete</button>
                                    </form>
                                </td>                     
                            </tr>
                        <?php } ?>
                    </tbody>
                  </table>
                     <?php if($total_pages > 1){ ?>
                    <div class="col-12">
                       <nav>
                           <ul class="pagination justify-content-center">
                                <?php
                                $page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
                                ?>

                                <!-- Previous Button -->
                                <li class="page-item <?php echo ($page <= 1) ? 'disabled' : ''; ?>">
                                    <a class="page-link"
                                    href="coupon.php?page=<?php echo ($page - 1)?>">
                                    Previous
                                    </a>
                                </li> 

                                <!-- Page Numbers -->
                                <?php for($i = 1; $i <= $total_pages; $i++): ?>
                                    <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                                        <a class="page-link"
                                        href="coupon.php?page=<?php echo $i ?>">
                                        <?php echo $i; ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>

                                <!-- Next Button -->
                                <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                                    <a class="page-link"
                                    href="coupon.php?page=<?php echo ($page + 1) ?>">
                                    Next
                                    </a>
                                </li>

                            </ul>

                        </nav>
                        </div>
                    <?php } ?>
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
          url:'coupon.php',
          type:'post',
          data:{statusId:status_id},
          success:function(response){
            response = JSON.parse(response);
            alert(response.statusmessage);
          }

        });     
    });
})
</script>
<?php 
include('../layout/footer.php'); 
?>