<?php
if (isset($_POST['upload'])) {
    $targetDir = "upload/adminPfp/"; // Folder where images are stored
    $fileName = basename($_FILES["profile_image"]["name"]); // Get file name
    $targetFilePath = $targetDir . $fileName; // Full path

    // Check if file is an image
    $fileType = strtolower(pathinfo($targetFilePath, PATHINFO_EXTENSION));
    $allowedTypes = array("jpg", "jpeg", "png");

    if (in_array($fileType, $allowedTypes)) {
        // Upload file
        if (move_uploaded_file($_FILES["profile_image"]["tmp_name"], $targetFilePath)) {
            echo "File uploaded successfully: " . $targetFilePath;
            // Store `$targetFilePath` in the database for the admin profile
        } else {
            echo "Error uploading file.";
        }
    } else {
        echo "Invalid file format. Only JPG, JPEG, PNG allowed.";
    }
}
?>
