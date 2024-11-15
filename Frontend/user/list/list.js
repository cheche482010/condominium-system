$(document).ready(function () {
    let selectedUserId; 
    const $togglePasswordBtn = $('#togglePassword');
    const $passwordSection = $('#passwordSection');

    let isPasswordMode = false;
    let table = createDataTable('#userTable', {
        url: PROJECT_URL + 'api/user/getAllUser',
    },
    [
        {
            data: null,
            title: '#',
            orderable: false,
            searchable: false,
            className: 'text-center',
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
            data: 'rol',
            render: function (data, type, row) {
                if (type === 'display') {
                    return data ? data.nombre : '';
                }
                return data;
            }
        },
        {
            data: 'is_active',
            render: function (data, type, row) {
                return data === 1 || data === true
                    ? '<span class="badge bg-success text-sm">Activo</span>'
                    : '<span class="badge bg-danger text-dark text-lg">Inactivo</span>';
            }
        },
        {
            data: null,
            orderable: false,
            searchable: false,
            className: 'no-print text-center',
            render: function (data, type, row) {
                return  generarBotonesAccion(row.id);
            }
        }
    ]);

    // Edit button click handler
    $('#userTable tbody').on('click', '.btn-edit', function () {
        var data = table.row($(this).parents('tr')).data();
        selectedUserId = data.id;
        $('#editUserForm').modal('show');
    
        rellenarFormulario('editForm', data, [
            'cedula',
            'nombre',
            'apellido',
            'email',
            'phone',
            'is_active'
        ]);
        $(`#condominio`).selectpicker('val', data.condominio.id);
        $(`#rol`).selectpicker('val',data.rol.id);
    });

    // Delete button click handler
    $('#userTable tbody').on('click', '.btn-delete', function () {
        var row = table.row($(this).parents('tr'));
        var data = row.data();

        deleteConfirmation().then(confirmed => {
            if (confirmed) {
                $.ajax({
                    url: PROJECT_URL + 'api/user/deactivate',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id: data.id
                    },
                    success: function(data) {
                        if (!handleError(data)) {
                            return; 
                        }
    
                        Swal.fire({
                            title: 'Usuario Eliminado',
                            text: 'Se ha Eliminado el usuario con éxito.',
                            icon: 'success',
                            confirmButtonText: 'Continuar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                row.remove().draw();
                            }
                        });
                    },
                    error: function(error) {
                        console.error(error);
                        Swal.fire({
                            title: 'Error al eliminar',
                            text: 'Ha ocurrido un error al intentar eliminar. Por favor, inténtelo nuevamente.',
                            icon: 'error'
                        });
                    }
                });
            }
        });

    });

    $('#editBtn').on('click', function(e) {
        e.preventDefault();
        
        const userData = {
            id: selectedUserId,
            cedula: $('#cedula').val(),
            nombre: $('#nombre').val(),
            apellido: $('#apellido').val(),
            email: $('#email').val(),
            phone: $('#phone').val(),
        };
        
        $.ajax({
            url:  `../api/user/update`,
            type: 'POST',
            dataType: 'json',
            data: {
                user_data: userData,
            },
            success: function(data) {
                
                if (!handleErrorValidate(data) || !handleError(data)) {
                    return; 
                }

                table.ajax.reload();
                $('#editUserForm').modal('hide');

                Swal.fire({
                    title: 'Usuario Actualizado',
                    text: 'Se ha actualizado el usuario con éxito.',
                    icon: 'success',
                    confirmButtonText: 'Continuar'
                });
            },
            error: function(error) {
                console.error(error);
                Swal.fire({
                    title: 'Error al alctualizar',
                    text: 'Ha ocurrido un error al intentar alctualizar. Por favor, inténtelo nuevamente.',
                    icon: 'error'
                });
            }
        });
    });
    
    $('#savePasswordBtn').on('click', function() {
        const userPassword = $('#user_password').val();
        const retryPassword = $('#retryPassword').val();

        const userData = {
            id: selectedUserId,
            user_password: userPassword,
        };
        
        $.ajax({
            url:  `../api/user/resetPassword`,
            type: 'POST',
            dataType: 'json',
            data: {
                user_data: userData,
            },
            success: function(data) {
                console.log(data);
                if (!handleError(data)) {
                    return; 
                }

                $('#editUserForm').modal('hide');

                Swal.fire({
                    title: 'Contraseña Actualizada',
                    text: 'La contrase ha sido actualiza con exito.',
                    icon: 'success',
                    confirmButtonText: 'Continuar'
                });
            },
            error: function(error) {
                console.error(error);
                Swal.fire({
                    title: 'Error al alctualizar',
                    text: 'Ha ocurrido un error al intentar alctualizar. Por favor, inténtelo nuevamente.',
                    icon: 'error'
                });
            }
        });
    });

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