<?php
    $fieldsValidity = array(
        'valid' => 'true',
        'error' => [],
    );
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password_repeat'])
    && !empty($_POST['prenom']) && !empty($_POST['nom']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password_repeat']))
    {
        include '../_library/php/functions.php';
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
                    time_sleep_until(time() + 1);

                    $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

                    $mysqlConnection = databaseConnection();
            
                    $sql = 'INSERT INTO user (name, firstname, email, password, token, tokie_time, signup_date) VALUES (:nom, :prenom, :email, :password, "0", "0", CURDATE());';
                    $sth = $mysqlConnection->prepare($sql);
            
                    $sth->bindParam(':nom', $_POST['nom'], PDO::PARAM_STR);
                    $sth->bindParam(':prenom', $_POST['prenom'], PDO::PARAM_STR);
                    $sth->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
                    $sth->bindParam(':password', $hashedPassword, PDO::PARAM_STR);
            
                    $sth->execute();
            
                } catch (Exception $e) {
                    $fieldsValidity['valid'] = 'false';
                    if ($e->getCode() === '23000') {
                        $fieldsValidity['error'][] = 'em-ae';
                    } else {
                        $fieldsValidity['error'][] = '500';
                    }
                }
            } else {
                $fieldsValidity['valid'] = 'false';
                $fieldsValidity['error'][] = 'pw-d';
            }
        } else {
            $fieldsValidity['valid'] = 'false';
            $fieldsValidity['error'][] = 'em-p';
        }

    } else {
        $fieldsValidity['valid'] = 'false';
        $fieldsValidity['error'][] = 'fields_incorrect';
    }

    echo json_encode($fieldsValidity);
    exit();
?>