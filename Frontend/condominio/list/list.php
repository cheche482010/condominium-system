<?php verifySession(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php include __DIR__ . "/../../includes/meta.php"; ?>
    <title><?= TITLE; ?></title>
    <?php include __DIR__ . "/../../includes/link.php"; ?>

    <link href="<?= URL; ?>Frontend/condominio/list/list.scss" rel="stylesheet">
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
            <div class='content-header'>
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Condominios</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item active"><?= TITLE; ?></li>
                                <li class="breadcrumb-item"><a href="list">Listar</a></li>
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
                            <div class="card">
                                <div class="card-header">
                                    <h3 class="card-title">Lista de Condominios</h3>
                                </div>
                                <div class="card-body">
                                    <table id="condomainTable" class="table table-bordered" style="width:100%">
                                        <thead>
                                            <tr>
                                                <th>#</th>
                                                <th>Nombre</th>
                                                <th>Deuda</th>
                                                <th>Alícuota</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                        </tbody>
                                        <tfoot>
                                            <tr>
                                                <th>#</th>
                                                <th>Nombre</th>
                                                <th>Deuda</th>
                                                <th>Alícuota</th>
                                                <th>Estado</th>
                                                <th>Acciones</th>
                                            </tr>
                                        </tfoot>
                                    </table>
                                </div>
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

    <script src="<?= URL; ?>Frontend/condominio/list/list.js"></script>
</body>

</html>