<?php
    session_start();

    $dsn = 'mysql:host=database;dbname='. getenv('MYSQL_DATABASE') .';charset=utf8';
    $mysqlConnection = new PDO($dsn, getenv('MYSQL_USER'), getenv('MYSQL_PASSWORD'));

    if (isset($_SESSION['token']) && isset($_SESSION['token_time']) && !empty($_SESSION['token']) && !empty($_SESSION['token_time'])) {
        try {
            $sql = 'SELECT email, password, token, token_time FROM user WHERE token = :token';
            $sth = $mysqlConnection->prepare($sql);
        
            $sth->bindParam(':token', $_SESSION['token'], PDO::PARAM_STR);
        
            $sth->execute();
    
            $row = $sth->fetch(PDO::FETCH_ASSOC);

            if ($row['token'] === $_SESSION['token'] || $row['token_time'] >= time()) {
                $email = $row['email'];
                $password = $row['password'];
    
                header('Location: http://localhost/dashboard/dashboard.php');
            } else {
                unset($_SESSION['token'], $_SESSION['token_time']);
            }
        } catch (Exception $e) {
            echo $e;
        }
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Connexion</title>
    <!-- Inclure les styles Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="./style.css">
    <script src="./index.js" defer></script>
    <noscript>You need javascript to run this app</noscript>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-light bg-light">
    <a class="navbar-brand" href="#">Mon Site</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarNav">
        <ul class="navbar-nav ml-auto">            
            <li class="nav-item">
                <a class="nav-link" href="./signup/signup.html">S'inscrire</a>
            </li>
        </ul>
    </div>
</nav>

<div class="container mt-5">
    <h2>Formulaire de Connexion</h2>
    <form action="#" method="POST" novalidate>
        <!-- Champ : Adresse e-mail -->
        <div class="form-group">
            <label for="email">Adresse e-mail</label>
            <input type="email" class="form-control" id="email" name="email" required>
            <div class="invalid-feedback"></div>
        </div>

        <!-- Champ : Mot de passe -->
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" required>
            <div class="invalid-feedback"></div>
        </div>

        <!-- Option : Se souvenir de moi -->
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="rememberMe" name="rememberMe">
            <label id="custom" class="form-check-label" for="rememberMe">Se souvenir de moi</label>
        </div>

        <!-- Lien : Mot de passe oublié -->
        <div class="form-group">
            <a href="#">Mot de passe oublié ?</a>
        </div>

        <!-- Bouton d'envoi -->
        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>
</div>

<!-- Inclure les scripts Bootstrap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
