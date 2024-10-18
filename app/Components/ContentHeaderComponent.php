<?php

namespace App\Components;

class ContentHeaderComponent extends Component
{
    protected $title;
    protected $breadcrumbs = [];

    public function __construct($data = [])
    {
        parent::__construct();
        $this->title       = $data['titulo'] ?? '';
        $this->breadcrumbs = $data['links'] ?? [];
    }

    public function view()
    {
        echo "<div class='content-header'>";
        echo "\n\t\t\t\t<div class=\"container-fluid\">";
        echo "\n\t\t\t\t\t<div class=\"row mb-2\">";
        echo "\n\t\t\t\t\t\t<div class=\"col-sm-6\">";
        echo "\n\t\t\t\t\t\t\t<h1 class=\"m-0\">" . $this->title . "</h1>";
        echo "\n\t\t\t\t\t\t</div>";

        if (!empty($this->breadcrumbs)) {
            echo "\n\t\t\t\t\t\t<div class=\"col-sm-6\">";
            echo "\n\t\t\t\t\t\t\t<ol class=\"breadcrumb float-sm-right\">";

            foreach ($this->breadcrumbs as $breadcrumb) {
                if (isset($breadcrumb['active']) && $breadcrumb['active']) {
                    echo "\n\t\t\t\t\t\t\t\t<li class=\"breadcrumb-item active\">" . $breadcrumb['label'] . "</li>";
                } else {
                    echo "\n\t\t\t\t\t\t\t\t<li class=\"breadcrumb-item\"><a href=\"" . $breadcrumb['url'] . "\">" . $breadcrumb['label'] . "</a></li>";
                }
            }

            echo "\n\t\t\t\t\t\t\t</ol>";
            echo "\n\t\t\t\t\t\t</div><!-- /.col -->";
        }

        echo "\n\t\t\t\t\t</div><!-- /.row -->";
        echo "\n\t\t\t\t</div><!-- /.container-fluid -->";
        echo "\n\t\t\t</div>";
    }

}
