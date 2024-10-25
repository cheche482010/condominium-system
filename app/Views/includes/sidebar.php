
        <aside class="main-sidebar elevation-2 sidebar-light-primary">
            <!-- Brand Logo -->
            <a href="javascript::void(0)" class="brand-link bg-primary">
                <img src="<?= $this->assets . 'img/' . $this->config::LOGO ?>" alt="Logo"
                    class="brand-image img-circle elevation-3">
                <span class="brand-text font-weight-light">
                    <?= $this->config->get('APP_NAME'); ?>
                </span>
            </a>

            <!-- Sidebar -->
            <?php
            $this->SidebarMenu([
                [
                    'type'  => 'header',
                    'label' => 'MENU',
                ],
                [
                    'url'   => 'home',
                    'icon'  => 'fas fa-home nav-icon',
                    'label' => 'INICIO',
                ],
                [
                    'url'      => '#',
                    'icon'     => 'nav-icon fa fa-user-circle',
                    'label'    => 'USUARIOS',
                    'subItems' => [
                        [
                            'url'   => 'user/register',
                            'icon'  => 'fa fa-plus-circle nav-icon',
                            'label' => 'REGISTRAR',
                        ],
                        [
                            'url'   => 'user/list',
                            'icon'  => 'fa fa-list nav-icon',
                            'label' => 'LISTA',
                        ],
                    ],
                ],
                [
                    'url'      => '#',
                    'icon'     => 'nav-icon fa fa-building',
                    'label'    => 'CONDOMINIOS',
                    'subItems' => [
                        [
                            'url'   => 'condominio/register',
                            'icon'  => 'fa fa-plus-circle nav-icon',
                            'label' => 'REGISTRAR',
                        ],
                        [
                            'url'   => 'condominio/list',
                            'icon'  => 'fa fa-list nav-icon',
                            'label' => 'LISTA',
                        ],
                    ],
                ],
                [
                    'url'      => '#',
                    'icon'     => 'nav-icon fas fa-dollar-sign',
                    'label'    => 'PAGOS',
                    'subItems' => [
                        [
                            'url'   => 'pago/register',
                            'icon'  => 'fa fa-plus-circle nav-icon',
                            'label' => 'PROCESAR',
                        ],
                        [
                            'url'   => 'pago/list',
                            'icon'  => 'fa fa-list nav-icon',
                            'label' => 'LISTA',
                        ],
                    ],
                ],
                [
                    'url'      => '#',
                    'icon'     => 'nav-icon fa fa-money-bill-wave',
                    'label'    => 'GASTOS',
                    'subItems' => [
                        [
                            'url'   => 'gasto/register',
                            'icon'  => 'fa fa-plus-circle nav-icon',
                            'label' => 'AGREGAR',
                        ],
                        [
                            'url'   => 'gasto/list',
                            'icon'  => 'fa fa-list nav-icon',
                            'label' => 'LISTA',
                        ],
                    ],
                ],
                [
                    'type'  => 'header',
                    'label' => 'REPORTES',
                ],
                [
                    'url'      => '#',
                    'icon'     => 'nav-icon fas fa-receipt',
                    'label'    => 'RELACION DE GASTOS',
                    'subItems' => [
                        [
                            'url'   => 'user/register',
                            'icon'  => 'fa fa-building nav-icon',
                            'label' => 'POR CONDOMINIO',
                        ],
                        [
                            'url'   => 'user/list',
                            'icon'  => 'fa fa-users nav-icon',
                            'label' => 'POR USUARIO',
                        ],
                    ],
                ],
                [
                    'type'  => 'header',
                    'label' => 'SEGURIDAD',
                ],
                [
                    'url'   => 'bitacora',
                    'icon'  => 'fa fa-calendar nav-icon',
                    'label' => 'BITACORA',
                ],
                [
                    'type'  => 'header',
                    'label' => 'ADMINISTRACION',
                ],
                [
                    'url'   => 'configuracion',
                    'icon'  => 'fa fa-cog nav-icon',
                    'label' => 'CONFIGURACION',
                ],
            ])->view();
            ?>
            <!-- /.sidebar -->
        </aside>