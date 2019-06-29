<?php
    if (isset($_POST['log-out'])){
        session_start();
        session_unset();
        session_destroy();
    }
    header('Location: index.php');
    exit();
