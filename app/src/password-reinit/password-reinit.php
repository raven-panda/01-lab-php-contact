<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <script src="./password-reinit.js" defer></script>
    <title>Réinitialiser mon mot de passe - Contacts</title>
</head>
<body>
    <main id="app" class="container mt-5">
        <h2>Réinitialisation de mon mot de passe</h2>
        <?php
        include '../_library/php/functions.php';
        if ($_SERVER['REQUEST_METHOD'] === "GET"
            && isset($_GET['key']) && isset($_GET['email']) && isset($_GET['action'])
            && !empty($_GET['key']) && !empty($_GET['email']) && $_GET['action'] === 'reset') {

                $email = filter_var($_GET['email'], FILTER_VALIDATE_EMAIL);
                $key = htmlspecialchars($_GET['key']);

                if ($email && $key) {
                    
                        $row = getKeysForPasswordReinit($key, $email);

                        if ($row && $row['key'] === $key && $row['expiracy'] > time()) {
                            ?>
                                <p>Entrez votre nouveau mot de passe.</p>
                                <form action="" method="POST" novalidate>
                                    <!-- Champ : Mot de passe -->
                                    <div class="form-group">
                                        <label for="password">Saisissez votre nouveau mot de passe :</label>
                                        <input type="password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*])(?!.*\s).{8,}$" class="form-control" id="password" name="password" value="" required>
                                        <div class="invalid-feedback">Votre mot de passe doit faire au moins 8 caractères et comporter une ou des majuscule(s), minuscule(s), chiffre(s) et caractères spéciaux : !@#$%^&*</div>
                                    </div>

                                    <!-- Champ : Confirmation mot de passe -->
                                    <div class="form-group">
                                        <label for="pw_repeat">Confirmez votre nouveau mot de passe :</label>
                                        <input type="password" pattern="^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#$%^&*])(?!.*\s).{8,}$" class="form-control" id="pw_repeat" name="pw_repeat" value="" required>
                                        <div class="invalid-feedback">Les mots de passes sont différents</div>
                                    </div>

                                    <input type="hidden" name="email" value="<?php echo $email; ?>">
                                    <input type="hidden" name="key" value="<?php echo $key; ?>">

                                    <!-- Bouton d'envoi -->
                                    <button type="submit" class="btn btn-primary">Réinitialiser le mot de passe</button>
                                </form>
                            <?php  
                        } else {
                            echo '<p>Votre lien a expiré. Veuillez recommencer.</p>';
                        }
                } else {
                    echo json_encode('invalid');
                }
            } else {
                header('HTTP/1.0 404 Not Found');
            }
        ?>
    </main>
</body>
</html>


