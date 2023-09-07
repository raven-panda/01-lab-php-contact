const form = document.querySelector('form');
const inputs = form.querySelectorAll('input');
const feedback = form.querySelectorAll('.invalid-feedback');

form.addEventListener('submit', function (e) {
    if (form.checkValidity() === true) {
        form.classList.remove('was-validated');
        e.preventDefault();
        const formdata = new FormData(form);

        fetch('./login/login.php', {
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
            if (data.ok === "true") {
                window.location.href = 'http://localhost/dashboard/dashboard.html';
                console.log('yessss');
            } else {
                console.log(data);
                if (data.error = "creds_not_found") {
                    form.classList.add('was-validated');
                    inputs.forEach(inp => inp.value = '');
                    feedback.forEach(el=> el.textContent = "L'adresse mail ou le mot de passe est incorrect.");
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
        feedback.forEach(el => el.textContent = "Veuillez remplir ce champ");
        e.preventDefault();

    }
})