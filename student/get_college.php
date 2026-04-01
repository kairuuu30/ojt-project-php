<?php 
session_start();
include '../server/connection.php';
mysqli_set_charset($conn, "utf8mb4");



$id = $_GET['college_id'];

// Selecting of branch request and branch list based on the branch id 
$sql = "SELECT  col.id, 
                col.college, 
                col.college_code,
                col.is_active,
                col.created_at,
                col.updated_at
 	
		FROM college as col
        WHERE col.id = $id
		";

	$result = mysqli_query($conn,$sql);
	$row = mysqli_fetch_assoc($result);
  

    echo json_encode([
            "id"	        => $row['id'] ?? '', 
			"college"	   	=> $row['college'] ?? '',
            "college_code"	=> $row['college_code'] ?? '',
            "is_active"	    => $row['is_active'] ?? '',
        ], JSON_UNESCAPED_UNICODE);

	

?>