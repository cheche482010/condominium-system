<!DOCTYPE html>
<html lang="es">

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
                  'titulo' =>  "Contacto",  
                  'links' => [
                      ['label' =>  $this->config->get('APP_NAME') ,'active' => true],
                      ['label' => 'Contacto', 'url' => 'home'],
                  ],
              ])->view();
            ?>

            <!-- /.content-header -->

            <!-- Main content -->
            <section class="content">
                <div class="container-fluid">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card card-solid">
                                <div class="card-body pb-0">
                                    <div class="row">
                                        <div class="col-12 col-sm-6 col-md-4 d-flex align-items-stretch flex-column">
                                            <div class="card bg-light d-flex flex-fill">
                                                <div class="card-header text-muted border-bottom-0">
                                                    Programador
                                                </div>
                                                <div class="card-body pt-0">
                                                    <div class="row">
                                                        <div class="col-7">
                                                            <h2 class="lead"><b>Josseth Arroyo</b></h2>
                                                            <p class="text-muted text-sm"><b>Acerca: </b> Programador. </p>
                                                            <ul class="ml-4 mb-0 fa-ul text-muted">
                                                                <li class="small"><span class="fa-li"><i
                                                                            class="fas fa-lg fa-phone"></i></span> Tlf
                                                                    #: (0416) 183-5429
                                                                </li>
                                                                <li class="small"><span class="fa-li"><i
                                                                            class="fas fa-lg fa-email"></i></span> Email
                                                                    #: cheche482010@gmail.com
                                                                </li>
                                                            </ul>
                                                        </div>
                                                        <div class="col-5 text-center">
                                                            <img src="<?= $this->assets . 'img/sethar.png'; ?>"
                                                                alt="user-avatar" class="img-circle img-fluid"
                                                                width="100">
                                                        </div>
                                                    </div>
                                                </div>
                                                <div class="card-footer">
                                                    <div class="text-right">

                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <!-- /.card-body -->
                                <div class="card-footer">
                                    Contactenos por Mensajes, WhatsApp o Correo Electronico.
                                </div>
                                <!-- /.card-footer -->
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
</body>

</html>