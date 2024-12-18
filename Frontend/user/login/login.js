$(document).ready(function () {
    $('#login').click(function (e) {
        e.preventDefault();

        const userData = {
            email: $('#email').val() || '',
            user_password: $('#user_password').val() || ''
        };

        if (!validForm()) {
            return;
        }

        $.ajax({
            url: PROJECT_URL + 'api/user/auth',
            method: 'POST',
            dataType: 'json',
            data: { user_data: JSON.stringify(userData) },
            success: function (data) {
                
                if (!handleError(data)) {
                    return;
                }

                if (data.status === true) {
                    Swal.fire({
                        title: 'Inicio de sesión Exitoso',
                        text: 'Se ha iniciado sesión con éxito. Bienvenido a nuestro sistema!',
                        icon: 'success',
                        confirmButtonText: null,
                        showConfirmButton: false,
                        allowOutsideClick: false,
                        allowEscapeKey: false,
                        timer: 2000,
                        timerProgressBar: true,
                        onBeforeOpen: () => {
                            Swal.showLoading()
                        },
                        onClose: () => {
                            window.location.href = PROJECT_URL + 'home';
                        }
                    }).then((result) => {
                        if (result.dismiss === Swal.DismissReason.timer) {
                            window.location.href = PROJECT_URL + 'home';
                        }
                    });
                }
                
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error al iniciar sesión',
                    text: 'Ha ocurrido un error al intentar iniciar sesión. Por favor, inténtelo nuevamente.',
                    icon: 'error'
                });
            }
        });
    });

    function validForm() {
        let email = $('#email').val();
        let password = $('#user_password').val();

        if (email.trim() === '') {
            toastr.error('El correo electrónico es obligatorio.');
            $('#email').addClass('invalid-input');
            return false;
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            toastr.error('Por favor, ingrese un correo electrónico válido.');
            $('#email').addClass('invalid-input');
            return false;
        }

        if (password.trim() === '') {
            toastr.error('La contraseña es obligatoria.');
            $('#user_password').addClass('invalid-input');
            return false;
        }

        return true;
    }
});