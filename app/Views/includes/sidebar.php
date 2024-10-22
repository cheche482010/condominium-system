
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