<?php
include('../connection.php');
if(!isset($_SESSION['user_name']))
{
    header("Location: ../login.php");
    exit();
}
if ($_SESSION['user_role'] != "admin"){
header("Location: users/form.php");
}
$basePath = null;
include('layout/sidebar.php');
include('layout/navbar.php');

$count= "select * from users";
$query=mysqli_query($conn,$count);

$count= "select * from category";
$query1=mysqli_query($conn,$count);

$count= "select * from sub_category";
$query2=mysqli_query($conn,$count);

$count= "select * from products";
$query3=mysqli_query($conn,$count);
?> 
      <!-- [ breadcrumb ] start -->
      <!-- <div class="page-header">
        <div class="page-block">
          <div class="row align-items-center">
            <div class="col-md-12">
              <div class="page-header-title">
                <h5 class="m-b-10">Home</h5>
              </div>
              <ul class="breadcrumb">
                <li class="breadcrumb-item"><a href="../dashboard/index.html">Home</a></li>
                <li class="breadcrumb-item"><a href="javascript: void(0)">Dashboard</a></li>
                <li class="breadcrumb-item" aria-current="page">Home</li>
              </ul>
            </div>
          </div>
        </div>
      </div> -->
      <!-- [ breadcrumb ] end -->
      
      <!-- [ Main Content ] start -->
      <div class="row">
        <div class="col-md-6 col-xl-3">
          <div class="card">
            <div class="card-body">
              <h6 class="mb-2 f-w-400 text-muted">Total Users</h6>
              <h4 class="mb-3"> <span class="badge bg-light-success border border-success"><i
                    class="ti ti-trending-up"></i><?php echo mysqli_num_rows($query)?></span></h4>
              <!-- <p class="mb-0 text-muted text-sm">You made an extra <span class="text-success">8,900</span> this year</p> -->
            </div>
          </div>
        </div>

         <div class="col-md-6 col-xl-3">
          <div class="card">
            <div class="card-body">
              <h6 class="mb-2 f-w-400 text-muted">Total Categories</h6>
              <h4 class="mb-3"> <span class="badge bg-light-warning border border-warning"><i
                    class="ti ti-trending-up"></i><?php echo mysqli_num_rows($query1)?></span></h4>
              <!-- <p class="mb-0 text-muted text-sm">You made an extra <span class="text-warning">8,900</span> this year</p> -->
            </div>
          </div>
        </div>

         <div class="col-md-6 col-xl-3">
          <div class="card">
            <div class="card-body">
              <h6 class="mb-2 f-w-400 text-muted">Total Sub Categories</h6>
              <h4 class="mb-3"> <span class="badge bg-light-info border border-info"><i
                    class="ti ti-trending-up"></i><?php echo mysqli_num_rows($query2)?></span></h4>
              <!-- <p class="mb-0 text-muted text-sm">You made an extra <span class="text-info">8,900</span> this year</p> -->
            </div>
          </div>
        </div>

         <div class="col-md-6 col-xl-3">
          <div class="card">
            <div class="card-body">
              <h6 class="mb-2 f-w-400 text-muted">Total Products</h6>
              <h4 class="mb-3"> <span class="badge bg-light-secondary border border-secondary"><i
                    class="ti ti-trending-up"></i><?php echo mysqli_num_rows($query3)?></span></h4>
              <!-- <p class="mb-0 text-muted text-sm">You made an extra <span class="text-secondary">8,900</span> this year</p> -->
            </div>
          </div>
        </div>
        </div>
      
<?php
include('layout/footer.php');
?>
       