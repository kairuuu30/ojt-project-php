<?php 
include '../server/connection.php';

$college_id = $_GET['college_id'];

if (isset($college_id)) {

    $sql = "SELECT * FROM courses WHERE college_id='$college_id'";

    $course_query = mysqli_query($conn, $sql);
  
    $courses = [];

    while ($row = mysqli_fetch_assoc($course_query)) {
        $courses[] = $row;
    }
    echo json_encode($courses, JSON_UNESCAPED_UNICODE);
}
?>