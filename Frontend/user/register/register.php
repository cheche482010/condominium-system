<!DOCTYPE html>
<html lang="es">

<head>
    <?php include __DIR__ . "/../../includes/meta.php"; ?>
    <title><?= $this->config->get('APP_NAME'); ?></title>
    <?php include __DIR__ . "/../../includes/link.php"; ?>
    
    <link href="<?= $this->assetsView; ?>user/register/register.scss" rel="stylesheet">
</head>

<body class="hold-transition register-page">
    <div class="register-box">
        <div class="card card-outline card-primary">
            <div class="card-header text-center">
                <span class="h1"><?= $this->config->get('APP_NAME'); ?></span>
            </div>

            <div class="card-body">
                <p class="login-box-msg">Registrar nuevo Usuario</p>

                <form action="" method="post">

                    <div class="row mb-2">
                        <div class="col-md-12">
                            <label for="cedula">Cedula</label>
                            <div class="input-group">
                                <input id="cedula" type="text" class="form-control" placeholder="Cedula....">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-id-card"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label for="nombre">Nombre</label>
                            <div class="input-group">
                                <input id="nombre" type="text" class="form-control" placeholder="Nombre....">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="apellido">Apellido</label>
                            <div class="input-group">
                                <input id="apellido" type="text" class="form-control" placeholder="Apellido....">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-user"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-6">
                            <label for="email">Correo</label>
                            <div class="input-group">
                                <input id="email" type="email" class="form-control" placeholder="example@gmail.com">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-envelope"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-6">
                            <label for="phone">Telefono</label>
                            <div class="input-group">
                                <input id="phone" type="phone" class="form-control" placeholder="+58 123 456 7890">
                                <div class="input-group-append">
                                    <div class="input-group-text">
                                        <span class="fas fa-phone"></span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row mb-2">
                        <div class="col-md-12">
                            <label for="user_password">Contraseña</label>
                            <div class="input-group">
                                <input id="user_password" type="password" class="form-control password" placeholder="*****">
                                <div class="input-group-append">
                                    <div class="input-group-text toggle-password">
                                        <span class="fas fa-eye-slash"></span>
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 mt-2">
                            <label for="retryPassword">Confirmar</label>
                            <div class="input-group">
                                <input id="retryPassword" type="password" class="form-control password" placeholder="*****">
                            </div>
                        </div>

                        <div class="col-md-12 mt-2 secure-password">
                            <div class="progress-wrap">
                                <div class="progress-bar" role="progressbar" style="width: 0%;" aria-valuenow="0"
                                    aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                            <span class="security-level"></span>
                        </div>
                    </div>

                    <div class="row button-container">
                        <!-- /.col -->
                        <div class="col-12">
                            <button id="register" type="button" class="btn btn-primary btn-block">Register</button>
                        </div>
                        <!-- /.col -->
                    </div>
                </form>

                <!-- <div class="social-auth-links text-center">
                    <a href="#" class="btn btn-primary facebook">
                        <i class="fab fa-facebook mr-2"></i>
                        Sign up using Facebook
                    </a>
                    <a href="#" class="btn btn-danger google">
                        <i class="fab fa-google-plus mr-2"></i>
                        Sign up using Google+
                    </a>
                </div> -->
            </div>
            <!-- /.form-box -->
        </div><!-- /.card -->
    </div>
    <!-- /.register-box -->

    
    <?php include __DIR__ . "/../../includes/script.php"; ?>

    <script src="<?= $this->assetsView; ?>user/register/register.js"></script>
</body> 

</html>