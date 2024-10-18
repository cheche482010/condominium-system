<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>
        <?= $this->config->get('APP_NAME'); ?>
    </title>
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
      ['rel' => 'stylesheet', 'href' => $this->assets . 'plugins/summernote/summernote-bs4.min.css']
    ])->view();
  ?>
</head>

<body class="layout-navbar-fixed accent-warning layout-footer-fixed layout-fixed sidebar-mini sidebar-collapse">
    <div class="wrapper">

        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="<?php echo $this->assets; ?>img/logo.jpg" alt="Logo" height="60"
                width="60">
        </div>

        <!-- Navbar -->
        <nav class="main-header navbar navbar-expand navbar-light bg-warning">
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
                <li class="nav-item">
                    <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#"
                        role="button">
                        <i class="fas fa-th-large"></i>
                    </a>
                </li>
            </ul>
        </nav>
        <!-- /.navbar -->

        <!-- Main Sidebar Container -->
        <aside class="main-sidebar elevation-4 sidebar-light-warning">
            <!-- Brand Logo -->
            <a href="javascript::void(0)" class="brand-link bg-warning">
                <img src="<?php echo $this->assets; ?>img/logo.jpg" alt="AdminLTE Logo"
                    class="brand-image img-circle elevation-3" style="opacity: .8">
                <span class="brand-text font-weight-light"><?php echo $this->config->get('APP_NAME'); ?></span>
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
                    'titulo' => $this->config->get('APP_NAME'),  
                    'links' => [
                        ['label' => $this->config->get('APP_NAME'), 'url' => '#','active' => true],
                        ['label' => 'Inicio', 'url' => '#'],
                    ],
                ])->view();
            ?>

            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <!-- Small boxes (Stat box) -->
                    <div class="row">
                        <div class="col-md-12">

                        </div>
                    </div>
                    <!-- /.row -->
                    <!-- Main row -->

                    <!-- /.row (main row) -->
                </div>

            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->

        <?php 
            $this->Footer([
            'siteName' => $this->config->get('APP_NAME'),
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
      $this->assets . 'plugins/jquery/jquery.min.js',
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
    ])->view(); 
  ?>
</body>

</html>