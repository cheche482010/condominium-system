$(document).ready(function() {
    $('#tipo_pago').selectize({
        create: true,
        sortField: 'text'
    });

    $('#apartamento').selectpicker({
        liveSearch: true,
        liveSearchNormalize: false,
        size: 10,
        style: 'btn btn-default'
    });

    $.ajax({
        url: PROJECT_URL + 'api/apartamento/getAllApartments',
        method: 'GET',
        dataType: 'json',
        success: function (data) {

            if (!handleError(data)) {
                return;
            }

            var options = '<option value="">Seleccione un apartamento</option>';
            $.each(data.data, function (index, item) {
                options += '<option value="' + item.id + '">' + item.nombre + '</option>';
            });
            $('#apartamento').html(options);
            $('#apartamento').selectpicker('refresh');
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

    $('#register').click(function (e) {
        e.preventDefault();
        
        const pagoData = {
            id_apartamento: parseInt($('#apartamento').val()) || null,
            tipo_pago: $('#tipo_pago').val(),
            monto: parseFloat($('#monto').val()),
            fecha: $('#fecha').val(),
            comprobante: $('#comprobante')[0] ? $('#comprobante')[0].files[0].name : null
        };

        if (!validateForm()) {
            return;
        }

        $.ajax({
            url: PROJECT_URL + 'api/pago/create',
            method: 'POST',
            dataType: 'json',
            data: { pago_data: JSON.stringify(pagoData) },
            success: function (data) {
                
                if (!handleErrorValidate(data) || !handleError(data)) {
                    return;
                }

                Swal.fire({
                    title: 'Registro Exitoso',
                    text: 'Pago realizado con exito',
                    icon: 'success',
                    confirmButtonText: 'Continuar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('form')[0].reset();
                    }
                });
            },
            error: function (xhr, status, error) {
                console.error('Error:', error);
                Swal.fire({
                    title: 'Error al registrar',
                    text: 'Ha ocurrido un error al intentar registrarse. Por favor, inténtelo nuevamente.',
                    icon: 'error'
                });
            }
        });
    });

    function validateForm() {
        
        const apartamento = $('#apartamento').val();
        const tipo_pago = $('#tipo_pago').val();
        const monto = $('#monto').val();
        const fecha = $('#fecha').val();
        const comprobante = $('#comprobante').val();
    
        if (!apartamento || !tipo_pago || !monto || !fecha) {
            toastr.error("Por favor, llene todos los campos obligatorios.");
            return false;
        }
    
        const dateRegex = /^\d{4}-\d{2}-\d{2}$/;
        if (!dateRegex.test(fecha)) {
            toastr.error("La fecha debe estar en formato YYYY-MM-DD.");
            return false;
        }
    
        const numberRegex = /^[0-9]+(\.[0-9]{1,2})?$/;
        if (!numberRegex.test(monto)) {
            toastr.error("El monto debe ser un número válido.");
            return false;
        }
    
        if (comprobante.size > 5 * 1024 * 1024) { 
            toastr.error("El archivo seleccionado es demasiado grande. El tamaño máximo permitido es 5MB.");
            return false;
        }else if (!['image/jpeg', 'image/png', 'application/pdf'].includes(comprobante.files[0].type)) {
            toastr.error("Solo se admiten archivos de imagen JPEG/PNG y PDF.");
            return false;
        }
    
        return true; 
    }
    
    
});