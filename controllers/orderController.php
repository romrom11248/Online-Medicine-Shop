<?php

    session_start();
    require_once('../models/AdminModel.php');

    header('Content-Type: application/json');

    if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
        echo json_encode(['success' => false, 'message' => 'Unauthorized request']);
        exit;
    }

    if($_SERVER['REQUEST_METHOD'] != 'POST'){
        echo json_encode(['success' => false, 'message' => 'Invalid method']);
        exit;
    }

    if(!isset($_SESSION['csrf_token']) || !isset($_POST['csrf_token']) || $_SESSION['csrf_token'] != $_POST['csrf_token']){
        echo json_encode(['success' => false, 'message' => 'Invalid request token']);
        exit;
    }

    $orderId = (int)($_POST['order_id'] ?? 0);
    $status = trim($_POST['status'] ?? "");

    if($orderId <= 0 || !in_array($status, ['accepted', 'rejected'])){
        echo json_encode(['success' => false, 'message' => 'Invalid order data']);
        exit;
    }

    if(updateOrderStatus($orderId, $status)){
        echo json_encode(['success' => true, 'message' => 'Order status updated', 'status' => $status]);
    }else{
        echo json_encode(['success' => false, 'message' => 'Order update failed']);
    }

?>
