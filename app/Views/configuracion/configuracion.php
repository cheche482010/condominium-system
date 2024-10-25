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
                            <div id="accordion">
                                <div class="card card-outline card-secondary">
                                    <div class="card-header" id="headingOne">
                                        <div class="card-title">
                                            <button type="button" class="btn btn-tool" data-toggle="collapse"
                                                data-target="#collapseOne" aria-expanded="false"
                                                aria-controls="collapseOne"><i class="fas fa-plus"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i
                                                    class="fas fa-expand"></i>
                                            </button>
                                            <span class="card-subtitle">
                                                Item #1
                                            </span>
                                        </div>
                                    </div>
                                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                                        data-parent="#accordion">
                                        <div class="card-body">

                                        </div>
                                    </div>
                                </div>
                                <div class="card card-outline card-secondary">

                                    <div class="card-header" id="headingTwo">
                                        <div class="card-title">
                                            <button type="button" class="btn btn-tool" data-toggle="collapse"
                                                data-target="#collapseTwo" aria-expanded="false"
                                                aria-controls="collapseTwo"><i class="fas fa-plus"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i
                                                    class="fas fa-expand"></i>
                                            </button>
                                            <span class="card-subtitle">
                                                Item #2
                                            </span>
                                        </div>
                                    </div>
                                    <div id="collapseTwo" class="collapse" aria-labelledby="headingTwo"
                                        data-parent="#accordion">
                                        <div class="card-body">

                                        </div>
                                    </div>
                                </div>
                                <div class="card card-outline card-secondary">
                                    <div class="card-header" id="headingThree">
                                        <div class="card-title">
                                            <button type="button" class="btn btn-tool" data-toggle="collapse"
                                                data-target="#collapseThree" aria-expanded="false"
                                                aria-controls="collapseThree"><i class="fas fa-plus"></i>
                                            </button>
                                            <button type="button" class="btn btn-tool" data-card-widget="maximize"><i
                                                    class="fas fa-expand"></i>
                                            </button>
                                            <span class="card-subtitle">
                                                Item #2
                                            </span>
                                        </div>
                                    </div>
                                    <div id="collapseThree" class="collapse" aria-labelledby="headingThree"
                                        data-parent="#accordion">
                                        <div class="card-body">

                                        </div>
                                    </div>
                                </div>
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