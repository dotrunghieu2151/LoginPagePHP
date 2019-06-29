<?php
    if (isset($_POST['login-submit'])) {
        require "../connectDB.php";
        session_start();
        $_SESSION['error']=['login-U'=> '','login-P'=> ''];
        $userNameEmail = $_POST['login-username-email'];
        $uPass = $_POST['login-password'];
        if (empty($userNameEmail)) {
            $_SESSION['error']['login-U'] = 'Please enter username or email';
        }
        if (empty($uPass)) {
            $_SESSION['error']['login-P'] = 'Please enter password';
        }
        if (array_filter($_SESSION['error'])) {
            header('Location: ../signup.php');
            exit();
        }
        $sql = 'SELECT * FROM users WHERE user_name = :username OR email = :useremail';
        $stmt = $connection->prepare($sql);
        $stmt->execute([
            ':username'=> $userNameEmail,
            ':useremail'=> $userNameEmail
        ]);
        $total = $stmt->rowCount();
        if ($total == 0) {
            $_SESSION['error']['login-U'] = 'This user doesn\'t exist';
            header('Location: ../signup.php');
            exit();
        }
        $pepper = 'FA2DKJL45KANVM'; 
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!password_verify($uPass.$pepper,$result['password'] )){
            $_SESSION['error']['login-P'] = 'This user doesn\'t exist(pass)';
            header('Location: ../signup.php');
            exit();
        } else {
            if(password_needs_rehash($result['password'], PASSWORD_DEFAULT, ['cost'=>11])) {
                $newhashed_pass = password_hash($uPass.$pepper,PASSWORD_DEFAULT,['cost'=>11]);
                $sql = "UPDATE users SET password = :newPass"
                        ." WHERE user_name = :username OR email = :useremail";
                $stmt = $connection->prepare($sql);
                $stmt->execute([
                    ':newPass'=>$newhashed_pass,
                    ':username'=>$userNameEmail,
                    ':useremail'=>$userNameEmail
                ]);
            }
            $_SESSION['id'] = $result['id'];
            $_SESSION['user'] = $result['user_name'];
            $_SESSION['email'] = $result['email'];
            header('Location: ../index.php');
            exit();
        }
    } else {
        header("Location: ../signup.php");
        exit();
    }
       
