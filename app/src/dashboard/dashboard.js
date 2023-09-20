class Session {
    /**
     * Déconnexion - Redirige l'utilisateur vers la page logout pour purger la session
     * @param {Boolean|String} timeout Définir pourquoi l'utilisateur a été déconnécté
     */
    logout(reason = false) {
        window.location.href = `../session/logout.php?reason=${reason}`;
    }
}

// Instanciation de la classe Session
const session = new Session();

// Récupération des éléments interactifs
const dropdown = document.querySelector('#account-settings'),
      ddBtn = document.querySelector('#account-menu-btn'),
      ddMenu = document.querySelector('#account-menu');

const burger = document.querySelector('#burger-menu'),
      navCol = document.querySelector('#navbarNav');

const tokenField = document.querySelector('#tokexp');

const addContact = document.querySelector('#add-contact-form');

// Tout ce qui doit être déclenché quand l'utilisateur clique
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('logout')) {
        session.logout('by_user');
    } else {
        
        // Affiche/cache le menu déroulant 'Mon Compte' quand le clic est sur celui ci (desktop) ou sur le burger (mobile)
        if (e.target === burger || burger.contains(e.target) || e.target === ddBtn || ddMenu.classList.contains('show') && !ddMenu.contains(e.target)) {
            
            ddMenu.classList.toggle('show');
            dropdown.classList.toggle('show');

            if (window.matchMedia('(max-width: 992px)').matches) {
                burger.classList.toggle('show');
                navCol.classList.toggle('show');
            }

        }
    }
})