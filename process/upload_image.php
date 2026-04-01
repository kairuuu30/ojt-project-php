<?php 
    if (isset($_FILES['image_release_preview'])) {
        $file = $_FILES['image_release_preview'];
        $targetDir = "/student/profiles/";
        $targetFile = $targetDir . basename($file['name']);

        if (move_uploaded_file($file['tmp_name'], $targetFile)) {
            echo json_encode([
            'success' => 'true',
            'filesPath' => $targetFile
            ]);
        } else {
            echo json_encode([
            'success' => 'false',
        ]);
        }
    }
?>