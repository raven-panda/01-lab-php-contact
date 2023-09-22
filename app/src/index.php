<?php
    include './_library/php/functions.php';

    // Vérifie si il y a déjà une session active ou un jeton de connexion pou
    if (check_session_state() || check_remember_state()) {
        header('Location: http://'. $_SERVER['HTTP_HOST'] .'/session/auto-login.php');
    }
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Formulaire de Connexion</title>
    <!-- Inclure les styles Bootstrap -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="style.css">
    <script src="./index.js" type="module" defer></script>
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
            <input type="email" pattern="^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,}$" class="form-control" id="email" name="email" value="jean.cricri@hotmail.fr" required>
            <div class="invalid-feedback">Veuillez remplir ce champ</div>
        </div>

        <!-- Champ : Mot de passe -->
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" class="form-control" id="password" name="password" required>
            <div class="invalid-feedback">Veuillez remplir ce champ</div>
        </div>

        <!-- Option : Se souvenir de moi -->
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="rememberMe" name="rememberMe">
            <label id="custom" class="form-check-label" for="rememberMe">Se souvenir de moi</label>
        </div>

        <!-- Lien : Mot de passe oublié -->
        <div class="form-group">
            <a href="./password-forgotten/password-forgotten.html">Mot de passe oublié ?</a>
        </div>

        <!-- Bouton d'envoi -->
        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>
</div>

<div class="modal logout" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-modal="true" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Vous avez été déconnecté</h5>
      </div>
      <div class="modal-body">
        <p>Votre session a expiré en raison d'une inactivité prolongée.</p>
        <p>Veuillez vous reconnecter pour continuer à utiliser l'application.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal-lo">Close</button>
      </div>
    </div>
  </div>
</div>
<div class="modal pw-changed" id="exampleModalCenter" tabindex="-1" aria-labelledby="exampleModalCenterTitle" aria-modal="true" role="dialog">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalCenterTitle">Mot de passe changé avec succès</h5>
      </div>
      <div class="modal-body">
        <p>Votre mot de passe a bien été changé.</p>
        <p>Vous pouvez vous connecter avec votre nouveau mot de passe.</p>
      </div>
      <div class="modal-footer">
        <button type="button" class="btn btn-secondary" data-dismiss="modal-pw">Close</button>
      </div>
    </div>
  </div>
</div>
<!-- Inclure les scripts Bootstrap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>

</body>
</html>
