<?php 
session_start();
unset($_SESSION['id']);
unset($_SESSION['username']);
session_destroy();
header("location: ../student/login_form.php");
?>