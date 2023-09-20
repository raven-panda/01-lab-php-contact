<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        include '../_library/php/functions.php';
        
        $response = array(
            'valid' => 'false',
            'error' => []
        );
    
        if (isset($_POST['email']) && isset($_POST['password'])
        && !empty($_POST['email']) && !empty($_POST['password'])) {
    
            /* Makes a token that will last until the session ends */
            function token_session($conn, $creds) {
    
                $token = bin2hex(random_bytes(32));
    
                $_SESSION['token'] = $token;
    
                $sql = 'UPDATE user SET token = :token WHERE email = :email';
                $sth = $conn->prepare($sql);
    
                $sth->bindParam(':email', $creds, PDO::PARAM_STR);
                $sth->bindParam(':token', $token, PDO::PARAM_STR);
    
                $sth->execute();
    
            }

            /* Makes a remember me token */
            function token_remember($conn, $creds) {
    
                $token = bin2hex(random_bytes(32));
                $tokieTimeout = time() + (3600 * 72);

                setcookie('token', $token, $tokieTimeout, '/', 'php-dev-1.online', false, true);
    
                $sql = 'UPDATE user SET token = :token, tokie_time = :tokie_time WHERE email = :email';
                $sth = $conn->prepare($sql);
    
                $sth->bindParam(':email', $creds, PDO::PARAM_STR);
                $sth->bindParam(':token', $token, PDO::PARAM_STR);
                $sth->bindParam(':tokie_time', $tokieTimeout, PDO::PARAM_STR);
    
                $sth->execute();
    
            }
            
            time_sleep_until(time() + 1);

            $mysqlConnection = databaseConnection();
    
            if ($mysqlConnection) {
        
                $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                $password = htmlspecialchars($_POST['password']);
        
                try {
        
                    $sql = 'SELECT firstname, name, email, password, token, tokie_time FROM user WHERE email = :email';
                    $sth = $mysqlConnection->prepare($sql);
        
                    $sth->bindParam(':email', $email, PDO::PARAM_STR);
        
                    $sth->execute();
        
                    $result = $sth->fetch(PDO::FETCH_ASSOC);
        
                    if ($result && password_verify($password, $result['password'])) {
                        if (isset($_POST['rememberMe'])) {
                            token_remember($mysqlConnection, $email);
                        } else {
                            token_session($mysqlConnection, $email);
                        }

                        $firstname = $result['firstname'];
                        $name = $result['name'];
    
                        $response['valid'] = 'true';
                    } else {
                        $response['error'] = 'no_creds';
                    }
        
                } catch (Exception $err) {
                    $response['error'] = $err->getMessage();
                    error_log($err->getMessage());
                }
                
            } else {
                $response['error'] = 'no_db';
            }
    
        } else {
            $response['error'] = 'fields_incorrect';
        }

        echo json_encode($response);
        exit();
    } else {
        header('HTTP/1.0 404 Not Found');
        exit();
    }

?>
