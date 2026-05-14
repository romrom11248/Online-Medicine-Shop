<?php
require_once('../config/db.php');

function getCartItem($userId, $medicineId){
    global $con;

    $sql = " SELECT * FROM cart
   WHERE user_id = '$userId'
    AND medicine_id = '$medicineId'
    ";
    $result = mysqli_query($con, $sql);

    $row=[];

    while($r = mysqli_fetch_assoc($result)){
        array_push($row, $r);
}
return $row[0];

}

function insertCartItem($userId, $medicineId, $quantity){
    global $con;

    $sql = "INSERT INTO cart 
    VALUES('','$userId', '$medicineId', '$quantity')";
    
    return mysqli_query($con, $sql);
}

function updateCartQuantity($cartId, $newQuantity){
    global $con;
    $sql = "UPDATE cart 
    SET quantity= '$newQuantity'
    WHERE id= '$cartId'
    ";

return mysqli_query($con, $sql);

}

function getCartCount($userId){

    global $con;

    $sql = "SELECT SUM(quantity) AS total
            FROM cart
            WHERE user_id = '$userId'";

    $result = mysqli_query($con, $sql);

    $row = mysqli_fetch_assoc($result);

    return $row['total'];
}
?>