<?php
require_once(__DIR__ . '/../config/db.php');

// User by Email
function getUserByEmail($email){
    $con = getConnection();
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    
    if(mysqli_num_rows($result) == 1){
        return mysqli_fetch_assoc($result);
    } else {
        return null;
    }
}

//Register
function addUser($user){
    $con = getConnection();
    $sql = "INSERT INTO users (name, email, password_hash, role, address, phone) VALUES (?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ssssss", $user['name'], $user['email'], $user['password'], $user['role'], $user['address'], $user['phone']);
    if(mysqli_stmt_execute($stmt)){
        return true;
    } else {
        return false;
    }
}

//update profile
function updateProfile($user){
    $con = getConnection();
    $sql = "UPDATE users SET name=?, address=?, phone=? WHERE email=?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ssss", $user['name'], $user['address'], $user['phone'], $user['email']);
    if(mysqli_stmt_execute($stmt)){
        return true;
    } else {
        return false;
    }
}

//Pass change
function changePassword($email, $newPassword){
    $con = getConnection();
    $hashedPassword = password_hash($newPassword, PASSWORD_DEFAULT);
    $sql = "UPDATE users SET password_hash=? WHERE email=?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $hashedPassword, $email);
    if(mysqli_stmt_execute($stmt)){
        return true;
    } else {
        return false;    
    }
}

//up profile pic
function updateProfilePicture($email, $imagePath){
    $con = getConnection();
    $sql = "UPDATE users SET profile_picture=? WHERE email=?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $imagePath, $email);
    if(mysqli_stmt_execute($stmt)){
        return true;
    } else {
        return false;    
    }
}
?>