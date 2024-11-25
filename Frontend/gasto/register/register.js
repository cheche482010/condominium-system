$(document).ready(function () {

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

    $('#register').on('click', function (e) {
        e.preventDefault();

        const dataGasto = {
            id_tipo: parseInt($('#id_tipo').val()) || null,
            concepto: $('#concepto').val() || '',
            monto: $('#monto').val() || '',
            fecha: $('#fecha').val() || '',
            is_active: $('#is_active').prop('checked'),
        };

        if (!validateForm()) {
            return;
        }

        $.ajax({
            url: PROJECT_URL + 'api/gasto/create',
            method: 'POST',
            dataType: 'json',
            data: { gasto_data: JSON.stringify(dataGasto) },
            success: function (response) {

                if (!handleErrorValidate(response) || !handleError(response) || response.Type == "Error") {
                    return;
                }

                Swal.fire({
                    title: 'Registro Exitoso',
                    text: 'Se ha registrado el Gasto con éxito.',
                    icon: 'success',
                    confirmButtonText: 'Continuar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('form')[0].reset();
                    }
                });
            },
            error: function (xhr, status, error) {
                var errorMessage = xhr.responseJSON ? xhr.responseJSON.message : 'Error al registrar el Gasto';
                console.error('Error:', errorMessage);
                Swal.fire({
                    title: 'Error al registrar',
                    text: 'Ha ocurrido un error al intentar registrar. Por favor, inténtelo nuevamente.',
                    icon: 'error'
                });
            }
        });
    });

    function validateForm() {
        $('.form-control').removeClass('invalid-input');

        // Validate id_tipo
        if ($('#id_tipo').val() === '') {
            toastr.error('Por favor seleccione un tipo de gasto.');
            $('#id_tipo').addClass('invalid-input');
            return false;
        }

        // Validate concepto
        if ($('#concepto').val().trim() === '') {
            toastr.error('El concepto es obligatorio.');
            $('#concepto').addClass('invalid-input');
            return false;
        } else if ($('#concepto').val().length < 5) {
            toastr.error('El concepto debe tener al menos 5 caracteres.');
            $('#concepto').addClass('invalid-input');
            return false;
        }

        // Validate monto
        let monto = $('#monto').val();
        if (monto.trim() === '') {
            toastr.error('El monto es obligatorio.');
            $('#monto').addClass('invalid-input');
            return false;
        } else if (!/^\d+(\.\d{1,2})?$/.test(monto)) {
            toastr.error('Por favor ingrese un valor numérico válido.');
            $('#monto').addClass('invalid-input');
            return false;
        }

        // Validate fecha registro
        let fechaRegistro = $('#fecha').val();
        if (fechaRegistro.trim() === '') {
            toastr.error('La fecha de registro es obligatoria.');
            $('#fecha').addClass('invalid-input');
            return false;
        } else if (!(new Date(fechaRegistro) instanceof Date && !isNaN(Date.parse(fechaRegistro)))) {
            toastr.error('Por favor seleccione una fecha válida.');
            $('#fecha').addClass('invalid-input');
            return false;
        }

        // Validate is_active
        if (!$('#is_active').prop('checked')) {
            toastr.error('Por favor seleccione si el gasto está activo.');
            $('#is_active').closest('.custom-control').addClass('invalid-input');
            return false;
        }

        return true;
    }


});