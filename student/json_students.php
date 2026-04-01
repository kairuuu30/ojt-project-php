<?php 
session_start();
include '../server/connection.php';
mysqli_set_charset($conn, "utf8mb4");

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
							
		FROM students AS stud 
		LEFT JOIN college AS col 
			ON stud.college_id = col.id
		LEFT JOIN courses AS cour
			ON stud.course_id = cour.id 
        WHERE stud.deleted_at IS NULL
		";

	$result = mysqli_query($conn,$sql);
	$json = array();
 
	while ($row = mysqli_fetch_assoc($result)) {
		$action = '<button class="btn btn-primary btn-sm edit_user" 
							data-user_id="'.$row['id'].'">
							Edit
						</button>
					<button class="btn btn-danger btn-sm delete_user" 
							data-user_id="'.$row['id'].'">
							Delete
						</button>';

			$json[] = array(
				"id"	   		=> $row['id'] ?? '', 
				"name"	   		=> $row['name'] ?? '',
				"bday"	   		=> !empty($row['bday']) ? date('M j, Y', strtotime($row['bday'])) : '',
				"phone"    		=> $row['phone'] ?? '',
				"tup_id"   		=> $row['tup_id'] ?? '',
				"college_name"  => $row['college_name'] ?? '',
				"course_name"   => $row['course_name'] ?? '',
				// "college_id"  	=> $row['college_id'] ?? '',
				// "course_id"   	=> $row['course_id'] ?? '',
				"created_at"	=> !empty($row['created_at']) ? date('M j, Y - h:i A', strtotime($row['created_at'])) : '',
				"updated_at"	=> !empty($row['updated_at']) ? date('M j, Y - h:i A', strtotime($row['updated_at'])) : '',
				"action"   		=> $action,
			);
	}
	echo json_encode($json, JSON_UNESCAPED_UNICODE);

?>