$(document).ready(function () {
    $('#login').click(function (e) {
        e.preventDefault();
        const formData = captureFormData();

        if (!validForm()) {
            return;
        }

        $.ajax({
            url: PROJECT_URL + '/api/user/auth',
            method: 'POST',
            data: {
                user_data: formData,
                role: $('input[name="role"]:checked').val()
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

    $('#email').on('keyup', function() {
        var email = $(this).val();
        
        if (email.length >= 3 && isValidEmail(email)) {
            checkUserRole(email);
        }
    });

    function checkUserRole(email) {
        $.ajax({
            url: PROJECT_URL + '/api/user/check-role',
            method: 'POST',
            data: { email: email },
            dataType: 'json',
            success: function(data) {
                if (data.roles && data.roles.length > 0) {
                    showRoles(data.roles);
                } else {
                    hideRoles();
                }
            },
            error: function(xhr, status, error) {
                console.error('Error:', error);
                toastr.error('Ha ocurrido un error al verificar el usuario.');
            }
        });
    }

    function showRoles(roles) {
        var rolesContainer = $('#roles-container');
        rolesContainer.empty();

        $.each(roles, function(index, role) {
            rolesContainer.append(`
                <input type="radio" name="role" value="${role.id}" required>
                <label for="role-${role.id}">${role.name}</label><br>
            `);
        });

        $('#login').attr('type', 'submit');
    }

    function hideRoles() {
        var rolesContainer = $('#roles-container');
        rolesContainer.empty();
        rolesContainer.hide();

        $('#login').attr('type', 'button');
    }

    function isValidEmail(email) {
        return /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email);
    }

});