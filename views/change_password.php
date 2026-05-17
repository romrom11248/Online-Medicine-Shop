<?php
require_once '../utils/auth_helper.php';
checkAuth();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Change Password - OMS</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container navbar-content">
            <a href="home.php" class="brand">OMS</a>
            <div class="nav-links">
                <a href="view.php">Back to Profile</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <div class="form-container">
            <h2 class="mb-4">Change Password</h2>
            
            <?php
            if(isset($_SESSION['error'])) {
                echo '<div class="alert alert-error">'.$_SESSION['error'].'</div>';
                unset($_SESSION['error']);
            }
            if(isset($_SESSION['success'])) {
                echo '<div class="alert alert-success">'.$_SESSION['success'].'</div>';
                unset($_SESSION['success']);
            }
            ?>

            <form method="post" action="../controllers/passwordCheck.php" id="passwordForm">
                <div class="form-group">
                    <label for="current_password">Current Password</label>
                    <input type="password" name="current_password" id="current_password" class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="new_password">New Password</label>
                    <input type="password" name="new_password" id="new_password" class="form-control" required>
                    <div class="error-msg">Must be at least 8 characters.</div>
                </div>

                <button type="submit" name="submit" class="btn btn-primary">Update Password</button>
            </form>
        </div>
    </div>
</body>
</html>