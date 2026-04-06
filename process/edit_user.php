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
$old_image =$_POST["old_image"];

$lowercase_tup_id = strtolower($tup_id);

$current_query = "SELECT * FROM students WHERE id = $id";
$current_run = mysqli_query($conn, $current_query);
$current_data = mysqli_fetch_assoc($current_run);

$validate_query = "SELECT * FROM students WHERE id != '$id' AND LOWER(tup_id)='$lowercase_tup_id' AND deleted_at IS NULL";
$validate_query_run = mysqli_query($conn, $validate_query);

if ($current_data['name'] == $name &&
    $current_data['bday'] == $bday &&
    $current_data['phone'] == $phone &&
    $current_data['tup_id'] == $tup_id &&
    $current_data['college_id'] == $college_id &&
    $current_data['course_id'] == $course_id &&
    empty($_FILES['upload_file']['name'])) {

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

        $update_fields = "name = '$name', 
                bday = '$bday', 
                phone = '$phone', 
                tup_id = '$tup_id', 
                college_id = '$college_id', 
                course_id = '$course_id', 
                updated_at = '$date_time_today'";

        if (!empty($_FILES['upload_file']['name'])) {
                $targetDir = '../student/profiles/';
                if (!is_dir($targetDir)) {
                        mkdir($targetDir, 0777, true);
                }

                $fileName = $_FILES['upload_file']['name'];
                $tmpName  = $_FILES['upload_file']['tmp_name'];
                $fileSize = $_FILES['upload_file']['size'];
                $error    = $_FILES['upload_file']['error'];

                $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));

                $allowed = ['jpg', 'jpeg', 'png'];

                if (!in_array($fileExt, $allowed)) {
                echo json_encode([
                        'status' => 'error',
                        'message' => 'Invalid file type.'
                ]);
                exit;
                }

                if ($fileSize > 2 * 1024 * 1024) { // 2MB limit
                echo json_encode([
                        'status' => 'error',
                        'message' => 'File too large.'
                ]);
                exit;
                }   

                if ($error !== 0) {
                echo json_encode([
                        'status' => 'error',
                        'message' => 'Upload error.'
                ]);
                exit;
                }

                $newFileName = time() . "_" . uniqid() . "." . $fileExt;

                $targetFile = $targetDir . $newFileName;

                if (move_uploaded_file($tmpName, $targetFile)) {
                        if(!empty($old_image) && file_exists($targetDir.$old_image)) {
                                unlink($targetDir.$old_image);
                        }

                        $update_fields .= ", image = '$newFileName'";
                }
        }

        $edit_query = "UPDATE students SET $update_fields WHERE id = $id";

        $edit_query_run = mysqli_query($conn, $edit_query);

        if($edit_query_run) {
                if (!empty($newFileName)) {
                        $_SESSION['user_image'] = $newFileName;
                }
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