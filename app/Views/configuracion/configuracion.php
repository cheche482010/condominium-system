<!DOCTYPE html>
<html lang="es">

<head>
    <?php include __DIR__ . "/../includes/meta.php"; ?>
    <title><?= $this->config->get('APP_NAME'); ?></title>
    <?php include __DIR__ . "/../includes/link.php"; ?>

    <link href="<?= $this->assetsView; ?>bitacora/list/list.scss" rel="stylesheet">
    <?php include __DIR__ . "/../includes/data-table.php"; ?>
</head>

<body class="layout-navbar-fixed accent-primary layout-footer-fixed layout-fixed sidebar-mini sidebar-collapse">
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
            <?php
            $this->ContentHeader([
                'titulo' =>  "Configuracion Web",  
                'links' => [
                    ['label' =>  "Administracion", 'url' => 'javascript::void(0)','active' => true],
                    ['label' => 'Configuracion', 'url' => 'javascript::void(0)'],
                ],
            ])->view();
            ?>

            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">All together</h3>

                                    <div class="card-tools">

                                        <button type="button" class="btn btn-tool" data-card-widget="maximize">
                                            <i class="fas fa-expand"></i>
                                        </button>
                                        <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                            <i class="fas fa-minus"></i>
                                        </button>

                                    </div>
                                    <!-- /.card-tools -->
                                </div>
                                <!-- /.card-header -->
                                <div class="card-body">
                                    The body of the card
                                </div>
                                <!-- /.card-body -->

                                <div class="card-footer">
                                    This is the card footer
                                </div>
                                <!-- /.card-footer -->
                            </div>
                        </div>
                    </div>

                    <div class="row">
                        
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

    <script src="<?= $this->assetsView; ?>bitacora/list/list.js"></script>
</body>

</html>