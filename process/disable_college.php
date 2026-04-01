<?php 
session_start();
include("../server/connection.php");

    $college_id = $_POST["college_id"];

    $disable_query = "UPDATE college 
            SET is_active = 0,
                updated_at = '$date_time_today'
            WHERE id = $college_id";
    $disable_query_run = mysqli_query($conn, $disable_query);

    if($disable_query_run) {

        $disable_courses_query = "UPDATE courses
                                    SET is_active = 0
                                    WHERE college_id = '$college_id'";

        $disable_courses_query_run = mysqli_query($conn, $disable_courses_query);

        if ($disable_courses_query_run) {
            echo json_encode([
                'status' => 'success',
                'message' => 'College and its courses are disabled successfully.'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'College is disabled but failed to disable courses.'
            ]);
        }
    } else {
        echo json_encode([
            'status' => 'error',
            'message' => 'Failed to disable College.'
        ]);
    }     
?>