<?php
    $response = array(
        'ok' => 'true',
        'error' => 'none',
        'code' => ''
    );

    if (isset($_POST['email']) && isset($_POST['password'])
    && !empty($_POST['email']) && !empty($_POST['password'])) {

        $dsn = 'mysql:host=database;dbname='. getenv('MYSQL_DATABASE') .';charset=utf8';
        $mysqlConnection = new PDO($dsn, getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'));

        try {

            $sql = 'SELECT email, password, token, token_time FROM user WHERE email = :email';
            $sth = $mysqlConnection->prepare($sql);

            $sth->bindParam(':email', $_POST['email'], PDO::PARAM_STR);

            $sth->execute();

            $row = $sth->fetch();

            if (!$row === false && password_verify($_POST['password'], $row['password'])) {
                session_start();
                try {
                    if (isset($_POST['rememberMe'])) {
                        $_SESSION['token'] = bin2hex(random_bytes(32));
                        $_SESSION['token_time'] = time() + 300;
                        $_SESSION['rememberMe'] = true;
        
                        $sql = 'UPDATE user SET token = :token, token_time = :token_time WHERE email = :email';
                        $sth = $mysqlConnection->prepare($sql);
        
                        $sth->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
                        $sth->bindParam(':token', $_SESSION['token'], PDO::PARAM_STR);
                        $sth->bindParam(':token_time', $_SESSION['token_time'], PDO::PARAM_STR);
        
                        $sth->execute();
                    }
                } catch (Exception $e) {
                    echo $e;
                }

            } else {
                $response['ok'] = 'false';
                $response['error'] = 'creds_not_found';
            }

        } catch (Exception $e) {
            $response['ok'] = 'false';
            $response['error'] = $e->getMessage();
            $response['code'] = $e->getCode();
        }
    } else {
        $response['ok'] = 'false';
        $response['error'] = 'fields_incorrect';
    }

    echo json_encode($response);
    exit();
?>