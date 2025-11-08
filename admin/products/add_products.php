<?php 
  include('../../connection.php');
  $basePath = '../';
  include('../layout/sidebar.php');
  include('../layout/navbar.php');
  if(!isset($_SESSION['user_name']))
  {
      header("Location: ../../login.php");
      exit();
  }
  if($_SESSION['user_role'] != "admin"){
  header("Location: form.php");
  }  
  
  if(isset($_POST['cat_id']) && $_POST['cat_id'] != null){
       $cat_id = $_POST['cat_id'];
       $subcat_query="Select * from sub_category where cat_id='$cat_id'";
       $subcat_data=mysqli_query($conn,$subcat_query);  
       echo '<option value="">Select Sub Category</option>';
         while($subcat=mysqli_fetch_assoc($subcat_data)){
         echo '<option value="'.$subcat['id'].'">'. $subcat["name"].'</option>';
       }
    exit(); 
   }  
  echo "<script>
  if (window.history.replaceState) {
    window.history.replaceState(null, null, window.location.href);
  }
  </script>";
     
  ?>

  <!-- Main content start -->
  <div class="card">
              <div class="card-header">
                <h4>Add Products Here</h4>
              </div>
              <div class="card-body">
                <div class="row">
                  <div class="form-group">
                    <form action="products.php" method="post"  enctype="multipart/form-data">
                      <div class="form-group">
                        <label class="form-label">Product Name</label>
                        <input type="text" class="form-control" name="p_name" placeholder="Product Name" aria-label="Username" aria-describedby="basic-addon1">
                      </div>
                      <div class="form-group">
                        <label class="form-label">Price</label>
                        <input type="number" class="form-control" placeholder="Product Price" name="p_price" aria-label="Username" aria-describedby="basic-addon1">
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
                        <div class="col-lg-12 mt-3 mb-3">  
                          <label class="form-label">Sub Category</label>                             
                          <select name="subcat_id" id="" class="form-control">
                          <option value="">Select Category first</option>
                          </select>
                      </div>
                      <button type="submit" name="add" class="btn btn-primary mb-4">Submit</button>
                      </form>
                  </div>          
                </div>
              </div>
            </div>

  <!-- main content end -->

  <script>
  $(document).ready(function(){
      $('select[name="cat_id"]').on('change', function() {
          var catID = $(this).val();
          if(catID) {
            $.ajax({
              type:'POST',
              url:'add_products.php',
              data:{cat_id:catID},
              success:function(data){
                  $('select[name="subcat_id"]').html(data);
              }
            });   
          } else {
              $('select[name="subcat_id"]').html('<option value="">Select Sub Category</option>');
          }
      });
  });
  </script>
  <?php
  include('../layout/footer.php');
?>