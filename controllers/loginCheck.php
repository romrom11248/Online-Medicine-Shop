<?php

session_start();
require_once('../models/userModel.php');

if(isset($_POST['submit'])){

    $email    = trim($_POST['email'] ?? '');
    $password = $_POST['password'] ?? '';
    $remember = isset($_POST['remember']);

    if($email == "" || $password == ""){
        $_SESSION['error'] = "Please fill up the email and password";
        header('location: ../views/login.php');
        exit();
    }

    $user = getUserByEmail($email);

    if($user && password_verify($password, $user['password_hash'])){

        $_SESSION['user_id'] = $user['id'];
        $_SESSION['name']    = $user['name'];
        $_SESSION['role']    = $user['role'];
        $_SESSION['email']   = $user['email'];
        $_SESSION['status']  = true;

        if($remember){
            $token = bin2hex(random_bytes(16));
            setcookie('remember_token', $token, time() + (86400 * 30), "/");
            setcookie('remember_email', $user['email'], time() + (86400 * 30), "/");
        }

        // Role-based redirect
        if($user['role'] == 'admin'){
            header('location: ../views/dashboard.php');
        } else {
            header('location: ../views/home.php');
        }
        exit();

    } else {
        $_SESSION['error'] = "Invalid email or password";
        header('location: ../views/login.php');
        exit();
    }

} else {
    header('location: ../views/login.php');
    exit();
}
?>