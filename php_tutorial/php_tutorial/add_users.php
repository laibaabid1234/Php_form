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
<h1>Add Users Here</h1>
<form action="form.php" method="post">
    <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1">NAME</span>
        <input type="text" class="form-control" name="name" placeholder="Name" aria-label="Username" aria-describedby="basic-addon1">
    </div>

    <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1">EMAIL</span>
        <input type="text" class="form-control" placeholder="Email" name="email" aria-label="Username" aria-describedby="basic-addon1">
    </div>

    <div class="input-group mb-3">
        <span class="input-group-text" id="basic-addon1">Contact</span>
        <input type="text" class="form-control" placeholder="Contact" name="contact" aria-label="Username" aria-describedby="basic-addon1">
    </div>
       <button type="submit" class="btn btn-success">SUBMIT</button>
   
</form>
    
</body>
</html>