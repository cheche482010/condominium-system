<!DOCTYPE html>
<html lang="es">

<head>
    <?php include __DIR__ . "/../includes/meta.php"; ?>
    <title><?= TITLE; ?></title>
    <?php include __DIR__ . "/../includes/link.php"; ?>
</head>

<body class="layout-navbar-fixed accent-primary layout-footer-fixed layout-fixed sidebar-mini sidebar-collapse">
    <!-- Wrapper -->
    <div class="wrapper">

        <!-- Navbar -->
        <?php include __DIR__ . "/../includes/navbar.php"; ?>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <?php include __DIR__ . "/../includes/sidebar.php"; ?>
        <!-- Main Sidebar Container -->

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class='content-header'>
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Condominium System</h1>
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

                        <div class='col-lg-3 col-6'>
                            <div class="small-box bg-info">
                                <div class="inner">
                                    <h3>3</h3>
                                    <p>Catedras</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-ios-book"></i>
                                </div>
                                <a href="#" class="small-box-footer">Information <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class='col-lg-3 col-6'>
                            <div class="small-box bg-success">
                                <div class="inner">
                                    <h3>10<sup style="font-size: 20px">%</sup></h3>
                                    <p>Pagos</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-stats-bars"></i>
                                </div>
                                <a href="#" class="small-box-footer">Information <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class='col-lg-3 col-6'>
                            <div class="small-box bg-warning">
                                <div class="inner">
                                    <h3>44</h3>
                                    <p>Estudiantes</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-android-contact"></i>
                                </div>
                                <a href="#" class="small-box-footer">Information <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>

                        <div class='col-lg-3 col-6'>
                            <div class="small-box bg-gray">
                                <div class="inner">
                                    <h3>65</h3>
                                    <p>Configuración</p>
                                </div>
                                <div class="icon">
                                    <i class="ion ion-android-settings"></i>
                                </div>
                                <a href="#" class="small-box-footer">Information <i
                                        class="fas fa-arrow-circle-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <!-- Footer -->
        <?php include __DIR__ . "/../includes/footer.php"; ?>
        <!-- /.footer -->
    </div>
    <!-- ./wrapper -->

    <?php include __DIR__ . "/../includes/script.php"; ?>
</body>

</html>