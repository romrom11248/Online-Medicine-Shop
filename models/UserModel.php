<?php

    require_once(__DIR__ . '/../config/db.php');

    function getUserByEmail($email){
        $con = getConnection();
        $sql = "select * from users where email = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "s", $email);
        mysqli_stmt_execute($stmt);
        $result = mysqli_stmt_get_result($stmt);
        return mysqli_fetch_assoc($result);
    }

    function updateUserPasswordHash($id, $passwordHash){
        $con = getConnection();
        $sql = "update users set password_hash = ? where id = ?";
        $stmt = mysqli_prepare($con, $sql);
        mysqli_stmt_bind_param($stmt, "si", $passwordHash, $id);
        return mysqli_stmt_execute($stmt);
    }

    function loginUser($email, $password){
        $user = getUserByEmail($email);

        if(!$user){
            return false;
        }

        if(password_verify($password, $user['password_hash'])){
            return $user;
        }

        if($password === $user['password_hash']){
            $hash = password_hash($password, PASSWORD_DEFAULT);
            updateUserPasswordHash($user['id'], $hash);
            $user['password_hash'] = $hash;
            return $user;
        }

        return false;
    }

?>
