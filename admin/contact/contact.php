<?php 
include('../../connection.php');
$limit = 2;
$page = isset($_GET['page']) ? (int)$_GET['page'] : 1;
$start_from = ($page - 1) * $limit;

$basePath = '../';
include('../layout/sidebar.php');
include('../layout/navbar.php');
// count total rows
$countquery = "SELECT COUNT(id) AS total FROM contact";
$count_result = mysqli_query($conn, $countquery);
$count_row = mysqli_fetch_assoc($count_result);
$total_records = $count_row['total'];
$total_pages = ceil($total_records / $limit);

$query1="select * from contact LIMIT $start_from, $limit";
$contact=mysqli_query($conn,$query1);

echo "<script>
if (window.history.replaceState) {
  window.history.replaceState(null, null, window.location.href);
}
</script>";
?>
 <div class="row">
          
         <!-- Zero config table start -->
          <div class="col-sm-12">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-3">Contact</h5>
              </div>

              <div class="card-body">
                <div class="dt-responsive table-responsive">
                  <table id="simpletable" class="table table-striped table-bordered nowrap">
                    <thead>
                      <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Subject</th>                       
                        <th>Message</th>
                      </tr>
                    </thead>
                    <tbody>
                       <?php while($row=mysqli_fetch_assoc($contact)){  ?>
                            <tr>
                                <td><?php echo $row['id'] ?></td>
                                <td><?php echo $row['name'] ?></td>
                                <td><?php echo $row['email'] ?></td>
                                <td><?php echo $row['subject'] ?></td>                               
                                <td><?php echo $row['message'] ?></td> 
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
                                    href="contact.php?page=<?php echo ($page - 1)?>">
                                    Previous
                                    </a>
                                </li> 

                                <!-- Page Numbers -->
                                <?php for($i = 1; $i <= $total_pages; $i++): ?>
                                    <li class="page-item <?php echo ($page == $i) ? 'active' : ''; ?>">
                                        <a class="page-link"
                                        href="contact.php?page=<?php echo $i ?>">
                                        <?php echo $i; ?>
                                        </a>
                                    </li>
                                <?php endfor; ?>

                                <!-- Next Button -->
                                <li class="page-item <?php echo ($page >= $total_pages) ? 'disabled' : ''; ?>">
                                    <a class="page-link"
                                    href="contact.php?page=<?php echo ($page + 1) ?>">
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
<?php
include('../layout/footer.php');
?>