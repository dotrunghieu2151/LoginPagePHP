<?php
/* using object oriented mysqli
    $host = 'localhost';
    $db_user= 'root';
    $db_password = 'dantebloodhunter';
    $database = 'accounts';
    //create connection
    $connection = new mysqli($host,$db_user,$db_password,$database) OR die($connection->error);
*/
// using PDO
    $host = 'localhost';
    $db_user = 'root';
    $db_pass = '';
    $db = 'accounts';
    $dsn = "mysql:host=$host;dbname=$db";
     try {
         $connection = new PDO($dsn,$db_user,$db_pass);
         $connection->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
     } catch (PDOException $e) {
         echo "connection failed: " . $e->getMessage();
     }
