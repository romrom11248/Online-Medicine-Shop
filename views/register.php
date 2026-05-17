<?php
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - OMS</title>
    <link rel="stylesheet" href="../public/style.css">
</head>
<body>
    <div class="container">
        <div class="form-container">
            <h2 class="text-center mb-4 brand">Register to OMS</h2>
            
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

            <form method="post" action="../controllers/signupCheck.php" id="registerForm" onsubmit="return validateRegister()">
                <div class="form-group">
                    <label for="name">Full Name</label>
                    <input type="text" name="name" id="name" class="form-control" required>
                    <div id="nameError" class="error-msg"></div>
                </div>

                <div class="form-group">
                    <label for="email">Email Address</label>
                    <input type="email" name="email" id="email" class="form-control" required>
                    <div id="emailError" class="error-msg"></div>
                </div>

                <div class="form-group">
                    <label for="password">Password</label>
                    <input type="password" name="password" id="password" class="form-control" required>
                    <div id="passwordError" class="error-msg"></div>
                </div>

                <div class="form-group">
                    <label for="address">Address</label>
                    <input type="text" name="address" id="address" class="form-control" required>
                    <div id="addressError" class="error-msg"></div>
                </div>

                <div class="form-group">
                    <label for="phone">Phone Number</label>
                    <input type="text" name="phone" id="phone" class="form-control" required>
                    <div id="phoneError" class="error-msg"></div>
                </div>

                <div class="form-group">
                    <label for="role">Role</label>
                    <select name="role" id="role" class="form-control" required>
                        <option value="customer">Customer</option>
                        <option value="admin">Admin</option>
                    </select>
                </div>

                <button type="submit" name="submit" class="btn btn-primary mb-3">Register</button>
                
                <div class="text-center">
                    Already have an account? <a href="login.php">Login here</a>
                </div>
            </form>
        </div>
    </div>
    <script src="../public/js/auth.js"></script>
</body>
</html>