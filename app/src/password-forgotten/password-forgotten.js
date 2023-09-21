const formgotten = document.querySelector('#formgotten');

formgotten.addEventListener('submit', function (e) {
    e.preventDefault();
    console.log(e.target);
    if (formgotten.checkValidity()) {
        const formData = new FormData(formgotten);

        fetch('./password-forgotten.php', {
            method: 'POST',
            body: formData
        })
        .then(res => {
            if (!res.ok) {
                throw new Error('Server error');
            }
            return res.json();
        })
        .then(data => {
            console.log(data);
        })

        document.body.classList.add('sent');
    } else {
        formgotten.classList.add('was-validated');
    }
})