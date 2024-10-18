<?php

namespace App\Components;

class NavbarNavComponent extends Component
{
    protected $links;

    public function __construct($links = [])
    {
        parent::__construct();
        $this->links = $links;
    }

    public function view()
    {
        echo "<ul class=\"navbar-nav\">\n";
        echo "\t\t\t\t<li class=\"nav-item\">\n";
        echo "\t\t\t\t\t<a class=\"nav-link\" data-widget=\"pushmenu\" href=\"#\" role=\"button\"><i class=\"fas fa-bars\"></i></a>\n";
        echo "\t\t\t\t</li>\n";
        foreach ($this->links as $link) {
            echo "\t\t\t\t<li class=\"nav-item\">\n";
            echo "\t\t\t\t\t<a href=\"" . $link['url'] . "\" class=\"nav-link\">" . $link['text'] . "</a>\n";
            echo "\t\t\t\t</li>\n";
        }
        echo "\t\t\t</ul>\n";
    }
}
