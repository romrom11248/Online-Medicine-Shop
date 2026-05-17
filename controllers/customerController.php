<?php

    session_start();
    require_once('../models/AdminModel.php');

    if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
        header('location: ../views/login.php');
        exit;
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        if(!isset($_SESSION['csrf_token']) || !isset($_POST['csrf_token']) || $_SESSION['csrf_token'] != $_POST['csrf_token']){
            $_SESSION['error'] = "Invalid request token";
            header('location: ../views/customers.php');
            exit;
        }

        $id = (int)($_POST['id'] ?? 0);

        if($id <= 0){
            $_SESSION['error'] = "Customer id is invalid";
        }else if(deleteCustomer($id)){
            $_SESSION['success'] = "Customer deleted successfully";
        }else{
            $_SESSION['error'] = "Customer delete failed";
        }
    }

    header('location: ../views/customers.php');

?>
