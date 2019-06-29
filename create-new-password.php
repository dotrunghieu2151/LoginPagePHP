<?php
    session_start();
    $selector = $_GET["selector"];
    $validator = $_GET["validator"];
?>
<!DOCTYPE html>
<html lang="en">
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" 
              content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
        <meta http-equiv="X-UA-Compatible" content="ie=edge">
        <title>Reset your pass</title>
    </head>
    <body>
        <?php if (empty($selector) || 
                  empty($validator) || 
                  ctype_xdigit($selector) === false || 
                  ctype_xdigit($validator)=== false ): ?>
        <p>We could not validate your request! Please make sure this is the right link</p>
        <?php elseif(ctype_xdigit($selector) !== false && ctype_xdigit($validator)!== false): ?>
        <form action="validation/newPassValidate.php" method="POST">
            <label for="password">
                Password
                <input type="password" id="password" name="u-password" >
                <meter id="pass-strength" form="register-form" min="0" max="100" value="0" style="width:230px;"></meter>
                <input type="hidden" name="meter" value="0">
                <span id="pass-message"></span>
            </label>
            <label for="repeat-password">
                repeat-password
                <input type="password" id="repeat-password" name="u-password-repeat">
            </label>
            <input type="hidden" name="selector" value="<?= $selector ?>" >
            <input type="hidden" name="validator" value="<?= $validator ?>" >
            <input type="submit" value="submit" name="create-pass-submit">
        </form>
            <?php if(isset($_SESSION['error'])): ?>
            <p><?= $_SESSION['error'] ?></p>
            <?php endif; ?>
        <?php endif; ?>
    </body>
    <script src="js/script(FOR-SIGN-UP).js" type="text/javascript"></script>
</html>
<?php 
    unset($_SESSION["error"]);
?>


