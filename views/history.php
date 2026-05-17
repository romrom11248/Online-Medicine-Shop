<?php
    session_start();
    if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
        header('location: login.php');
    }

    require_once('../models/AdminModel.php');
    $pageTitle = "Purchase History";
    $history = getPurchaseHistory();
    require_once('header.php');
?>

<h3>Purchase History</h3>

<?php foreach($history as $order){ ?>
    <fieldset class="box">
        <legend>Order #<?php echo h($order['order_id']); ?></legend>
        Customer: <?php echo h($order['customer_name']); ?> |
        Email: <?php echo h($order['email']); ?> |
        Phone: <?php echo h($order['phone']); ?> <br>
        Address: <?php echo h($order['shipping_address']); ?> <br>
        Payment: <?php echo h($order['payment_method']); ?> |
        Total: <?php echo number_format((float)$order['total_amount'], 2); ?> |
        Date: <?php echo h($order['order_date']); ?>

        <table class="data-table">
            <tr>
                <th>Medicine</th>
                <th>Quantity</th>
                <th>Unit Price</th>
                <th>Subtotal</th>
            </tr>
            <?php foreach($order['items'] as $item){ ?>
                <tr>
                    <td><?php echo h($item['medicine_name']); ?></td>
                    <td><?php echo h($item['quantity']); ?></td>
                    <td><?php echo number_format((float)$item['unit_price'], 2); ?></td>
                    <td><?php echo number_format((float)$item['unit_price'] * $item['quantity'], 2); ?></td>
                </tr>
            <?php } ?>
        </table>
    </fieldset>
<?php } ?>

<?php if(count($history) == 0){ ?>
    <p>No accepted purchase history found.</p>
<?php } ?>

<?php require_once('footer.php'); ?>
