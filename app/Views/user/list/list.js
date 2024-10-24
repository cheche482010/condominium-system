$(document).ready(function () {

    var table = createDataTable('#userTable', {
        url: '../api/user/getAll',
    },
        [{
            data: null,
            title: '#',
            orderable: false,
            searchable: false,
            render: function (data, type, row, meta) {
                return meta.row + 1;
            }
        },
        {
            data: 'cedula'
        },
        {
            data: 'nombre'
        },
        {
            data: 'apellido'
        },
        {
            data: 'phone'
        },
        {
            data: 'email'
        },
        {
            data: 'rol'
        },
        {
            data: 'is_active'
        }, {
            data: null,
            className: 'no-print text-center',
            render: function (data, type, row) {
                return generarBotonesAccion(data.id);
            }
        }
        ]);

    // Edit button click handler
    $('#userTable tbody').on('click', '.btn-edit', function () {
        var data = table.row($(this).parents('tr')).data();
        $('#editUserForm').modal('show');
        
        rellenarFormulario('editForm', data, [
            'cedula',
            'nombre',
            'apellido',
            'email',
            'phone'
        ]);
    });

    // Delete button click handler
    $('#userTable tbody').on('click', '.btn-delete', function () {
        var row = table.row($(this).parents('tr'));
        var data = row.data();

        if (deleteConfirmation()) {
            // row.remove().draw();
        }

    });

    const $togglePasswordBtn = $('#togglePassword');
    const $passwordSection = $('#passwordSection');

    let isPasswordMode = false;

    $togglePasswordBtn.on('click', function() {
        if (!isPasswordMode) {
            $('.button-style').removeClass('mt-3');
            $('#userDataForm').hide();
            $passwordSection.show();
            $togglePasswordBtn.html('<i class="fa fa-angle-left pr-2" aria-hidden="true"></i> Volver').removeClass('btn-default');
            $('#savePasswordBtn').show();
            $('#editBtn').hide();
            isPasswordMode = true;
        } else {
            $('.button-style').addClass('mt-3');
            $('#userDataForm').show();
            $passwordSection.hide();
            $togglePasswordBtn.text('Modificar contraseña').addClass('btn-default');
            $('#savePasswordBtn').hide();
            $('#editBtn').show();
            isPasswordMode = false;
        }
    });

    $('#editBtn').on('click', function(e) {
        e.preventDefault();

        const userData = {
            cedula: $('#cedula').val(),
            nombre: $('#nombre').val(),
            apellido: $('#apellido').val(),
            email: $('#email').val(),
            phone: $('#phone').val(),
        };
        
        $.ajax({
            url: '../api/user/update',
            type: 'POST',
            dataType: 'json',
            data: {
                user_data: userData,
            },
            success: function(response) {
                console.log(response);
            },
            error: function(error) {
                console.error('Error:', error);
            }
        });
    });
    
    $('#savePasswordBtn').on('click', function() {
        const userPassword = $('#user_password').val();
        const retryPassword = $('#retryPassword').val();
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
            updateSecurityLevel(`La contraseña debe tener al menos ${minLength} caracteres`);
        } else if (password.length > maxLength) {
            updateSecurityLevel(`La contraseña no debe exceder ${maxLength} caracteres`);
        } else if (!hasLowercase) {
            updateSecurityLevel('Falta minúsculas');
        } else if (!hasUppercase) {
            updateSecurityLevel('Falta mayúsculas');
        } else if (!hasNumber) {
            updateSecurityLevel('Falta números');
        } else if (!hasSpecialChar) {
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
});