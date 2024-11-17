<?php verifySession(); ?>  
<!DOCTYPE html>
<html lang="es">

<head>
    <?php include __DIR__ . "/../../includes/meta.php"; ?>
    <title><?= TITLE; ?></title>
    <?php include __DIR__ . "/../../includes/link.php"; ?>

    <link href="<?= URL; ?>Frontend/user/list/list.scss" rel="stylesheet">
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
                            <h1 class="m-0">Usuarios</h1>
                        </div>
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                <li class="breadcrumb-item active">Condominium System</li>
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
                            <table class="table table-hover table-bordered" id="userTable" style="width:100%">
                                <thead>
                                    <tr>
                                        <th>#</th>
                                        <th>CI</th>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>Telefono</th>
                                        <th>Email</th>
                                        <th>Rol</th>
                                        <th>Activo</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                </tbody>
                                <tfoot>
                                    <tr>
                                        <th>#</th>
                                        <th>CI</th>
                                        <th>Nombre</th>
                                        <th>Apellido</th>
                                        <th>Telefono</th>
                                        <th>Email</th>
                                        <th>Rol</th>
                                        <th>Activo</th>
                                        <th>Actions</th>
                                    </tr>
                                </tfoot>
                            </table>
                        </div>
                    </div>

                    <div class="modal fade" id="editUserForm" tabindex="-1" role="dialog"
                        aria-labelledby="editUserFormLabel" aria-hidden="true">
                        <div class="modal-dialog modal-lg" role="dialog">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title" id="editUserFormLabel">Editar Usuario</h5>
                                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                        <span aria-hidden="true">&times;</span>
                                    </button>
                                </div>
                                <form id="editForm" action="POST">
                                    <div class="modal-body">
                                        <div id="userDataForm">
                                            <div class="row mb-2">
                                                <div class="col-md-12">
                                                    <label for="cedula">Cedula</label>
                                                    <div class="input-group">
                                                        <input id="cedula" type="text" class="form-control"
                                                            placeholder="Cedula....">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <span class="fas fa-id-card"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mb-2">
                                                <div class="col-md-6">
                                                    <label for="nombre">Nombre</label>
                                                    <div class="input-group">
                                                        <input id="nombre" type="text" class="form-control"
                                                            placeholder="Nombre....">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <span class="fas fa-user"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="apellido">Apellido</label>
                                                    <div class="input-group">
                                                        <input id="apellido" type="text" class="form-control"
                                                            placeholder="Apellido....">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <span class="fas fa-user"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mb-2">
                                                <div class="col-md-6">
                                                    <label for="email">Correo</label>
                                                    <div class="input-group">
                                                        <input id="email" type="email" class="form-control"
                                                            placeholder="example@gmail.com">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <span class="fas fa-envelope"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>

                                                <div class="col-md-6">
                                                    <label for="phone">Telefono</label>
                                                    <div class="input-group">
                                                        <input id="phone" type="phone" class="form-control"
                                                            placeholder="+58 123 456 7890">
                                                        <div class="input-group-append">
                                                            <div class="input-group-text">
                                                                <span class="fas fa-phone"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row mb-2">
                                                <div class="col-md-12">
                                                    <label for="condominio">Condominio</label>
                                                    <select id="condominio" name="condominio"
                                                        class="form-control custom-select">
                                                        <option value="">Seleccione un condominio</option>
                                                    </select>
                                                </div>

                                                <div class="col-md-12">
                                                    <div class="form-group">
                                                        <label for="rol">Rol</label>
                                                        <select id="rol" name="rol" class="form-control custom-select">
                                                            <option value="">Seleccione un rol</option>
                                                        </select>
                                                    </div>
                                                </div>
                                            </div>
                                            
                                            <div class="row mb-2">
                                                <div class="col-md-12 text-center">
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input"
                                                            id="is_active" name="is_active" checked>
                                                        <label class="custom-control-label"
                                                            for="is_active">Activo</label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row mb-1 mt-3 button-style">
                                            <div class="col-md-12">
                                                <button type="button" class="btn btn-default"
                                                    id="togglePassword">Modificar
                                                    contraseña</button>
                                            </div>
                                        </div>
                                        <div class="row mb-2" id="passwordSection" style="display: none;">
                                            <div class="col-md-12">
                                                <label for="user_password">Contraseña</label>
                                                <div class="input-group">
                                                    <input id="user_password" type="password"
                                                        class="form-control password" placeholder="*****">
                                                    <div class="input-group-append">
                                                        <div class="input-group-text toggle-password">
                                                            <span class="fas fa-eye-slash"></span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-12 mt-2">
                                                <label for="retryPassword">Confirmar</label>
                                                <div class="input-group">
                                                    <input id="retryPassword" type="password"
                                                        class="form-control password" placeholder="*****">
                                                </div>
                                            </div>

                                            <div class="col-md-12 mt-2 secure-password">
                                                <span class="security-level"></span>
                                            </div>
                                        </div>

                                    </div>
                                    <div class="modal-footer">
                                        <button type="button" class="btn btn-secondary"
                                            data-dismiss="modal">Cancelar</button>
                                        <button type="button" class="btn btn-primary" id="editBtn">Guardar</button>
                                        <button type="button" class="btn btn-primary" id="savePasswordBtn"
                                            style="display: none;">Guardar Contraseña</button>
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

    <script src="<?= URL; ?>Frontend/user/list/list.js"></script>
</body>

</html>