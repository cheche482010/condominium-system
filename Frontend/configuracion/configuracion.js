let modalAction = 'add'; 
let selectedRow = null;

let table = $("#bancosTable").DataTable({
    ajax: {
        url: 'api/configuracion/getAllBancos',
    },
    columns: [
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
            data: 'codigo'
        },
        {
            data: 'nombre'
        }
    ],
    language: {
        url: 'Frontend/assets/json/Spanish.json',
    },
    searching: true,
    ordering: true,
    info: true,
    autoWidth: false,
    responsive: true,
    processing: false,
    pageLength: 10,
    lengthMenu: [5, 10, 20, 30],
    select: true,
    dom: '<"row mb-3"B><"d-flex justify-content-between"fl>rt<"d-flex justify-content-between"ip>',
    buttons: [
        {
            text: 'Agregar',
            className: 'btn-info',
            action: function () {
                modalAction = 'add';
                $('#BancForm').modal('show');
                $('#editForm')[0].reset();
            }
        },
        {
            text: 'Editar',
            className: 'btn-primary',
            action: function () {
                if (selectedRow) {
                    modalAction = 'edit';
                    rellenarFormulario('BancForm', selectedRow, ['codigo', 'nombre', 'is_active']);
                    $('#BancForm').modal('show');
                } else {
                    alert('Por favor, selecciona una fila para editar.');
                }
            }
        },
        {
            text: 'Eliminar',
            className: 'btn-danger',
            action: function () {
                eliminarBanco();
            }
        },
    ],
    rowCallback: function(row, data) {
        if ($(row).hasClass('selected')) {
            $(row).addClass('table-active'); 
        } else {
            $(row).removeClass('table-active'); 
        }
    }
});

$('#bancosTable tbody').on('click', 'tr', function () {
    if ($(this).hasClass('selected')) {
        $(this).removeClass('selected');
        selectedRow = null; 
    } else {
        table.$('tr.selected').removeClass('selected'); 
        $(this).addClass('selected');
        selectedRow = table.row(this).data(); 
    }
});

$('#BancForm').on('show.bs.modal', function (e) {
    if (modalAction === 'add') {
        $('#editFormLabel').text('Agregar Banco');
        $('#editBtn').text('Agregar').off('click').on('click', agregarBanco);
    } else if (modalAction === 'edit') {
        $('#editFormLabel').text('Editar Banco');
        $('#editBtn').text('Guardar').off('click').on('click', editarBanco);
    }
});

function agregarBanco(e) {
    e.preventDefault();

    const bancosData = {
        codigo: $('#codigo').val(),
        nombre: $('#nombre').val(),
        is_active: $('#is_active').prop('checked')
    };

    $.ajax({
        url: 'api/configuracion/addBanco',
        type: 'POST',
        dataType: 'json',
        data: { bancos_data: JSON.stringify(bancosData) },
        success: function(data) {
            if (!handleError(data)) return;
            table.ajax.reload();
            $('#BancForm').modal('hide');
            Swal.fire({
                title: 'Banco Agregado',
                text: 'Se ha agregado el banco con éxito.',
                icon: 'success',
                confirmButtonText: 'Continuar'
            });
        },
        error: function(error) {
            console.error(error);
            Swal.fire({
                title: 'Error al agregar',
                text: 'Hubo un problema al agregar el banco.',
                icon: 'error'
            });
        }
    });
}

function editarBanco(e) {
    e.preventDefault();

    const bancosData = {
        id: selectedRow.id,
        codigo: $('#codigo').val(),
        nombre: $('#nombre').val(),
        is_active: $('#is_active').prop('checked')
    };

    $.ajax({
        url: 'api/configuracion/updateBancos',
        type: 'POST',
        dataType: 'json',
        data: { bancos_data: JSON.stringify(bancosData) },
        success: function(data) {
            if (!handleError(data)) return;
            table.ajax.reload();
            $('#BancForm').modal('hide');
            Swal.fire({
                title: 'Banco Actualizado',
                text: 'Se ha actualizado el banco con éxito.',
                icon: 'success',
                confirmButtonText: 'Continuar'
            });
        },
        error: function(error) {
            console.error(error);
            Swal.fire({
                title: 'Error al actualizar',
                text: 'Hubo un problema al actualizar el banco.',
                icon: 'error'
            });
        }
    });
}

function eliminarBanco() {
    if (!selectedRow) {
        Swal.fire({
            title: 'Error',
            text: 'Por favor, selecciona un banco para eliminar.',
            icon: 'error',
            confirmButtonText: 'Aceptar'
        });
        return;
    }

    Swal.fire({
        title: '¿Estás seguro?',
        text: `¿Deseas eliminar el banco "${selectedRow.nombre}"? Esta acción no se puede deshacer.`,
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#d33',
        cancelButtonColor: '#3085d6',
        confirmButtonText: 'Eliminar',
        cancelButtonText: 'Cancelar'
    }).then((result) => {
        if (result.isConfirmed) {
            $.ajax({
                url: 'api/configuracion/deleteBanco',
                type: 'POST',
                dataType: 'json',
                data: { idBanco: selectedRow.id },
                success: function(data) {
                    if (!handleError(data)) return;
                    table.ajax.reload();
                    Swal.fire({
                        title: 'Banco Eliminado',
                        text: 'El banco ha sido eliminado con éxito.',
                        icon: 'success',
                        confirmButtonText: 'Continuar'
                    });
                    selectedRow = null; 
                },
                error: function(error) {
                    console.error(error);
                    Swal.fire({
                        title: 'Error al eliminar',
                        text: 'Hubo un problema al eliminar el banco.',
                        icon: 'error'
                    });
                }
            });
        }
    });
}
