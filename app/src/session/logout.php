<?php
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['timeout']) && !empty($_GET['timeout'])) {
        session_start();
        session_unset();
        session_destroy();
        header('Location: ../index.php?logout=' . $_GET['timeout']);
    } else {
        header('HTTP/1.0 404 Not Found');
        exit();
    }
?>