

<?php
require_once(__DIR__ . '/../models/cartModel.php');
require_once(__DIR__ . '/../models/medicineModel.php');
$total=0;
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

function increase(){
    global $total;
    
    if(!isset($_SESSION['user_id'])){

        echo json_encode([
            'status' => false,
            'message' => 'Login required'
           
        ]);

        exit();
    }

    $cart = $_REQUEST['increase'] ?? '';

    $data = json_decode($cart, true);



    if(!$data){

        echo json_encode([
            'status' => false,
            'message' => 'Invalid data'
        ]);

        exit();
    }
    $cartID = (int)$data['cart_id'];
    $price = (float)$data['med_price'];

    $cartItem = getCartByID($cartID);

    $increased=$cartItem['quantity']+1;

    $subtotal=$increased*$price;
    $total+= $subtotal;


    $status = updateCartQuantity(
        $cartItem['id'],
        $increased
    );


if($status){
    echo json_encode([
        'status'=> true,
        'subtotal'=> $subtotal,
        'total'=>$total
        
    ]);

    exit();
}

}

function decrease(){
    global $total;

    if(!isset($_SESSION['user_id'])){

        echo json_encode([
            'status' => false,
            'message' => 'Login required'
        ]);

        exit();
    }

    $cart = $_REQUEST['decrease'] ?? '';

    $data = json_decode($cart, true);



    if(!$data){

        echo json_encode([
            'status' => false,
            'message' => 'Invalid data'
        ]);

        exit();
    }
    $cartID = (int)$data['cart_id'];
    $price = (float)$data['med_price'];

    $cartItem = getCartByID($cartID);

    $increased=$cartItem['quantity']-1;

    $subtotal=$increased*$price;
    $total+= $subtotal;


    $status = updateCartQuantity(
        $cartItem['id'],
        $increased
    );


if($status){
    echo json_encode([
        'status'=> true, 
    'subtotal'=> $subtotal,
        'total'=>$total]);

    exit();
}

}

function remove(){
global $total;
    if(!isset($_SESSION['user_id'])){

        echo json_encode([
            'status' => false,
            'message' => 'Login required'
        ]);

        exit();
    }

    $cart = $_REQUEST['remove'] ?? '';

    $data = json_decode($cart, true);

    $price = (float)$data['med_price'];

    $cartID = (int)$data['cart_id'];

    

    $cartItem = getCartByID($cartID);



    $cartQuantity = $cartItem['quantity'];
    
    $subtotal= $cartQuantity* $price;
    $total-=$subtotal;

   $status= deleteCartItem($cartID);
   if($status){
    echo json_encode([
        'status'=> true,
        'total'=>$total,
    'message' => 'Deleted Successfully']);

    }



}
?>