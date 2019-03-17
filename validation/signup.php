<?php
 if(isset($_POST['signup-submit'])) {
    require '../connectDB.php';
    session_start();
    $_SESSION['error'] = ['invalidU' => '','invalidP' => '', 'invalidE'=>''];
    $username = htmlspecialchars($_POST['username']);
    $uPass = htmlspecialchars($_POST['u-password']);
    $uEmail = htmlspecialchars($_POST['u-email']);
    if (empty($username)) {
        $_SESSION['error']['invalidU'] = 'Please fill in the username';
    } elseif (!preg_match('/^(?=.*[0-9])(?=.*[a-zA-Z])(?=\S+$).{6,20}$/',$username)) {
        $_SESSION['error']['invalidU'] = 'Invalid username';
    }
    if (empty($uPass)) {
        $_SESSION['error']['invalidP'] = 'Please fill in the password';
    } elseif (!preg_match('/^(?=.*[0-9])(?=.*[a-zA-Z])(?=\S+$).{6,20}$/',$uPass)) {
        $_SESSION['error']['invalidP'] = 'Invalid password';
    }
    if (empty($uEmail)) {
        $_SESSION['error']['invalidE'] = 'Please fill in the email';
    } elseif (!filter_var($uEmail,FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error']['invalidE'] = 'Invalid email';
    }
    if(array_filter($_SESSION['error'])) {
        header('Location: ../signup.php');
        exit();
    } else {
        echo "no error";
    }
    
 }

