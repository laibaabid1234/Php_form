<?php
include('../../connection.php');

$limit = 4;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page - 1) * $limit;

if(!isset($_SESSION['user_name']))
{
    header("Location: ../../login.php");
    exit();
}
if(isset($_POST['status']) && $_POST['status'] != null){
    $status = $_POST['status'];
    $orderId =$_POST['orderId']; 

    $updateStatusQuery = "UPDATE orders SET status = '$status' WHERE id = $orderId";
    $statusChanged = mysqli_query($conn, $updateStatusQuery);
    if($statusChanged){
      $statusMessage = "Order status updated successfully";
     
    }else{
      $statusMessage = "Order status not updated";
    }   
    echo json_encode(['statusmessage' => $statusMessage]);
    exit();
}

// count total rows
$countquery = "SELECT COUNT(id) AS total FROM orders";
$count_result = mysqli_query($conn, $countquery);
$count_row = mysqli_fetch_assoc($count_result);
$total_records = $count_row['total'];
$total_pages = ceil($total_records / $limit);

$basePath = '../';
include('../layout/sidebar.php');
include('../layout/navbar.php');

$ordersQuery = "SELECT * FROM orders LIMIT $start_from, $limit";
$orders = mysqli_query($conn, $ordersQuery);

?>
 <!-- [ Main Content ] start -->
        <div class="row">
            <!-- Zero config table start -->
          <div class="col-sm-12">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-3">Orders Table</h5>
                <!-- <a href="add_products.php" class="btn btn-primary">Add New</a> -->
              </div>
            <!-- Table start -->
            <div class="card-body">
    <div class="dt-responsive table-responsive">

        <table id="simpletable" class="table table-striped table-bordered nowrap">
            <thead>
                <tr>
                    <th>Id</th>
                    <th>Name</th>
                    <th>Email</th>
                    <th>Contact</th>
                    <th>Address</th>
                    <th>City</th>
                    <th>Zip</th>
                    <th>Total Amount</th>
                    <th>Action</th>
                    <th>Status</th>
                </tr>
            </thead>

            <tbody>

            <?php 
            $modalIDs = []; // store IDs to build modals later

            while ($row = mysqli_fetch_assoc($orders)) { 
                $modalIDs[] = $row['id'];  // store order id for later modal creation
            ?>
            
                <tr>
                    <td><?= $row['id'] ?></td>
                    <td><?= $row['first_name'] . " " . $row['last_name'] ?></td>
                    <td><?= $row['email'] ?></td>
                    <td><?= $row['contact'] ?></td>
                    <td><?= $row['address'] ?></td>
                    <td><?= $row['city'] ?></td>
                    <td><?= $row['zip'] ?></td>
                    <td><?= $row['total_amount'] ?></td>

                    <td>
                        <button type="button"
                            class="btn btn-info btn-sm"
                            data-bs-toggle="modal"
                            data-bs-target="#orderModal_<?= $row['id'] ?>">
                            View
                        </button>
                    </td>

                    <td>
                        <select name="status" 
                                class="form-select form-select-sm status"
                                data-id="<?= $row['id'] ?>">

                            <option value="Pending"     <?= $row['status']=='Pending'?'selected':'' ?>>Pending</option>
                            <option value="InProgress"  <?= $row['status']=='InProgress'?'selected':'' ?>>Processing</option>
                            <option value="Completed"   <?= $row['status']=='Completed'?'selected':'' ?>>Completed</option>
                            <option value="Cancelled"   <?= $row['status']=='Cancelled'?'selected':'' ?>>Cancelled</option>
                        </select>
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
                                    href="orders.php?page=<?php echo ($page - 1)?>">
                                    Previous
                                    </a>
                                </li> 

                                <!-- Page Numbers -->
                                <?php for($i = 1; $i <= $total_pages; $i++): ?>
                                    <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                                        <a class="page-link"
                                        href="orders.php?page=<?php echo $i ?>">
                                        <?php echo $i; ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>

                                <!-- Next Button -->
                                <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                                    <a class="page-link"
                                    href="orders.php?page=<?php echo ($page + 1) ?>">
                                    Next
                                    </a>
                                </li>

                            </ul>

                        </nav>
                        </div>
                    <?php } ?>
    </div>
</div>
<?php 

foreach ($modalIDs as $orderId) {

    // fetch order items
    $orderDetailsQuery = "
        SELECT * FROM order_items oi
        INNER JOIN products p ON oi.product_id = p.id
        WHERE oi.order_id = $orderId
    ";
    $orderDetails = mysqli_query($conn, $orderDetailsQuery);
?>
    
    <div class="modal fade" id="orderModal_<?= $orderId ?>" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">

                <div class="modal-header">
                    <h5 class="modal-title">Order Details (Order #<?= $orderId ?>)</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                </div>

                <div class="modal-body">

                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Product Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th>Total</th>
                            </tr>
                        </thead>

                        <tbody>
                        <?php while ($d = mysqli_fetch_assoc($orderDetails)) { ?>
                            <tr>
                                <td><?= $d['p_name'] ?></td>
                                <td><?= $d['p_price'] ?></td>
                                <td><?= $d['quantity'] ?></td>
                                <td><?= $d['total'] ?></td>
                            </tr>
                        <?php } ?>
                        </tbody>
                    </table>

                </div>

            </div>
        </div>
    </div>

<?php } ?>


            </div>
          </div>
          <!-- Zero config table end -->
<script>
    $(document).ready(function(){
     $('.status').change(function(){
      var status= $(this).val();
      var orderId = $(this).data('id');
          $.ajax({
             url:'orders.php',
             type:'post',
             data:{status:status, orderId:orderId},
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
 <!-- [ Main Content ] end -->
