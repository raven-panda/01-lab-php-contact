// Récupération des éléments interactifs
const dropdown = document.querySelector('#account-settings'),
      ddBtn = document.querySelector('#account-menu-btn'),
      ddMenu = document.querySelector('#account-menu');

const burger = document.querySelector('#burger-menu'),
      navCol = document.querySelector('#navbarNav');

// Tout ce qui doit être déclenché quand l'utilisateur clique
document.addEventListener('click', function(e) {  
    // Affiche/cache le menu déroulant 'Mon Compte' quand le clic est sur celui ci (desktop) ou sur le burger (mobile)
    if (e.target === burger || burger.contains(e.target) || e.target === ddBtn || ddMenu.classList.contains('show') && !ddMenu.contains(e.target)) {
        
        ddMenu.classList.toggle('show');
        dropdown.classList.toggle('show');

        if (window.matchMedia('(max-width: 992px)').matches) {
            burger.classList.toggle('show');
            navCol.classList.toggle('show');
        }

    }
})