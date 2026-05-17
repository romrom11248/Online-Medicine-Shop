<?php
require_once('../config/db.php');

function getCategories() {
    $con = getConnection();
    $sql = "SELECT * FROM categories ORDER BY name ASC";
    $result = mysqli_query($con, $sql);
    $categories = [];
    while($row = mysqli_fetch_assoc($result)) {
        $categories[] = $row;
    }
    return $categories;
}

function searchMedicines($query, $vendor, $genre) {
    $con = getConnection();
    
    $sql = "SELECT m.*, c.name as category_name FROM medicines m LEFT JOIN categories c ON m.category_id = c.id WHERE 1=1";
    $types = "";
    $params = [];
    
    if(!empty($query)) {
        $sql .= " AND m.name LIKE ?";
        $types .= "s";
        $params[] = "%" . $query . "%";
    }
    
    if(!empty($vendor)) {
        $sql .= " AND m.vendor_name LIKE ?";
        $types .= "s";
        $params[] = "%" . $vendor . "%";
    }
    
    if(!empty($genre)) {
        $sql .= " AND c.name = ?";
        $types .= "s";
        $params[] = $genre;
    }
    
    $stmt = mysqli_prepare($con, $sql);
    if (!empty($params)) {
        mysqli_stmt_bind_param($stmt, $types, ...$params);
    }
    
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    $medicines = [];
    while($row = mysqli_fetch_assoc($result)) {
        $medicines[] = $row;
    }
    return $medicines;
}
?>
