<?php
require_once '../models/medicineModel.php';

header('Content-Type: application/json');

$query = $_GET['q'] ?? '';
$vendor = $_GET['vendor'] ?? '';
$genre = $_GET['genre'] ?? '';


$medicines = searchMedicines($query, $vendor, $genre);

echo json_encode($medicines);
?>
