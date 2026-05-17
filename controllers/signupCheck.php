<?php
session_start();
require_once('../models/userModel.php');

if(isset($_POST['submit'])){
    $name = trim($_POST['name'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $address = trim($_POST['address'] ?? '');
    $phone = trim($_POST['phone'] ?? '');
    $role = $_POST['role'] ?? '';

   
    if($name == "" || $email == "" || $password == "" || $address == "" || $phone == "" || $role == ""){
        $_SESSION['error'] = "Please fill all the fields";
        header('location: ../views/register.php');
        exit();
    }

    if(strlen($password) < 8){
        $_SESSION['error'] = "Password must be at least 8 characters long";
        header('location: ../views/register.php');
        exit();
    }

   
    $existingUser = getUserByEmail($email);
    if($existingUser) {
        $_SESSION['error'] = "Email is already registered";
        header('location: ../views/register.php');
        exit();
    }

    $hashedPassword = password_hash($password, PASSWORD_DEFAULT);
    $user = [
        'name' => $name,
        'email' => $email,
        'password' => $hashedPassword,
        'role' => $role,
        'address' => $address,
        'phone' => $phone
    ];

    $status = addUser($user);
    if($status){
        $_SESSION['success'] = "Registration successful. Please login.";
        header('location: ../views/login.php');
    } else {
        $_SESSION['error'] = "Registration failed due to server error.";
        header('location: ../views/register.php');
    }
} else {
    header('location: ../views/register.php');
}
?>