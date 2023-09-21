<?php
    session_start();
    /**
     * Fonction pour connecter PHP à la BDD.
     */
    function databaseConnection() {
        
        try {
            $mysqlHost = getenv('MYSQL_HOST');
            $mysqlDb = getenv('MYSQL_DATABASE');
            $mysqlUser = getenv('MYSQL_USER');
            $mysqlPw = getenv('MYSQL_PASSWORD');
    
            $dsn = 'mysql:host='. $mysqlHost .';dbname='. $mysqlDb .';charset=utf8';
            $mysqlConnection = new PDO($dsn, $mysqlUser, $mysqlPw);
        } catch (Exception $err) {
            error_log($err->getMessage());
            $mysqlConnection = false;
        }

        return $mysqlConnection;
    }

    /**
     * Fonction pour déconnecter l'utilisateur.
     */
    function logout($reason) {
        header('Location: http://'. $_SERVER['HTTP_HOST'] .'/session/logout.php?reason='. $reason);
    }

    /**
     * Fonctions pour vérifier la validité de la connection automatique.
     */
    function check_session_state() {
        if (isset($_SESSION['token']) && !empty($_SESSION['token'])) {
            return true;
        } else {
            return false;
        }
    }
    function check_remember_state() {
        if (isset($_COOKIE['token']) && !empty($_COOKIE['token'])) {

            $token = getToken();
    
            try {

                $mysqlConnection = databaseConnection();
        
                $sql = 'SELECT token FROM user WHERE token = :token';
                $sth = $mysqlConnection->prepare($sql);
                $sth->bindParam(':token', $token, PDO::PARAM_STR);
        
                $sth->execute();
    
                $result = $sth->fetch(PDO::FETCH_ASSOC);

            } catch (Exception $err) {
                return $err;
            }

            if ($result) {
                return true;
            } else {
                return false;
            }

        } else {
            return false;
        }
    }

    /**
     * Fonctions pour récupérer des infos de connection sur l'utilisateur (jeton, infos, contacts et token de changement de mdp).
     */
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
        
        try {

            $mysqlConnection = databaseConnection();
    
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
    function getUserContacts() {
        $user_email = htmlspecialchars(getUser()['email']);

        try {

            $mysqlConnection = databaseConnection();
    
            $sql = 'SELECT firstname, name, email, user_email FROM contact WHERE user_email = :user_email';
            $sth = $mysqlConnection->prepare($sql);

            $sth->bindParam(':user_email', $user_email, PDO::PARAM_STR);
    
            $sth->execute();

            $result = array();

            while ($row = $sth->fetch(PDO::FETCH_ASSOC)) {
                $result[] = $row;
            }

            if (empty($result)) {
                $result = 'no_contacts';
            }

            return $result;

        } catch (Exception $err) {
            return $err;
        }
    }
    function getKeysForPasswordReinit($key, $email) {
        try {
            $mysqlConnection = databaseConnection();

            $sql = "SELECT email, `key`, expiracy FROM pw_reset WHERE `key` = :key AND email = :email";
            $sth = $mysqlConnection->prepare($sql);
            
            $sth->bindParam(':key', $key, PDO::PARAM_STR);
            $sth->bindParam(':email', $email, PDO::PARAM_STR);
            
            $sth->execute();
    
            $result = $sth->fetch(PDO::FETCH_ASSOC);
    
            return $result;
        } catch (Exception $err) {
            return false;
        }
    }
?>