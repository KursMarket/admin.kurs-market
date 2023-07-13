(function () {
    document.addEventListener('DOMContentLoaded', function () {
        var $form = document.getElementById('auth--form');

        if ($form) {
            $form.addEventListener('submit', async function (event) {
                event.preventDefault();
                var fd = new FormData($form),
                    errorBlock = document.getElementById('alert-error');
                errorBlock.textContent = '';
                errorBlock.style.display = 'none';
                await fetch('/admin/login', {
                    method: 'POST',
                    headers: {
                        'enctype': 'multipart/form-data'
                    },
                    body: fd
                }).then(function (response) {
                    return response.json();
                }).then(function (response) {
                    if (response.status) {
                        window.location.href = response.data.redirect;
                    } else {
                        errorBlock.style.display = 'block';
                        errorBlock.textContent = response.errors.errorMessage;
                    }
                })
            });
        }
    })
})()
