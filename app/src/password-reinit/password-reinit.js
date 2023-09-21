const form = document.querySelector('form');
const password = document.querySelector('input#password');
const pwRepeat = document.querySelector('input#pw_repeat');

form.addEventListener('submit', function (e) {
    e.preventDefault();
    password.classList.remove('is-invalid');
    pwRepeat.classList.remove('is-invalid');
    if (form.checkValidity()) {

        const formData = new FormData(form);

        fetch('./new-password.php', {
            method: "POST",
            body: formData
        })
        .then(res => {
            if (!res.ok) {
                throw new Error('Server error');
            }
            return res.json();
        })
        .then(data => {
            if (data === 'true') {
                location.href = '../index.php?pw=changed';
            }
        })

    } else {
        if (password.checkValidity() && password.value !== pwRepeat.value) {
            pwRepeat.classList.add('is-invalid');
        } else {
            password.classList.add('is-invalid');
        }
    }
})