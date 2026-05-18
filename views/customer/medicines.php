<?php

session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'customer'){
    header('location: ../../views/login.php');
    exit();
}

require_once(__DIR__ . '/../../config/db.php');
require_once(__DIR__ . '/../../models/medicineModel.php');

$medicines = searchMedicines('', '', '');

?>

<!DOCTYPE html>
<html>
<head>

<title>Medicines</title>

<style>
body{
    font-family: Arial;
    background:#f5f5f5;
    padding:20px;
}

.card{
    background:white;
    border:1px solid #ddd;
    width:300px;
    padding:15px;
    margin:15px;
    border-radius:6px;
    display:inline-block;
    vertical-align:top;
}

button{
    background:#2d89ef;
    color:white;
    border:none;
    padding:8px 14px;
    border-radius:4px;
    cursor:pointer;
}

input[type="number"]{
    padding:5px;
    width:60px;
}

a{
    text-decoration:none;
    color:#2d89ef;
}
</style>

</head>
<body>



<h1>Medicine List</h1>

<p>Welcome, <?php echo htmlspecialchars($_SESSION['name']); ?> | <a href="../../controllers/logout.php">Logout</a></p>

<h3>
    <a href="cart.php">
        Cart (<span id="cartCount">0</span>)
    </a>
</h3>

<?php foreach($medicines as $medicine){ ?>

    <div class="card">

<?php if(!empty($medicine['image_path']) && file_exists('../../' . $medicine['image_path'])){ ?>
    <img
        src="../../<?php echo htmlspecialchars($medicine['image_path']); ?>"
        style="width:100%; height:150px; object-fit:cover; border-radius:4px;"
        alt="<?php echo htmlspecialchars($medicine['name']); ?>"
    >
<?php } else { ?>
    <img
        src="https://placehold.co/300x150?text=No+Image"
        style="width:100%; height:150px; object-fit:cover; border-radius:4px;"
        alt="No Image"
    >
<?php } ?>

    <h3><?php echo htmlspecialchars($medicine['name']); ?></h3>

    <p>Vendor: <?php echo htmlspecialchars($medicine['vendor_name']); ?></p>
    <p>Price: <?php echo htmlspecialchars($medicine['price']); ?></p>
    <p>Available: <?php echo htmlspecialchars($medicine['availability']); ?></p>

    <?php if($medicine['availability'] > 0){ ?>

        <input
            type="number"
            id="qty_<?php echo $medicine['id']; ?>"
            value="1"
            min="1"
            max="<?php echo $medicine['availability']; ?>"
        >

        <br><br>

        <button onclick="addToCart(<?php echo $medicine['id']; ?>)">
            Add To Cart
        </button>

    <?php } else { ?>
        <p style="color:red;">Out of Stock</p>
    <?php } ?>

</div>

<?php } ?>

<p id="msg"></p>

<script src="../../public/js/cart.js"></script>

</body>
</html>