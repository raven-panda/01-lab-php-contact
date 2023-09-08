<?php
    session_start();
    unset($_SESSION['token'], $_SESSION['token_time'], $_SESSION['rememberMe']);
    header('Location: http://localhost/');
?>