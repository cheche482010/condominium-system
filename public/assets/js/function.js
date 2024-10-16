
function handleErrorValidate(data) {
    if (data.status === false && data.type === 'errorValidate') {
        toastr.error(MSG_ERROR_VALIDATE);
        return false;
    }
    return true;
}

function handleErrorExisting(data) {
    if (data.status === false && data.code === 409) {
        toastr.error(data.data +" "+ data.message);
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

function captureFormData() {
    const formData = {};

    $('.form-control').each(function (index) {
        const $input = $(this);
        const name = $input.attr('id');
        const value = $input.val();
        formData[name] = value;
    });

    return formData;
}