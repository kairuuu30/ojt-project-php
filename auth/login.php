<?php 
session_start();
include("../server/connection.php"); 


if (isset($_POST['login'])) {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);
    
    
    $select = mysqli_query($conn, "SELECT * FROM students WHERE username = '$username'");
    $row = mysqli_fetch_array($select);

    if(!password_verify($password, $hashed_password) && !$row) {
        echo json_encode([
                'status' => 'error',
                'message' => 'Login Failed. Please try again. '
            ]);
    } else {
        $_SESSION["id"] = $row['id'];
        $_SESSION["username"] = $row['username'];
        $_SESSION["name"] = $row['name'];
        $_SESSION['is-user-logged'] = 1;

        echo json_encode([
            'status' => 'success',
            'message' => 'Login Success!',
            'redirect' => '../student/list.php'
        ]);
    } 
}
?> 