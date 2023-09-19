<?php
    session_start();
    function check_session_state() {
        if (isset($_SESSION['token']) && !empty($_SESSION['token']) && isset($_SESSION['token_time']) && !empty($_SESSION['token_time']) && $_SESSION['token_time'] > time()) {
            return true;
        } else {
            return false;
        }
    }
    function check_remember_state() {
        if (isset($_COOKIE['token']) && !empty($_COOKIE['token'])) {
            return true;
        } else {
            return false;
        }
    }

    function getToken() {
        if (isset($_COOKIE['token']) && !empty($_COOKIE['token'])) {
            return $_COOKIE['token'];
        } else if (isset($_SESSION['token']) && !empty($_SESSION['token'])) {
            return $_SESSION['token'];
        } else {
            return false;
        }
    }

    function getUser() {
        $token = getToken();

        $mysqlHost = getenv('MYSQL_HOST');
        $mysqlDb = getenv('MYSQL_DATABASE');
        $mysqlUser = getenv('MYSQL_USER');
        $mysqlPw = getenv('MYSQL_PASSWORD');

        try {
            $dsn = 'mysql:host='. $mysqlHost .';dbname='. $mysqlDb .';charset=utf8';
            $mysqlConnection = new PDO($dsn, $mysqlUser, $mysqlPw);
    
            $sql = 'SELECT firstname, name, email FROM user WHERE token = :token';
            $sth = $mysqlConnection->prepare($sql);
            $sth->bindParam(':token', $token, PDO::PARAM_STR);
    
            $sth->execute();

            $result = $sth->fetch(PDO::FETCH_ASSOC);

            return $result;
        } catch (Exception $err) {
            return $err;
        }

    }

    function getContacts() {
        $token = getToken();

        $mysqlHost = getenv('MYSQL_HOST');
        $mysqlDb = getenv('MYSQL_DATABASE');
        $mysqlUser = getenv('MYSQL_USER');
        $mysqlPw = getenv('MYSQL_PASSWORD');

        try {
            $dsn = 'mysql:host='. $mysqlHost .';dbname='. $mysqlDb .';charset=utf8';
            $mysqlConnection = new PDO($dsn, $mysqlUser, $mysqlPw);
    
            $sql = 'SELECT firstname, name, email FROM contact WHERE user_email = (SELECT email FROM user WHERE token = :token)';
            $sth = $mysqlConnection->prepare($sql);
            $sth->bindParam(':token', $token, PDO::PARAM_STR);
    
            $sth->execute();

            $contacts = array();
            $result = '';

            while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
                $contacts[] = $row;
            }
            
            if (!empty($contacts)) {
                foreach ($contacts as $contact) {
                    $firstname = $contact['firstname'];
                    $name = $contact['name'];
                    $email = $contact['email'];
    
                    $result .= '<tr><td>'. $name .'</td><td>'. $firstname .'</td><td>'. $email .'</td><td class="actions-clmn"><button class="btn p-0"><span class="delete-contact"></span></button><button class="btn p-0"><span class="edit-contact"></span></button></td></tr>';
                }
            } else {
                $result .= '<tr><td>Aucun contacts à afficher.</td></tr>';
            }


            return $result;
        } catch (Exception $err) {
            return $err;
        }
    }
?>