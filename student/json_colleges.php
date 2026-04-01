<?php 
session_start();
include '../server/connection.php';
mysqli_set_charset($conn, "utf8mb4");


// Selecting of branch request and branch list based on the branch id 
$sql = "SELECT  col.id,
                col.college,
                col.college_code,
				col.is_active,
                col.created_at,
                col.updated_at,
				CASE 
					WHEN is_active = 1 THEN 'Active'
					WHEN is_active = 0 THEN 'Inactive'
					ELSE 'Inactive'
				END AS status
		FROM college AS col
		-- WHERE col.deleted_at IS NULL
		";

	$result = mysqli_query($conn, $sql);
	$json = array();

	while ($row = mysqli_fetch_assoc($result)) {

		if($row['is_active'] == 1) {
			$statusBtn = '<button class="btn btn-danger btn-sm disable_college" 
							data-college_id="'.$row['id'].'">
							Disable
						</button>';
		} else {
			$statusBtn = '<button class="btn btn-success btn-sm enable_college" 
							data-college_id="'.$row['id'].'">
							Enable
						</button>';
		}
		
		$action = '<button class="btn btn-primary btn-sm edit_college" 
							data-college_id="'.$row['id'].'">
							Edit
					</button>
					'.$statusBtn;

			$json[] = array(
				"id"			=> $row['id'] ?? '', 
				"college"  		=> $row['college'] ?? '', 
				"college_code"  => $row['college_code'] ?? '',
				"status"  		=> $row['status'] ?? '',
				"created_at"	=> !empty($row['created_at']) ? date('M j, Y - h:i A', strtotime($row['created_at'])) : '',
				"updated_at"	=> !empty($row['updated_at']) ? date('M j, Y - h:i A', strtotime($row['updated_at'])) : '',
				"action"   		=> $action,
			);
	}
	echo json_encode($json, JSON_UNESCAPED_UNICODE);

?>