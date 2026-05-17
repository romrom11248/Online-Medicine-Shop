<?php
session_start();
session_destroy();

setcookie('remember_token', '', time() - 3600, "/");
setcookie('remember_email', '', time() - 3600, "/");

header('location: ../views/login.php');
?>