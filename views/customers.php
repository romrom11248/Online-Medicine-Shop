<?php
    session_start();
    if(!isset($_SESSION['role']) || $_SESSION['role'] != 'admin'){
        header('location: login.php');
    }

    require_once('../models/AdminModel.php');
    $pageTitle = "Customer Management";
    $customers = getAllCustomers();
    require_once('header.php');
?>

<h3>Customers</h3>

<table class="data-table">
    <tr>
        <th>Name</th>
        <th>Email</th>
        <th>Phone</th>
        <th>Address</th>
        <th>Joined</th>
        <th>Action</th>
    </tr>
    <?php foreach($customers as $customer){ ?>
        <tr>
            <td><?php echo h($customer['name']); ?></td>
            <td><?php echo h($customer['email']); ?></td>
            <td><?php echo h($customer['phone']); ?></td>
            <td><?php echo h($customer['address']); ?></td>
            <td><?php echo h($customer['created_at']); ?></td>
            <td>
                <form method="post" action="../controllers/customerController.php" class="inline-form delete-form">
                    <input type="hidden" name="csrf_token" value="<?php echo $_SESSION['csrf_token']; ?>">
                    <input type="hidden" name="id" value="<?php echo h($customer['id']); ?>">
                    <input type="submit" value="Delete">
                </form>
            </td>
        </tr>
    <?php } ?>
</table>

<?php require_once('footer.php'); ?>
