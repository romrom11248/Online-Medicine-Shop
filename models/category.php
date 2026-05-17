<?php
require_once(__DIR__ . '/../config/db.php');
function getallCategories(){
    $con = getConnection();
    $sql = "SELECT * FROM categories";
    $result = mysqli_query($con, $sql);
    return $result;
}

?>