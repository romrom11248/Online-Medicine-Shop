

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



    if(
        !is_numeric($data['med_id']) ||
        !is_numeric($data['quantity']) ||
        $data['quantity'] <= 0
    ){

        echo json_encode([
            'status' => false,
            'message' => 'Invalid input'
        ]);

        exit();
    }



    $medicineId = (int)$data['med_id'];

    $quantity = (int)$data['quantity'];



    $medicine = getMedicineById($medicineId);



    if(empty($medicine)){

        echo json_encode([
            'status' => false,
            'message' => 'Medicine does not exist'
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

    }else{

        echo json_encode([
            'status' => false,
            'message' => 'Database error'
        ]);

        exit();
    }
}

function updateCart(){

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



    $cartId = (int)$data['cart_id'];

    $action = $data['action'];



    $cartItem = getCartByID($cartId);



    if(empty($cartItem)){

        echo json_encode([
            'status' => false,
            'message' => 'Cart item not found'
        ]);

        exit();
    }



    $medicine = getMedicineById(
        $cartItem['medicine_id']
    );



    if($action == 'increase'){

        $newQuantity =
            $cartItem['quantity'] + 1;



        if($newQuantity >
           $medicine['availability']){

            echo json_encode([
                'status' => false,
                'message' => 'Insufficient stock'
            ]);

            exit();
        }

    }else if($action == 'decrease'){

        $newQuantity =
            $cartItem['quantity'] - 1;



        if($newQuantity < 1){

            echo json_encode([
                'status' => false,
                'message' => 'Minimum quantity is 1'
            ]);

            exit();
        }

    }else{

        echo json_encode([
            'status' => false,
            'message' => 'Invalid action'
        ]);

        exit();
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

            'quantity' => $newQuantity,

            'subtotal' => $subtotal,

            'grandTotal' => $grandTotal
        ]);

        exit();

    }else{

        echo json_encode([
            'status' => false,
            'message' => 'Database error'
        ]);

        exit();
    }
}




function removeCart(){

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

    }else{

        echo json_encode([
            'status' => false,
            'message' => 'Database error'
        ]);

        exit();
    }

}
?>