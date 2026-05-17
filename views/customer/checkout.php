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

</head>

<body>

    <h1>Checkout Page</h1>

    <h2>Medicine list</h2>
    <hr>

    <?php

    foreach ($items as $item) {

        ?>

        <label><?php echo $item['name']; ?> </label>
        <label><?php echo $item['quantity']; ?> x </label>
        <label><?php echo $item['price']; ?> =</label>
        <label><?php echo $item['price'] * $item['quantity']; ?></label>

    <?php } ?>
    <hr>

    <label for="">Grand Total: <?php echo $total; ?> </label>

    <hr>
    <hr>

    <label for="">Address: </label>

    <textarea id="address"></textarea>
    <br>
    <br>


    <label for="">Payment method: </label>
    <input type="radio" name="payment" id="" value="bkash">bKash
    <input type="radio" name="payment" id="" value="Nagad">Nagad
    <input type="radio" name="payment" id="" value="COD">COD
    <br>
    <span id="msg"></span>

    <hr>

    <button onclick="confirmOrder()">
        Confirm Purchase
    </button>
<div id="confirm"></div>
    <script src="../../public/js/cart.js"></script>



</body>

</html>