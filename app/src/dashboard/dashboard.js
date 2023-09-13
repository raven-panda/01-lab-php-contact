const dropdown = document.querySelector('#account-settings');
const ddBtn = document.querySelector('#account-menu-btn');
const ddMenu = document.querySelector('#account-menu');

const burger = document.querySelector('#burger-menu');
const navCol = document.querySelector('#navbarNav');
const tokexp = document.querySelector('#tokexp');

function logout() {
    window.location = '../session/logout.php';
}

document.addEventListener('click', function(e) {
    console.log(e, e.target);
    if (e.target.classList.contains('logout')) {
        logout();
    }

    if (e.target === ddBtn) {
        ddMenu.classList.toggle('show');
        dropdown.classList.toggle('show');
    }
    
    if (e.target === burger || e.target === burger.querySelector('.navbar-toggler-icon')) {
        burger.classList.toggle('show');
        navCol.classList.toggle('show');
        ddMenu.classList.toggle('show');
        dropdown.classList.toggle('show');
    }

    const now = Date.now() / 1000;
    if (tokexp.value < now || e.target.classList.contains('logout')) {
        logout();
    }
})