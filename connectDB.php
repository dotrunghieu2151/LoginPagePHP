<?php
    $host = 'localhost';
    $user= 'root';
    $password = 'dantebloodhunter';
    $database = 'accounts';
    //create connection
    $connection = mysqli_connect($host,$user,$password,$database);
    if(!$connection) {
        exit("Connection failed: " . mysqli_connect_error() );
    }


