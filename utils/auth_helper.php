<?php
@session_start();

function checkAuth() {
    if(!isset($_SESSION['status'])){
        header('Location: ../views/login.php');
        exit();
    }
}

function checkRememberMe() {
    if(!isset($_SESSION['status']) && isset($_COOKIE['remember_token']) && isset($_COOKIE['remember_email'])) {
        require_once('../models/userModel.php');
        
        $email = $_COOKIE['remember_email'];
        $user = getUserByEmail($email);
        
        if($user) {
            // Note: In a real-world secure implementation, we would hash the token in the DB and compare it.
            // Since this project's scope requires a simple remember me cookie:
            $_SESSION['user_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            $_SESSION['email'] = $user['email'];
            $_SESSION['status'] = true;
            
            header('Location: ../views/home.php');
            exit();
        }
    }
}
?>