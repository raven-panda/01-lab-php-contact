const form = document.querySelector('form');
const inputs = form.querySelectorAll('input');
const feedback = form.querySelector('#email + .invalid-feedback');

const modalLogout = document.querySelector('.modal.logout');
const modalPWC = document.querySelector('.modal.pw-changed')

const logoutReason = new URLSearchParams(window.location.search);

if (logoutReason.get('logout') === 'invalid_token') {
    modalLogout.classList.add('show');
} else if (logoutReason.get('pw') === 'changed') {
    modalPWC.classList.add('show');
}

history.replaceState({}, document.title, "/");

document.addEventListener('click', function(e) {
    if (e.target.dataset.dismiss === 'modal-lo') {
        modalLogout.classList.remove('show');
    }
    if (e.target.dataset.dismiss === 'modal-pw') {
        modalPWC.classList.remove('show');
    }
})

form.addEventListener('submit', function (e) {
    e.preventDefault();
    if (form.checkValidity() === true) {
        form.classList.remove('was-validated');

        const formdata = new FormData(form);

        fetch('./session/login.php', {
            method: 'POST',
            body: formdata
        })
        .then(res => {
            if (!res.ok) {
                throw new Error("Le serveur va pas bien :(");
            }
            return res.json();
        })
        .then(data => {
            if (data.valid === "true") {
                window.location.href = './dashboard/dashboard.php';
                console.log(data);
            } else {
                console.log(data);
                if (data.error === "no_creds") {
                    form.classList.add('was-validated');
                    inputs.forEach(inp => inp.value = '');
                    feedback.textContent = "L'adresse mail ou le mot de passe est incorrect.";
                }
            }
        })
        .catch(error => {
            console.error('Erreur lors de la requête AJAX : ', error);
        });

    } else {

        form.classList.add('was-validated');
        inputs.forEach(inp => {
            if (inp.checkValidity() == false) inp.textContent = '';
        });

    }
})