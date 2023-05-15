<?php
    $hostname = "localhost";
    $username = "root";
    $password = "";
    $database = "cp_wedding";
    
    $connect = new mysqli($hostname, $username, $password, $database);
    if($connect->connect_error){
        // If failed to connect, shut it down with die()
        die("Connection failed: ".$connect->connect_error);
    }