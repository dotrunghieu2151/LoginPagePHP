<?php
if (isset($_POST['getData'])) {
    $data = json_decode($_POST['getData'],true);
    $username = htmlspecialchars($data['username']);
    $uPass = htmlspecialchars($data['password']);
    $uEmail = htmlspecialchars($data['email']);
    $errors = ['invalidU'=>'','invalidP'=>'','invalidE'=>''];
    if (empty($username)) {
        $errors['invalidU'] = 'Please fill in the username';
    } elseif (!preg_match('/^(?=.*[0-9])(?=.*[a-zA-Z])(?=\S+$).{6,20}$/',$username)) {
        $errors['invalidU'] = 'Invalid username';
    }
    if (empty($uPass)) {
       $errors['invalidP'] = 'Please fill in the password';
    } elseif (!preg_match('/^(?=.*[0-9])(?=.*[a-zA-Z])(?=\S+$).{6,20}$/',$uPass)) {
       $errors['invalidP'] = 'Invalid password';
    }
    if (empty($uEmail)) {
        $errors['invalidE'] = 'Please fill in the email';
    } elseif (!filter_var($uEmail,FILTER_VALIDATE_EMAIL)) {
        $errors['invalidE'] = 'Invalid email';
    }
    if (array_filter($errors)) {
        $errors['status'] = 'error';
    } else {
        $errors['status'] = 'ok';
    }
    echo json_encode($errors);
}
