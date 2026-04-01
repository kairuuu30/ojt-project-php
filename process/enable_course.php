<?php 
session_start();
include("../server/connection.php");

    $course_id = $_POST["course_id"];
    $college_id = $_POST["college_id"];

    $validate_college_status = "SELECT is_active FROM college WHERE id = '$college_id'";
    $validate_college_status_run = mysqli_query($conn, $validate_college_status);

    if ($validate_college_status_run && mysqli_num_rows($validate_college_status_run) > 0) {

        $college = mysqli_fetch_assoc($validate_college_status_run);

        if ($college['is_active'] == 1) {
            
            $enable_query = "UPDATE courses
            SET is_active = 1,
                updated_at = '$date_time_today'
            WHERE id = $course_id";

            $enable_query_run = mysqli_query($conn, $enable_query);

            if ($enable_query_run) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'Course is enabled successfully.'
                ]);
            } else {
                echo json_encode([
                    'status' => 'error',
                    'message' => 'Failed to enable course.'
                ]);
            }
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Cannot enable course because college is inactive.'
            ]);
        }
    } else {
        echo json_encode([
                'status' => 'error',
                'message' => 'College not found.'
            ]);
    }
?>