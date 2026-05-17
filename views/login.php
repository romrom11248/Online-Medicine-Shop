<?php
<<<<<<< HEAD
session_start();
// If already logged in, redirect to home
if(isset($_SESSION['status'])) {
    header('Location: home.php');
    exit();
}
// Try to check remember me token
require_once('../controllers/authHelper.php');
checkRememberMe();
=======
    session_start();

    if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'){
        header('location: dashboard.php');
    }
>>>>>>> origin/feature/task2-2355531-3
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
<<<<<<< HEAD
    <title>Login - OMS</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2 class="text-center mb-4 brand">Login to OMS</h2>
            
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

            <form method="post" action="../controllers/loginCheck.php" id="loginForm" onsubmit="return validateLogin()">
                <div class="form-group">
                    <label for="login_email">Email Address</label>
                    <input type="email" name="email" id="login_email" class="form-control" required>
                    <div id="emailError" class="error-msg"></div>
                </div>

                <div class="form-group">
                    <label for="login_password">Password</label>
                    <input type="password" name="password" id="login_password" class="form-control" required>
                    <div id="passwordError" class="error-msg"></div>
                </div>

                <div class="form-group" style="display: flex; align-items: center; gap: 0.5rem;">
                    <input type="checkbox" name="remember" id="remember">
                    <label for="remember" style="margin-bottom: 0;">Remember Me</label>
                </div>

                <button type="submit" name="submit" class="btn btn-primary mb-3">Login</button>
                
                <div class="text-center">
                    Don't have an account? <a href="register.php">Register here</a>
                </div>
            </form>
        </div>
    </div>
    <script src="../public/js/auth.js"></script>
</body>
</html>
=======
    <title>Admin Login</title>
    <link rel="stylesheet" href="../public/css/style.css">
</head>
<body>
    <div class="login-box">
        <h2>Online Medicine Shop</h2>
        <h3>Admin Login</h3>

        <?php if(isset($_SESSION['error'])){ ?>
            <p class="error"><?php echo htmlspecialchars($_SESSION['error']); unset($_SESSION['error']); ?></p>
        <?php } ?>

        <form method="post" action="../controllers/loginCheck.php" id="loginForm">
            <table class="form-table">
                <tr>
                    <td>Email</td>
                    <td>
                        <input type="email" name="email" value="" id="email">
                        <span class="field-error" id="emailError"></span>
                    </td>
                </tr>
                <tr>
                    <td>Password</td>
                    <td>
                        <input type="password" name="password" value="" id="password">
                        <span class="field-error" id="passwordError"></span>
                    </td>
                </tr>
                <tr>
                    <td></td>
                    <td><input type="submit" name="submit" value="Login"></td>
                </tr>
            </table>
        </form>
    </div>
    <script src="../public/js/admin.js"></script>
</body>
</html>
>>>>>>> origin/feature/task2-2355531-3
