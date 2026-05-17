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
    <title>Profile - OMS</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body>
    <nav class="navbar">
        <div class="container navbar-content">
            <a href="home.php" class="brand">OMS</a>
            <div class="nav-links">
                <a href="home.php">Home</a>
                <a href="../controllers/logout.php" class="btn-outline" style="padding: 0.25rem 0.75rem;">Logout</a>
            </div>
        </div>
    </nav>

    <div class="container">
        <?php
        if(isset($_SESSION['error'])) {
            echo '<div class="alert alert-error" style="max-width: 800px; margin: 2rem auto;">'.$_SESSION['error'].'</div>';
            unset($_SESSION['error']);
        }
        if(isset($_SESSION['success'])) {
            echo '<div class="alert alert-success" style="max-width: 800px; margin: 2rem auto;">'.$_SESSION['success'].'</div>';
            unset($_SESSION['success']);
        }
        ?>

        <div class="profile-card">
            <div class="profile-avatar-container">
                <?php if(!empty($user['profile_picture']) && file_exists('../public/uploads/'.$user['profile_picture'])): ?>
                    <img src="../public/uploads/<?php echo htmlspecialchars($user['profile_picture']); ?>" alt="Profile Picture" class="profile-avatar">
                <?php else: ?>
                    <img src="https://ui-avatars.com/api/?name=<?php echo urlencode($user['name']); ?>&background=random" alt="Default Avatar" class="profile-avatar">
                <?php endif; ?>
                
                <form action="../controllers/uploadCheck.php" method="post" enctype="multipart/form-data" style="width: 100%; text-align: center; margin-top: 1rem;">
                    <input type="file" name="profile_picture" id="profile_picture" accept="image/*" style="display: none;" onchange="this.form.submit()">
                    <label for="profile_picture" class="btn btn-outline" style="font-size: 0.875rem; padding: 0.5rem 1rem;">Update Picture</label>
                </form>
            </div>
            
            <div class="profile-info">
                <div style="display: flex; justify-content: space-between; align-items: center; margin-bottom: 1.5rem;">
                    <h2>User Profile</h2>
                    <a href="edit.php" class="btn btn-primary" style="width: auto;">Edit Profile</a>
                </div>
                
                <div class="profile-details">
                    <p><strong>Name:</strong> <?php echo htmlspecialchars($user['name']); ?></p>
                    <p><strong>Email:</strong> <?php echo htmlspecialchars($user['email']); ?></p>
                    <p><strong>Role:</strong> <span style="text-transform: capitalize;"><?php echo htmlspecialchars($user['role']); ?></span></p>
                    <p><strong>Address:</strong> <?php echo htmlspecialchars($user['address']); ?></p>
                    <p><strong>Phone:</strong> <?php echo htmlspecialchars($user['phone']); ?></p>
                    <p><strong>Joined:</strong> <?php echo htmlspecialchars($user['created_at']); ?></p>
                </div>

                <div style="margin-top: 2rem; padding-top: 1.5rem; border-top: 1px solid var(--secondary);">
                    <h3>Security</h3>
                    <a href="change_password.php" class="btn btn-outline mt-4" style="width: auto;">Change Password</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>