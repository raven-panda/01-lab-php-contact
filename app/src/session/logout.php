<?php
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_GET['reason']) && !empty($_GET['reason'])) {
        
        // Destruction de la session.
        session_start();
        session_destroy();

        // Destruction du cookie.
        if(isset($_COOKIE['token'])) {
            setcookie('token', '0', time()-3600, '/', 'php-dev-1.online');
        }

        // Redirection vers l'index avec la raison de déconnexion.
        header('Location: http://'. $_SERVER['HTTP_HOST'] .'/index.php?logout=' . $_GET['reason']);
        
    } else {
        // Redirection vers l'index car les conditions sont incorrectes.
        header('Location: http://'. $_SERVER['HTTP_HOST'] .'/index.php');
        exit();
    }
?>