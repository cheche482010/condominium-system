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
        ['rel' => 'stylesheet', 'href' => $this->assets . 'css/adminlte.min.css'],
        ['rel' => 'stylesheet', 'href' => $this->assetsView . "user/login/login.scss"],
        ['rel' => 'stylesheet', 'href' => 'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css'],
      ])->view();
    ?>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <span class="h1"><?= $this->config->get('APP_NAME'); ?></span>
            </div>

            <div class="card-body">
                <p class="login-box-msg">Inicie sesión</p>

                <form action="" method="POST">
                    <div class="input-group mb-3">
                        <input id="email" type="email" class="form-control" placeholder="Email">
                        <div class="input-group-append">
                            <div class="input-group-text">
                                <span class="fas fa-envelope"></span>
                            </div>
                        </div>
                    </div>
                    <div class="input-group mb-3">
                        <input type="password" class="form-control password" id="user_password" placeholder="Password">
                        <div class="input-group-append">
                            <div class="input-group-text toggle-password">
                                <span class="fas fa-eye-slash"></span>
                            </div>
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-8">
                            <div class="icheck-primary">
                                <input type="checkbox" id="remember">
                                <label for="remember">
                                    Remember Me
                                </label>
                            </div>
                        </div>
                        <!-- /.col -->
                        <div class="col-4">
                            <button id="login" type="button" class="btn btn-primary btn-block">Ingresar</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <div class="row login-footer">
                    <p class="col-6">
                        <a href="forgot-password.html">Recupera Contraseña</a>
                    </p>
                    <p class="col-6">
                        <a href="Register" class="text-center">Registrarse</a>
                    </p>
                </div>
            </div>
            <!-- /.card-body -->
        </div>
        <!-- /.card -->
    </div>
    <!-- /.login-box -->

    <?php
      $this->Script([
        $this->assets . 'plugins/jquery/jquery.min.js',
        $this->assets . 'plugins/bootstrap/js/bootstrap.bundle.min.js',
        $this->assets . 'js/adminlte.min.js',
        $this->assets . 'js/constants.js',
        $this->assets . 'js/function.js',
        $this->assetsView . 'user/login/login.js',
        'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js',
        'https://code.jquery.com/ui/1.12.1/jquery-ui.min.js',
        'https://cdn.jsdelivr.net/npm/sweetalert2@11',
      ])->view();
    ?>
</body>

</html>