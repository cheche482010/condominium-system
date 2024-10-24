<!DOCTYPE html>
<html lang="es">

<head>
    <?php include __DIR__ . "/../../includes/meta.php"; ?>
    <title><?= $this->config->get('APP_NAME'); ?></title>
    <?php include __DIR__ . "/../../includes/link.php"; ?>

    <link href="<?= $this->assetsView; ?>user/list/list.scss" rel="stylesheet">
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
                    ['label' => 'Listar', 'url' => 'javascript::void(0)'],
                ],
            ])->view();
            ?>

            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered" id="userTable" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Last Name</th>
                                        <th>CI</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Rol</th>
                                        <th>Is Active</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Last Name</th>
                                        <th>CI</th>
                                        <th>Phone</th>
                                        <th>Email</th>
                                        <th>Rol</th>
                                        <th>Is Active</th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="modal fade" id="editUserForm" tabindex="-1" role="dialog" aria-labelledby="editUserFormLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editUserFormLabel">Editar Usuario</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="editForm">
                                    <div class="modal-body">
                                        
                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancelar</button>
                                        <button type="button" class="btn btn-primary" id="edit">Guardar</button>
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

    <script src="<?= $this->assetsView; ?>user/list/list.js"></script>
</body>

</html>