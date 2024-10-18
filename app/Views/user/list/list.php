<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Torres Music</title>
    <?php 
    $this->Link([
      ['rel' => 'icon', 'href' => $this->assets . 'img/logo.jpg', 'type' => 'image/x-icon'],
      ['rel' => 'stylesheet', 'href' => 'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback'],
      ['rel' => 'stylesheet', 'href' => $this->assets . 'plugins/fontawesome-free/css/all.min.css'],
      ['rel' => 'stylesheet', 'href' => 'https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css'],
      ['rel' => 'stylesheet', 'href' => $this->assets . 'plugins/tempusdominus-bootstrap-4/css/tempusdominus-bootstrap-4.min.css'],
      ['rel' => 'stylesheet', 'href' => $this->assets . 'plugins/icheck-bootstrap/icheck-bootstrap.min.css'],
      ['rel' => 'stylesheet', 'href' => $this->assets . 'css/adminlte.min.css'],
      ['rel' => 'stylesheet', 'href' => $this->assets . 'plugins/overlayScrollbars/css/OverlayScrollbars.min.css'],
      ['rel' => 'stylesheet', 'href' => $this->assets . 'plugins/daterangepicker/daterangepicker.css'],
      ['rel' => 'stylesheet', 'href' => $this->assets . 'plugins/summernote/summernote-bs4.min.css'],
      ['rel' => 'stylesheet', 'href' => $this->assetsView . "user/list/list.scss"],
    ])->view();
  ?>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    </link>
    <!-- DataTables CSS -->
    <link href="https://cdn.datatables.net/1.13.4/css/dataTables.bootstrap5.min.css" rel="stylesheet">
    </link>
    <!-- DataTables Buttons CSS -->
    <link href="https://cdn.datatables.net/buttons/2.4.1/css/buttons.bootstrap5.min.css" rel="stylesheet">
    </link>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js">
    </script>
    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js">
    </script>
    <!-- DataTables JS -->
    <script src="https://cdn.datatables.net/1.13.4/js/jquery.dataTables.min.js">
    </script>
    <script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js">
    </script>
    <!-- DataTables Buttons JS -->
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/dataTables.buttons.min.js">
    </script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.bootstrap5.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.1.3/jszip.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js">
    </script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js">
    </script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.html5.min.js">
    </script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.print.min.js">
    </script>
    <script src="https://cdn.datatables.net/buttons/2.4.1/js/buttons.colVis.min.js">
    </script>
</head>

