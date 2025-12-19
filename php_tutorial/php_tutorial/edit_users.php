<?php
include('connection.php');

if(isset($_GET['id'])&& $_GET['id']!=null)
{
    $id=$_GET['id'];
    $query="select * from users where id='$id'";
    $user=mysqli_query($conn,$query);
    $row=mysqli_fetch_assoc($user);
}
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
<h1>Edit Users Here</h1>
<form action="form.php" method="post">
    <input type="hidden" class="form-control" value="<?php echo $row['id'] ?>" name="id" placeholder="Name" aria-label="Username" aria-describedby="basic-addon1">

    <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1">NAME</span>
        <input type="text" class="form-control" value="<?php echo $row['name'] ?>" name="name" placeholder="Name" aria-label="Username" aria-describedby="basic-addon1">
    </div>

    <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1">EMAIL</span>
        <input type="text" class="form-control" placeholder="Email" value="<?php echo $row['email'] ?>" name="email" aria-label="Username" aria-describedby="basic-addon1">
    </div>

    <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1">Contact</span>
        <input type="text" class="form-control" placeholder="Contact" value="<?php echo $row['contact'] ?>" name="contact" aria-label="Username" aria-describedby="basic-addon1">
    </div>
       <button type="submit" class="btn btn-success" name="update">UPDATE</button>
   
</form>
    
</body>
</html>