<?php

session_start();
//lets assume
$_SESSION['user_id'] = 2;
$_SESSION['role'] = 'customer';

require_once('../../config/db.php');

$sql = "SELECT * FROM medicines";

$result = mysqli_query($con, $sql);

?>

<!DOCTYPE html>

<html>

<head>

    <title>Medicines</title>

</head>

<body>

    <h1>Medicine List</h1>

    <h3>
        Cart Count:
        <span id="cartCount">0</span>
    </h3>

    <?php

    while ($medicine = mysqli_fetch_assoc($result)) {

        ?>

        <div style="border:1px solid black; padding:10px; margin:10px; width:300px; ">

            <h3>
                <?php echo $medicine['name']; ?>
            </h3>

            <p>
                Vendor:
                <?php echo $medicine['vendor_name']; ?>
            </p>

            <p>
                Price:
                <?php echo $medicine['price']; ?>
            </p>

            <p>
                Available:
                <?php echo $medicine['availability']; ?>
            </p>

            <input type="number" id="qty_<?php echo $medicine['id']; ?>" value="1" min="1">

            <br><br>

            <button onclick="addToCart(<?php echo $medicine['id']; ?>)">
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