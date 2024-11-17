<?php verifySession(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php include __DIR__ . "/../../includes/meta.php"; ?>
    <title><?= TITLE; ?></title>
    <?php include __DIR__ . "/../../includes/link.php"; ?>

    <link href="<?= URL; ?>Frontend/user/profile/profile.scss" rel="stylesheet">
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
                            <h1 class="m-0">
                                Perfil
                            </h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item active"><?= TITLE; ?></li>
                                <li class="breadcrumb-item"><a href="profile">Perfil</a></li>
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
                        <div class="col-md-3">

                            <!-- Profile Image -->
                            <div class="card card-primary card-outline">
                                <div class="card-body box-profile">

                                    <h3 class="profile-username text-center">
                                        <?= $_SESSION['user']['nombre']." ".$_SESSION['user']['apellido']; ?>
                                    </h3>

                                    <p class="text-muted text-center">
                                        Rol: <?= $_SESSION['user']['rol']['nombre']; ?>
                                    </p>

                                    <ul class="list-group list-group-unbordered mb-3">
                                        <li class="list-group-item">
                                            <b>Condominio</b> <a class="float-right">Test 1</a>
                                        </li>
                                        <li class="list-group-item">
                                            <b>Deuda</b> <a class="float-right">543</a>
                                        </li>
                                    </ul>
                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->

                            <!-- About Me Box -->
                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Datos</h3>
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    <strong>
                                        <i class="fas fa-id-card mr-1"></i> Cedula
                                    </strong>

                                    <p class="text-muted">
                                        26142326
                                    </p>

                                    <hr>

                                    <strong>
                                        <i class="fas fa-envelope mr-1"></i> Correo
                                    </strong>

                                    <p class="text-muted">
                                        example@gmail.com
                                    </p>

                                    <hr>

                                    <strong>
                                        <i class="fas fa-phone mr-1"></i> Telefono
                                    </strong>

                                    <p class="text-muted">
                                        +58 416 183 5429
                                    </p>

                                </div>
                                <!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                        <div class="col-md-9">
                            <div class="card">
                                <div class="card-header p-2">
                                    <ul class="nav nav-pills">
                                        <li class="nav-item">
                                            <a class="nav-link active" href="#history" data-toggle="tab">Historial</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#pagos" data-toggle="tab">Pagar</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" href="#security" data-toggle="tab">Seguridad</a>
                                        </li>
                                    </ul>
                                </div><!-- /.card-header -->
                                <div class="card-body">
                                    <div class="tab-content">
                                        <div class="active tab-pane" id="history">
                                            <!-- Post -->
                                            <div class="post">
                                                <p>
                                                    Lorem ipsum represents a long-held tradition for designers,
                                                    typographers and the like. Some people hate it and argue for
                                                    its demise, but others ignore the hate as they create awesome
                                                    tools to help create filler text for everyone from bacon lovers
                                                    to Charlie Sheen fans.
                                                </p>
                                            </div>
                                            <!-- /.post -->


                                        </div>
                                        <!-- /.tab-pane -->
                                        <div class="tab-pane" id="pagos">
                                            <!-- The timeline -->
                                            <p>
                                                Lorem ipsum represents a long-held tradition for designers,
                                                typographers and the like. Some people hate it and argue for
                                                its demise, but others ignore the hate as they create awesome
                                                tools to help create filler text for everyone from bacon lovers
                                                to Charlie Sheen fans.
                                            </p>
                                        </div>
                                        <!-- /.tab-pane -->

                                        <div class="tab-pane" id="security">
                                            <p>
                                                Lorem ipsum represents a long-held tradition for designers,
                                                typographers and the like. Some people hate it and argue for
                                                its demise, but others ignore the hate as they create awesome
                                                tools to help create filler text for everyone from bacon lovers
                                                to Charlie Sheen fans.
                                            </p>
                                        </div>
                                        <!-- /.tab-pane -->
                                    </div>
                                    <!-- /.tab-content -->
                                </div><!-- /.card-body -->
                            </div>
                            <!-- /.card -->
                        </div>
                        <!-- /.col -->
                    </div>
                    <!-- /.row -->
                </div><!-- /.container-fluid -->
            </section>
        </div>

        <!-- /.content -->
    </div>
    <!-- /.content-wrapper -->

    <!-- Footer -->
    <?php include __DIR__ . "/../../includes/footer.php"; ?>
    <!-- /.footer -->
    </div>
    <!-- ./wrapper -->
    <?php include __DIR__ . "/../../includes/script.php"; ?>

    <script src="<?= URL; ?>Frontend/user/profile/profile.js"></script>
</body>

</html>