const form = document.querySelector('form');
const inputs = form.querySelectorAll('input');
const feedback = form.querySelector('#email + .invalid-feedback');

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
                console.log('yessss');
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