<?php
    session_start();

    if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'){
        header('location: views/dashboard.php');
    }else{
        header('location: views/login.php');
    }
?>
