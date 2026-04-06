<?php 
session_start();
include '../server/connection.php';

    $username = $_POST['username'];
    $password = $_POST['password'];
    $name = $_POST['name'];
    $bday = $_POST['bday'];
    $phone = $_POST['phone'];
    $tup_id = $_POST['tup_id'];
    $college_id = $_POST['college_id'];
    $course_id = $_POST['course_id'];

    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    $lowercase_tup_id = strtolower($tup_id);

    $validate_username_query = "SELECT * FROM students WHERE username='$username' AND deleted_at IS NULL";
    $validate_username_query_run = mysqli_query($conn, $validate_username_query);

    $validate_phone_query = "SELECT * FROM students WHERE phone='$phone' AND deleted_at IS NULL";
    $validate_phone_query_run = mysqli_query($conn, $validate_phone_query);

    $validate_query = "SELECT * FROM students WHERE LOWER(tup_id)='$lowercase_tup_id' AND deleted_at IS NULL";
    $validate_query_run = mysqli_query($conn, $validate_query);

    if(!preg_match('/^09\d{9}$/', $phone)) { 
        echo json_encode([
            'status' => 'error',
            'message' => 'Invalid Phone Number.'
            
        ]);
    } else if (mysqli_num_rows($validate_username_query_run) > 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Username is already taken. Please enter a different username.'
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

        $targetDir = "../student/profiles/";

        if (!is_dir($targetDir)) {
            mkdir($targetDir, 0777, true);
        }

        $fileName = $_FILES['upload_file']['name'];
        $tmpName  = $_FILES['upload_file']['tmp_name'];
        $fileSize = $_FILES['upload_file']['size'];
        $error    = $_FILES['upload_file']['error'];

        $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

        $allowed = ['jpg', 'jpeg', 'png'];

        if (!in_array($fileExt, $allowed)) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Invalid file type.'
            ]);
            exit;
        }

        if ($fileSize > 2 * 1024 * 1024) { // 2MB limit
            echo json_encode([
                'status' => 'error',
                'message' => 'File too large.'
            ]);
            exit;
        }   

        if ($error !== 0) {
            echo json_encode([
                'status' => 'error',
                'message' => 'Upload error.'
            ]);
            exit;
        }

        $newFileName = time() . "_" . uniqid() . "." . $fileExt;

        $targetFile = $targetDir . $newFileName;

        if (move_uploaded_file($tmpName, $targetFile)) {

            $insert_query = "INSERT INTO students
            SET username = '$username',
                password = '$hashed_password',
                image = '$newFileName',
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
    }
?>