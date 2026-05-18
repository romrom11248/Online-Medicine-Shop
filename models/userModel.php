<?php

require_once(__DIR__ . '/../config/db.php');

function getUserByEmail($email){
    $con = getConnection();
    $sql = "SELECT * FROM users WHERE email = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "s", $email);
    mysqli_stmt_execute($stmt);
    $result = mysqli_stmt_get_result($stmt);
    return mysqli_fetch_assoc($result);
}

function updateUserPasswordHash($id, $passwordHash){
    $con = getConnection();
    $sql = "UPDATE users SET password_hash = ? WHERE id = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "si", $passwordHash, $id);
    return mysqli_stmt_execute($stmt);
}

function loginUser($email, $password){
    $user = getUserByEmail($email);
    if(!$user) return false;

    if(password_verify($password, $user['password_hash'])){
        return $user;
    }
    // fallback for plain-text passwords during dev
    if($password === $user['password_hash']){
        $hash = password_hash($password, PASSWORD_DEFAULT);
        updateUserPasswordHash($user['id'], $hash);
        $user['password_hash'] = $hash;
        return $user;
    }
    return false;
}

// Called by signupCheck.php
function addUser($user){
    $con = getConnection();
    $sql = "INSERT INTO users(name, email, password_hash, role, address, phone)
            VALUES(?, ?, ?, ?, ?, ?)";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param(
        $stmt, "ssssss",
        $user['name'],
        $user['email'],
        $user['password'],
        $user['role'],
        $user['address'],
        $user['phone']
    );
    return mysqli_stmt_execute($stmt);
}

// Called by profileCheck.php
function updateProfile($user){
    $con = getConnection();
    $sql = "UPDATE users SET name = ?, address = ?, phone = ? WHERE email = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param(
        $stmt, "ssss",
        $user['name'],
        $user['address'],
        $user['phone'],
        $user['email']
    );
    return mysqli_stmt_execute($stmt);
}

// Called by passwordCheck.php
function changePassword($email, $newPassword){
    $con = getConnection();
    $hash = password_hash($newPassword, PASSWORD_DEFAULT);
    $sql = "UPDATE users SET password_hash = ? WHERE email = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $hash, $email);
    return mysqli_stmt_execute($stmt);
}

// Called by uploadCheck.php
function updateProfilePicture($email, $filename){
    $con = getConnection();
    $sql = "UPDATE users SET profile_picture = ? WHERE email = ?";
    $stmt = mysqli_prepare($con, $sql);
    mysqli_stmt_bind_param($stmt, "ss", $filename, $email);
    return mysqli_stmt_execute($stmt);
}