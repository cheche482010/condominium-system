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
                return  generarBotonesAccion(row.id);
            }
        }
    ]); 

});