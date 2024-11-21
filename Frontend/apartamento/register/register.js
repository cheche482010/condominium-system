$(document).ready(function () {
    $('#register').on('click', function (e) {
        e.preventDefault();

        const dataApartament = {
            nombre: $('#nombre').val() || '',
            deuda: parseFloat($('#deuda').val()) || 0,
            alicuota: parseFloat($('#alicuota').val()) || 0,
            is_active: $('#is_active').prop('checked'),
        };

        if (!validateForm(dataApartament)) {
            return;
        }

        $.ajax({
            url: PROJECT_URL + 'api/apartamento/create',
            method: 'POST',
            dataType: 'json',
            data: { apartament_data: JSON.stringify(dataApartament) },
            success: function (response) {
                
                if (!handleErrorValidate(response) || !handleError(response)) {
                    return;
                }

                Swal.fire({
                    title: 'Registro Exitoso',
                    text: 'Se ha registrado el Apartamento con éxito.',
                    icon: 'success',
                    confirmButtonText: 'Continuar'
                }).then((result) => {
                    if (result.isConfirmed) {
                        $('form')[0].reset();
                    }
                });
            },
            error: function (xhr, status, error) {
                var errorMessage = xhr.responseJSON ? xhr.responseJSON.message : 'Error al registrar el Apartamento';
                console.error('Error:', errorMessage);
                Swal.fire({
                    title: 'Error al registrar',
                    text: 'Ha ocurrido un error al intentar registrar. Por favor, inténtelo nuevamente.',
                    icon: 'error'
                });
            }
        });
    });

    $('#condominio').selectpicker({
        liveSearch: true,
        liveSearchNormalize: false,
        size: 10,
        style: 'btn btn-default'
    });

    function validateForm(data) {
        const nombre = data.nombre.trim();
        const deuda = data.deuda;
        const alicuota = data.alicuota;

        if (nombre.length === 0) {
            toastr.error('El campo Nombre del Apartamento es obligatorio.');
            return false;
        }

        if (!/^[a-zA-Z0-9ñÑ\s-]+$/i.test(nombre)) {
            toastr.error('El Nombre del Apartamento solo puede contener letras, números y los caracteres especiales - y ñ.');
            return false;
        }

        if (nombre.length < 3 || nombre.length > 100) {
            toastr.error('El Nombre del Apartamento debe tener entre 3 y 100 caracteres.');
            return false;
        }

        // Validate debt
        if (isNaN(deuda) || deuda <= 0) {
            toastr.error('La Deuda debe ser un número válido mayor a cero.');
            return false;
        }

        // Validate quota
        if (isNaN(alicuota) || alicuota <= 0) {
            toastr.error('La Alícuota debe ser un número válido mayor a cero.');
            return false;
        }

        return true;
    }
});
