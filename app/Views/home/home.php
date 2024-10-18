<!DOCTYPE html>
<html lang="en">

<head>
    <?php include __DIR__ . "/../includes/meta.php"; ?>
    <title><?= $this->config->get('APP_NAME'); ?></title>
    <?php include __DIR__ . "/../includes/link.php"; ?>
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
    <?php include __DIR__ . "/../includes/script.php"; ?>
</body>

</html>
