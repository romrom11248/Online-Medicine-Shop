<?php
require_once(__DIR__ . '/../config/db.php');

function createOrder($userId, $total, $address, $status, $method)
{

    global $con;
    $sql = "INSERT INTO orders(user_id,total_amount, shipping_address,status,payment_method)
    VALUES(?, ?, ?,?,?)";

    $stmt = mysqli_prepare($con, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "idsss",
        $userId,
        $total,
        $address,
        $status,
        $method
    );
    $orderId = mysqli_insert_id($con);

    $result= mysqli_stmt_execute($stmt);
    
    return $orderId;
}


function createOrderItem($a,$b,$c,$d){
    global $con;
    $sql = "INSERT INTO order_items(order_id,medicine_id,quantity,unit_price)
    VALUES(?, ?,?,?)";

    $stmt = mysqli_prepare($con, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "iiid",
        $a,
        $b,
        $c,
        $d

    );
    return mysqli_stmt_execute($stmt);

}







?>