<?php
    include '../_library/php/functions.php';

    // Récupération des infos nécéssaires au fonctionnement de l'application.
    $token = getToken();
    $user = getUser();

    // Vérifie qu'un jeton est bien en place pour valider la connection (automatique ou non).
    if (!check_session_state() && !check_remember_state() || !$token || !$user) {
        header('Location: http://'. $_SERVER["HTTP_HOST"] .'/session/logout.php?reason=invalid_token');
    } else {
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tableau de Bord - Gestion des Contacts</title>
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <link rel="stylesheet" href="../style.css">
    <script src="dashboard.js" defer></script>
    <noscript>
        <h1>You need javascript to run this app</h1>
        <style>.navbar, div { display: none; }</style>
    </noscript>
</head>
<body>
    <!-- Header and Account Dropdown Menu -->
    <nav class="navbar navbar-expand-lg navbar-light bg-light">
        <a class="navbar-brand" href="#">Mon Tableau de Bord</a>
        <button id="burger-menu" class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarNav" aria-controls="navbarNav" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarNav">
            <ul class="navbar-nav ml-auto">
                <li id="account-settings" class="nav-item dropdown">
                    <button id="account-menu-btn" class="btn btn-secondary dropdown-toggle" type="button" id="dropdownMenuButton" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                        Mon compte
                    </button>
                    <div id="account-menu" class="dropdown-menu dropdown-menu-right" aria-labelledby="navbarDropdownMenuLink">
                        <div class="dropdown-item-text custom">
                            <div class="custom-box">
                                <div class="user-infos">
                                    <?php
                                        echo '<p>'. $user['firstname'] .' '. $user['name'] .'</p>';
                                        echo '<p class="text-muted">'. $user['email'] .'</p>';
                                    ?>
                                </div>
                                <svg xmlns="http://www.w3.org/2000/svg" width="48" height="48" viewBox="4 4 40 40">
                                    <path d="M24 4c-11.05 0-20 8.95-20 20s8.95 20 20 20 20-8.95 20-20-8.95-20-20-20zm0 6c3.31 0 6 2.69 6 6 0 3.32-2.69 6-6 6s-6-2.68-6-6c0-3.31 2.69-6 6-6zm0 28.4c-5.01 0-9.41-2.56-12-6.44.05-3.97 8.01-6.16 12-6.16s11.94 2.19 12 6.16c-2.59 3.88-6.99 6.44-12 6.44z"/>
                                </svg>
                            </div>
                        </div>
                        <div class="actions">
                            <a class="dropdown-item logout" href="../session/logout.php?reason=by_user">Se déconnecter</a>
                        </div>
                    </div>
                </li>
            </ul>
        </div>
    </nav>

    <!-- Main Container -->
    <div class="container mt-5">
        <h2>Tableau de Bord - Gestion des Contacts</h2>
        <p>Bienvenue dans votre tableau de bord de gestion des contacts. Vous pouvez ajouter, modifier ou supprimer des contacts ici.</p>
        <div class="row">
            <div class="col-md-6">
                <!-- Add contact form -->
                <form id="add-contact-form" name="add-contact-form" action="../_library/php/add-contact.php" method="post">
                    <div class="form-group">
                        <label for="nom">Nom</label>
                        <input type="text" class="form-control" id="nom" name="nom" required>
                    </div>
                    <div class="form-group">
                        <label for="prenom">Prénom</label>
                        <input type="text" class="form-control" id="prenom" name="prenom" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Adresse e-mail</label>
                        <input type="email" pattern="^[\w\-\.]+@([\w\-]+\.)+[\w\-]{2,}$" class="form-control" id="email" name="email" required>
                    </div>
                    <button type="submit" class="btn btn-primary">Ajouter Contact</button>
                </form>
                <input type="hidden" name="tokexp" id="tokexp" value="<?php echo $token_to; ?>">
            </div>
            <div class="col-md-6">
                <!-- Contacts list -->
                <h3>Liste des Contacts</h3>
                <ul id="contacts-list" class="list-group">
                    <?php
                        // Ajout des contacts à l'interface.
                        $contacts = getUserContacts();
                        if ($contacts === 'no_contacts') {
                            echo '<li class="list-group-item">Aucun contacts. Veuillez en ajouter.</li>';
                        } else {
                            foreach($contacts as $row) {
                                echo '<li class="list-group-item">'. $row['firstname'] .' '. $row['name'] .' - '. $row['email'] .'</li>';
                            }
                        }

                    ?>
                </ul>
            </div>
        </div>
    </div>
    <!-- Bootstrap scripts -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
<?php
    }
?>