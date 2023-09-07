const form = document.querySelector('form');

form.addEventListener('submit', e => {
    if (form.checkValidity() === true) {
        e.preventDefault()
        const formdata = new FormData(form);
        fetch('./signup.php', {
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
                window.location.href = 'http://localhost/index.html';
            } else {
                console.log(data);
            }
        })
        .catch(error => {
            console.error('Erreur lors de la requête AJAX : ', error);
        });
    } else {
        e.preventDefault()
    }
});