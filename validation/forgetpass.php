<?php
    if (isset($_POST['forgetpass-submit'])) {
        require '../connectDB.php';     
        $userEmail = $_POST["forgetpass-email"];
        $sql = 'SELECT email FROM users WHERE email = :uemail';
        $stmt= $connection->prepare($sql);
        $stmt->execute([':uemail'=>$userEmail]);
        if ($stmt->rowCount() == 0) {
            echo 'can\'t find the user';
            exit();
        }    
        // create 2 token 
        $selector = bin2hex(random_bytes(8)); // this is the first token to go to database and check if it is the right user
        $token = random_bytes(32); // this is the second token to authenticate the user
        $url = "http://localhost:81/loginpagePHP/create-new-password.php?"
                . "selector=$selector&validator=" . bin2hex($token);
        $expireDate = date("U")+1800;
        // delete any existing token from this user Ex: the user already reset pass 20 min ago
        $sql = "DELETE FROM passreset WHERE passResetEmail= :userEmail";
        $stmt = $connection->prepare($sql);
        $stmt->execute([":userEmail"=>$userEmail]);
        // insert the token
        $sql = "INSERT INTO passreset(passResetEmail,passResetSelector,passResetToken,passResetExpire)"
                . "VALUES(:email,:selector,:token,:expire)";
        $stmt = $connection->prepare($sql);
        $hashedToken = password_hash($token,PASSWORD_DEFAULT,['cost'=>11]);
        $stmt->execute([
            ':email'=>$userEmail,
            ':selector'=>$selector,
            ':token'=>$hashedToken,
            ':expire'=>$expireDate
        ]);
        // sending the email
        $to = $userEmail;
        $subject = "Reset your password for this web page";
        $message = "<p>We received a password reset request. The link to reset your password is below. If you did not make this request"
                . " ignore this email</p>"
                . "<p>Here is your password reset link: </br>"
                . "<a href='$url' >$url</a></p>";
        $headers = "From: spadar dante<dante.bloodhunter@gmail.com>\r\n"
                . "Reply-To: dante.bloodhunter@gmail.com\r\n"
                . "Content-type: text/html\r\n"; // to display html in the email
        $sendmail = mail($to, $subject, $message, $headers);
        if ($sendmail) {
            echo 'mail sent. Check your email';
        } else {
            echo 'error';
        }       
    }   
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" 
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>forget pass</title>
    </head>
    <body>
        <form action="forgetpass.php" method="POST">
            <input type="text" placeholder="Enter email..." name="forgetpass-email">
            <input type="submit" name="forgetpass-submit" value="submit">
        </form>
    </body>
</html>
