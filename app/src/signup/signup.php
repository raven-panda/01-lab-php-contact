<?php
    $response = array(
        'ok' => 'true',
        'error' => 'none',
    );

    if (isset($_POST['prenom']) && isset($_POST['nom']) && isset($_POST['email']) && isset($_POST['password']) && isset($_POST['password_repeat'])
    && !empty($_POST['prenom']) && !empty($_POST['nom']) && !empty($_POST['email']) && !empty($_POST['password']) && !empty($_POST['password_repeat']))
    {
        if ($_POST['password'] === $_POST['password_repeat']) {
            //var_dump($_POST);
            $dsn = 'mysql:host=database;dbname='. $_ENV['MYSQL_DATABASE'] .';charset=utf8';
            $mysqlConnection = new PDO($dsn, $_ENV['MYSQL_USER'], $_ENV['MYSQL_PASSWORD']);

            try {

                $hashedPassword = password_hash($_POST['password'], PASSWORD_DEFAULT);

                $sql = 'INSERT INTO user (name, firstname, email, password, date) VALUES (:nom, :prenom, :email, :password, CURDATE());';
                $sth = $mysqlConnection->prepare($sql);

                $sth->bindParam(':nom', $_POST['nom'], PDO::PARAM_STR);
                $sth->bindParam(':prenom', $_POST['prenom'], PDO::PARAM_STR);
                $sth->bindParam(':email', $_POST['email'], PDO::PARAM_STR);
                $sth->bindParam(':password', $hashedPassword, PDO::PARAM_STR);

                $sth->execute();

                $response['ok'] = 'true';
                $response['error'] = 'none';
                echo json_encode($response);
                exit();

            } catch (Exception $e) {
                $response['ok'] = 'false';
                $response['error'] = $e->getMessage();
            }
        } else {
            $response['ok'] = 'false';
            $response['error'] = 'password_different';
        }
    } else {
        $response['ok'] = 'false';
        $response['error'] = 'fields_incorrect';
    }

    echo json_encode($response);
    exit();
?>