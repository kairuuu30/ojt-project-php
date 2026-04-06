<?php 
session_start();
unset($_SESSION['id']);
unset($_SESSION['username']);
unset($_SESSION['user_image']);
session_destroy();
header("location: ../student/login_form.php");
?>