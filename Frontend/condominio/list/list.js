$(document).ready(function () {
    let selectedUserId; 
    
    let table = createDataTable('#condomainTable', {
        url: PROJECT_URL + 'api/condominio/getAllCondomains',
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
            data: 'nombre'
        },
        {
            data: 'deuda'
        },
        {
            data: 'alicuota'
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
                return  generarBotonesAccion(row.id);
            }
        }
    ]); 

    // Delete button click handler
    $('#condomainTable tbody').on('click', '.btn-delete', function () {
        var row = table.row($(this).parents('tr'));
        var data = row.data();

        deleteConfirmation().then(confirmed => {
            if (confirmed) {
                $.ajax({
                    url: PROJECT_URL + 'api/condominio/deactivate',
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
                            title: 'Condominio Eliminado',
                            text: 'Se ha Eliminado el Condominio con éxito.',
                            icon: 'success',
                            confirmButtonText: 'Continuar'
                        }).then((result) => {
                            if (result.isConfirmed) {
                                table.ajax.reload();
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

    // Edit button click handler
    $('#condomainTable tbody').on('click', '.btn-edit', function () {
        var data = table.row($(this).parents('tr')).data();
        selectedUserId = data.id;
        $('#editCondomainForm').modal('show');
    
        rellenarFormulario('editForm', data, [
            'nombre',
            'deuda',
            'alicuota',
            'is_active'
        ]);

    });

    $('#editBtn').on('click', function(e) {
        e.preventDefault();
        
        const dataCondominio = {
            id: selectedUserId,
            nombre: $('#nombre').val() || '',
            deuda: parseFloat($('#deuda').val()) || 0,
            alicuota: parseFloat($('#alicuota').val()) || 0,
            is_active: $('#is_active').prop('checked'),
        };
        
        $.ajax({
            url:  PROJECT_URL + `api/condominio/update`,
            type: 'POST',
            dataType: 'json',
            data: { condominio_data: JSON.stringify(dataCondominio) },
            success: function(response) {
                
                if (!handleErrorValidate(response) || !handleError(response)) {
                    return; 
                }

                table.ajax.reload();
                $('#editCondomainForm').modal('hide');

                Swal.fire({
                    title: 'Condominio Actualizado',
                    text: 'Se ha actualizado el Condominio con éxito.',
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
});