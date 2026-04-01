<?php 
session_start();
include '../server/connection.php';
mysqli_set_charset($conn, "utf8mb4");


$id = $_GET['student_id'];

// Selecting of branch request and branch list based on the branch id 
$sql = "SELECT  stud.id AS id,
                stud.name AS name,
                stud.bday AS bday,
                stud.phone,
                stud.tup_id,
                stud.college_id,
                stud.course_id,
                col.college AS college_name,
				cour.course AS course_name,
				stud.created_at,
				stud.updated_at
							
		FROM students as stud 
        LEFT JOIN college AS col 
			ON stud.college_id = col.id
		LEFT JOIN courses AS cour
			ON stud.course_id = cour.id
        WHERE stud.id = $id
		";

	$result = mysqli_query($conn,$sql);
	$row = mysqli_fetch_assoc($result);
  

    echo json_encode([
            "id"	   	    => $row['id'] ?? '', 
			"name"	   	    => $row['name'] ?? '',
			"bday"	   	    => !empty($row['bday']) ? date('Y-m-d', strtotime($row['bday'])) : '',  
			"phone"    	    => $row['phone'] ?? '',
            "tup_id"   	    => $row['tup_id'] ?? '',
            "college_id"  	=> $row['college_id'] ?? '',
            "course_id"   	=> $row['course_id'] ?? '',
            "college_name"  => $row['college_name'] ?? '',
            "course_name"   => $row['course_name'] ?? '',
        ], JSON_UNESCAPED_UNICODE);

	

?>