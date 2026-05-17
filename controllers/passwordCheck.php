<?php
session_start();
require_once('../models/userModel.php');
require_once('../utils/validation_helper.php');

if(isset($_POST['submit'])){
    $currentPassword = $_POST['current_password'] ?? '';
    $newPassword = $_POST['new_password'] ?? '';
    
    if(isempty($currentPassword) || isempty($newPassword)){
        $_SESSION['error'] = "Please fill all the fields";
        header('location: ../views/change_password.php');
        exit();
    }
    
    if(!validpassword($newPassword)){
        $_SESSION['error'] = "Password must be at least 8 characters long.";
        header('location: ../views/change_password.php');
        exit();
    }
    
    $user = getUserByEmail($_SESSION['email']);
    if(password_verify($currentPassword, $user['password_hash'])){
        $status = changePassword($_SESSION['email'], $newPassword);
        if($status){
            $_SESSION['success'] = "Password changed successfully.";
            header('location: ../views/view.php');
            exit();
        } else {
            $_SESSION['error'] = "Error changing password.";
            header('location: ../views/change_password.php');
            exit();
        }
    } else {
        $_SESSION['error'] = "Current password is incorrect.";
        header('location: ../views/change_password.php');
        exit();
    }
} else {
    header('location: ../views/change_password.php');
    exit();
}
?>