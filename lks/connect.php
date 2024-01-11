<?php

//header("Location: bakim.php");

ob_start();
session_start();
//  4Vn[;>nPspQ
date_default_timezone_set('Europe/Istanbul');
$local = 1;

if ($local == 1) {
    try {
        $db = new PDO("mysql:host=localhost;dbname=lab;charset=utf8mb4", "root", "");
    } catch (PDOException $e) {
        print $e->getMessage();
    }
} else if ($local == 0) {
}

/*

Log Types:

    1   Login to LAB
    2   Logout from LAB
    3   LAB Online
    4   LAB Offline
    5   
    6   

*/