<?php

    $host = "127.0.0.1";
    $dbname = "oms";
    $dbuser = "root";
    $dbpass = "";

    function getConnection(){
        global $host;
        global $dbname;
        global $dbuser;
        global $dbpass;

        $con = mysqli_connect($host, $dbuser, $dbpass, $dbname);

        if(!$con){
            die("Database connection failed");
        }

        mysqli_set_charset($con, "utf8mb4");
        return $con;
    }

?>
