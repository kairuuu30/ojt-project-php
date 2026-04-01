<?php 

session_start();
include("../server/connection.php");

$course_id = $_POST['course_id'];
$course = $_POST['course'];
$course_code = $_POST['course_code'];
$college_id = $_POST['college_id'];

$lowercase_course = strtolower($course);
$lowercase_course_code = strtolower($course_code);

$current_query = "SELECT * FROM courses WHERE id = $course_id";
$current_run = mysqli_query($conn, $current_query);
$current_data = mysqli_fetch_assoc($current_run);

$validate_edit_query = "SELECT * FROM courses WHERE id != '$course_id' AND college_id = '$college_id' AND (LOWER(course) = '$lowercase_course' OR LOWER(course_code) = '$lowercase_course_code')";
$validate_edit_query_run = mysqli_query($conn, $validate_edit_query); 

    if ($current_data['course'] == $course && $current_data['course_code'] == $course_code && $current_data['college_id'] == $college_id) {
        echo json_encode([
            'status' => 'success',
            'message' => 'No changes were made.'
            ]);
    } else if(mysqli_num_rows($validate_edit_query_run) > 0) { 
        echo json_encode([
            'status' => 'error',
            'message' => 'Course Name or Course Code already exist.'
            ]);
    } else {

        $edit_query = "UPDATE courses 
        SET course = '$course', 
            course_code = '$course_code',   
            college_id = '$college_id',  
            updated_at = '$date_time_today'
        WHERE id = '$course_id'
        ";

        $edit_query_run = mysqli_query($conn, $edit_query);

        if($edit_query_run) {
            echo json_encode([
                'status' => 'success',
                'message' => 'Course is edited successfully.'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Failed to edit course.'
            ]);
        }
    }

   
// }        
?>