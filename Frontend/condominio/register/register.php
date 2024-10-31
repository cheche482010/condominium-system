<!DOCTYPE html>
<html lang="es">

<head>
    <?php include __DIR__ . "/../../includes/meta.php"; ?>
    <title><?= $this->config->get('APP_NAME'); ?></title>
    <?php include __DIR__ . "/../../includes/link.php"; ?>

    <link href="<?= $this->assetsView; ?>condominio/register/register.scss" rel="stylesheet">
    <?php include __DIR__ . "/../../includes/data-table.php"; ?>
</head>

<body class="layout-navbar-fixed accent-primary layout-footer-fixed layout-fixed sidebar-mini sidebar-collapse">
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
            <?php
            $this->ContentHeader([
                'titulo' =>  $this->config->get('APP_NAME'),  
                'links' => [
                    ['label' =>  $this->config->get('APP_NAME'), 'url' => '#','active' => true],
                    ['label' => 'Registrar', 'url' => 'javascript::void(0)'],
                ],
            ])->view();
            ?>

            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-md-12">

                            <div class="card card-primary">
                                <div class="card-header">
                                    <h3 class="card-title">Registrar Condominio</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="formRegistroCondominio">
                                    <div class="card-body">
                                        <div class="form-group">
                                            <label for="nombre">Nombre del Condominio</label>
                                            <input type="text" class="form-control" id="nombre" name="nombre" placeholder="Ingrese el nombre del condominio" required>
                                        </div>
                                        <div class="form-group">
                                            <label for="alicuota">Alícuota</label>
                                            <input type="number" class="form-control" id="alicuota" name="alicuota" placeholder="Ingrese la alícuota" step="0.01" min="0" required>
                                        </div>
                                        <div class="form-group">
                                            <div class="custom-control custom-switch">
                                                <input type="checkbox" class="custom-control-input" id="is_active" name="is_active" checked>
                                                <label class="custom-control-label" for="is_active">Activo</label>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- /.card-body -->

                                    <div class="card-footer">
                                        <button type="submit" class="btn btn-primary">Registrar</button>
                                        <button type="button" class="btn btn-danger" onclick="window.history.back();">Cancelar</button>
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
    

    <script src="<?= $this->assetsView; ?>condominio/register/register.js"></script>
</body>

</html>