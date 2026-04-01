<?php 

session_start();
include("../server/connection.php");

$id = $_POST["id"];
$name = $_POST["name"];
$bday = $_POST["bday"];
$phone = $_POST["phone"];
$tup_id = $_POST["tup_id"];
$college_id = $_POST["college_id"];
$course_id = $_POST["course_id"];

$lowercase_tup_id = strtolower($tup_id);

$current_query = "SELECT * FROM students WHERE id = $id";
$current_run = mysqli_query($conn, $current_query);
$current_data = mysqli_fetch_assoc($current_run);

$validate_query = "SELECT * FROM students WHERE LOWER(tup_id)='$lowercase_tup_id' AND deleted_at IS NULL";
$validate_query_run = mysqli_query($conn, $validate_query);

if ($current_data['name'] == $name &&
    $current_data['bday'] == $bday &&
    $current_data['phone'] == $phone &&
    $current_data['tup_id'] == $tup_id &&
    $current_data['college_id'] == $college_id &&
    $current_data['course_id'] == $course_id) {

    echo json_encode([
        'status' => 'success',
        'message' => 'No changes were made.'
    ]);
} else if (mysqli_num_rows($validate_query_run) > 0) {
        echo json_encode([
                'status' => 'error',
                'message' => 'TUP ID is already in use.'
                ]);
} else {
        $edit_query = "UPDATE students 

        SET name = '$name', 
                bday = '$bday', 
                phone = '$phone', 
                tup_id = '$tup_id', 
                college_id = '$college_id', 
                course_id = '$course_id', 
                updated_at = '$date_time_today'
        WHERE id = $id";

        $edit_query_run = mysqli_query($conn, $edit_query);

        if($edit_query_run) {
        echo json_encode([
                'status' => 'success',
                'message' => 'Student is edited successfully.'
                ]);
        } else {
                echo json_encode([
                'status' => 'error',
                'message' => 'Error.'
                ]);
        }
}
?>