<?php
session_start();
require_once('../models/userModel.php');
require_once('validationHelper.php');

if(isset($_POST['submit'])){
    $name = $_POST['name'] ?? '';
    $address = $_POST['address'] ?? '';
    $phone = $_POST['phone'] ?? '';

    if(isempty($name) || isempty($address) || isempty($phone)){
        $_SESSION['error'] = "Please fill all the fields";
        header('location: ../views/edit.php');
        exit();
    }
    
    $user = [
        'name' => $name,
        'email' => $_SESSION['email'],
        'address' => $address,
        'phone' => $phone
    ];
    
    $status = updateProfile($user);
    if($status){
      
        $_SESSION['name'] = $name;
        $_SESSION['success'] = "Profile updated successfully.";
        header('location: ../views/view.php');
        exit();
    } else {
        $_SESSION['error'] = "Error updating profile.";
        header('location: ../views/edit.php');
        exit();
    }
} else {
     header('location: ../views/edit.php');
     exit();
}
?>