<?php
    session_start();

    if(isset($_SESSION['role']) && $_SESSION['role'] == 'admin'){
        header('location: dashboard.php');
    }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
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
