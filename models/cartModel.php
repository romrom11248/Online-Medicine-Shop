<?php

require_once(__DIR__ . '/../config/db.php');

function getCartItem($userId, $medicineId){
    $con = getConnection();
    $sql = "SELECT * FROM cart WHERE user_id = ? AND medicine_id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $userId, $medicineId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row ? $row : null;
}

function getCartByID($cartId){
    $con = getConnection();
    $sql = "SELECT * FROM cart WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $cartId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row ? $row : null;
}

function insertCartItem($userId, $medicineId, $quantity){
    $con = getConnection();
    $sql = "INSERT INTO cart(user_id, medicine_id, quantity) VALUES(?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "iii", $userId, $medicineId, $quantity);
    return mysqli_stmt_execute($stmt);
}

function updateCartQuantity($cartId, $newQuantity){
    $con = getConnection();
    $sql = "UPDATE cart SET quantity = ? WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ii", $newQuantity, $cartId);
    return mysqli_stmt_execute($stmt);
}

function deleteCartItem($cartId){
    $con = getConnection();
    $sql = "DELETE FROM cart WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $cartId);
    return mysqli_stmt_execute($stmt);
}

function clearCart($userId){
    $con = getConnection();
    $sql = "DELETE FROM cart WHERE user_id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    return mysqli_stmt_execute($stmt);
}

function getCartCount($userId){
    $con = getConnection();
    $sql = "SELECT SUM(quantity) AS total FROM cart WHERE user_id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row['total'] ?? 0;
}

function getGrandTotal($userId){
    $con = getConnection();
    $sql = "SELECT SUM(cart.quantity * medicines.price) AS grandTotal
            FROM cart
            INNER JOIN medicines ON cart.medicine_id = medicines.id
            WHERE cart.user_id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $row = mysqli_fetch_assoc($result);
    return $row['grandTotal'] ?? 0;
}

function getCartItems($userId){
    $con = getConnection();
    $sql = "SELECT
            cart.id,
            cart.quantity,
            medicines.id AS medicine_id,
            medicines.name,
            medicines.price,
            medicines.vendor_name,
            medicines.image_path,
            medicines.availability
            FROM cart
            INNER JOIN medicines ON cart.medicine_id = medicines.id
            WHERE cart.user_id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "i", $userId);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    $items = [];
    while($row = mysqli_fetch_assoc($result)){
        array_push($items, $row);
    }
    return $items;
}