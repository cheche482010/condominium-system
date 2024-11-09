
function handleErrorValidate(data) {
    if (data.status === false && data.type === 'errorValidate') {
        toastr.error(MSG_ERROR_VALIDATE);
        return false;
    }
    return true;
}

function handleErrorExisting(data) {
    if (data.status === false && data.code === 409) {
        toastr.error(data.data + " " + data.message);
        return false;
    }
    return true;
}

function handleError(data) {
    if (data.status === false) {
        toastr.error(data.message);
        return false;
    }
    return true;
}

function createDataTable(selector, ajaxConfig, columnConfig, functioname = null) {
    return $(selector).DataTable({
        ajax: ajaxConfig,
        columns: columnConfig,
        language: {
            url: PROJECT_URL + 'Frontend/assets/json/Spanish.json',
        },
        scrollX: true,
        scrollY: '500px',
        scrollCollapse: true,
        paging: true,
        searching: true,
        ordering: true,
        info: true,
        autoWidth: false,
        responsive: true,
        processing: false,
        pageLength: 10,
        lengthMenu: [5, 10, 20, 30, 40, 50, 100],
        buttons: [
            {
                extend: 'colvis',
                text: 'Columna Visibles',
                className: 'btn btn-secondary'
            },
            {
                extend: 'collection',
                text: 'Exportar <i class="fas fa-download"></i>',
                className: 'btn btn-secondary dropdown-toggle',
                buttons: [
                    {
                        extend: 'copy',
                        text: '<i class="fas fa-copy"></i> Copiar ',
                        className: 'dropdown-item',
                        exportOptions: {
                            columns: ':not(.no-print)'
                        }
                    },
                    {
                        extend: 'csv',
                        text: '<i class="fas fa-file-csv"></i> Csv',
                        className: 'dropdown-item',
                        exportOptions: {
                            columns: ':not(.no-print)'
                        }
                    },
                    {
                        extend: 'excel',
                        text: '<i class="fas fa-file-excel"></i> Excel',
                        className: 'dropdown-item',
                        exportOptions: {
                            columns: ':not(.no-print)'
                        }
                    },
                    {
                        extend: 'pdf',
                        text: '<i class="fas fa-file-pdf"></i> PDF',
                        className: 'dropdown-item',
                        exportOptions: {
                            columns: ':not(.no-print)'
                        }
                    },
                    {
                        extend: 'print',
                        text: '<i class="fas fa-print"></i> Imprimir',
                        className: 'dropdown-item',
                        exportOptions: {
                            columns: ':not(.no-print)'
                        }
                    }, {
                        text: '<i class="fas fa-print"></i> Resumen',
                        className: 'dropdown-item',
                        action: function (e, dt, node, config) {
                            if (functioname) {
                                functioname();
                            }
                        }
                    }
                ]
            }
        ],
        dom: '<"d-flex"lBf>rt<"d-flex justify-content-between"ip>',
    });
}

function deleteConfirmation() {
    Swal.fire({
        title: '¿Estás seguro?',
        text: "¿Quieres eliminar este registro?",
        icon: 'warning',
        showCancelButton: true,
        confirmButtonColor: '#3085d6',
        cancelButtonColor: '#d33',
        confirmButtonText: 'Aceptar'
    }).then((result) => {
        if (result.isConfirmed) {
            Swal.fire({
                title: "Eliminado!",
                text: "El registro ha sido eliminado",
                icon: "success"
            });
            return true;
        }
        return false;
    })
}

function generarBotonesAccion(id) {
    return `
        <button id="edit" class="btn btn-primary btn-edit" alt="Editar" data-id="${id}">
            <i class="fa fa-edit"></i>
        </button>
        <button id="delete" class="btn btn-danger btn-delete" alt="Eliminar" data-id="${id}">
            <i class="fa fa-trash"></i>
        </button>
    `;
}

function rellenarFormulario(formId, data, campos) {
    campos.forEach(campo => {
        if (data.hasOwnProperty(campo)) {
            $(`#${formId} #${campo}`).val(data[campo]);
        }
    });

    if (data.hasOwnProperty('is_active')) {
        const checkbox = $(`#${formId} #is_active`);
        checkbox.prop('checked', data.is_active);
    }
}

$(document).on('click', '[data-dismiss="modal"]', function () {
    $(this).closest('.modal').modal('hide');
    $('form')[0].reset();
    $('.security-level').text('');
});

$('.toggle-password').click(function (e) {
    e.preventDefault();
    var passwordField = document.getElementById("user_password");
    if (passwordField.type === "password") {
        $(".password").attr("type", "text");
        $(this).find('span').removeClass('fa-eye-slash').addClass('fa-eye');
        $(".password").focus();
    } else {
        $(".password").attr("type", "password");
        $(this).find('span').removeClass('fa-eye').addClass('fa-eye-slash');
        $(".password").focus();
    }
});
