<?php
$basePath = '../';
include('../../connection.php');


if(!isset($_SESSION['user_name']))
{
    header("Location: ../../login.php");
    exit();
}
if(isset($_POST['statusId']) && $_POST['statusId'] != null){
    $Id = $_POST['statusId'];
    $subcategoryStatusQuery = "SELECT status FROM sub_category WHERE id = $Id";
    $statusResult = mysqli_query($conn, $subcategoryStatusQuery);
    $statusRow = mysqli_fetch_assoc($statusResult);
    $statusId = $statusRow['status'];
    if($statusId==0){
      $statusId=1;
    }else{
      $statusId=0;
    }
    $updateStatusQuery = "UPDATE sub_category SET status = $statusId WHERE id = $Id";
    $statuschanged=mysqli_query($conn, $updateStatusQuery);
    if($statuschanged){
      $statusmessage = "Status updated successfully";
    }else{
      $statusmessage = "Status not updated";  
    }   
    echo json_encode(['statusmessage' => $statusmessage]);
    exit();
  
}
include('../layout/sidebar.php');
include('../layout/navbar.php');
$data=null;

if(isset($_POST['update']) && isset( $_POST['id']) && $_POST['id']!= null){
    $id=$_POST['id'];
    $name=$_POST['name'];
    $cat_id=$_POST['cat_id'];
    $query="update sub_category set name='$name',cat_id='$cat_id' where id='$id'";
    $data=mysqli_query($conn,$query);
   if($data){
       $msg="Changes Saved!";
    }
}
else if(isset($_GET['id'])&& $_GET['id']!=null)
{
    $id=$_GET['id'];
    $query="select * from sub_category where id='$id'";
    $sub_category=mysqli_query($conn,$query);
    $row=mysqli_fetch_assoc($sub_category);
}
else if (isset($_POST['delete']) && isset($_POST['id']) && $_POST['id'] != null) {
    $id = $_POST['id'];
    $delquery = "DELETE FROM sub_category WHERE id = $id";
    $data=mysqli_query($conn,$delquery);
    if($data){
       $msg="Record has been deleted";
    }
}
else if(isset($_POST['add']) && isset($_POST['name']) && $_POST['name']!= null){
    $name=$_POST['name'];
    $cat_id=$_POST['cat_id'];
    $query = "INSERT INTO sub_category (name,cat_id) VALUES ('$name','$cat_id')";
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
$query1="select sub_category.id as id,category.name as cat_name,sub_category.name as sub_name,sub_category.cat_id as cat_id,sub_category.status as status from sub_category inner join category on category.id=sub_category.cat_id";
$sub_category=mysqli_query($conn,$query1);
?>
 <!-- [ breadcrumb ] start -->
        <!-- <div class="page-header">
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
        </div> -->
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
                <h5 class="mb-3">Sub Category Table</h5>

              <!-- Button trigger modal -->
            <button type="button" class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#exampleModal">
              Add new
            </button> 
              </div>
            <!-- Table start -->
              <div class="card-body">
                <div class="dt-responsive table-responsive">
                  <table id="simpletable" class="table table-striped table-bordered nowrap">
                    <thead>
                      <tr>
                        <th>Id</th>
                        <th>Sub Category Name</th>
                        <th>Category Name</th>
                        <th>Actions</th>
                        <th>Status</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php while($row=mysqli_fetch_assoc($sub_category)){  ?>
                    <tr>
                      <td><?php echo $row['id'] ?></td>
                      <td><?php echo $row['sub_name'] ?></td> 
                      <td><?php echo $row['cat_name'] ?></td>            
                      <td> 
                          <button type="button" class="btn btn-warning" data-bs-toggle="modal" data-bs-target="#editModal_<?php echo $row['id']; ?>">
                          Edit
                          </button> 
                          
                          <form action="sub_category.php" method="post" style="display:inline;">
                            <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                            <button type="submit" name="delete"  class="btn btn-danger">Delete</button>
                          </form>
                       </td> 
                       <td>                        
                          <div class="form-check form-switch">
                            <input class="form-check-input toggle" id="toggle_id" value="<?php echo $row['id'] ?>" type="checkbox" <?php if($row['status']==1){ echo 'checked'; } ?> name="toggle" role="switch" id="myToggleSwitch">                                              
                          </div>                                                              
                       </td>
                      </tr>
                    <!-- edit modal start -->
                            <div class="modal fade" id="editModal_<?php echo $row['id']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                            <div class="modal-dialog modal-dialog-centered">
                              <div class="modal-content">
                                <form method="POST" action="sub_category.php" style="display:inline;">

                                    <div class="modal-header">
                                      <h1 class="modal-title fs-5" id="exampleModalLabel">Add Sub Category here</h1>
                                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                    </div>
                                    <div class="modal-body">
                                      
                                      <div class="container">
                                        <div class="row">
                                          <div class="col-lg-12">
                                            <label class="form-label">Sub Category</label>
                                            <input type="hidden" class="form-control" name="id" aria-label="Username" value="<?php echo $row['id'] ?>" aria-describedby="basic-addon1">
                                            <input type="text" class="form-control" name="name" value="<?php echo $row['sub_name'] ?>" aria-label="Username" aria-describedby="basic-addon1">
                                          </div>
                                          <div class="col-lg-12 mt-3">  
                                            <label class="form-label">Category</label>                             
                                            <select name="cat_id" id="" class="form-control">
                                              <option value="">Select Category</option>
                                              <?php 
                                                $cat_query="Select * from category";
                                                  $cat_data=mysqli_query($conn,$cat_query);
                                                 
                                                while($cat=mysqli_fetch_assoc($cat_data)){
                                                  if($row['cat_id']==$cat["id"])  { ?>

                                                  <option selected value="<?php echo $cat["id"]; ?>"><?php echo $cat["name"]; ?></option>
                                                   <?php }else{ ?>
                                                  <option value="<?php echo $cat["id"]; ?>"><?php echo $cat["name"]; ?></option>

                                                  <?php  } ?>
                                                  <?php  } ?>
                                            </select>
                                          </div>
                                        </div>
                                      </div>
                                    </div> 
                                    <div class="modal-footer">
                                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                                      <button type="submit" class="btn btn-primary" name="update">Save Changes</button>
                                    </div>
                                </form>
                              </div>
                            </div>
                          </div>
                           <!-- edit modal end -->
                     <?php } ?>
                    </tbody>
                  </table>
                   <!-- Table end -->
                </div>
              </div>
            </div>
          </div>
          <!-- Zero config table end -->

            <!-- Add new Modal -->
            <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
              <div class="modal-dialog modal-dialog-centered">
                <div class="modal-content">
                
                  <form action="sub_category.php" method="post">
                    <div class="modal-header">
                      <h1 class="modal-title fs-5" id="exampleModalLabel">Add Sub Category here</h1>
                      <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                      <div class="container">
                        <div class="row">
                            <div class="col-lg-12">
                              <label class="form-label">Sub Category</label>
                              <input type="text" class="form-control" name="name" placeholder="Enter your Sub Category" aria-label="Username" aria-describedby="basic-addon1">
                            </div>
                            <div class="col-lg-12 mt-3">
                              <label class="form-label">Category</label>
                              <select name="cat_id" id="" class="form-control">
                                <option value="">Select Category</option>
                                <?php 
                                $cat_query="Select * from category";
                                  $cat_data=mysqli_query($conn,$cat_query);
                                while($cat=mysqli_fetch_assoc($cat_data)){?>
                                <option value="<?php echo $cat["id"]; ?>"><?php echo $cat["name"]; ?></option>
                                <?php } ?>
      
                              </select>
                            
                            </div>
                        </div>
                      </div> 
                    </div>

                    <div class="modal-footer">
                      <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Close</button>
                      <button type="submit" class="btn btn-primary" name="add">Submit</button>
                    </div>
                  </form>
              
                </div>             
              </div>
            </div>
            <!-- end -->

          <?php }else{ ?>
          <!-- Zero config table start -->
          <div class="col-sm-12">
            <div class="card">
              <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="mb-3">Sub Category Table</h5>
              </div>

            <!-- Table start -->
              <div class="card-body">
                <div class="dt-responsive table-responsive">
                  <table id="simpletable" class="table table-striped table-bordered nowrap">
                    <thead>
                      <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Category Name</th>
                      </tr>
                    </thead>
                    <tbody>
                    <?php while($row=mysqli_fetch_assoc($sub_category)){  ?>
                    <tr>
                      <td><?php echo $row['id'] ?></td>
                      <td><?php echo $row['sub_name'] ?></td>  
                      <td><?php echo $row['cat_name'] ?></td>          
                    </td> 
                    </tr>
                    <?php } ?>
                    </tbody>
                  </table>
                </div>
              </div>
            </div>
          </div>
            <?php }?>
<script>
   $(document).ready(function(){
    $('.toggle').change(function(){
     var status_id= $(this).val();
        $.ajax({
          url:'sub_category.php',
          type:'post',
          data:{statusId:status_id},
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