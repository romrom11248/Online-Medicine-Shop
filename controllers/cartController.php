<?php

require_once(__DIR__ . '/../models/cartModel.php');
require_once(__DIR__ . '/../models/medicineModel.php');

function addToCart(){

    if(!isset($_SESSION['user_id'])){

        echo json_encode([
            'status' => false,
            'message' => 'Login required'
        ]);

        exit();
    }


    $cart = $_REQUEST['cart'] ?? '';

    $data = json_decode($cart, true);


    if(!$data){

        echo json_encode([
            'status' => false,
            'message' => 'Invalid data'
        ]);

        exit();
    }


    $medicineId = (int)$data['med_id'];

    $quantity = (int)$data['quantity'];


    $medicine = getMedicineById($medicineId);


    if(empty($medicine)){

        echo json_encode([
            'status' => false,
            'message' => 'Medicine not found'
        ]);

        exit();
    }


    $cartItem = getCartItem(
        $_SESSION['user_id'],
        $medicineId
    );


    if(!empty($cartItem)){

        $newQuantity =
            $cartItem['quantity'] + $quantity;


        if($newQuantity > $medicine['availability']){

            echo json_encode([
                'status' => false,
                'message' => 'Insufficient stock'
            ]);

            exit();
        }


        $status = updateCartQuantity(
            $cartItem['id'],
            $newQuantity
        );

    }else{

        if($quantity > $medicine['availability']){

            echo json_encode([
                'status' => false,
                'message' => 'Insufficient stock'
            ]);

            exit();
        }


        $status = insertCartItem(
            $_SESSION['user_id'],
            $medicineId,
            $quantity
        );
    }


    if($status){

        $total = getCartCount(
            $_SESSION['user_id']
        );


        echo json_encode([
            'status' => true,
            'message' => 'Successfully added',
            'cartCount' => $total
        ]);

        exit();
    }
}


function updateCart(){

    $cart = $_REQUEST['cart'] ?? '';

    $data = json_decode($cart, true);


    $cartId = (int)$data['cart_id'];

    $action = $data['action'];


    $cartItem = getCartByID($cartId);

    $medicine = getMedicineById(
        $cartItem['medicine_id']
    );


    if($action == 'increase'){

        $newQuantity =
            $cartItem['quantity'] + 1;


        if($newQuantity > $medicine['availability']){

            echo json_encode([
                'status' => false,
                'message' => 'Insufficient stock'
            ]);

            exit();
        }

    }else{

        $newQuantity =
            $cartItem['quantity'] - 1;


        if($newQuantity < 1){

            echo json_encode([
                'status' => false,
                'message' => 'Minimum quantity is 1'
            ]);

            exit();
        }
    }


    $status = updateCartQuantity(
        $cartId,
        $newQuantity
    );


    if($status){

        $subtotal =
            $medicine['price'] *
            $newQuantity;


        $grandTotal = getGrandTotal(
            $_SESSION['user_id']
        );


        echo json_encode([
            'status' => true,
            'message' => 'Updated successfully',
            'quantity' => $newQuantity,
            'subtotal' => $subtotal,
            'grandTotal' => $grandTotal
        ]);

        exit();
    }
}


function removeCart(){

    $cart = $_REQUEST['cart'] ?? '';

    $data = json_decode($cart, true);


    $cartId = (int)$data['cart_id'];


    $status = deleteCartItem($cartId);


    if($status){

        $grandTotal = getGrandTotal(
            $_SESSION['user_id']
        );


        echo json_encode([
            'status' => true,
            'message' => 'Removed successfully',
            'grandTotal' => $grandTotal
        ]);

        exit();
    }
}


if(isset($_GET['action'])){

    session_start();

    header('Content-Type: application/json');


    if($_GET['action'] == 'add'){

        addToCart();
    }

    else if($_GET['action'] == 'update'){

        updateCart();
    }

    else if($_GET['action'] == 'remove'){

        removeCart();
    }
}
?>