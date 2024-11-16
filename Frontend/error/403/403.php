<!DOCTYPE html>
<html>

<head>
    <title>403 Forbidden</title>
    <link rel="icon" type="image/x-icon" href="<?= URL; ?>Frontend/assets/img/403.svg">
    <link rel="stylesheet" href="<?= URL; ?>Frontend/error/403/403.scss">
</head>

<body>
    <h1>403</h1>
    <div>
        <p>> 
            <span>CÓDIGO DE ERROR</span>: "<i>HTTP 403 Prohibido</i>"
        </p>
        <p>> 
            <span>DESCRIPCIÓN DEL ERROR</span>: "<i>Acceso Denegado. Usted No Tiene La Permisión Para Acceder A Esta
                Página En Este Servidor</i>"
        </p>
        <p>> 
            <span>POSIBLES CAUSAS DEL ERROR</span>: [<b>acceso ejecutivo prohibido, acceso de lectura prohibido, acceso
                de escritura prohibido,
                requerido SSL, requerido SSL 128, dirección IP rechazada, certificado cliente requerido, acceso de sitio
                denegado,
                excedida cantidad de usuarios, configuración inválida, cambio de contraseña, acceso denegado por
                mapeador,
                certificado cliente revocado, lista de directorios denegada, licencias de acceso de cliente excedidas,
                certificado cliente sin confiar o inválido, certificado cliente expirado o no aún válido, fallido inicio
                de sesión de pasaporte,
                acceso de origen denegado, denegado profundidad infinita, excedida cantidad de solicitudes desde la
                misma dirección IP del cliente
            </b>...]
        </p>
        <p>> 
            <span>PÁGINAS EN ESTE SERVIDOR A LAS QUE USTED TIENE PERMISOS PARA ACCESAR</span>: [<a href="<?= URL; ?>user/login">Iniciar Sesion</a>]
        </p>
        <p>> <span>QUE TENGAS UN DÍA.</span></p>
    </div>

    <script src="<?= URL; ?>Frontend/error/403/403.js"></script>
</body>

</html>