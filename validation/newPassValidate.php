<?php
    if (isset($_POST["create-pass-submit"])) {
        session_start();
        $selector = $_POST["selector"];
        $validator = $_POST["validator"];
        $url = "http://localhost:81/loginpagePHP/create-new-password.php?"
                . "selector=$selector&validator=$validator";
        $uPass = $_POST["u-password"];
        $passwordStrength = $_POST['meter'];
        $repeatPass = $_POST["u-password-repeat"];
        if (empty($uPass) || empty($repeatPass)) {
            $_SESSION["error"] = 'Please fill in the missing fields';
        } elseif($uPass !== $repeatPass) {
            $_SESSION["error"] = 'Passwords are not matched';
        } elseif($passwordStrength <= 40) {
            $_SESSION["error"] = 'Weak password, try more secure password';
        }
        if (isset($_SESSION["error"])) {
            header("Location: $url");
            exit();
        }
        $currentDate = date("U");
        require '../connectDB.php';
        // here we don't need parameter for $currentDate because it is not the user input so it is safe
        $sql = "SELECT * FROM passreset WHERE passResetSelector= :selector AND passResetExpire >= $currentDate";
        $stmt = $connection->prepare($sql);
        $stmt->execute([":selector"=>$selector]);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        if (count($result) == 0) {
            $_SESSION['error'] = 'You need to re-submit your request';
            header("Location: $url");
            exit();
        }
        // validate with token
        $token = hex2bin($validator);
        if (!password_verify($token,$result['passResetToken'])) {
            $_SESSION['error'] = 'You need to re-submit your request';
            header("Location: $url");
            exit();
        } 
        // update the pass
        $pepper = 'FA2DKJL45KANVM';
        $hashedPass = password_hash($uPass.$pepper,PASSWORD_DEFAULT, ['cost'=>11]);
        $tokenEmail = $result['passResetEmail'];
        $sql = "UPDATE users SET password = :newPass WHERE email = :tokenEmail";
        $stmt = $connection->prepare($sql);
        $stmt->execute([
            ':newPass'=>$hashedPass,
            ':tokenEmail'=>$tokenEmail
        ]);
        // delete the token when done
        $sql = "DELETE FROM passreset WHERE passResetEmail= :userEmail";
        $stmt = $connection->prepare($sql);
        $stmt->execute([":userEmail"=>$tokenEmail]);
    } 
    // return to index
    header("Location: ../index.php");
    exit();
   
