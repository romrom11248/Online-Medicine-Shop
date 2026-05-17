<?php

require_once(__DIR__ . '/../config/db.php');

function createPayment(
    $orderId,
    $amount,
    $method,
    $trxId
) {

    global $con;

    $sql = "INSERT INTO payments(
            order_id,
            amount,
            payment_method,
            transaction_id
            )
            VALUES(?, ?, ?, ?)";

    $stmt = mysqli_prepare($con, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "idss",
        $orderId,
        $amount,
        $method,
        $trxId
    );

    return mysqli_stmt_execute($stmt);
}

?>