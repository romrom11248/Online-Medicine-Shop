<?php

session_start();

if(isset($_SESSION['status'])){
    if($_SESSION['role'] == 'admin'){
        header('location: views/dashboard.php');
    } else {
        header('location: views/home.php');
    }
    exit();
}

// Not logged in — go to login
header('location: views/login.php');
exit();