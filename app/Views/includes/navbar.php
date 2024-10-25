    
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="<?= $this->assets . 'img/' . $this->config::LOGO ?>" alt="Logo" height="60" width="60">
        </div>

        <nav class="main-header navbar navbar-expand navbar-light bg-primary border-bottom-0">
            <!-- Left navbar links -->
            <?php
            $this->NavbarNav([
                ['url' => 'home', 'text' => 'Inicio'],
                ['url' => 'contacto', 'text' => 'Contacto'],
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