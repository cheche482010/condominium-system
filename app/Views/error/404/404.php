<!DOCTYPE html>
<html>

<head>
    <title>404 Not Found</title>
    <link rel="icon" type="image/x-icon" href="<?=  $this->URL?>public/assets/img/404.png">
    <link rel="stylesheet" href="<?=  $this->URL?>app/Views/error/404/404.scss">
</head>

<body>
    <div class="noise"></div>
    <div class="overlay"></div>
    <div class="terminal">
        <h1>Error <span class="errorcode">404</span></h1>
        <p class="output">
            La página que busca puede haber sido eliminada, haber cambiado de nombre o no estar disponible temporalmente.
            temporalmente no disponible.
        </p>
        <p class="output">
            Por favor, intente <a href="home">volver a la página de inicio</a>.
        </p>
        <p class="output">Buena suerte.</p>
    </div>
</body>

</html>