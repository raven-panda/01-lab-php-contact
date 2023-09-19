class Session {
    /**
     * Déconnexion - Redirige l'utilisateur vers la page logout pour purger la session
     * @param {Boolean|String} timeout Définir pourquoi l'utilisateur a été déconnécté
     */
    logout(reason = false) {
        window.location.href = `../session/logout.php?reason=${reason}`;
    }

    /**
     * Vérifie si le token est toujours valide, et remets à jour l'hordotage d'expiration
     */
    checkAndUpdateTokenValidity() {
        fetch('../session/update-session.php', {
            method: 'PATCH',
            headers: {
                'Content-Type': 'application/json',
            },
            body: JSON.stringify(this.getTokenTimeout())
        })
        .then(res => {
            if (!res.ok) {
                throw new Error("Server error");
            }
            return res.json();
        })
        .then(data => {
            if (data.context === 'invalid_token') {
                this.logout(data.context);
            } else if (data.new_timeout) {
                tokenField.value = data.new_timeout;
            }
        })
    }

    /**
     * Récupère l'expiration du token.
     * @returns L'horodatage UNIX de l'expiration du token
     */
    getTokenTimeout() {
        const value = tokenField.value;
        return value;
    }
}

function addContact(data) {
    fetch('../_library/php/add-contact.php', {
        method: 'POST',
        body: data
    })
    .then(res => {
        if (!res.ok) {
            throw new Error('Server error');
        }
        return res.json();
    })
    .then(data => {
        contactsList.innerHTML = data.context;
        console.log(data);
    })
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

const addContactForm = document.querySelector('#add-contact-form'), 
      contactsList = document.querySelector('#contacts-list tbody');

session.checkAndUpdateTokenValidity();

// Tout ce qui doit être déclenché quand l'utilisateur clique
document.addEventListener('click', function(e) {
    if (e.target.classList.contains('logout')) {
        session.logout('by_user');
    } else {
        console.log(e.target);
        
        // Affiche/cache le menu déroulant 'Mon Compte' quand le clic est sur celui ci (desktop) ou sur le burger (mobile)
        if (e.target === burger || burger.contains(e.target) || e.target === ddBtn || ddMenu.classList.contains('show') && !ddMenu.contains(e.target)) {
            
            ddMenu.classList.toggle('show');
            dropdown.classList.toggle('show');

            if (window.matchMedia('(max-width: 992px)').matches) {
                burger.classList.toggle('show');
                navCol.classList.toggle('show');
            }

        }

        //session.checkAndUpdateTokenValidity();
    }
})

addContactForm.addEventListener('submit', function (e) {
    e.preventDefault();
    if (addContactForm.checkValidity()) {
        const formData = new FormData(addContactForm);
        addContact(formData);
    }
})