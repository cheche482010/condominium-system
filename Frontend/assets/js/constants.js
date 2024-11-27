const BASE_URL = window.location.origin;
const PATH_BASE = window.location.pathname.split('/').filter(Boolean);
const PROJECT_ROOT = PATH_BASE.slice(0, -2).join('/') + '/';
const PROJECT_URL = "http://localhost/www/condominium-system/";

// mensajes
const MSG_ERROR_VALIDATE = "Lo siento, ha habido un problema con los datos ingresados. Por favor, vuelva a intentar y asegúrese de llenar todos los campos correctamente."

