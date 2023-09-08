document.addEventListener('click', function(e) {
    console.log(e, e.target);
    if (e.target.id === 'logout') {
        window.location = 'http://localhost/login/logout.php';
    }
})