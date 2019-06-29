<?php
 if(isset($_POST['signup-submit'])) {
    require '../connectDB.php';
    session_start();
    $_SESSION['error'] = ['invalidU' => '','invalidP' => '', 'invalidE'=>''];
    $username = $_POST['username'];
    $passwordStrength = $_SESSION['passStrength'];
    unset($_SESSION['passStrength']);
    $uPass = $_POST['u-password'];
    $uEmail = $_POST['u-email'];
    // check for valid info
    if (empty($username)) {
        $_SESSION['error']['invalidU'] = 'Please fill in the username';
    } elseif (!preg_match('/^(?=.*[0-9])(?=.*[a-zA-Z])(?=\S+$).{6,20}$/',$username)) {
        $_SESSION['error']['invalidU'] = 'Invalid username';
    }
    if (empty($uPass)) {
        $_SESSION['error']['invalidP'] = 'Please fill in the password';
    } elseif ($passwordStrength <= 40) {
        $_SESSION['error']['invalidP'] = 'Weak password, try stronger password';
    }
    if (empty($uEmail)) {
        $_SESSION['error']['invalidE'] = 'Please fill in the email';
    } elseif (!filter_var($uEmail,FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error']['invalidE'] = 'Invalid email';
    }
    if(array_filter($_SESSION['error'])) {
        header("Location: ../signup.php?username=$username&email=$uEmail");
        exit();
    } 
    // check if inform is already taken
    $sql = "SELECT * FROM users WHERE user_name = :user_name OR email = :email";
    $stmt = $connection->prepare($sql);
    $stmt->execute([
        ':user_name' => $username,
        ':email' => $uEmail
    ]);
    // the object approach
    $total = $stmt->rowCount();
    if ($total != 0) {
        while ($row = $stmt->fetchObject()) {
            if ($username === $row->user_name){
                $_SESSION['error']['invalidU'] = 'username taken';
            }
            if ($uEmail === $row->email){
                $_SESSION['error']['invalidE'] = 'email taken';
            } 
        }
        header("Location: ../signup.php?username=$username&email=$uEmail");
        exit();
    } elseif ($total == 0) {
        $pepper = 'FA2DKJL45KANVM';
        $uPass = password_hash($uPass.$pepper,PASSWORD_DEFAULT,['cost'=>11]);
        $sql = "INSERT INTO users(user_name, password, email)"
                . "VALUES(:username,:uPass,:uEmail)";
        $stmt = $connection->prepare($sql);
        $stmt->execute([
           ':username'=>$username,
            ':uPass'=>$uPass,
            ':uEmail'=>$uEmail
        ]);
        unset($_SESSION['error']);
        echo 'registerd successfully';
    }    
 } else {
     header('Location: ../signup.php');
     exit();
 }
 /* the array approach
    $total = $stmt->rowCount() (or use count($result) since it is an array)
    $result = $stmt->fetchAll() (returns an Associative array)
    foreach($result as $user) {
        echo $user['username'];
    }
  * Or use fetch(PDO::FETCH_ASSOC)
  */

