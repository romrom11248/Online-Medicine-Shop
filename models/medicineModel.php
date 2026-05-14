<?php
require_once('../config/db.php');

function getMedicineById($id){
    global $con;

    $sql = " SELECT * FROM medicines
    WHERE id= '$id'
    ";
    $result = mysqli_query($con, $sql);

    $row=[];

    while($r = mysqli_fetch_assoc($result)){
        array_push($row, $r);
}
return $row[0];

}

?>