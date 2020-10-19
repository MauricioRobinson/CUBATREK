(function () {
    'use strict';
    window.addEventListener('load', function () {
        // Fetch all the forms we want to apply custom Bootstrap validation styles to
        var form = document.getElementById('contact-form');
        let email = document.getElementById('email');
        let confirmEmail = document.getElementById('confirmEmail');
        var validateForm = form.addEventListener('submit', function (event) {
            if (form.checkValidity() === false && email === confirmEmail) {
                event.preventDefault();
                event.stopPropagation();
            }
            form.classList.add('was-validated');          
        }, false);
    }, false);
})();