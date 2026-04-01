<?php 
session_start();
include '../server/connection.php';

    $course = $_POST['course'];
    $course_code = $_POST['course_code'];
    $college = $_POST['college'];
    
    $validate_query = "SELECT * FROM courses WHERE (course='$course' OR course_code='$course_code')";

    $validate_query_run = mysqli_query($conn, $validate_query);

    if(mysqli_num_rows($validate_query_run) > 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'Course Name or Course Code already exists.'
        ]);
    } else {
        $insert_query = "INSERT INTO courses
        SET course = '$course', 
            course_code = '$course_code',
            college_id = '$college',
            created_at = '$date_time_today'
            ";

        $insert_query_run = mysqli_query($conn, $insert_query);

        if($insert_query_run) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Course is created successfully.'
            ]);
        } else {
                echo json_encode([
                'status' => 'error',
                'message' => 'Error.'
            ]);
        }

    }
?>