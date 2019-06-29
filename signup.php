<?php 
    require "header.php"
?>
<main>
    <h1>Sign up</h1>
    <form action="validation/signup.php" method="POST" id="register-form">
        <label for="username">
            Username
            <input type="text" id="username" name="username" 
                   value="<?php if(isset($_GET['username'])) 
                           echo htmlspecialchars($_GET['username']) ?>">
        </label>
        <div>
            <?php if(!empty($_SESSION['error']['invalidU'])): ?> 
            <p><?= $_SESSION['error']['invalidU'] ?></p>
            <?php endif; ?>
        </div>
        <label for="password">
            Password
            <input type="password" id="password" name="u-password" >
            <meter id="pass-strength" form="register-form" min="0" max="100" value="0" style="width:230px;"></meter>
            <input type="hidden" name="meter" value="0">
            <span id="pass-message"></span>
        </label>
        <div>
            <?php if(!empty($_SESSION['error']['invalidP'])): ?> 
            <p><?= $_SESSION['error']['invalidP'] ?></p>
            <?php endif; ?>
        <label for="email">
            Email
            <input type="text" id="email" name="u-email" 
                   value="<?php if(isset($_GET['email'])) 
                           echo htmlspecialchars($_GET['email']) ?>">
        </label>
        <div>
            <?php if(!empty($_SESSION['error']['invalidE'])): ?> 
            <p><?= $_SESSION['error']['invalidE'] ?></p>
            <?php endif; ?>
        </div>
        <input type="submit" value="submit" name="signup-submit">
    </form>
</main>
<script src="js/script(FOR-SIGN-UP).js" type="text/javascript"></script>
<?php 
    require "footer.php"; 
?>
