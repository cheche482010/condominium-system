$(document).ready(function () {
    let selectedUserId;

    let table = createDataTable('#gastoTable', {
        url: PROJECT_URL + 'api/gasto/getAllExpenses',
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
                data: 'tipo_gasto'
            },
            {
                data: 'concepto'
            },
            {
                data: 'monto'
            },
            {
                data: 'fecha'
            },
            {
                data: 'is_active',
                className: 'text-center',
                render: function (data, type, row) {
                    return data === 1 || data === true
                        ? '<span class="badge bg-success text-sm">Activo</span>'
                        : '<span class="badge bg-danger text-dark text-sm">Inactivo</span>';
                }
            },
            {
                data: null,
                orderable: false,
                searchable: false,
                className: 'no-print text-center',
                render: function (data, type, row) {
                    return generarBotonesAccion(row.id);
                }
            }
        ]);

    $('#gastoTable tbody').on('click', '.btn-delete', function () {
        var row = table.row($(this).parents('tr'));
        var data = row.data();

        deleteConfirmation().then(confirmed => {
            if (confirmed) {
                $.ajax({
                    url: PROJECT_URL + 'api/gasto/deactivate',
                    type: 'POST',
                    dataType: 'json',
                    data: {
                        id: data.id
                    },
                    success: function (data) {

                        if (!handleError(data)) {
                            return;
                        }

                        Swal.fire({
                            title: 'Gasto Eliminado',
                            text: 'Se ha Eliminado el Gasto con éxito.',
                            icon: 'success',
                            confirmButtonText: 'Continuar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                table.ajax.reload();
                            }
                        });
                    },
                    error: function (error) {
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
});