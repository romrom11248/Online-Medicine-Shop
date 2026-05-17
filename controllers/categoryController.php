<?php

    session_start();
    require_once('../models/AdminModel.php');

    if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
        header('location: ../views/login.php');
        exit;
    }

    function cleanCategoryInput(){
        return [
            'id' => (int)($_POST['id'] ?? 0),
            'name' => trim($_POST['name'] ?? ""),
            'category_type' => trim($_POST['category_type'] ?? "")
        ];
    }

    function validCategory($category){
        if($category['name'] == ""){
            return "Category name is required";
        }

        if(!in_array($category['category_type'], ['liquid', 'solid'])){
            return "Category type is invalid";
        }

        return "";
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $action = $_POST['action'] ?? "";

        if(!isset($_SESSION['csrf_token']) || !isset($_POST['csrf_token']) || $_SESSION['csrf_token'] != $_POST['csrf_token']){
            $_SESSION['error'] = "Invalid request token";
            header('location: ../views/categories.php');
            exit;
        }

        if($action == "add"){
            $category = cleanCategoryInput();
            $error = validCategory($category);

            if($error != ""){
                $_SESSION['error'] = $error;
            }else if(addCategory($category)){
                $_SESSION['success'] = "Category added successfully";
            }else{
                $_SESSION['error'] = "Category add failed";
            }

            header('location: ../views/categories.php');
            exit;
        }

        if($action == "update"){
            $category = cleanCategoryInput();
            $error = validCategory($category);

            if($category['id'] <= 0){
                $error = "Category id is invalid";
            }

            if($error != ""){
                $_SESSION['error'] = $error;
            }else if(updateCategory($category)){
                $_SESSION['success'] = "Category updated successfully";
            }else{
                $_SESSION['error'] = "Category update failed";
            }

            header('location: ../views/categories.php');
            exit;
        }

        if($action == "delete"){
            $id = (int)($_POST['id'] ?? 0);
            $status = deleteCategory($id);

            if($status === true){
                $_SESSION['success'] = "Category deleted successfully";
            }else{
                $_SESSION['error'] = $status;
            }

            header('location: ../views/categories.php');
            exit;
        }
    }

    header('location: ../views/categories.php');

?>
