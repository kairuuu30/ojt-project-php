<?php 
session_start();
include '../server/connection.php';

    $username = $_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $bday = $_POST['bday'];
    $phone = $_POST['phone'] ;
    $tup_id = $_POST['tup_id'];
    $college_id = $_POST['college_id'];
    $course_id = $_POST['course_id'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $lowercase_tup_id = strtolower($tup_id);

    $validate_phone_query = "SELECT * FROM students WHERE phone='$phone' AND deleted_at IS NULL";
    $validate_phone_query_run = mysqli_query($conn, $validate_phone_query);

    $validate_query = "SELECT * FROM students WHERE LOWER(tup_id)='$lowercase_tup_id' AND deleted_at IS NULL";
    $validate_query_run = mysqli_query($conn, $validate_query);

    if(!preg_match('/^09\d{9}$/', $phone)) { 
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid Phone Number.'
            
        ]);
    } else if (mysqli_num_rows($validate_phone_query_run) > 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Phone Number already exists. Enter a different Phone Number.'
        ]);
    } else if (mysqli_num_rows($validate_query_run) > 0) { 
        echo json_encode([
            'status' => 'error',
            'message' => 'TUP ID already exists.'
        ]);
    } else if (!preg_match('/^TUPM-\d{2}-\d{4}$/', $tup_id)) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid TUP ID.'
        ]);
    } else {
        $insert_query = "INSERT INTO students
        SET username = '$username',
            password = '$hashed_password',
            name = '$name', 
            bday = '$bday',
            phone = '$phone', 
            tup_id = '$tup_id',
            college_id = '$college_id', 
            course_id = '$course_id',
            created_at = '$date_time_today'
            ";

        $insert_query_run = mysqli_query($conn, $insert_query);

        if($insert_query_run) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Student is created successfully.'
            ]);
        } else {
                echo json_encode([
                'status' => 'error',
                'message' => 'Error.'
            ]);
        } 
    }
?>