<?php
    $this->Footer([
        'siteName' =>  $this->config->get('APP_NAME'),
        'author'   =>  $this->config::AUTHOR,
        'year'     =>  2024,
        'version'  =>  $this->config::VERSION,
    ])->view();
?> 