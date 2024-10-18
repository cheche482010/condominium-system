<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $this->config->get('APP_NAME'); ?>
    </title>
    
    <?php
      $this->Link([
        ['rel' => 'icon', 'href' => $this->assets . 'img/logo.jpg', 'type' => 'image/x-icon'],
        ['rel' => 'stylesheet', 'href' => 'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback'],
        ['rel' => 'stylesheet', 'href' => $this->assets . 'plugins/fontawesome-free/css/all.min.css'],
        ['rel' => 'stylesheet', 'href' => $this->assets . 'plugins/icheck-bootstrap/icheck-bootstrap.min.css'],
        ['rel' => 'stylesheet', 'href' => 'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css'],
        ['rel' => 'stylesheet', 'href' => $this->assets . 'css/adminlte.min.css'],
        ['rel' => 'stylesheet', 'href' => $this->assetsView . "user/register/register.scss"]
      ])->view();
    ?>
</head>

<body class="hold-transition register-page">

<h1>Registro de Condominio</h1>
    <?php
      $this->Script([
        $this->assets . 'plugins/jquery/jquery.min.js',
        $this->assets . 'plugins/bootstrap/js/bootstrap.bundle.min.js',
        $this->assets . 'js/adminlte.min.js',
        $this->assets . 'js/constants.js',
        $this->assets . 'js/function.js',
        $this->assetsView . 'user/register/register.js',
      ])->view();
    ?>
</body>

</html>