<?php

namespace App\Components;

class FooterComponent extends Component
{
    protected $data;

    public function __construct($data = [])
    {
        $this->data = $data;
    }

    public function view()
    {
        echo "\n<footer class=\"main-footer text-sm\">";
        echo "\n\t<strong>" . $this->data['siteName'] . ' <a href="javascript::void(0)">' . $this->data['author'] . ' &copy;</a>.</strong>';
        echo " Derechos Reservados " . $this->data['year'];
        echo "\n\t<div class=\"float-right d-none d-sm-inline-block\">";
        echo "\n\t\t<b>Version</b> " . $this->data['version'];
        echo "\n\t</div>";
        echo "\n</footer>";
    }

}
