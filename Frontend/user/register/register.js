$(document).ready(function () {

    function validateForm() {
        $('.form-control').removeClass('invalid-input');

        // Validate cedula
        if ($('#cedula').val().trim() === '') {
            toastr.error('La cédula es obligatoria.');
            $('#cedula').addClass('invalid-input');
            return false;
        } else if (!/^(?:\d{7}|\d{8}|\d{9})$/.test($('#cedula').val())) {
            toastr.error('La cédula debe ser un número valido.');
            $('#cedula').addClass('invalid-input');
            return false;
        }

        // Validate nombre
        if ($('#nombre').val().trim() === '') {
            toastr.error('El nombre es obligatorio.');
            $('#nombre').addClass('invalid-input');
            return false;
        }

        // Validate apellido
        if ($('#apellido').val().trim() === '') {
            toastr.error('El apellido es obligatorio.');
            $('#apellido').addClass('invalid-input');
            return false;
        }

        // Validate email
        let email = $('#email').val();
        if (email.trim() === '') {
            toastr.error('El correo electrónico es obligatorio.');
            $('#email').addClass('invalid-input');
            return false;
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            toastr.error('Por favor, ingrese un correo electrónico válido.');
            $('#email').addClass('invalid-input');
            return false;
        }

        // Validate phone
        let phone = $('#phone').val();
        if (phone.trim() === '') {
            toastr.error('El teléfono es obligatorio.');
            $('#phone').addClass('invalid-input');
            return false;
        } else if (!/^\+?\d+$/.test(phone)) {
            toastr.error('Por favor, ingrese un número de teléfono válido para Venezuela (+58).');
            $('#phone').addClass('invalid-input');
            return false;
        }

        // passwords
        let password = $('#user_password').val();
        if (password.trim() === '') {
            toastr.error('La contraseña es obligatoria.');
            $('#user_password').addClass('invalid-input');
            return false;
        }

        let confirmPassword = $('#retryPassword').val();
        if (confirmPassword.trim() === '') {
            toastr.error('La confirmación de contraseña es obligatorias.');
            $('#retryPassword').addClass('invalid-input');
            return false;
        }

        return true;
    }

    function checkPasswordStrength() {
        let password = $('#user_password').val();

        let hasLowercase = /[a-z]/.test(password);
        let hasUppercase = /[A-Z]/.test(password);
        let hasNumber = /\d/.test(password);
        let hasSpecialChar = /[!@#$%^&*(),.?":{}|<>]/.test(password);
        let minLength = 4;
        let maxLength = 20;

        let strength = 0;

        if (password.length < minLength) {
            $('.progress-bar').width(`${(minLength / maxLength) * 100}%`);
            updateSecurityLevel(`La contraseña debe tener al menos ${minLength} caracteres`);
        } else if (password.length > maxLength) {
            $('.progress-bar').width(`${(maxLength / maxLength) * 100}%`);
            updateSecurityLevel(`La contraseña no debe exceder ${maxLength} caracteres`);
        } else if (!hasLowercase) {
            $('.progress-bar').width(`${(2 / 5) * 100}%`);
            updateSecurityLevel('Falta minúsculas');
        } else if (!hasUppercase) {
            $('.progress-bar').width(`${(2 / 5) * 100}%`);
            updateSecurityLevel('Falta mayúsculas');
        } else if (!hasNumber) {
            $('.progress-bar').width(`${(2 / 5) * 100}%`);
            updateSecurityLevel('Falta números');
        } else if (!hasSpecialChar) {
            $('.progress-bar').width(`${(3 / 5) * 100}%`);
            updateSecurityLevel('Falta caracteres especiales');
        } else {
            $('.progress-bar').width('90%');
            updateSecurityLevel('Las Contraseñas Deben Coincidir');
        }
    }

    function updateSecurityLevel(level) {
        const securityLevelSpan = $('.security-level');
        securityLevelSpan.text(level);
        securityLevelSpan.css('color', getSecurityColor(level));
    }

    function getSecurityColor(level) {
        switch (level) {
            case 'La contraseña debe tener al menos 4 caracteres':
            case 'La contraseña no debe exceder 20 caracteres':
                return '#FF4B47';
            case 'Falta minúsculas':
            case 'Falta mayúsculas':
            case 'Falta números':
                return '#FF4B47';
            case 'Falta caracteres especiales':
                return '#F9AE35';
            case 'Las Contraseñas Deben Coincidir':
                return '#F9AE35';
            default:
                return '#2ECC71';
        }
    }

    $('#register').click(function (e) {
        e.preventDefault();
        
        const userData = {
            cedula: $('#cedula').val() || '',
            nombre: $('#nombre').val() || '',
            apellido: $('#apellido').val() || '',
            email: $('#email').val() || '',
            phone: $('#phone').val() || '',
            id_condominio: parseInt($('#condominio').val()) || null,
            id_rol: parseInt($('#rol').val()) || null,
            is_active: $('#is_active').prop('checked'),
            user_password: $('#user_password').val() || ''
        };

        if (!validateForm()) {
            return;
        }

        $.ajax({
            url: PROJECT_URL + 'api/user/createNewUser',
            method: 'POST',
            dataType: 'json',
            data: { user_data: JSON.stringify(userData) },
            success: function (data) {
                console.log(data);
                if (!handleErrorValidate(data) || !handleErrorExisting(data) || !handleError(data)) {
                    return;
                }

                Swal.fire({
                    title: 'Registro Exitoso',
                    text: 'Se ha registrado el usuario con éxito. Bienvenido a nuestro sistema!',
                    icon: 'success',
                    confirmButtonText: 'Continuar'
                });
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error al registrar',
                    text: 'Ha ocurrido un error al intentar registrarse. Por favor, inténtelo nuevamente.',
                    icon: 'error'
                });
            }
        });
    });

    $('#clear').click(function () {
        $('form')[0].reset();
        $('.form-control').removeClass('invalid-input');
        $('.progress-bar').css('width', '0%').attr('aria-valuenow', 0);
        $('.security-level').text('');
    });

    $('#user_password').keyup(function () {
        checkPasswordStrength();
    });

    $('#retryPassword').keyup(function () {
        let password = $('#user_password').val();
        const confirmed = $('#retryPassword').val();

        if (password !== confirmed) {
            $('.progress-bar').width('90%');
            updateSecurityLevel('Las Contraseñas Deben Coincidir');
        } else {
            $('.progress-bar').width('100%');
            updateSecurityLevel('Contraseña segura');
        }
    });

    $('#condominio').selectpicker({
        liveSearch: true,
        liveSearchNormalize: false,
        size: 10,
        style: 'btn btn-default'
    });

    $.ajax({
        url: PROJECT_URL + 'api/condominio/getAllCondomains',
        method: 'GET',
        dataType: 'json',
        success: function (data) {

            if (!handleError(data)) {
                return;
            }

            var options = '<option value="">Seleccione un condominio</option>';
            $.each(data.data, function (index, item) {
                options += '<option value="' + item.id + '">' + item.nombre + '</option>';
            });
            $('#condominio').html(options);
            $('#condominio').selectpicker('refresh');
        },
        error: function (error) {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error',
                text: 'Ha ocurrido un error. Por favor, inténtelo nuevamente.',
                icon: 'error'
            });
        }
    });

    $.ajax({
        url: PROJECT_URL + 'api/user/getAllRols',
        method: 'GET',
        dataType: 'json',
        success: function (data) {

            if (!handleError(data)) {
                return;
            }

            var options = '<option value="">Seleccione un rol</option>';
            $.each(data.data, function (index, item) {
                options += '<option value="' + item.id + '">' + item.nombre + '</option>';
            });
            $('#rol').html(options);
            $('#rol').selectpicker('refresh');
        },
        error: function (error) {
            console.error('Error:', error);
            Swal.fire({
                title: 'Error',
                text: 'Ha ocurrido un error. Por favor, inténtelo nuevamente.',
                icon: 'error'
            });
        }
    });

});