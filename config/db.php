<?php
$db_host = "127.0.0.1";
$db_username = "root";
$db_password = "";
$db_name = "oms";

function getConnection(){
    global $db_host;
    global $db_username;
    global $db_password;
    global $db_name;

    $con = mysqli_connect($db_host, $db_username, $db_password, $db_name);
    if(!$con){
        die("Connection failed: " . mysqli_connect_error());
    }else{
        return $con;
    }
}

?>