<?php
include('connection.php');

if(isset($_POST['update']) && isset( $_POST['id']) && $_POST['id']!= null){
    $id=$_POST['id'];
    $name=$_POST['name'];
    $email=$_POST['email'];
    $contact=$_POST['contact'];
    $query="update users set name='$name',email='$email',contact='$contact' where id='$id'";
    $data=mysqli_query($conn,$query);

   if($data){
       $msg="Record has been updated";
    }
}

else if (isset($_POST['delete']) && isset($_POST['id']) && $_POST['id'] != null) {
    $id = $_POST['id'];
    $delquery = "DELETE FROM users WHERE id = $id";
    $delete=mysqli_query($conn,$delquery);
    if($delete){
       $msg1="Record has been deleted";
    }
}

else if(isset($_POST['name']) && $_POST['name']!= null){
    $name=$_POST['name'];
    $email=$_POST['email'];
    $contact=$_POST['contact'];
    $query="insert into users(name,email,contact)value('$name','$email','$contact')";
    $data=mysqli_query($conn,$query);

    if($data)
    {
        $msg="New record has been submitted";
    }
}


$query1="select * from users";
$users=mysqli_query($conn,$query1);

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-EVSTQN3/azprG1Anm3QDgpJLIm9Nao0Yz1ztcQTwFspd3yD65VohhpuuCOmLASjC" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>
 
    <!-- <form action="form.php" method="post">
      Name:  <input type="text" name="name"><br>
      Email:  <input type="text" name="email"> <br>
      Contact:  <input type="text" name="contact" id=""> <br>
        <input type="submit" value="submit">
    </form> -->
<?Php if(isset($data)&& $data!=null){?>
 <div class="alert alert-success alert-dismissible fade show" role="alert">
  <strong>New Alert</strong> <?php echo $msg ?>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php } ?>
<?Php if(isset($delete)&& $delete!=null){?>
 <div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>New Alert</strong> <?php echo $msg1 ?>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php } ?>
 <a href="add_users.php"  class="btn btn-success">Add New</a>
    <table class="table table-striped ">
        
        <thead>
            <td>ID</td>
            <td>NAME</td>
            <td>Email</td>
            <td>Contact</td>
            <td>Actions</td>
        </thead>
        <tbody>
            
            <?php while($row=mysqli_fetch_assoc($users)){  ?>
            <tr>
                <td><?php echo $row['id'] ?></td>
                <td><?php echo $row['name'] ?></td>
                <td><?php echo $row['email'] ?></td>
                <td><?php echo $row['contact'] ?></td>
                <td> 
                <a href="edit_users.php?id=<?php echo $row['id'] ?>"  class="btn btn-warning">Edit</a>
                <form method="POST" action="form.php" style="display:inline;">
                <input type="hidden" name="id" value="<?php echo $row['id'] ?>">
                <button type="submit" name="delete"  class="btn btn-danger">Delete</button>
                </form>
                </td>
            </tr>
            <?php } ?>
        </tbody>
    </table>

</body>
</html>