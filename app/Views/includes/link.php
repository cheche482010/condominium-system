<?php 
    $this->Link([
        ['rel' => 'icon', 'href' => $this->assets . 'img/'. $this->config::LOGO, 'type' => 'image/x-icon'],
        ['rel' => 'stylesheet', 'href' => $this->assets . 'plugins/fontawesome-free/css/all.min.css'],
        ['rel' => 'stylesheet', 'href' => $this->assets . 'css/adminlte.min.css'],
        ['rel' => 'stylesheet', 'href' => $this->assets . 'plugins/overlayScrollbars/css/OverlayScrollbars.min.css'],
        ['rel' => 'stylesheet', 'href' => $this->assets . "scss/style.scss"],
        ['rel' => 'stylesheet', 'href' => 'https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback'],
        ['rel' => 'stylesheet', 'href' => 'https://code.ionicframework.com/ionicons/2.0.1/css/ionicons.min.css'],
        ['rel' => 'stylesheet', 'href' => 'https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css'],
    ])->view();
?>

    <script src="https://code.jquery.com/jquery-3.7.0.min.js"></script>
    