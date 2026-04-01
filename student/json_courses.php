<?php 
session_start();
include '../server/connection.php';
mysqli_set_charset($conn, "utf8mb4");


// Selecting of branch request and branch list based on the branch id 
$sql = "SELECT  cour.id,
                cour.course,
                cour.course_code,
				cour.is_active,
				cour.college_id,
				col.college_code AS college_code,
                cour.created_at,
                cour.updated_at,
				CASE 
					WHEN cour.is_active = 1 THEN 'Active'
					WHEN cour.is_active = 0 THEN 'Inactive'
					ELSE 'Inactive'
				END AS status
		FROM courses as cour
		LEFT JOIN college AS col 
			ON cour.college_id = col.id
		";

	$result = mysqli_query($conn, $sql);
	$json = array();

	while ($row = mysqli_fetch_assoc($result)) {
		
		if($row['is_active'] == 1) {
			$statusBtn = '<button class="btn btn-danger btn-sm disable_course" 
							data-course_id="'.$row['id'].'">
							Disable
						</button>';
		} else {
			$statusBtn = '<button class="btn btn-success btn-sm enable_course" 
							data-course_id="'.$row['id'].'">
							Enable
						</button>';
		}
		
		$action = '<button class="btn btn-primary btn-sm edit_course" 
							data-course_id="'.$row['id'].'">
							Edit
					</button>
					'.$statusBtn;

			$json[] = array(
				"id"			=> $row['id'] ?? '', 
				"course"  		=> $row['course'] ?? '',
                "course_code"  	=> $row['course_code'] ?? '',
				"college_code"  => $row['college_code'] ?? '',
				"college_id"    => $row['college_id'] ?? '',
				"status"  		=> $row['status'] ?? '',
				"created_at"	=> !empty($row['created_at']) ? date('M j, Y - h:i A', strtotime($row['created_at'])) : '',
				"updated_at"	=> !empty($row['updated_at']) ? date('M j, Y - h:i A', strtotime($row['updated_at'])) : '',
				"action"   		=> $action,
			);
	}
	echo json_encode($json, JSON_UNESCAPED_UNICODE);

?>