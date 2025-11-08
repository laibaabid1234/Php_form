<?php
include('connection.php');
if (isset($_SESSION['user_name'])){
    header("Location: admin/dashboard.php");
    exit();
}
$basePath = 'admin/';
if(isset($_POST['login'])){
    //forms data
    $userName=mysqli_real_escape_string($conn,$_POST['user_name']);
    $password = trim(mysqli_real_escape_string($conn, $_POST['password']));
    //end
    
    //username check
    if($userName !=null || $userName != " " )
    {
        $userQuery="select * from users where user_name='$userName'";
        $userData=mysqli_query($conn,$userQuery);
        if($userData) {
            if (mysqli_num_rows($userData) > 0) {
                if(!empty($password))
                {
                   $row=mysqli_fetch_assoc($userData);
                   $decryptPassword = password_verify($password, $row['password']);
                //    echo $decryptPassword;
                   if($decryptPassword)
                   {
                      session_start();
                      $_SESSION['id'] = $row['id'];
                      $_SESSION['user_name']=$row['user_name'];
                      $_SESSION['name']=$row['name'];
                      $_SESSION['email']=$row['email'];
                      $_SESSION['password']=$row['password'];
                      $_SESSION['user_role'] = $row['user_role'];
                      header("Location: admin/dashboard.php"); 
                      exit();
                   }
                   else{
                    $userPasswordError="Invalid Password!";
                   }
                }
            }else{
                $userNameError="Invalid Username!";
            } 
        }
    }
     //end

}


?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Registration Form</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: #fff;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
        }
        .registration-form {
            background: #ffffff;
            color: #000;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 4px 6px rgba(0, 0, 0, 0.1);
            max-width: 400px;
            width: 100%;
        }
        .form-control:focus {
            box-shadow: 0 0 10px rgba(38, 143, 255, 0.5);
            border-color: #268fff;
        }
        .form-header {
            text-align: center;
            margin-bottom: 1.5rem;
        }
        .form-header h2 {
            font-weight: bold;
        }
        .form-header p {
            font-size: 0.9rem;
            color: #6c757d;
        }
        .btn-custom {
            background: linear-gradient(135deg, #6a11cb, #2575fc);
            color: #fff;
            border: none;
            transition: background 0.3s ease;
        }
        .btn-custom:hover {
            background: linear-gradient(135deg, #2575fc, #6a11cb);
        }
        .text-muted {
            font-size: 0.8rem;
            text-align: center;
            margin-top: 1rem;
        }
    </style>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js" integrity="sha384-MrcW6ZMFYlzcLA8Nl+NtUVF0sA7MsXsP1UyJoMp4YLEuNSfAP+JcXn/tWtIaxVXM" crossorigin="anonymous"></script>
</head>
<body>

    <div class="registration-form">
     <?Php if(isset($data)&& $data!=null){?>
 <div class="alert alert-warning alert-dismissible fade show" role="alert">
  <strong>New Alert</strong> <?php echo $msg ?>
  <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
</div>
<?php } ?>
        <div class="form-header">
            <h2>Login Here</h2>
        </div>
        <form action="login.php" method="post">
            <div class="mb-3">
                <label for="username" class="form-label">Username</label>
                <input type="text" class="form-control" name="user_name" id="username" placeholder="Enter your username" required>
            </div>
            <?Php if(isset($userNameError)&& $userNameError!=null){?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <?php echo $userNameError ?>
                </div>
            <?php } ?>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="text" class="form-control" name="password" id="password" placeholder="Create a password" required>
            </div>
           <?Php if(isset($userPasswordError)&& $userPasswordError!=null){?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <?php echo $userPasswordError ?>
                </div>
                <?php } ?>
            <button type="submit" class="btn btn-custom w-100" name="login">Login</button>
        </form>
        <div class="text-muted">
            Don't have an account? <a href="signup.php" class="text-primary">Sign Up</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
