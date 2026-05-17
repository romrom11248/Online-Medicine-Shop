<?php
    session_start();

<<<<<<< HEAD
    // If they aren't logged in at all, go to login
    if(!isset($_SESSION['status'])) {
        header('location: views/login.php');
        exit();
    }

    // If they are logged in, route them by role
    if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'){
        header('location: views/dashboard.php');
        exit();
    } else {
        header('location: views/home.php'); // Customers go to the medicine browsing page
        exit();
=======
    if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'){
        header('location: views/dashboard.php');
    }else{
        header('location: views/login.php');
>>>>>>> origin/feature/task2-2355531-3
    }
?>
