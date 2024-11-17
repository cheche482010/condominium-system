<!-- Preloader -->
<div class="preloader flex-column justify-content-center align-items-center">
    <img class="animation__shake" src="<?= URL; ?>Frontend/assets/img/logo.jpg" alt="Logo" height="60" width="60">
</div>

<nav class="main-header navbar navbar-expand navbar-light bg-primary border-bottom-0">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item">
            <a href="<?= URL; ?>home" class="nav-link">Inicio</a>
        </li>
        <li class="nav-item">
            <a href="<?= URL; ?>contacto" class="nav-link">Contacto</a>
        </li>
    </ul>

    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-bell"></i>
                <span class="badge badge-danger navbar-badge">3</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <span class="dropdown-item dropdown-header">3 Notificaciones</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="far fa-envelope mr-2"></i>4 new messages <span class="float-right text-muted text-sm">3
                        mins</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-users mr-2"></i>8 friend requests <span class="float-right text-muted text-sm">12
                        hours</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-file mr-2"></i>3 new reports <span class="float-right text-muted text-sm">2
                        days</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">Ver todas las notificaciones</a>
            </div>
        </li>
        <li class="nav-item dropdown" id="userContent">
            <a class="nav-link user-nav" data-toggle="dropdown" href="#">
                <span class="user-name">
                    <?= $_SESSION['user']['nombre']." ".$_SESSION['user']['apellido']; ?>
                </span>
                <i class="fa fa-user"></i>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right">
                <div class="user-header">
                    <div class="user-content">
                        <span class="user-name">
                            <?= $_SESSION['user']['nombre']." ".$_SESSION['user']['apellido']; ?>
                        </span>
                        <span class="badge bg-success user-rol">
                            <?= $_SESSION['user']['rol']['nombre']; ?>
                        </span>
                    </div>
                </div>
                
                <div class="user-body">
                    <a href="#" class="btn btn-default btn-flat">Perfil</a>
                    <a href="#" id="logout" class="btn btn-default btn-flat">Salir</a>
                </div>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
    </ul>
</nav>