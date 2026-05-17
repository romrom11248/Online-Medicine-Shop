<?php
    if(!isset($_SESSION['csrf_token'])){
        $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
    }

    function h($value){
        return htmlspecialchars($value ?? "", ENT_QUOTES, "UTF-8");
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="<?php echo $_SESSION['csrf_token']; ?>">
    <title><?php echo h($pageTitle); ?></title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
    <table class="header-table">
        <tr>
            <td>
                <h2>Online Medicine Shop</h2>
                <b>Admin Panel</b>
            </td>
            <td class="right">
                Welcome <?php echo h($_SESSION['name']); ?> |
                <a class="logout-btn" href="../controllers/logout.php">Logout</a>
            </td>
        </tr>
    </table>

    <div class="menu">
        <a href="dashboard.php">Dashboard</a>
        <a href="categories.php">Categories</a>
        <a href="medicines.php">Medicines</a>
        <a href="customers.php">Customers</a>
        <a href="orders.php">Purchase Requests</a>
        <a href="history.php">Purchase History</a>
    </div>

    <div class="main">
        <?php if(isset($_SESSION['success'])){ ?>
            <p class="success"><?php echo h($_SESSION['success']); unset($_SESSION['success']); ?></p>
        <?php } ?>

        <?php if(isset($_SESSION['error'])){ ?>
            <p class="error"><?php echo h($_SESSION['error']); unset($_SESSION['error']); ?></p>
        <?php } ?>
