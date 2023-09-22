<?php
    include '../_library/php/functions.php';
    if ($_SERVER['REQUEST_METHOD'] === 'POST') {
        $token = getToken();

        if (isset($_POST['nom']) && isset($_POST['prenom']) && isset($_POST['email'])
            && !empty($_POST['nom']) && !empty($_POST['prenom']) && !empty($_POST['email'])
            && $token !== false) {
        
            $lastname = htmlspecialchars($_POST['nom']);
            $firstname = htmlspecialchars($_POST['prenom']);
            $email = htmlspecialchars($_POST['email']);
            $user_email = htmlspecialchars(getUser()['email']);

            try {

                $mysqlConnection = databaseConnection();

                $sql = 'INSERT INTO contact (name, firstname, email, user_email) VALUES (:lastname, :firstname, :email, :user_email)';
                
                $sth = $mysqlConnection->prepare($sql);

                $sth->bindParam(':lastname', $lastname, PDO::PARAM_STR);
                $sth->bindParam(':firstname', $firstname, PDO::PARAM_STR);
                $sth->bindParam(':email', $email, PDO::PARAM_STR);
                $sth->bindParam(':user_email', $user_email, PDO::PARAM_STR);

                $sth->execute();

                header('Location: http://'. $_SERVER["HTTP_HOST"] .'/dashboard/dashboard.php');

            } catch (Exception $err) {
                echo json_encode($err->getMessage());
            }

        } else {
            echo 'non';
        }

    } else {
        http_response_code(404);
        exit();
    }
?>