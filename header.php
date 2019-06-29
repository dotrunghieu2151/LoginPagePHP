<?php 
    session_start();
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <meta name="description" content="MY WEB PAGE, this will show up in search results">
        <title>My page</title>
        <link href="css/style.css" rel="stylesheet" type="text/css"/>
    </head>      
    <body>
        <header>
            <nav>
                <a href="#">
                    <img src="img/logo.png" alt="logo">
                </a>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="#">Portfolio</a></li>
                    <li><a href="#">About me</a></li>
                    <li><a href="#">Contact</a></li>
                </ul>
                <div>
                    <?php if(empty($_SESSION['user']) || empty($_SESSION['email']) || empty($_SESSION['id'])): ?>
                    <form action="validation/login.php" method="POST">
                        <input type="text" name="login-username-email" placeholder="Username or Email..." value="">
                        <input type="password" name="login-password" placeholder="password...">
                        <input type="submit" name="login-submit" value="login">
                        <div>
                            <?php if(!empty($_SESSION['error']['login-U'])): ?>
                            <p><?= $_SESSION['error']['login-U'] ?></p>
                            <?php endif; ?>
                            <?php if(!empty($_SESSION['error']['login-P'])): ?>
                            <p><?= $_SESSION['error']['login-P'] ?></p>
                            <?php endif; ?>
                        </div>
                    </form>
                    <a href="signup.php">Sign up</a>
                    <a href="validation/forgetpass.php">Forgot password ?</a>
                    <?php elseif (!empty($_SESSION['user']) && !empty($_SESSION['email']) && !empty($_SESSION['id'])): ?>
                    <img src=<?php 
                               $profilePic = glob("uploads/user{$_SESSION['id']}/profile.*");
                               if (!$profilePic) {echo "uploads/default.jpg";}
                               else {echo "{$profilePic[0]}?" .mt_rand() ;}
                              ?>
                         alt="user-profile-pic">
                    <span><?= $_SESSION['user'] ?></span>
                    <span><?= $_SESSION['email'] ?></span>
                    <form action="upload.php" method="POST" enctype="multipart/form-data">
                        <input type="file" name="file">
                        <input type="submit" name="upload" value="UPLOAD PROFILE PICTURE">
                    </form>
                    <form action="logout.php" method="POST">
                        <input type="submit" value="logout" name="log-out">
                    </form>
                    <div>
                        <p>WEB PAGE CONTENT</p>
                    </div>
                    <?php endif; ?>
                </div>
            </nav>
        </header>

