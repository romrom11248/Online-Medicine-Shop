<?php

require_once(__DIR__ . '/../config/db.php');

function createOrder(
    $userId,
    $total,
    $address,
    $status,
    $method
){

    global $con;

    $sql = "INSERT INTO orders(
            user_id,
            total_amount,
            shipping_address,
            status,
            payment_method
            )
            VALUES(?, ?, ?, ?, ?)";

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

    $result = mysqli_stmt_execute($stmt);

    if($result){

        return mysqli_insert_id($con);
    }

    return false;
}



function createOrderItem(
    $orderId,
    $medicineId,
    $quantity,
    $price
){

    global $con;

    $sql = "INSERT INTO order_items(
            order_id,
            medicine_id,
            quantity,
            unit_price
            )
            VALUES(?, ?, ?, ?)";

    $stmt = mysqli_prepare($con, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "iiid",
        $orderId,
        $medicineId,
        $quantity,
        $price
    );

    return mysqli_stmt_execute($stmt);
}

?>