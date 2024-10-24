$(document).ready(function () {

    var table = createDataTable('#userTable', {
        url: '../api/user/getAll',
    },
        [{
            data: 'id'
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
            className: 'no-print',
            render: function (data, type, row) {
                return '<button class="btn btn-warning btn-edit">Edit</button>' +
                    ' <button class="btn btn-danger btn-delete">Delete</button>';
            }
        }
        ]);

    // Edit button click handler
    $('#userTable tbody').on('click', '.btn-edit', function () {
        var data = table.row($(this).parents('tr')).data();
        $('#editUserForm').modal('show');

        $.ajax({
            url: '../api/user/update',
            method: 'POST',
            data: {
                user_data: data,
            },
            success: function (response) {
                if (response) {
                    $('#editUserForm').modal('hide');
                    table.ajax.reload(null, false);
                } else {
                    alert('Error al editar el usuario');
                }
            },
            error: function (error) {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error al registrar',
                    text: 'Ha ocurrido un error al intentar registrarse. Por favor, inténtelo nuevamente.',
                    icon: 'error'
                });
            }
        });

    });

    // Delete button click handler
    $('#userTable tbody').on('click', '.btn-delete', function () {
        var row = table.row($(this).parents('tr'));
        var data = row.data();

        if (deleteConfirmation()) {
            // row.remove().draw();
        }

    });
});