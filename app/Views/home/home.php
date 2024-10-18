<!DOCTYPE html>
<html lang="en">

<head>
    <?php include __DIR__ . "/../includes/meta.php"; ?>

    <title><?= $this->config->get('APP_NAME'); ?></title>
    <?php 
    $this->Link([
        ['rel' => 'icon', 'href' => $this->assets . 'img/'. $this->config::LOGO, 'type' => 'image/x-icon'],
        ['rel' => 'stylesheet', 'href' => $this->assets . 'plugins/fontawesome-free/css/all.min.css'],
        ['rel' => 'stylesheet', 'href' => $this->assets . 'css/adminlte.min.css'],
        ['rel' => 'stylesheet', 'href' => $this->assets . 'plugins/overlayScrollbars/css/OverlayScrollbars.min.css'],
        ['rel' => 'stylesheet', 'href' => $this->assets . "scss/style.scss"],
        ['rel' => 'stylesheet', 'href' => 'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback'],
        ['rel' => 'stylesheet', 'href' => 'https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css'],
    ])->view();
    ?>
</head>

<body class="layout-navbar-fixed accent-primary layout-footer-fixed layout-fixed sidebar-mini sidebar-collapse">
    <!-- Wrapper -->
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
                  'titulo' =>  $this->config->get('APP_NAME'),  
                  'links' => [
                      ['label' =>  $this->config->get('APP_NAME') ,'active' => true],
                      ['label' => 'Inicio', 'url' => 'home'],
                  ],
              ])->view();
            ?>

            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <?php
                          $this->SmallBox([
                              [
                                  'bgColor' => 'bg-info',
                                  'number' => '3',
                                  'title' => 'Catedras',
                                  'icon' => 'ion ion-ios-book',
                                  'url' => '#',
                              ],
                              [
                                  'bgColor' => 'bg-success',
                                  'number' => '10<sup style="font-size: 20px">%</sup>',
                                  'title' => 'Pagos',
                                  'icon' => 'ion ion-stats-bars',
                                  'url' => '#',
                              ],
                              [
                                  'bgColor' => 'bg-warning',
                                  'number' => '44',
                                  'title' => 'Estudiantes',
                                  'icon' => 'ion ion-android-contact',
                                  'url' => '#',
                              ],
                              [
                                  'bgColor' => 'bg-gray',
                                  'number' => '65',
                                  'title' => 'Configuración',
                                  'icon' => 'ion ion-android-settings',
                                  'url' => '#',
                              ],
                          ])->view();
                        ?>
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
    <?php 
        $this->Script([
        $this->assets . 'plugins/jquery/jquery.min.js',
        $this->assets . 'plugins/jquery-ui/jquery-ui.min.js',
        $this->assets . 'plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js',
        $this->assets . 'js/adminlte.js',
        $this->assets . 'js/constants.js',
        $this->assets . 'js/function.js',
        ])->view(); 
    ?> 
</body>

</html>
