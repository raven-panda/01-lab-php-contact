<?php
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password_repeat'])
    && !empty($_POST['prenom']) && !empty($_POST['nom']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password_repeat']))
    {
        // Name fields
        $firstname = htmlspecialchars($_POST['prenom']);
        $name = htmlspecialchars($_POST['nom']);

        // Email
        $email = filter_var($_POST['email'], FILTER_SANITIZE_EMAIL);
        $emailValid = preg_match('/^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,}$/', $email);
        
        // Passwords
        $password = htmlspecialchars($_POST['password']);
        $pwRepeat = htmlspecialchars($_POST['password_repeat']);
        $pwSecure = preg_match('/^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*])(?!.*\s).{8,}$/', $password);
        $pwSame = $password === $pwRepeat;

        if ($emailValid) {
            if ($pwSame) {
                try {

                    $dsn = 'mysql:host=database;dbname='. getenv('MYSQL_DATABASE') .';charset=utf8';
                    $mysqlConnection = new PDO($dsn, getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'));

                    $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
            
                    $sql = 'INSERT INTO user (name, firstname, email, password, token, token_time, signup_date) VALUES (:nom, :prenom, :email, :password, "0", "0", CURDATE());';
                    $sth = $mysqlConnection->prepare($sql);
            
                    $sth->bindParam(':nom', $_POST['nom'], PDO::PARAM_STR);
                    $sth->bindParam(':prenom', $_POST['prenom'], PDO::PARAM_STR);
                    $sth->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
                    $sth->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
            
                    $sth->execute();
            
                } catch (Exception $e) {
                    if ($e->getCode() === '23000') {
                        echo 'Adresse email déjà utilisée.';
                    } else {
                        echo 'JSP';
                    }
                }
            } else {
                echo 'Les mots de passes correspondent pas.';
            }
        } else {
            echo "Ce n'est pas un email.";
        }

    } else {
        echo 'Champs incorrects.';
    }
    
    exit();
?>