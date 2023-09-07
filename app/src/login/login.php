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

            $sql = 'SELECT email, password FROM user WHERE email = :email';
            $sth = $mysqlConnection->prepare($sql);

            $sth->bindParam(':email', $_POST['email'], PDO::PARAM_STR);

            $sth->execute();

            $row = $sth->fetch();

            if (!$row === false && password_verify($_POST['password'], $row['password'])) {
                if (isset($_POST['rememberMe']) && !empty($_POST['rememberMe'])) {
                    

                    $response['ok'] = 'true';
                    $response['error'] = 'none';
                } else {
                    $response['ok'] = 'true';
                    $response['error'] = 'none';
                }
                session_start();
                $_SESSION['token'] = bin2hex(random_bytes(32));
                $_SESSION['token_time'];
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