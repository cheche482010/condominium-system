$(document).ready(function () {

    var table = createDataTable('#condominiosTable', {
        url:   '../api/user/getAll',
    },
        [{
            data: 'id'
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
    $('#example tbody').on('click', '.btn-edit', function () {
        var data = table.row($(this).parents('tr')).data();
        alert('Edit User ID: ' + data.userId + ', ID: ' + data.id);
        // Implement your edit logic here
        table.ajax.reload(null, false);
    });

    // Delete button click handler
    $('#example tbody').on('click', '.btn-delete', function () {
        var row = table.row($(this).parents('tr'));
        var data = row.data();
        if (confirm('Are you sure you want to delete this row?')) {
            // Implement your delete logic here (e.g., send an AJAX request to delete the record)
            row.remove().draw(); // Remove row from the DataTable
        }
    });
});