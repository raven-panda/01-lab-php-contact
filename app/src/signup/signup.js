//=-=-=-=-=-=- Variables -=-=-=-=-=-=//
const form = document.querySelector('form');
const inputs = form.querySelectorAll('input');
const feedbacks = form.querySelectorAll('.invalid-feedback');

const email = inputs[2];
const password = inputs[3];
const pwRepeat = document.querySelector('#password_repeat');

const emailFeedback = feedbacks[2];
const pwFeedback = feedbacks[3];

//=-=-=-=-=-=- Functions -=-=-=-=-=-=//

/**
 * Checks if passwords fields have the same value given by the user.
 */
const pwSame = () => password.value === pwRepeat.value;

/**
 * Manages and returns the form validation errors.
 * 
 * Useful only for the front-end since the back return an object in response if there was errors validating the form.
 * @returns Error codes in array.
 */
function errorManager() {
    let dataError = [];
    if (email.value.length < 1) {
        dataError.push('em-l');
    } else if (email.validity.patternMismatch) {
        dataError.push('em-p');
    };

    if (password.value.length < 8) {
        dataError.push('pw-l');
    } else if (password.validity.patternMismatch) {
        dataError.push('pw-p');
    } else if (!pwSame()) {
        dataError.push('pw-d');
    };

    if (dataError.length < 1) {
        dataError = false;
    };
    
    return dataError;
}

/**
 * Changes error feedback divs to show why the form isn't valid to the user.
 * @param {Array} errors Array of the error codes defined by the errorManager() function.
 */
function fieldsError(errors) {
    inputs.forEach(el => {
        if (!el.checkValidity()) {
            el.classList.add('is-invalid');
        }
    })

    errors.forEach(error => {
        if (error === 'em-l') {
            emailFeedback.textContent = "Veuillez remplir ce champ";
        }
        if (error === 'em-p') {
            emailFeedback.textContent = "Veuillez respecter le format d'email : cool.email@example.com";
        }
        if (error === 'em-ae') {
            emailFeedback.textContent = "Cette adresse email est déjà utilisée";
            email.classList.add('is-invalid');
        }
        if (error === 'pw-d') {
            pwRepeat.classList.add('is-invalid');
        }
    })
}

//=-=-=-=-=-=- Form Event (AJAX request) -=-=-=-=-=-=//
form.addEventListener('submit', function(e) {
    e.preventDefault();
    inputs.forEach(el => {
        el.classList.remove('is-invalid');
    })
    if (form.checkValidity() && pwSame()) {

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
            if (data.valid === "true") {
                window.location.href = '../index.php';
                console.log(data);
            } else {
                console.log(data);
                fieldsError(data.error);
            }
        })
        .catch(error => {
            console.error('Erreur lors de la requête AJAX : ', error);
        });


    } else {

        const fieldsValidity = errorManager();
        fieldsError(fieldsValidity);

    }
});