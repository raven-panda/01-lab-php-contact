<?php
    if ($_SERVER['REQUEST_METHOD'] === 'GET' && isset($_COOKIE['token'])) {
        include '../_library/php/functions.php';
    
        $oldToken = $_COOKIE['token'];

        $newToken = bin2hex(random_bytes(32));
        $tokieTimeout = time() + (3600 * 72);

        try {

            $mysqlConnection = databaseConnection();

            $sql = 'UPDATE user SET token = :new_token WHERE token = :old_token';
            $sth = $mysqlConnection->prepare($sql);

            $sth->bindParam(':new_token', $newToken, PDO::PARAM_STR);
            $sth->bindParam(':old_token', $oldToken, PDO::PARAM_STR);

            $sth->execute();

            setcookie('token', $newToken, $tokieTimeout, '/', 'php-dev-1.online', false, true);

            header('Location: http://'. $_SERVER['HTTP_HOST'] .'/dashboard/dashboard.php');
        } catch (Exception $err) {
            header('HTTP/1.0 404 Not Found');
        }
    } else {
        header('HTTP/1.0 404 Not Found');
        exit();
    }
?>