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
                alert('Botón Agregar presionado');
            }
        },
        {
            text: 'Editar',
            className: 'btn-primary',
            action: function () {
                if (selectedRow) {
                    rellenarFormulario('editBancForm', selectedRow, ['codigo', 'nombre', 'is_active']);
                    $('#editBancForm').modal('show');
                } else {
                    alert('Por favor, selecciona una fila para editar.');
                }
            }
        },
        {
            text: 'Eliminar',
            className: 'btn-danger',
            action: function () {
                if (selectedRow) {
                    alert('Eliminando: ' + selectedRow.nombre); 
                } else {
                    alert('Por favor, selecciona una fila para eliminar.');
                }
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

$('#editBancForm #editBtn').on('click', function(e) {
    e.preventDefault();
    
    const bancosData = {
        id: selectedRow.id,
        codigo: $('#codigo').val(),
        nombre: $('#nombre').val(),
        is_active: $('#is_active').prop('checked')
    };
    
    $.ajax({
        url:  `api/configuracion/updateBancos`,
        type: 'POST',
        dataType: 'json',
        data: {
            bancos_data: JSON.stringify(bancosData),
        },
        success: function(data) {

            if (!handleError(data)) {
                return; 
            }

            table.ajax.reload();

            $('#editBancForm').modal('hide');

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
                title: 'Error al alctualizar',
                text: 'Ha ocurrido un error al intentar alctualizar. Por favor, inténtelo nuevamente.',
                icon: 'error'
            });
        }
    });
});