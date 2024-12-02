<?php verifySession(); ?>
<!DOCTYPE html>
<html lang="es">

<head>
    <?php include __DIR__ . "/../../includes/meta.php"; ?>
    <title><?= TITLE; ?></title>
    <?php include __DIR__ . "/../../includes/link.php"; ?>
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/css/selectize.bootstrap3.min.css">

    <link href="<?= URL; ?>Frontend/pago/register/register.scss" rel="stylesheet">
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
                            <h1 class="m-0">Pagos</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item active">Condominium System</li>
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
                                    <h3 class="card-title">Registrar Pago</h3>
                                </div>
                                <!-- /.card-header -->

                                <!-- form start -->
                                <form id="registerGasto">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-md-12">
                                                <div class="form-group">
                                                    <label for="apartamento">Apartamento</label>
                                                    <select id="apartamento" name="apartamento"
                                                        class="form-control custom-select">
                                                        <option value="">Seleccione un Apartamento</option>
                                                    </select>
                                                </div>
                                            </div>
                                            <!-- Tipo de Pago -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="tipo_pago">Tipo de Pago</label>
                                                    <select id="tipo_pago" name="tipo_pago"
                                                        placeholder="Seleccione o escriba un tipo de pago">
                                                        <option></option>
                                                        <option value="Efectivo">Efectivo</option>
                                                        <option value="Efectivo Divisas">Efectivo Divisas</option>
                                                        <option value="Pago Móvil">Pago Móvil</option>
                                                        <option value="Transferencia">Transferencia</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <!-- Monto -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="monto">Monto</label>
                                                    <input type="number" step="any" id="monto" name="monto"
                                                        class="form-control" placeholder="0.00">
                                                </div>
                                            </div>

                                            <!-- Fecha -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="fecha">Fecha</label>
                                                    <input type="date" id="fecha" name="fecha" class="form-control">
                                                </div>
                                            </div>

                                            <!-- Comprobante -->
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label for="comprobante">Comprobante</label>
                                                    <div class="custom-file">
                                                        <input type="file" class="custom-file-input" id="comprobante"
                                                            name="comprobante">
                                                        <label class="custom-file-label" for="comprobante">
                                                            Inserte Archivo
                                                        </label>
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

    <script src="<?= URL; ?>Frontend/pago/register/register.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/selectize.js/0.12.6/js/standalone/selectize.min.js">
    </script>
</body>

</html>