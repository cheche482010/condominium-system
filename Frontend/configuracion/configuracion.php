<!DOCTYPE html>
<html lang="es">

<head>
    <?php include __DIR__ . "/../includes/meta.php"; ?>
    <title><?= TITLE; ?></title>
    <?php include __DIR__ . "/../includes/link.php"; ?>
 
    <link href="<?= URL; ?>Frontend/configuracion/configuracion.scss" rel="stylesheet">
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
            <div class='content-header'>
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">Configuracion Web</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item active">Administracion</li>
                                <li class="breadcrumb-item"><a href="configuracion">Configuracion</a></li>
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
                                                Bancos
                                            </span>
                                        </div>
                                    </div>
                                    <div id="collapseOne" class="collapse" aria-labelledby="headingOne"
                                        data-parent="#accordion">
                                        <div class="card-body">
                                            <div class="row">
                                                <div class="col-md-12">
                                                    <table class="table table-hover table-bordered" id="bancosTable"
                                                        style="width:100%">
                                                        <thead>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Código</th>
                                                                <th>Nombre</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>

                                                        </tbody>
                                                        <tfoot>
                                                            <tr>
                                                                <th>#</th>
                                                                <th>Código</th>
                                                                <th>Nombre</th>
                                                            </tr>
                                                        </tfoot>
                                                    </table>

                                                    <div class="modal fade" id="editBancForm" tabindex="-1"
                                                        role="dialog" aria-labelledby="editFormLabel"
                                                        aria-hidden="true">
                                                        <div class="modal-dialog modal-lg" role="dialog">
                                                            <div class="modal-content">
                                                                <div class="modal-header">
                                                                    <h5 class="modal-title" id="editFormLabel">
                                                                        Editar Banco</h5>
                                                                    <button type="button" class="close"
                                                                        data-dismiss="modal" aria-label="Close">
                                                                        <span aria-hidden="true">&times;</span>
                                                                    </button>
                                                                </div>
                                                                <form id="editForm" action="POST">
                                                                    <div class="modal-body">
                                                                        <div class="row">
                                                                            <div class="col-md-12 mb-2">
                                                                                <label for="codigo">Codigo</label>
                                                                                <div class="input-group">
                                                                                    <input id="codigo" type="text"
                                                                                        class="form-control"
                                                                                        placeholder="0001">
                                                                                    <div class="input-group-append">
                                                                                        <div class="input-group-text">
                                                                                            <span
                                                                                                class="fas fa-hashtag"></span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>

                                                                            <div class="col-md-12">
                                                                                <label for="nombre">Nombre</label>
                                                                                <div class="input-group">
                                                                                    <input id="nombre" type="text"
                                                                                        class="form-control"
                                                                                        placeholder="Nombre....">
                                                                                    <div class="input-group-append">
                                                                                        <div class="input-group-text">
                                                                                            <span
                                                                                                class="fas fa-bookmark"></span>
                                                                                        </div>
                                                                                    </div>
                                                                                </div>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="modal-footer">
                                                                        <button type="button" class="btn btn-secondary"
                                                                            data-dismiss="modal">Cancelar</button>
                                                                        <button type="button" class="btn btn-primary"
                                                                            id="editBtn">Guardar</button>
                                                                    </div>
                                                                </form>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
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

    <script src="<?= URL; ?>Frontend/configuracion/configuracion.js"></script>
</body>

</html>