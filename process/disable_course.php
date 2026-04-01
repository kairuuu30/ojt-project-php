<?php 
session_start();
include("../server/connection.php");

    $course_id = $_POST["course_id"];

    $enable_query = "UPDATE courses
            SET is_active = 0,
                updated_at = '$date_time_today'
            WHERE id = $course_id";

    $enable_query_run = mysqli_query($conn, $enable_query);

    if($enable_query_run) {
        echo json_encode([
                'status' => 'success',
                'message' => 'Course is disabled successfully.'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Error.'
            ]);
        }     
?>