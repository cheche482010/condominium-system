$(document).ready(function () {
    let selectedUserId; 
    
    let table = createDataTable('#apartamentTable', {
        url: PROJECT_URL + 'api/apartamento/getAllApartments',
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
    $('#apartamentTable tbody').on('click', '.btn-delete', function () {
        var row = table.row($(this).parents('tr'));
        var data = row.data();

        deleteConfirmation().then(confirmed => {
            if (confirmed) {
                $.ajax({
                    url: PROJECT_URL + 'api/apartamento/deactivate',
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
                            title: 'Apartamento Eliminado',
                            text: 'Se ha Eliminado el Apartamento con éxito.',
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
    $('#apartamentTable tbody').on('click', '.btn-edit', function () {
        var data = table.row($(this).parents('tr')).data();
        selectedUserId = data.id;
        $('#editApartamentForm').modal('show');
    
        rellenarFormulario('editForm', data, [
            'nombre',
            'deuda',
            'alicuota',
            'is_active'
        ]);

    });

    $('#editBtn').on('click', function(e) {
        e.preventDefault();
        
        const dataApartament = {
            id: selectedUserId,
            nombre: $('#nombre').val() || '',
            deuda: parseFloat($('#deuda').val()) || 0,
            alicuota: parseFloat($('#alicuota').val()) || 0,
            is_active: $('#is_active').prop('checked'),
        };
        
        $.ajax({
            url:  PROJECT_URL + `api/apartamento/update`,
            type: 'POST',
            dataType: 'json',
            data: { apartament_data: JSON.stringify(dataApartament) },
            success: function(response) {
                
                if (!handleErrorValidate(response) || !handleError(response)) {
                    return; 
                }

                table.ajax.reload();
                $('#editApartamentForm').modal('hide');

                Swal.fire({
                    title: 'Apartamento Actualizado',
                    text: 'Se ha actualizado el Apartamento con éxito.',
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