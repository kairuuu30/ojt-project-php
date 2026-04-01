<?php 

session_start();
include("../server/connection.php");

$college_id = $_POST['college_id'];
$college = $_POST['college'];
$college_code = $_POST['college_code'];

$lowercase_college = strtolower($college);
$lowercase_college_code = strtolower($college_code);

$current_query = "SELECT * FROM college WHERE id = $college_id";
$current_run = mysqli_query($conn, $current_query);
$current_data = mysqli_fetch_assoc($current_run);

    if ($current_data['college'] == $college && $current_data['college_code'] == $college_code) {
        echo json_encode([
            'status' => 'success',
            'message' => 'No changes were made.'
            ]);
    } else {
        $validate_edit_query = "SELECT * FROM college WHERE (LOWER(college) = '$lowercase_college' OR LOWER(college_code) = '$lowercase_college_code') AND id != '$college_id'";
        $validate_edit_query_run = mysqli_query($conn, $validate_edit_query); 

        if (mysqli_num_rows($validate_edit_query_run) > 0) { 
            echo json_encode([
                'status' => 'error',
                'message' => 'College Name or College Code already exist.'
            ]);
        } else {
            $edit_query = "UPDATE college 

            SET college = '$college', 
                college_code = '$college_code',     
                updated_at = '$date_time_today'
            WHERE id = '$college_id'
            ";

            $edit_query_run = mysqli_query($conn, $edit_query);

            if($edit_query_run) {
                echo json_encode([
                    'status' => 'success',
                    'message' => 'College is edited successfully.'
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