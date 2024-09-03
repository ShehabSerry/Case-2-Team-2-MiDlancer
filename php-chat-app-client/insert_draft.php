<?php
// Check if a file is uploaded
if (isset($_FILES['file']) && $_FILES['file']['error'] === UPLOAD_ERR_OK) {
    
    // Directory where the file will be saved
    $uploadDir = 'uploads/';

    // Get the file name and its path
    $fileName = basename($_FILES['file']['name']);
    $uploadFilePath = $uploadDir . $fileName;

    // Check if the uploads directory exists, create it if not
    if (!is_dir($uploadDir)) {
        mkdir($uploadDir, 0755, true);
    }

    // Move the uploaded file to the server directory
    if (move_uploaded_file($_FILES['file']['tmp_name'], $uploadFilePath)) {
        echo 'File uploaded successfully!';
    } else {
        echo 'Failed to move uploaded file.';
    }
} else {
    echo 'No file uploaded or there was an upload error!';
}
?>
