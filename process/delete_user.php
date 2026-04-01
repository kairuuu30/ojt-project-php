<?php 
session_start();
include("../server/connection.php");

    $id = $_POST["id"];
    // $name = $_POST["name"];

    $delete_query = "UPDATE students 
            SET  deleted_at = '$date_time_today'
            WHERE id = $id";

    $delete_query_run = mysqli_query($conn, $delete_query);

    if($delete_query_run) {
        echo json_encode([
                'status' => 'success',
                'message' => 'Student is deleted successfully.'
            ]);
        } else {
            echo json_encode([
                'status' => 'error',
                'message' => 'Error.'
            ]);
        }     



?>