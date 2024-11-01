<!DOCTYPE html>
<html lang="es">

<head>
    <?php include __DIR__ . "/../../includes/meta.php"; ?>
    <title><?= TITLE; ?></title>
    <?php include __DIR__ . "/../../includes/link.php"; ?>

    <link href="<?= URL; ?>Frontend/user/register/register.scss" rel="stylesheet">
</head>

<body class="layout-navbar-fixed accent-primary layout-footer-fixed layout-fixed sidebar-mini sidebar-collapse">
    <!-- Wrapper -->
    <div class="wrapper">

        <!-- Navbar -->
        <?php include __DIR__ . "/../../includes/navbar.php"; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include __DIR__ . "/../../includes/sidebar.php"; ?>
        <!-- Main Sidebar Container -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class='content-header'>
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Usuarios</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item active">Condominium System</li>
                                <li class="breadcrumb-item"><a href="home">Inicio</a></li>
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Registrar nuevo Usuario</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="register-form" action="POST">
                                    <div class="card-body">
                                        <div class="row mb-2">
                                            <div class="col-md-12">
                                                <label for="cedula">Cedula</label>
                                                <div class="input-group">
                                                    <input id="cedula" type="text" class="form-control"
                                                        placeholder="Cedula....">
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
                                                    <input id="nombre" type="text" class="form-control"
                                                        placeholder="Nombre....">
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
                                                    <input id="apellido" type="text" class="form-control"
                                                        placeholder="Apellido....">
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
                                                    <input id="email" type="email" class="form-control"
                                                        placeholder="example@gmail.com">
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
                                                    <input id="phone" type="phone" class="form-control"
                                                        placeholder="+58 123 456 7890">
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
                                                <div class="form-group">
                                                    <label for="condominio">Condominio</label>
                                                    <select id="condominio" name="condominio"
                                                        class="form-control custom-select">
                                                        <option value="">Seleccione un condominio</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-2">
                                            <div class="col-md-12">
                                                <label for="user_password">Contraseña</label>
                                                <div class="input-group">
                                                    <input id="user_password" type="password"
                                                        class="form-control password" placeholder="*****">
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
                                                    <input id="retryPassword" type="password"
                                                        class="form-control password" placeholder="*****">
                                                </div>
                                            </div>

                                            <div class="col-md-12 mt-2 secure-password">
                                                <div class="progress-wrap">
                                                    <div class="progress-bar" role="progressbar" style="width: 0%;"
                                                        aria-valuenow="0" aria-valuemin="0" aria-valuemax="100">
                                                    </div>
                                                </div>
                                                <span class="security-level"></span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <div class="row">
                                            <!-- /.col -->
                                            <div class="col-12">
                                                <button id="register" type="button"
                                                    class="btn btn-primary">Register</button>
                                                <button id="clear" type="button" class="btn btn-danger">Limpiar</button>
                                            </div>
                                            <!-- /.col -->
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>
                </div>

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Footer -->
        <?php include __DIR__ . "/../../includes/footer.php"; ?>
        <!-- /.footer -->
    </div>
    <!-- ./wrapper -->
    <?php include __DIR__ . "/../../includes/script.php"; ?>

    <script src="<?= URL; ?>Frontend/user/register/register.js"></script>
</body>

</html>