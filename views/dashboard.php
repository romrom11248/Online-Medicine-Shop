<?php
    session_start();
    if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
        header('location: login.php');
    }

    require_once('../models/AdminModel.php');
    $pageTitle = "Admin Dashboard";
    $counts = getDashboardCounts();
    require_once('header.php');
?>

<h3>Dashboard</h3>

<div class="dashboard-box">
    <div class="single-info">
        <b>Total Medicines</b>
        <span><?php echo h($counts['medicines']); ?></span>
    </div>

    <div class="single-info">
        <b>Categories</b>
        <span><?php echo h($counts['categories']); ?></span>
    </div>

    <div class="single-info">
        <b>Customers</b>
        <span><?php echo h($counts['customers']); ?></span>
    </div>

    <div class="single-info">
        <b>Pending Orders</b>
        <span><?php echo h($counts['pending_orders']); ?></span>
    </div>
</div>

<p>
    <a class="btn" href="medicines.php">Manage Medicines</a>
    <a class="btn" href="orders.php">View Purchase Requests</a>
</p>

<?php require_once('footer.php'); ?>
