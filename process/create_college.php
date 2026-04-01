<?php 
session_start();
include '../server/connection.php';

    $college = $_POST['college'];
    $college_code = $_POST['college_code'];

    $lowercase_college = strtolower($college);
    $lowercase_college_code = strtolower($college_code);

    $validate_query = "SELECT * FROM college WHERE (LOWER(college)='$lowercase_college' OR LOWER(college_code)='$lowercase_college_code')";

    $validate_query_run = mysqli_query($conn, $validate_query);

    if(mysqli_num_rows($validate_query_run) > 0) {
        echo json_encode([
            'status' => 'error',
            'message' => 'College Name or College Code already exist.'
        ]);
    } else {
        $insert_query = "INSERT INTO college
        SET college = '$college', 
            college_code = '$college_code',
            is_active = 1,     
            created_at = '$date_time_today'
            ";

        $insert_query_run = mysqli_query($conn, $insert_query);

        if($insert_query_run) {
            echo json_encode([
                'status' => 'success',
                'message' => 'College is created successfully.'
            ]);
        } else {
                echo json_encode([
                'status' => 'error',
                'message' => 'Error.'
            ]);
        }

    }
?>