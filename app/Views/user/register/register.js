$(document).ready(function () {

    function validateForm() {
        let isValid = true;
        var toastQueue = [];

        $('.form-control').removeClass('invalid-input');

        // Validate cedula
        if ($('#cedula').val().trim() === '') {
            toastr.error('La cédula es obligatoria.');
            $('#cedula').addClass('invalid-input');
            isValid = false;
        } else if (!/^\d{9}$/.test($('#cedula').val())) {
            toastr.error('La cédula debe ser un número de 9 dígitos.');
            $('#cedula').addClass('invalid-input');
            isValid = false;
        }

        // Validate nombre
        if ($('#nombre').val().trim() === '') {
            toastr.error('El nombre es obligatorio.');
            $('#nombre').addClass('invalid-input');
            isValid = false;
        }

        // Validate apellido
        if ($('#apellido').val().trim() === '') {
            toastr.error('El apellido es obligatorio.');
            $('#apellido').addClass('invalid-input');
            isValid = false;
        }

        // Validate email
        let email = $('#email').val();
        if (email.trim() === '') {
            toastr.error('El correo electrónico es obligatorio.');
            $('#email').addClass('invalid-input');
            isValid = false;
        } else if (!/^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(email)) {
            toastr.error('Por favor, ingrese un correo electrónico válido.');
            $('#email').addClass('invalid-input');
            isValid = false;
        }

        // Validate phone
        let phone = $('#phone').val();
        if (phone.trim() === '') {
            toastr.error('El teléfono es obligatorio.');
            $('#phone').addClass('invalid-input');
            isValid = false;
        } else if (!/^(\+58\s?)?[\d]{8}$/.test(phone)) {
            toastr.error('Por favor, ingrese un número de teléfono válido para Venezuela (+58).');
            $('#phone').addClass('invalid-input');
            isValid = false;
        }

        // passwords
        let password = $('#user_password').val();
        if (password.trim() === '') {
            toastr.error('La contraseña es obligatoria.');
            $('#user_password').addClass('invalid-input');
            isValid = false;
        }

        let confirmPassword = $('#retryPassword').val();
        if (confirmPassword.trim() === '') {
            toastr.error('La confirmación de contraseña es obligatorias.');
            $('#retryPassword').addClass('invalid-input');
            isValid = false;
        }

        return isValid;
    }

    $('#register').click(function (e) {
        e.preventDefault();
        const formData = captureFormData();
        delete formData.retryPassword;
        
        if (validateForm()) {
            $.ajax({
                url: PROJECT_URL + '/api/user/create',
                method: 'POST',
                data: {
                    user_data: formData,
                    user_type: 0 // usuario registrado sin rol
                },
                dataType: 'json',
                success: function (data) {
    
                    if (!handleErrorValidate(data) || !handleErrorExisting(data)) {
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
        }
    });

    $('#clear').click(function() {
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
});