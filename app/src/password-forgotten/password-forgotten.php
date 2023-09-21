<?php
    include '../_library/php/functions.php';
    if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['email'])) {
        $email = 'noreply@php-dev-1-contacts.online';
        $user_email = htmlspecialchars($_POST['email']);

        // Vérification de l'email
        if (filter_var($user_email, FILTER_VALIDATE_EMAIL)) {
            $mysqlConnection = databaseConnection();

            $sql = 'SELECT firstname, name, email FROM user WHERE email = :email';
            $sth = $mysqlConnection->prepare($sql);

            $sth->bindParam(':email', $user_email, PDO::PARAM_STR);

            $sth->execute();

            $row = $sth->fetch(PDO::FETCH_ASSOC);

            if ($row) {
                
                $key = bin2hex(random_bytes(32));
                $expiracy = time() + (15 * 60);

                $sql = "INSERT INTO pw_reset (email, `key`, expiracy) VALUES (:email, :key, :expiracy)";
                $sth = $mysqlConnection->prepare($sql);

                $sth->bindParam(':email', $user_email, PDO::PARAM_STR);
                $sth->bindParam(':key', $key, PDO::PARAM_STR);
                $sth->bindParam(':expiracy', $expiracy, PDO::PARAM_STR);

                $sth->execute();
                
                //=-=-=-=-Email-=-=-=-=//
                $firstname = htmlspecialchars($row['firstname']);
                $name = htmlspecialchars($row['name']);

                $object = 'Réinitialisation de votre mot de passe - Contacts';
                $message = "
                    <p>Cher(e) ". $firstname . " ". $name .",</p>
                    <p>Vous recevez cet e-mail car vous avez demandé la réinitialisation de votre mot de passe sur notre site. Si vous n'avez pas fait cette demande, veuillez ignorer cet e-mail.</p>
                    <p>Pour réinitialiser votre mot de passe, veuillez cliquer sur <a href=\"http://php-dev-1.online/password-reinit/password-reinit.php?key=". $key ."&email=". $user_email ."&action=reset\">ce lien</a>, il est valide pendant 15 minutes après récéption de ce mail.</p>
                    <p>Ce lien sera valide pendant 24 heures. Après cette période, vous devrez en demander un nouveau.</p>
                    <p>Gardez cet e-mail en sécurité et ne partagez pas le lien de réinitialisation avec d'autres personnes.</p>";

                $boundary = md5(uniqid(microtime(), TRUE));

                // En-tête
                $headers = 'From: ' . $email . "\r\n";
                $headers .= "MIME-Version: 1.0\r\n";
                $headers .= 'Content-Type: multipart/form-data;boundary='.$boundary."\r\n";
                $headers .= "\r\n";

                // Objet & message
                $msg = '--'. $boundary ."\r\n";
                $msg .= "Content-Type: text/html;charset=utf-8\r\n\r\n";
                $msg .= '<h1>' . $object . '</h1>';
                $msg .= $message . "\r\n";

                $msg .= '--'.$boundary;

                mail($user_email, $object, $msg, $headers);
                
                echo json_encode('sent');

            } else {
                echo json_encode('sent');
            }

        } else {
            echo json_encode('email_format_invalid');
        }

    } else {
        header('HTTP/1.0 404 Not Found');
    }
?>