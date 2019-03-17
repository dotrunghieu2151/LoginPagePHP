<?php 
    session_start();
    require "header.php"
?>
<main>
    <h1>Sign up</h1>
    <form action="validation/signup.php" method="POST">
        <label for="username">
            Username
            <input type="text" id="username" name="username" >
        </label>
        <div>
            <?php if(!empty($_SESSION['error']['invalidU'])){ 
               echo  "<p>{$_SESSION['error']['invalidU']}</p>";
               unset($_SESSION['error']['invalidU']);
             } ?>
        </div>
        <label for="password">
            Password
            <input type="password" id="password" name="u-password" >
        </label>
        <div>
            <?php if(!empty($_SESSION['error']['invalidP'])){ 
               echo  "<p>{$_SESSION['error']['invalidP']}</p>";
               unset($_SESSION['error']['invalidP']);
             } ?>
        </div>
        <label for="email">
            Email
            <input type="text" id="email" name="u-email" >
        </label>
        <div>
            <?php if(!empty($_SESSION['error']['invalidE'])){ 
               echo  "<p>{$_SESSION['error']['invalidE']}</p>";
               unset($_SESSION['error']['invalidE']);
             } ?>
        </div>
        <input type="submit" value="submit" name="signup-submit">
    </form>
</main>
<?php require "footer.php" ?>