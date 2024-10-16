$(document).ready(function () {
    $('.toggle-password').click(function (e) {
        e.preventDefault();
        var passwordField = document.getElementById("user_password");
        if (passwordField.type === "password") {
            $(".password").attr("type", "text");
            $(this).find('span').removeClass('fa-eye-slash').addClass('fa-eye');
            $(".password").focus();
        } else {
            $(".password").attr("type", "password");
            $(this).find('span').removeClass('fa-eye').addClass('fa-eye-slash');
            $(".password").focus();
        }
    });

    $('#login').click(function (e) {
        e.preventDefault();
        const formData = captureFormData();

        if (!validForm()) {
            return;
        }

        $.ajax({
            url: PROJECT_URL + '/api/users/auth',
            method: 'POST',
            data: {
                user_data: formData,
            },
            dataType: 'json',
            success: function (data) {

                if (!handleError(data)) {
                    return;
                }

                Swal.fire({
                    title: 'Inicio de sesion Exitoso',
                    text: 'Se ha iniciado sesion con éxito. Bienvenido a nuestro sistema!',
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
                        Swal.hideLoading()
                    }
                });

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