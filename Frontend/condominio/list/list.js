$(document).ready(function () {

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
});