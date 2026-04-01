<?php 
if (empty($_SESSION['id'])) {
    header('location: ../auth/logout.php');
}

if(empty($_SESSION['is-user-logged'])) {
    header('location: ../auth/logout.php');
}
?>