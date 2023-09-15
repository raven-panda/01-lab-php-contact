<?php
    include '../_library/php/functions.php';

    if ($_SERVER['REQUEST_METHOD'] === 'PATCH') {

        $response = array(
            'valid' => 'false'
        );

        $mysqlHost = getenv('MYSQL_HOST');
        $mysqlDb = getenv('MYSQL_DATABASE');
        $mysqlUsr = getenv('MYSQL_USER');
        $mysqlPw = getenv('MYSQL_PASSWORD');

        $dsn = 'mysql:host='. $mysqlHost .';dbname='. $mysqlDb .';charset=utf8';
        $mysqlConnection = new PDO($dsn, $mysqlUsr, $mysqlPw);
        
        if (check_session_state()) {
            session_regenerate_id(true);
            $token = $_SESSION['token'];
            $tokenTimeout = time() + ini_get('session.gc_maxlifetime');
            $_SESSION['token_time'] = $tokenTimeout;
                
            try {

                $sql = 'UPDATE user SET token_time = :token_time WHERE token = :token';
                $sth = $mysqlConnection->prepare($sql);
    
                $sth->bindParam(':token_time', $tokenTimeout);
                $sth->bindParam(':token', $token);
    
                $sth->execute();

                $response['valid'] = 'true';
                $response['new_timeout'] = $tokenTimeout;
            } catch (Exception $err) {
                $response['context'] = ['server_error' , $err->getCode()];
            }
    
        } else {
            $response['context'] = 'invalid_token';

            try {
                $sql = 'UPDATE user SET token_time = "0" WHERE token = "0"';
                $sth = $mysqlConnection->prepare($sql);
    
                $sth->execute();
            } catch (Exception $err) {
                $response['context'] = ['server_error', $err->getCode()];
            }
            
        }
    
        echo json_encode($response);
        exit();
    } else {
        header('HTTP/1.0 404 Not Found');
    };

?>