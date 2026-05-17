<?php
    session_start();
    if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
        header('location: login.php');
    }

    require_once('../models/AdminModel.php');
    $pageTitle = "Purchase Requests";
    $orders = getAllOrders();
    require_once('header.php');
?>

<h3>Purchase Requests</h3>

<div id="ajaxMessage"></div>

<table class="data-table">
    <tr>
        <th>Order</th>
        <th>Customer</th>
        <th>Total</th>
        <th>Address</th>
        <th>Date</th>
        <th>Status</th>
        <th>Action</th>
    </tr>
    <?php foreach($orders as $order){ ?>
        <tr id="order-<?php echo h($order['id']); ?>">
            <td>#<?php echo h($order['id']); ?></td>
            <td>
                <?php echo h($order['customer_name']); ?><br>
                <?php echo h($order['customer_email']); ?>
            </td>
            <td><?php echo number_format((float)$order['total_amount'], 2); ?></td>
            <td><?php echo h($order['shipping_address']); ?></td>
            <td><?php echo h($order['order_date']); ?></td>
            <td class="status-text"><?php echo h($order['status']); ?></td>
            <td class="order-buttons">
                <?php if($order['status'] == 'pending'){ ?>
                    <button type="button" class="order-action" data-id="<?php echo h($order['id']); ?>" data-status="accepted">Accept</button>
                    <button type="button" class="order-action danger" data-id="<?php echo h($order['id']); ?>" data-status="rejected">Reject</button>
                <?php }else{ ?>
                    Updated
                <?php } ?>
            </td>
        </tr>
    <?php } ?>
</table>

<?php require_once('footer.php'); ?>