<body class="layout-navbar-fixed accent-primary layout-footer-fixed layout-fixed sidebar-mini sidebar-collapse">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="<?php echo $this->assets; ?>img/logo.jpg" alt="Logo" height="60"
                width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-light bg-primary border-bottom-0">
            <!-- Left navbar links -->
            <?php
            $this->NavbarNav([
                ['url' => '#', 'text' => 'Inicio'],
                ['url' => '#', 'text' => 'Contacto'],
            ])->view();
            ?>

            <!-- Right navbar links -->
            <ul class="navbar-nav ml-auto">
                <!-- Notifications Dropdown Menu -->
                <?php
                $this->Notifications([
                    [
                        'icon' => 'far fa-envelope',
                        'text' => '4 new messages',
                        'timestamp' => '3 mins',
                        'link' => '#',
                    ],
                    [
                        'icon' => 'fas fa-users',
                        'text' => '8 friend requests',
                        'timestamp' => '12 hours',
                        'link' => '#',
                    ],
                    [
                        'icon' => 'fas fa-file',
                        'text' => '3 new reports',
                        'timestamp' => '2 days',
                        'link' => '#',
                    ],
                ])->view();
                ?>
                <li class="nav-item">
                    <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                        <i class="fas fa-expand-arrows-alt"></i>
                    </a>
                </li>

            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar elevation-2 sidebar-light-primary">
            <!-- Brand Logo -->
            <a href="javascript::void(0)" class="brand-link bg-primary">
                <img src="<?php echo $this->assets; ?>img/logo.jpg" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light">Torres Music</span>
            </a>

            <!-- Sidebar -->
            <?php
                $this->SidebarMenu([
                    [
                        'type'  => 'header',
                        'label' => 'MULTI LEVEL EXAMPLE',
                    ],
                    [
                        'url'   => '#',
                        'icon'  => 'fas fa-circle nav-icon',
                        'label' => 'Level 1',
                    ],
                    [
                        'url'      => '#',
                        'icon'     => 'nav-icon fas fa-circle',
                        'label'    => 'Level 1',
                        'subItems' => [
                            [
                                'url'   => '#',
                                'icon'  => 'far fa-circle nav-icon',
                                'label' => 'Level 2',
                            ],
                            [
                                'url'      => '#',
                                'icon'     => 'far fa-circle nav-icon',
                                'label'    => 'Level 2',
                                'subItems' => [
                                    [
                                        'url'   => '#',
                                        'icon'  => 'far fa-dot-circle nav-icon',
                                        'label' => 'Level 3',
                                    ],
                                    [
                                        'url'   => '#',
                                        'icon'  => 'far fa-dot-circle nav-icon',
                                        'label' => 'Level 3',
                                    ],
                                    [
                                        'url'   => '#',
                                        'icon'  => 'far fa-dot-circle nav-icon',
                                        'label' => 'Level 3',
                                    ],
                                ],
                            ],
                            [
                                'url'   => '#',
                                'icon'  => 'far fa-circle nav-icon',
                                'label' => 'Level 2',
                            ],
                        ],
                    ],
                    [
                        'url'   => '#',
                        'icon'  => 'fas fa-circle nav-icon',
                        'label' => 'Level 1',
                    ],
                ])->view();
            ?>
            <!-- /.sidebar -->
        </aside>

        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <?php
            $this->ContentHeader([
                'titulo' =>  $this->config->get('APP_NAME'),  
                'links' => [
                    ['label' =>  $this->config->get('APP_NAME'), 'url' => '#','active' => true],
                    ['label' => 'Inicio', 'url' => '#'],
                ],
            ])->view();
            ?>

            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">

                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-striped table-bordered" id="example" style="width:100%">
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
                                    <script>
                                    $(document).ready(function() {

                                        var table = createDataTable('#example', {
                                                url: PROJECT_URL + '/api/user/getAll',
                                            },
                                            [{
                                                    data: 'id'
                                                },
                                                {
                                                    data: 'cedula'
                                                },
                                                {
                                                    data: 'nombre'
                                                },
                                                {
                                                    data: 'apellido'
                                                },
                                                {
                                                    data: 'phone'
                                                },
                                                {
                                                    data: 'email'
                                                },
                                                {
                                                    data: 'rol'
                                                },
                                                {
                                                    data: 'is_active'
                                                }, {
                                                    data: null,
                                                    className: 'no-print',
                                                    render: function(data, type, row) {
                                                        return '<button class="btn btn-warning btn-edit">Edit</button>' +
                                                            ' <button class="btn btn-danger btn-delete">Delete</button>';
                                                    }
                                                }
                                         ]);

                                        // Edit button click handler
                                        $('#example tbody').on('click', '.btn-edit', function() {
                                            var data = table.row($(this).parents('tr')).data();
                                            alert('Edit User ID: ' + data.userId + ', ID: ' + data.id);
                                            // Implement your edit logic here
                                            table.ajax.reload(null, false);
                                        });

                                        // Delete button click handler
                                        $('#example tbody').on('click', '.btn-delete', function() {
                                            var row = table.row($(this).parents('tr'));
                                            var data = row.data();
                                            if (confirm('Are you sure you want to delete this row?')) {
                                                // Implement your delete logic here (e.g., send an AJAX request to delete the record)
                                                row.remove().draw(); // Remove row from the DataTable
                                            }
                                        });
                                    });
                                    </script>
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

                </div>

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <?php 
            $this->Footer([
            'siteName' =>  $this->config->get('APP_NAME'),
            'author' => 'SETHAR',
            'year' => '2023',
            'version' => '1.0',
            ])->view(); 
        ?>

        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->

    <?php 
        $this->Script([
        $this->assets . 'plugins/jquery-ui/jquery-ui.min.js',
        $this->assets . 'plugins/bootstrap/js/bootstrap.bundle.min.js',
        $this->assets . 'plugins/chart.js/Chart.min.js',
        $this->assets . 'plugins/jquery-knob/jquery.knob.min.js',
        $this->assets . 'plugins/moment/moment.min.js',
        $this->assets . 'plugins/daterangepicker/daterangepicker.js',
        $this->assets . 'plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js',
        $this->assets . 'plugins/summernote/summernote-bs4.min.js',
        $this->assets . 'plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js',
        $this->assets . 'js/adminlte.js',
        $this->assets . 'js/constants.js',
        $this->assets . 'js/function.js',
        ])->view(); 
    ?>
</body>

</html>