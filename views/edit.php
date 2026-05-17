<?php
require_once '../utils/auth_helper.php';
require_once '../models/userModel.php';

checkAuth();
$user = getUserByEmail($_SESSION['email']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Profile - OMS</title>
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
            <h2 class="mb-4">Edit Profile</h2>
            
            <?php
            if(isset($_SESSION['error'])) {
                echo '<div class="alert alert-error">'.$_SESSION['error'].'</div>';
                unset($_SESSION['error']);
            }
            ?>

            <form method="post" action="../controllers/profileCheck.php" onsubmit="return validateProfile()">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" name="name" id="name" class="form-control" value="<?php echo htmlspecialchars($user['name']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" name="phone" id="phone" class="form-control" value="<?php echo htmlspecialchars($user['phone']); ?>" required>
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <textarea name="address" id="address" class="form-control" rows="3" required><?php echo htmlspecialchars($user['address']); ?></textarea>
                </div>

                <button type="submit" name="submit" class="btn btn-primary">Save Changes</button>
            </form>
        </div>
    </div>
    
    <script src="../js/profile.js"></script>
</body>
</html>