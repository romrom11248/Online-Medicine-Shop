<?php

session_start();
header('Content-Type: application/json');


require_once(__DIR__ . '/../models/AdminModel.php');

// Task 3 models
require_once(__DIR__ . '/../models/cartModel.php');
require_once(__DIR__ . '/../models/orderModel.php');
require_once(__DIR__ . '/../models/paymentModel.php');
require_once(__DIR__ . '/../models/medicineModel.php');

//Task 3: Customer places an order

function placeOrder(){

    if(!isset($_SESSION['user_id'])){
        echo json_encode(['status' => false, 'message' => 'Login required']);
        exit();
    }

    $check = $_REQUEST['check'] ?? '';
    $data = json_decode($check, true);

    if(!$data){
        echo json_encode(['status' => false, 'message' => 'Invalid data']);
        exit();
    }

    if(empty($data['address']) || empty($data['payment'])){
        echo json_encode(['status' => false, 'message' => 'Address and payment required']);
        exit();
    }

    $items = getCartItems($_SESSION['user_id']);

    if(empty($items)){
        echo json_encode(['status' => false, 'message' => 'Cart is empty']);
        exit();
    }

    foreach($items as $item){
        if($item['quantity'] > $item['availability']){
            echo json_encode(['status' => false, 'message' => 'Stock unavailable for: ' . $item['name']]);
            exit();
        }
    }

    $total = getGrandTotal($_SESSION['user_id']);

    $orderId = createOrder(
        $_SESSION['user_id'],
        $total,
        $data['address'],
        'pending',
        $data['payment']
    );

    if(!$orderId){
        echo json_encode(['status' => false, 'message' => 'Order failed']);
        exit();
    }

    foreach($items as $item){
        createOrderItem($orderId, $item['medicine_id'], $item['quantity'], $item['price']);
        updateMedicineStock($item['quantity'], $item['medicine_id']);
    }

    createPayment($orderId, $total, $data['payment'], NULL);
    clearCart($_SESSION['user_id']);

    echo json_encode(['status' => true, 'message' => 'Order placed successfully']);
    exit();
}

//  Task 2: Admin updates order status 

function handleUpdateOrderStatus(){

    if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
        echo json_encode(['success' => false, 'message' => 'Unauthorized request']);
        exit();
    }

    if(!isset($_SESSION['csrf_token']) ||
       !isset($_POST['csrf_token']) ||
       $_SESSION['csrf_token'] != $_POST['csrf_token']){
        echo json_encode(['success' => false, 'message' => 'Invalid request token']);
        exit();
    }

    $orderId = (int)($_POST['order_id'] ?? 0);
    $status  = trim($_POST['status'] ?? "");

    if($orderId <= 0 || !in_array($status, ['accepted', 'rejected'])){
        echo json_encode(['success' => false, 'message' => 'Invalid order data']);
        exit();
    }

    if(updateOrderStatus($orderId, $status)){
        echo json_encode(['success' => true, 'message' => 'Order status updated', 'status' => $status]);
    } else {
        echo json_encode(['success' => false, 'message' => 'Order update failed']);
    }
    exit();
}


if(isset($_GET['action']) && $_GET['action'] == 'confirm'){
    placeOrder();
} elseif($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['order_id'])){
    handleUpdateOrderStatus();
}

?>