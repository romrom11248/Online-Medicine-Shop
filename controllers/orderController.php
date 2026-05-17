<?php

require_once(__DIR__ . '/../models/cartModel.php');
require_once(__DIR__ . '/../models/orderModel.php');
require_once(__DIR__ . '/../models/paymentModel.php');
require_once(__DIR__ . '/../models/medicineModel.php');

function placeOrder(){

    if(!isset($_SESSION['user_id'])){

        echo json_encode([
            'status' => false,
            'message' => 'Login required'
        ]);

        exit();
    }


    $check = $_REQUEST['check'] ?? '';

    $data = json_decode($check, true);


    if(!$data){

        echo json_encode([
            'status' => false,
            'message' => 'Invalid data'
        ]);

        exit();
    }


    if(empty($data['address']) ||
       empty($data['payment'])){

        echo json_encode([
            'status' => false,
            'message' => 'Address and payment required'
        ]);

        exit();
    }


    $items = getCartItems(
        $_SESSION['user_id']
    );


    if(empty($items)){

        echo json_encode([
            'status' => false,
            'message' => 'Cart is empty'
        ]);

        exit();
    }


    foreach($items as $item){

        if($item['quantity'] >
           $item['availability']){

            echo json_encode([
                'status' => false,
                'message' => 'Stock unavailable'
            ]);

            exit();
        }
    }


    $total = getGrandTotal(
        $_SESSION['user_id']
    );


    $orderId = createOrder(
        $_SESSION['user_id'],
        $total,
        $data['address'],
        'pending',
        $data['payment']
    );


    if(!$orderId){

        echo json_encode([
            'status' => false,
            'message' => 'Order failed'
        ]);

        exit();
    }


    foreach($items as $item){

        createOrderItem(
            $orderId,
            $item['medicine_id'],
            $item['quantity'],
            $item['price']
        );


        updateMedicineStock(
            $item['quantity'],
            $item['medicine_id']
        );
    }


    createPayment(
        $orderId,
        $total,
        $data['payment'],
        NULL
    );


    clearCart($_SESSION['user_id']);


    echo json_encode([
        'status' => true,
        'message' => 'Order placed successfully'
    ]);

    exit();
}


if(isset($_GET['action'])){

    session_start();

    header('Content-Type: application/json');


    if($_GET['action'] == 'confirm'){

        placeOrder();
    }
}
?>