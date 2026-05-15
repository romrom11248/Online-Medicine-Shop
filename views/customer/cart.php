<?php

session_start();
//lets assume
$_SESSION['user_id'] = 2;
$_SESSION['role'] = 'customer';

require_once('../../config/db.php');

require_once('../../model/cartModel.php');

$items = getCartItems($_SESSION['user_id']);

?>

<!DOCTYPE html>

<html>

<head>

    <title>Cart</title>

</head>

<body>

    <h1>Cart Items</h1>

    <h3>
        Total Cost:
        <span id="total">0</span>
    </h3>

    <?php

    foreach ($items as $item) {

        ?>

        <div style="border:1px solid black; padding:10px; margin:10px; width:300px; ">

            <h3>
                <?php echo $item['medicines.name']; ?>
            </h3>

            <p>
                Price:
                <?php echo $item['medicines.price']; ?>
            </p>

            <p>
                Quantity:
                <?php echo $item['cart.quantity']; ?>
            </p>

            <h3>
                Subtotal:
                <span id="subtotal_<?php echo $item['cart.id']; ?>">0</span>
            </h3>

            <button onclick="increase(<?php echo $item['cart.id'].','.$item['medicine.price']; ?>)">
           +
           <br>
           <button onclick="decrease(<?php echo $item['cart.id'].','.$item['medicine.price']; ?>)">
           -
        

            <br><br>

            <button onclick="remove(<?php echo $item['cart.id'].','.$item['medicine.price']; ?>)">
                Add To Cart
            </button>

        </div>

        <?php

    }

    ?>

    <p id="msg"></p>

    <script src="../../public/js/cart.js"></script>

</body>

</html>