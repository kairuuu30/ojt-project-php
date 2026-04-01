<?php 
session_start();
include("../server/connection.php");

    $college_id = $_POST["college_id"];

    $enable_query = "UPDATE college 
            SET is_active = 1,
                updated_at = '$date_time_today'
            WHERE id = $college_id";

    $enable_query_run = mysqli_query($conn, $enable_query);

    if($enable_query_run) {

        $enable_courses_query = "UPDATE courses
                                    SET is_active = 1
                                    WHERE college_id = '$college_id'";

        $enable_courses_query_run = mysqli_query($conn, $enable_courses_query);

        if ($enable_courses_query_run) {
            echo json_encode([
                'status' => 'success',
                'message' => 'College and its courses are enabled successfully.'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'College is enabled but failed to enable courses.'
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to enable College.'
        ]);
    }     
?>