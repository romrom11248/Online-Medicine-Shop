<?php

    session_start();
    require_once('../models/AdminModel.php');

    if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
        header('location: ../views/login.php');
        exit;
    }

    function medicineInput(){
        return [
            'id' => (int)($_POST['id'] ?? 0),
            'name' => trim($_POST['name'] ?? ""),
            'category_id' => (int)($_POST['category_id'] ?? 0),
            'vendor_name' => trim($_POST['vendor_name'] ?? ""),
            'price' => (float)($_POST['price'] ?? 0),
            'availability' => (int)($_POST['availability'] ?? 0),
            'description' => trim($_POST['description'] ?? ""),
            'image_path' => ""
        ];
    }

    function validMedicine($medicine){
        if($medicine['name'] == ""){
            return "Medicine name is required";
        }

        if($medicine['category_id'] <= 0 || !getCategoryById($medicine['category_id'])){
            return "Valid category is required";
        }

        if($medicine['vendor_name'] == ""){
            return "Vendor name is required";
        }

        if($medicine['price'] <= 0){
            return "Price must be greater than zero";
        }

        if($medicine['availability'] < 0){
            return "Stock cannot be negative";
        }

        return "";
    }

    function uploadMedicineImage($required){
        if(!isset($_FILES['image']) || $_FILES['image']['error'] == UPLOAD_ERR_NO_FILE){
            return $required ? ['error' => 'Medicine image is required'] : ['path' => ''];
        }

        if($_FILES['image']['error'] != UPLOAD_ERR_OK){
            return ['error' => 'Image upload failed'];
        }

        if($_FILES['image']['size'] > 2 * 1024 * 1024){
            return ['error' => 'Image must be 2MB or less'];
        }

        $finfo = finfo_open(FILEINFO_MIME_TYPE);
        $mime = finfo_file($finfo, $_FILES['image']['tmp_name']);
        finfo_close($finfo);

        $allowed = [
            'image/jpeg' => 'jpg',
            'image/png' => 'png'
        ];

        if(!isset($allowed[$mime])){
            return ['error' => 'Only JPEG and PNG images are allowed'];
        }

        $folder = __DIR__ . '/../public/uploads/medicines/';

        if(!is_dir($folder)){
            mkdir($folder, 0777, true);
        }

        $fileName = 'medicine_' . time() . '_' . rand(1000, 9999) . '.' . $allowed[$mime];
        $target = $folder . $fileName;

        if(!move_uploaded_file($_FILES['image']['tmp_name'], $target)){
            return ['error' => 'Image save failed'];
        }

        return ['path' => 'public/uploads/medicines/' . $fileName];
    }

    if($_SERVER['REQUEST_METHOD'] == 'POST'){
        $action = $_POST['action'] ?? "";

        if(!isset($_SESSION['csrf_token']) || !isset($_POST['csrf_token']) || $_SESSION['csrf_token'] != $_POST['csrf_token']){
            $_SESSION['error'] = "Invalid request token";
            header('location: ../views/medicines.php');
            exit;
        }

        if($action == "add"){
            $medicine = medicineInput();
            $error = validMedicine($medicine);
            $upload = uploadMedicineImage(true);

            if(isset($upload['error'])){
                $error = $upload['error'];
            }else{
                $medicine['image_path'] = $upload['path'];
            }

            if($error != ""){
                $_SESSION['error'] = $error;
            }else if(addMedicine($medicine)){
                $_SESSION['success'] = "Medicine added successfully";
            }else{
                $_SESSION['error'] = "Medicine add failed";
            }

            header('location: ../views/medicines.php');
            exit;
        }

        if($action == "update"){
            $medicine = medicineInput();
            $error = validMedicine($medicine);

            if($medicine['id'] <= 0 || !getMedicineById($medicine['id'])){
                $error = "Medicine id is invalid";
            }

            $upload = uploadMedicineImage(false);

            if(isset($upload['error'])){
                $error = $upload['error'];
            }else{
                $medicine['image_path'] = $upload['path'];
            }

            if($error != ""){
                $_SESSION['error'] = $error;
            }else if(updateMedicine($medicine)){
                $_SESSION['success'] = "Medicine updated successfully";
            }else{
                $_SESSION['error'] = "Medicine update failed";
            }

            header('location: ../views/medicines.php');
            exit;
        }

        if($action == "delete"){
            $id = (int)($_POST['id'] ?? 0);
            $status = deleteMedicine($id);

            if($status === true){
                $_SESSION['success'] = "Medicine deleted successfully";
            }else{
                $_SESSION['error'] = $status;
            }

            header('location: ../views/medicines.php');
            exit;
        }
    }

    header('location: ../views/medicines.php');

?>
