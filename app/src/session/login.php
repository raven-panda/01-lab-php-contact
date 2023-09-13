<?php
    $response = array(
        'valid' => 'false',
        'error' => [],
    );

    if (isset($_POST['email']) && isset($_POST['password'])
    && !empty($_POST['email']) && !empty($_POST['password'])) {

        /* Makes a token that will last until the session ends */
        function token_session($conn, $creds) {

            session_start();

            $token = bin2hex(random_bytes(32));
            $tokenExp = time() + ini_get('session.gc_maxlifetime');

            $_SESSION['token'] = $token;
            $_SESSION['token_time'] = $tokenExp;

            $sql = 'UPDATE user SET token = :token, token_time = :token_time WHERE email = :email';
            $sth = $conn->prepare($sql);

            $sth->bindParam(':email', $creds, PDO::PARAM_STR);
            $sth->bindParam(':token', $token, PDO::PARAM_STR);
            $sth->bindParam(':token_time', $tokenExp, PDO::PARAM_STR);

            $sth->execute();

        }

        $mysqlHost = getenv('MYSQL_HOST');
        $mysqlDb = getenv('MYSQL_DATABASE');
        $mysqlUser = getenv('MYSQL_USER');
        $mysqlPw = getenv('MYSQL_PASSWORD');

        if ($mysqlHost && $mysqlDb && $mysqlUser && $mysqlPw) {

            $dsn = 'mysql:host='. $mysqlHost .';dbname='. $mysqlDb .';charset=utf8';
            $mysqlConnection = new PDO($dsn, $mysqlUser, $mysqlPw);
    
            $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
            $password = htmlspecialchars($_POST['password']);
    
            try {
    
                $sql = 'SELECT email, password, token, token_time FROM user WHERE email = :email';
                $sth = $mysqlConnection->prepare($sql);
    
                $sth->bindParam(':email', $email, PDO::PARAM_STR);
    
                $sth->execute();
    
                $result = $sth->fetch(PDO::FETCH_ASSOC);
    
                if ($result && password_verify($password, $result['password'])) {
                    token_session($mysqlConnection, $email);

                    $response['valid'] = 'true';
                } else {
                    $response['error'][] = 'no_creds';
                }
    
            } catch (Exception $err) {
                $response['error'][] = $err->getMessage();
                error_log($err->getMessage());
            }
            
        } else {
            $response['error'][] = 'no_db';
        }

    } else {
        $response['error'][] = 'fields_incorrect';
    }

    echo json_encode($response);
    exit();
?>
