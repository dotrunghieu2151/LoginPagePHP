<?php 
    require "header.php"
?>
<main>
    <h1>Sign up</h1>
    <form action="validation/signupAJAX.php" method="POST" id="theForm">
        <label for="username">
            Username
            <input type="text" id="username" name="username" >
        </label>
        <div>
            <p class="error-mes"></p>
        </div>
        <label for="password">
            Password
            <input type="password" id="password" name="u-password" >
        </label>
        <div>
            <p class="error-mes"></p>
        </div>
        <label for="email">
            Email
            <input type="text" id="email" name="u-email" >
        </label>
        <div>
            <p class="error-mes"></p>
        </div>
        <input type="submit" value="submit" name="signup-submit">
    </form>
</main>
<script src="js/script(signupAJAX).js" type="text/javascript"></script>
<?php require "footer.php" ?>