<?php

session_start();

if(!isset($_SESSION['user_id']) || $_SESSION['role'] != 'customer'){
    header('location: ../../views/login.php');
    exit();
}

require_once('../../models/cartModel.php');

$items = getCartItems($_SESSION['user_id']);
$total = getGrandTotal($_SESSION['user_id']);

?>

<!DOCTYPE html>
<html>
<head>

<title>Cart</title>

<style>
body{
    font-family: Arial;
    background:#f4f4f4;
    padding:20px;
}

.box{
    background:white;
    border:1px solid #ddd;
    padding:15px;
    margin:20px auto;
    border-radius:6px;
    width:320px;
}

button{
    padding:6px 12px;
    border:none;
    background:#2d89ef;
    color:white;
    border-radius:4px;
    cursor:pointer;
}

a{
    text-decoration:none;
    background:#27ae60;
    color:white;
  
    padding:10px 15px;
    border-radius:4px;
}

.idk{
    text-align:center;
}
</style>

</head>
<body>
<div class="idk">
<h1>Cart Items</h1>

<p><a href="medicines.php" style="background:#2d89ef;">← Continue Shopping</a></p>

<h2>
    Grand Total:
    <span id="total"><?php echo $total; ?></span>
</h2>
</div>
<?php if(empty($items)){ ?>
    <p>Your cart is empty.</p>
<?php } ?>

<?php foreach($items as $item){
    $subtotal = $item['price'] * $item['quantity'];
?>

<div class="box" id="cartRow_<?php echo $item['id']; ?>">

    <h3><?php echo htmlspecialchars($item['name']); ?></h3>

    <p>Vendor: <?php echo htmlspecialchars($item['vendor_name']); ?></p>
    <p>Price: <?php echo htmlspecialchars($item['price']); ?></p>

    <p>
        Quantity:

        <button onclick="updateQuantity(<?php echo $item['id']; ?>, 'decrease')">-</button>

        <span id="qty_<?php echo $item['id']; ?>">
            <?php echo $item['quantity']; ?>
        </span>

        <button onclick="updateQuantity(<?php echo $item['id']; ?>, 'increase')">+</button>
    </p>

    <p>
        Subtotal:
        <span id="subtotal_<?php echo $item['id']; ?>">
            <?php echo $subtotal; ?>
        </span>
    </p>

    <button onclick="removeCartItem(<?php echo $item['id']; ?>)">
        Remove
    </button>

</div>



<?php } ?>

<div class="idk">

<p id="msg"></p>

<br>

<?php if(!empty($items)){ ?>
    <a href="checkout.php">Proceed To Checkout</a>
<?php } ?>
</div>
<script src="../../public/js/cart.js"></script>

</body>
</html>