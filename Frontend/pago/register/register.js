$(document).ready(function () {

    function validateForm() {
        return isValid;
    }

    $('#register').click(function (e) {
        e.preventDefault();
        const formData = captureFormData();
        delete formData.retryPassword;
        
        if (validateForm()) {
            $.ajax({
                url: PROJECT_URL + '/api/',
                method: 'POST',
                data: {
                    data: formData,
                },
                dataType: 'json',
                success: function (data) {
    
                    if (!handleErrorValidate(data) || !handleErrorExisting(data)) {
                        return; 
                    }
    
                    Swal.fire({
                        title: 'Registro Exitoso',
                        text: 'Se ha registrado con éxito.',
                        icon: 'success',
                        confirmButtonText: 'Continuar'
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
        }
    });

});