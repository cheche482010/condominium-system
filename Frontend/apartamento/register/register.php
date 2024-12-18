<?php verifySession(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php include __DIR__ . "/../../includes/meta.php"; ?>
    <title><?= TITLE; ?></title>
    <?php include __DIR__ . "/../../includes/link.php"; ?>

    <link href="<?= URL; ?>Frontend/apartamento/register/register.scss" rel="stylesheet">
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
                            <h1 class="m-0">Apartamentos</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item active"><?= TITLE; ?></li>
                                <li class="breadcrumb-item"><a href="register">Registrar</a></li>
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
                                    <h3 class="card-title">Registrar Apartamento</h3>
                                </div>
                                <!-- /.card-header -->
                                <!-- form start -->
                                <form id="registerApartament">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="nombre">Nombre del Apartamento</label>
                                                    <input type="text" class="form-control" id="nombre" name="nombre"
                                                        placeholder="Ingrese el nombre del Apartamento">
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="condominio">Condominio</label>
                                                    <select id="condominio" name="condominio"
                                                        class="form-control custom-select">
                                                        <option value="">Seleccione un condominio</option>
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="deuda">Deuda</label>
                                                    <input type="number" class="form-control" id="deuda" name="deuda"
                                                        placeholder="Ingrese la Deuda" step="0.01" min="0">
                                                </div>
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="alicuota">Alícuota</label>
                                                    <input type="number" class="form-control" id="alicuota"
                                                        name="alicuota" placeholder="Ingrese la alícuota" step="0.01"
                                                        min="0">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="is_active" name="is_active" checked>
                                                        <label class="custom-control-label"
                                                            for="is_active">Activo</label>
                                                    </div>
                                                </div>
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

    <script src="<?= URL; ?>Frontend/apartamento/register/register.js"></script>
</body>

</html>