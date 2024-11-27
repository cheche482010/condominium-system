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

    $('#gastoTable tbody').on('click', '.btn-edit', function () {
        var data = table.row($(this).parents('tr')).data();
        selectedUserId = data.id;
        $('#editGastoForm').modal('show');
    
        rellenarFormulario('editForm', data, [
            'concepto',
            'monto',
            'fecha',
            'is_active'
        ]);
        $(`#id_tipo`).selectpicker('val', data.id_tipo);
    });

    $('#editBtn').on('click', function(e) {
        e.preventDefault();
        
        const dataApartament = {
            id: selectedUserId,
            concepto: $('#concepto').val() || '',
            monto: parseFloat($('#monto').val()) || 0,
            fecha: $('#fecha').val() || '',
            is_active: $('#is_active').prop('checked'), 
            id_tipo: parseInt($('#id_tipo').val()) || null
        };
        
        $.ajax({
            url:  PROJECT_URL + `api/gasto/updateExpense`,
            type: 'POST',
            dataType: 'json',
            data: { gasto_data: JSON.stringify(dataApartament) },
            success: function(response) {
                
                if (!handleErrorValidate(response) || !handleError(response)) {
                    return; 
                }

                table.ajax.reload();
                $('#editGastoForm').modal('hide');

                Swal.fire({
                    title: 'Gasto Actualizado',
                    text: 'Se ha actualizado el Gasto con éxito.',
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

    $('#id_tipo').selectpicker({
        liveSearch: true,
        liveSearchNormalize: false,
        size: 10,
        style: 'btn btn-default'
    });

    $.ajax({
        url: PROJECT_URL + 'api/gasto/getAllTypeExpense',
        method: 'GET',
        dataType: 'json',
        success: function (data) {

            if (!handleError(data)) {
                return;
            }

            var options = '<option value="">Seleccione un tipo de Gasto</option>';
            $.each(data.data, function (index, item) {
                options += '<option value="' + item.id + '">' + item.nombre + '</option>';
            });
            $('#id_tipo').html(options);
            $('#id_tipo').selectpicker('refresh');
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