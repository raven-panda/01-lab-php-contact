<?php
include '../_library/php/functions.php';
if ($_SERVER['REQUEST_METHOD'] === "POST"
    && isset($_POST['password']) && isset($_POST['pw_repeat']) && isset($_POST['email']) && isset($_POST['key'])
    && !empty($_POST['password']) && !empty($_POST['pw_repeat']) && !empty($_POST['email']) && !empty($_POST['key'])) {

        $password = htmlspecialchars($_POST['password']);
        $pw_repeat = htmlspecialchars($_POST['pw_repeat']);
        $key = htmlspecialchars($_POST['key']);
        $email = filter_var($_POST['email'], FILTER_VALIDATE_EMAIL);

        if ($password === $pw_repeat) {

            $mysqlConnection = databaseConnection();

            $row = getKeysForPasswordReinit($key, $email);

            if ($row) {
                $new_password = password_hash($password, PASSWORD_DEFAULT);

                $sql = "UPDATE user SET `password` = :new_password, token = 0, tokie_time = 0;
                        DELETE FROM pw_reset WHERE email = :email;";
                $sth = $mysqlConnection->prepare($sql);
                
                $sth->bindParam(':new_password', $new_password, PDO::PARAM_STR);
                $sth->bindParam(':email', $email, PDO::PARAM_STR);
                
                $sth->execute();

                session_destroy();
                setcookie('token', '');
    
                echo json_encode('true');
            } else {
                echo json_encode('no');
            }

        } else {
            echo json_encode('password_different');
        }
    } else {
        header('HTTP/1.0 403 Forbidden');
    }
?>