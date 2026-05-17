<?php
require_once(__DIR__ . '/../config/db.php');

function createPayment($a,$b,$c,$d){
    global $con;
    $sql = "INSERT INTO payments(order_id,amount,payment_method,transaction_id)
    VALUES(?, ?,?,?)";

    $stmt = mysqli_prepare($con, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "idss",
        $a,
        $b,
        $c,
        $d

    );
    return mysqli_stmt_execute($stmt);

}

?>