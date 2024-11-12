<!DOCTYPE html>
<html lang="es">

<head>
    <?php include __DIR__ . "/../../includes/meta.php"; ?>
    <title><?= TITLE; ?></title>
    <?php include __DIR__ . "/../../includes/link.php"; ?>

    <link href="<?= URL; ?>Frontend/user/login/login.scss" rel="stylesheet">
    <style>
        #roles-container {
            display: none;
        }
    </style>
</head>

<body class="hold-transition login-page">
    <div class="login-box">
        <!-- /.login-logo -->
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <span class="h1"><?= TITLE; ?></span>
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
                        <div id="roles-container">
                            Seleccione su rol
                            <br>
                            <input type="radio" name="role" value="" required>
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
    <?php include __DIR__ . "/../../includes/script.php"; ?>

    <script src="<?= URL; ?>Frontend/user/login/login.js"></script>
</body>

</html>