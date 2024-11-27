<aside class="main-sidebar elevation-2 sidebar-light-primary">
            <!-- Brand Logo -->
            <a href="javascript::void(0)" class="brand-link bg-primary">
                <img src="<?= URL; ?>Frontend/assets/img/logo.jpg" alt="Logo"
                    class="brand-image img-circle elevation-3">
                <span class="brand-text font-weight-light">
                    <?= TITLE; ?>
                </span>
            </a>

            <!-- Sidebar -->
            <div class="sidebar">
                <nav class="mt-2">
                    <ul class="nav nav-pills nav-sidebar flex-column" data-widget="treeview" role="menu"
                        data-accordion="false">
                        <li class="nav-header">MENU</li>
                        <li class="nav-item">
                            <a href="<?= URL; ?>home" class="nav-link">
                                <i class="fas fa-home nav-icon"></i>
                                <p>
                                    INICIO
                                </p>
                            </a>
                        </li>
                        <li class="nav-item">
                            <a href="<?= URL; ?>#" class="nav-link">
                                <i class="nav-icon fa fa-user-circle"></i>
                                <p>
                                    USUARIOS
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= URL; ?>user/register"
                                        class="nav-link">
                                        <i class="fa fa-plus-circle nav-icon"></i>
                                        <p>
                                            REGISTRAR
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= URL; ?>user/list"
                                        class="nav-link">
                                        <i class="fa fa-list nav-icon"></i>
                                        <p>
                                            LISTA
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="<?= URL; ?>#" class="nav-link">
                                <i class="nav-icon fa fa-building"></i>
                                <p>
                                    APARTAMENTOS
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= URL; ?>apartamento/register"
                                        class="nav-link">
                                        <i class="fa fa-plus-circle nav-icon"></i>
                                        <p>
                                            REGISTRAR
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= URL; ?>apartamento/list"
                                        class="nav-link">
                                        <i class="fa fa-list nav-icon"></i>
                                        <p>
                                            LISTA
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="<?= URL; ?>#" class="nav-link">
                                <i class="nav-icon fas fa-dollar-sign"></i>
                                <p>
                                    PAGOS
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= URL; ?>pago/register"
                                        class="nav-link">
                                        <i class="fa fa-plus-circle nav-icon"></i>
                                        <p>
                                            PROCESAR
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= URL; ?>pago/list"
                                        class="nav-link">
                                        <i class="fa fa-list nav-icon"></i>
                                        <p>
                                            LISTA
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-item">
                            <a href="<?= URL; ?>#" class="nav-link">
                                <i class="nav-icon fa fa-money-bill-wave"></i>
                                <p>
                                    GASTOS
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= URL; ?>gasto/register"
                                        class="nav-link">
                                        <i class="fa fa-plus-circle nav-icon"></i>
                                        <p>
                                            AGREGAR
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= URL; ?>gasto/list"
                                        class="nav-link">
                                        <i class="fa fa-list nav-icon"></i>
                                        <p>
                                            LISTA
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-header">REPORTES</li>
                        <li class="nav-item">
                            <a href="<?= URL; ?>#" class="nav-link">
                                <i class="nav-icon fas fa-receipt"></i>
                                <p>
                                    RELACION DE GASTOS
                                    <i class="right fas fa-angle-left"></i>
                                </p>
                            </a>
                            <ul class="nav nav-treeview">
                                <li class="nav-item">
                                    <a href="<?= URL; ?>user/register"
                                        class="nav-link">
                                        <i class="fa fa-building nav-icon"></i>
                                        <p>
                                            POR APARTAMENTO
                                        </p>
                                    </a>
                                </li>
                                <li class="nav-item">
                                    <a href="<?= URL; ?>user/list"
                                        class="nav-link">
                                        <i class="fa fa-users nav-icon"></i>
                                        <p>
                                            POR USUARIO
                                        </p>
                                    </a>
                                </li>
                            </ul>
                        </li>
                        <li class="nav-header">SEGURIDAD</li>
                        <li class="nav-item">
                            <a href="<?= URL; ?>bitacora" class="nav-link">
                                <i class="fa fa-calendar nav-icon"></i>
                                <p>
                                    BITACORA
                                </p>
                            </a>
                        </li>
                        <li class="nav-header">ADMINISTRACION</li>
                        <li class="nav-item">
                            <a href="<?= URL; ?>configuracion" class="nav-link">
                                <i class="fa fa-cog nav-icon"></i>
                                <p>
                                    CONFIGURACION
                                </p>
                            </a>
                        </li>
                    </ul>
                </nav>
            </div>
            <!-- /.sidebar -->
        </aside> 
