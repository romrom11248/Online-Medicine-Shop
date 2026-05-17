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

    <title>Cart</title>

</head>

<body>

    <h1>Cart Items</h1>

    <h2>
        Total:
        <span id="total">
            <?php echo $total; ?>
        </span>
    </h2>

    <?php

    foreach ($items as $item) {

        $subtotal =
            $item['price'] *
            $item['quantity'];

        ?>

        <div id="cartRow_<?php echo $item['id']; ?>" style="
border:1px solid black;
padding:10px;
margin:10px;
width:300px;
">

            <h3>
                <?php echo $item['name']; ?>
            </h3>

            <p>
                Vendor:
                <?php echo $item['vendor_name']; ?>
            </p>

            <p>
                Price:
                <?php echo $item['price']; ?>
            </p>

            <p>

                Quantity:

                <button onclick="
        updateQuantity(
        <?php echo $item['id']; ?>,
        'decrease'
        )">
                    -
                </button>

                <span id="qty_<?php echo $item['id']; ?>">
                    <?php echo $item['quantity']; ?>
                </span>

                <button onclick="
        updateQuantity(
        <?php echo $item['id']; ?>,
        'increase'
        )">
                    +
                </button>

            </p>

            <p>

                Subtotal:

                <span id="subtotal_<?php echo $item['id']; ?>">
                    <?php echo $subtotal; ?>
                </span>

            </p>

            <button onclick="
    removeCartItem(
    <?php echo $item['id']; ?>
    )">
                Remove
            </button>

        </div>

        <?php

    }

    ?>

    <p id="msg"></p>


    <a href="checkout.php">
        Checkout
    </a>


    <script src="../../public/js/cart.js"></script>

</body>

</html>