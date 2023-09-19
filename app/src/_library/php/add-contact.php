<?php
    include './functions.php';

    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $response = array(
            'valid' => 'false'
        );
    
        if (isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['email'])
        && !empty($_POST['prenom']) && !empty($_POST['nom']) && !empty($_POST['email'])) {
    
            $mysqlHost = getenv('MYSQL_HOST');
            $mysqlDb = getenv('MYSQL_DATABASE');
            $mysqlUser = getenv('MYSQL_USER');
            $mysqlPw = getenv('MYSQL_PASSWORD');
    
            if ($mysqlHost && $mysqlDb && $mysqlUser && $mysqlPw) {
    
                $dsn = 'mysql:host='. $mysqlHost .';dbname='. $mysqlDb .';charset=utf8';
                $mysqlConnection = new PDO($dsn, $mysqlUser, $mysqlPw);
        
                $firstname = htmlspecialchars($_POST['prenom']);
                $name = htmlspecialchars($_POST['nom']);
                $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
                $user_email = getUser()['email'];
        
                try {

                    $sqlAdd = 'INSERT INTO contact (firstname, name, email, user_email) VALUES (:firstname, :name, :email, :user_email)';
                    $sqlFetch = 'INSERT INTO user_contact (user_id, contact_id) VALUES ((SELECT id FROM user WHERE email = :user_email), (SELECT id FROM contact WHERE email = :email AND user_email = :user_email ORDER BY id DESC LIMIT 1))';

                    $sth = $mysqlConnection->prepare($sqlAdd);
                    $sth->bindParam(':firstname', $firstname, PDO::PARAM_STR);
                    $sth->bindParam(':name', $name, PDO::PARAM_STR);
                    $sth->bindParam(':email', $email, PDO::PARAM_STR);
                    $sth->bindParam(':user_email', $user_email, PDO::PARAM_STR);

                    $sth->execute();

                    $sth = $mysqlConnection->prepare($sqlFetch);
                    $sth->bindParam(':email', $email, PDO::PARAM_STR);
                    $sth->bindParam(':user_email', $user_email, PDO::PARAM_STR);
                    $sth->execute();

                    $response['valid'] = true;
                    $response['context'] = getContacts();
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
