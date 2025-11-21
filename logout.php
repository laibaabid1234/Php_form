<?php 
  session_set_cookie_params(0); //session cookie ka expiry time set kia hai, 0 ka matlab hai browser band hote hi session khatam 
  session_start();
  unset($_SESSION['user_id']); 
  unset($_SESSION['user_name']); 
  session_destroy();
  header("Location: login.php");
?>