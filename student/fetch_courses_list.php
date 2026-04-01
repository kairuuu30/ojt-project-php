<?php 
session_start();
include '../server/connection.php';
mysqli_set_charset($conn, "utf8mb4");

$id = $_GET['course_id'];

$sql = "SELECT  cour.id,
                cour.course,
                cour.course_code,
                cour.college_id,
                cour.is_active,
                cour.created_at,
                cour.updated_at
 	
		FROM courses as cour
        WHERE cour.id = $id
		";

	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);
  

    echo json_encode([
            "id"	        => $row['id'] ?? '', 
			"course"	   	=> $row['course'] ?? '',
            "course_code"	=> $row['course_code'] ?? '',
            "college_id"	=> $row['college_id'] ?? '',
            "is_active"	    => $row['is_active'] ?? '',
        ], JSON_UNESCAPED_UNICODE);

	

?>