<?php
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['reason']) && !empty($_GET['reason'])) {
        session_start();
        session_unset();
        session_destroy();

        if(isset($_COOKIE['token'])) {
            setcookie('token', '', 0, '/', 'php-dev-1.online');
        }
        
        header('Location: ../index.php?logout=' . $_GET['reason']);
        
    } else {
        header('Location: ../index.php');
        exit();
    }
?>