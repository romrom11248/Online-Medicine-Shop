<?php
    session_start();
    require_once('../models/UserModel.php');

    if(isset($_POST['submit'])){
        $email = trim($_POST['email']);
        $password = $_POST['password'];

        if($email == "" || $password == ""){
            $_SESSION['error'] = "Email and password are required";
            header('location: ../views/login.php');
        }else{
            $user = loginUser($email, $password);

            if($user && $user['role'] == 'admin'){
                $_SESSION['user_id'] = $user['id'];
                $_SESSION['name'] = $user['name'];
                $_SESSION['role'] = $user['role'];
                header('location: ../views/dashboard.php');
            }else{
                $_SESSION['error'] = "Invalid admin login";
                header('location: ../views/login.php');
            }
        }
    }else{
        header('location: ../views/login.php');
    }
?>
