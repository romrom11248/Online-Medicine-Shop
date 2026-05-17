<?php

session_start();

$_SESSION['user_id'] = 2;
$_SESSION['role'] = 'customer';

require_once('../../models/cartModel.php');

$items = getCartItems(
    $_SESSION['user_id']
);

$total = getGrandTotal(
    $_SESSION['user_id']
);

?>

<!DOCTYPE html>

<html>

<head>

<title>Checkout</title>

<style>
body{
    font-family: Arial;
    background:#f5f5f5;
    padding:20px;
}

.container{
    background:white;
    width:500px;
    padding:20px;
    border-radius:6px;
    border:1px solid #ddd;
}

button{
    background:#27ae60;
    color:white;
    border:none;
    padding:10px 16px;
    border-radius:4px;
    cursor:pointer;
}

textarea{
    width:100%;
    height:80px;
}
</style>

</head>

<body>

<div class="container">

<h1>Checkout</h1>

<hr>

<?php

foreach($items as $item){

?>

<p>
<?php echo $item['name']; ?>
-
<?php echo $item['quantity']; ?> x
<?php echo $item['price']; ?>
=
<?php echo $item['quantity'] * $item['price']; ?>
</p>

<?php
}
?>

<hr>

<h3>
Grand Total:
<?php echo $total; ?>
</h3>

<hr>

<label>
Address:
</label>

<br><br>

<textarea id="address"></textarea>

<br><br>

<label>
Payment Method:
</label>

<br><br>

<input
type="radio"
name="payment"
value="bKash"
>
bKash

<br>

<input
type="radio"
name="payment"
value="Nagad"
>
Nagad

<br>

<input
type="radio"
name="payment"
value="COD"
>
Cash On Delivery

<br><br>

<button onclick="confirmOrder()">
Confirm Purchase
</button>

<br><br>

<div id="msg"></div>
<div id="confirm"></div>

</div>

<script src="../../public/js/cart.js"></script>

</body>

</html>