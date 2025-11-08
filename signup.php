<?php
include('connection.php');
if (isset($_SESSION['user_name'])){
    header("Location: admin/users/form.php");
    exit();
}
$basePath = 'admin/';
if(isset($_POST['register'])){
    //forms data
    $name=$_POST['name'];
    $userName=$_POST['user_name'];
    $email=$_POST['email'];
    $password=$_POST['password'];
    $confirmPassword=$_POST['confirm_password'];
    $hashedpassword=password_hash($password, PASSWORD_DEFAULT);
    
    
    //end

    //error message variable
    $userNameError=null;
    $emailError=null;
    $ConfirmPasswordError=null;
    $PasswordlengthError=null;
    //end

    //username check
    if($userName !=null || $userName != " " )
    {
        $userQuery="select * from users where user_name='$userName'";
        $userData=mysqli_query($conn,$userQuery);
        if($userData) {
            if (mysqli_num_rows($userData) > 0) {
                $userNameError="Username should be unique!";
            } 
        }
    }
    //end

    //email check
    if($email !=null || $email !=" " )
    {
        $emailQuery="select * from users where email='$email'";
        $emailData=mysqli_query($conn,$emailQuery);
        if($emailData) {
            if (mysqli_num_rows($emailData) > 0) {
                $emailError="Email Address should be unique!";
            } 
        }
    }
    //end

     //password length check
    if(strlen($password)<= 8){
         $PasswordlengthError="Password length must be greater than 8 characters!";
    }
    //end

    //password check
    if($password!=null && $confirmPassword!=null)
    {
        if($password!==$confirmPassword)
        {
            $ConfirmPasswordError="Confirm password must be same as password!";
        }
    }
    //end

    // sirf tab insert karo jab koi error set nahi ho
    if(empty($userNameError) && empty($emailError) && empty($ConfirmPasswordError)&& empty($PasswordlengthError)){
        $query = "INSERT INTO users(name,user_name,email,password) 
                VALUES ('$name','$userName','$email','$hashedpassword')";
        $data = mysqli_query($conn,$query);

        if($data) {
            $msg = "Registered Successfully!";
        }
    }
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
            <h2>Create Your Account</h2>
            <p>Sign up to get started!</p>
        </div>
        <form action="signup.php" method="post">
             <div class="mb-3">
                <label for="username" class="form-label">Name</label>
                <input type="text" class="form-control" name="name" id="name" placeholder="Enter your name" required>
            </div>
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
                <label for="email" class="form-label">Email Address</label>
                <input type="email" class="form-control" name="email" id="email" placeholder="Enter your email" required>
            </div>
            <?Php if(isset($emailError)&& $emailError!=null){?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <?php echo $emailError ?>
                </div>
                <?php } ?>
            <div class="mb-3">
                <label for="password" class="form-label">Password</label>
                <input type="password" class="form-control" name="password" id="password" placeholder="Create a password" required>
            </div>
             <?Php if(isset($PasswordlengthError)!=null){?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <?php echo $PasswordlengthError ?>
                </div>
                <?php } ?>
            <div class="mb-3">
                <label for="confirm-password" class="form-label">Confirm Password</label>
                <input type="password" class="form-control" name="confirm_password" id="confirm-password" placeholder="Confirm your password" required>
            </div>
             <?Php if(isset($ConfirmPasswordError)&& $ConfirmPasswordError!=null){?>
                <div class="alert alert-warning alert-dismissible fade show" role="alert">
                <?php echo $ConfirmPasswordError ?>
                </div>
                <?php } ?>
            <button type="submit" class="btn btn-custom w-100" name="register">Register</button>
        </form>
        <div class="text-muted">
            Already have an account? <a href="login.php" class="text-primary">Sign In</a>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
