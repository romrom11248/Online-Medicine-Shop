<?php
session_start();
require_once('../models/userModel.php');

if(isset($_FILES['profile_picture'])){
    $file = $_FILES['profile_picture'];
    $filename = $file['name'];
    $tmpname = $file['tmp_name'];
    $filesize = $file['size'];
    $error = $file['error'];
    
    if($error !== UPLOAD_ERR_OK) {
        $_SESSION['error'] = "Error during file upload.";
        header('location: ../views/view.php');
        exit();
    }

    $extension = strtolower(pathinfo($filename, PATHINFO_EXTENSION));
    $allowed = ['jpg','jpeg','png']; 

    if(!in_array($extension, $allowed)){
        $_SESSION['error'] = "File type not allowed. Please upload JPG or PNG.";
        header('location: ../views/view.php');
        exit();
    }
    
    if($filesize > 2000000){
        $_SESSION['error'] = "File size must be less than 2MB";
        header('location: ../views/view.php');
        exit();
    }
    
    $newfilename = time() . '_' . uniqid() . '.' . $extension;
    $destination = '../public/uploads/' . $newfilename;
    
    // Ensure directory exists, though we created it already via bash, just in case
    if(!is_dir('../public/uploads/')) {
        mkdir('../public/uploads/', 0777, true);
    }
    
    if(move_uploaded_file($tmpname, $destination)){
        $status = updateProfilePicture($_SESSION['email'], $newfilename);
        if($status){
            $_SESSION['success'] = "Profile picture updated.";
            header('location: ../views/view.php');
            exit();
        } else {
            $_SESSION['error'] = "Error updating database with new image.";
            header('location: ../views/view.php');
            exit();
        }
    } else {
        $_SESSION['error'] = "Failed to move uploaded file.";
        header('location: ../views/view.php');
        exit();
    }
} else {
    header('location: ../views/view.php');
    exit();
}
?>