

<?php
require_once(__DIR__ . '/../config/db.php');

function getMedicineById($id){

    global $con;

    $sql = "SELECT * FROM medicines WHERE id = ?";

    $stmt = mysqli_prepare($con, $sql);

    mysqli_stmt_bind_param($stmt, "i", $id);

    mysqli_stmt_execute($stmt);

    $result = mysqli_stmt_get_result($stmt);

    $row = mysqli_fetch_assoc($result);

    return $row ? $row : null;
}


function updateMedicineStock($a,$b){
    global $con;

    $sql = "UPDATE medicines
            SET availabilty = availabilty- ?
            WHERE id = ?";

    $stmt = mysqli_prepare($con, $sql);

    mysqli_stmt_bind_param(
        $stmt,
        "ii",
        $a,
        $b
    );

    return mysqli_stmt_execute($stmt);
}
?>

