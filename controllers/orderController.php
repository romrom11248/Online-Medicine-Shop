<?php
require_once(__DIR__ . '/../models/cartModel.php');
require_once(__DIR__ . '/../models/medicineModel.php');


function placeOrder()
{
    if (!isset($_SESSION['user_id'])) {

        echo json_encode([
            'status' => false,
            'message' => 'Login required'
        ]);

        exit();
    }

    $check= $_REQUEST['check'];
    $data= json_decode($check,true);

    
    if(!$data){

        echo json_encode([
            'status' => false,
            'message' => 'Invalid data'
        ]);

        exit();
    }

    /* cart.id,
    cart.quantity,

    medicines.id AS medicine_id,
    medicines.name,
    medicines.price,
    medicines.vendor_name,
    medicines.image_path,
    medicines.availability

    FROM cart

    INNER JOIN medicines
    ON cart.medicine_id = medicines.id

    WHERE cart.user_id = ?";*/


    $items=getCartItems($_SESSION['user_id']);

    $meds=getMedicineById($items['medicine_id']);

    $total=getGrandTotal($_SESSION['user_id']);

    //function createOrder($userId, $total, $address, $status, $method)

    $order_id= createOrder($_SESSION['user_id'],$total,$data['address'],"pending",$data['payment']);

    if(!$order_id){

        echo json_encode([
            'status' => false,
            'message' => 'Order creation failed'
        ]);

        exit();
    }
    
    $status1=createOrderItem($order_id,$items['medicine_id'],$items['quantity'],$items['price'] );

    if(!$status1){
        echo json_encode([
            'status' => false,
            'message' => 'Order items failed'
        ]);

        exit();
    }


    $status2=createPayment($order_id,$total,$data['payment'],NULL);

    if(!$status2){
        echo json_encode([
            'status' => false,
            'message' => 'Payment failed'
        ]);

        exit();
    }


}



?>