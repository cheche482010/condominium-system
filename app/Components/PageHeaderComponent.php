<?php

namespace App\Components;

class PageHeaderComponent extends Component
{
    protected $breadcrumbs;

    public function __construct($breadcrumbs = [])
    {
        parent::__construct();

        $this->breadcrumbs = $breadcrumbs;
    }

    protected function view()
    {
        echo '<div class="content-header">';
        echo '<div class="container-fluid">';
        echo '<div class="row mb-2">';
        echo '<div class="col-sm-6">';
        echo '<h1 class="m-0">' . end($this->breadcrumbs)['text'] . '</h1>';
        echo '</div><!-- /.col -->';
        echo '<div class="col-sm-6">';
        echo '<ol class="breadcrumb float-sm-right">';

        foreach ($this->breadcrumbs as $breadcrumb) {
            echo '<li class="breadcrumb-item' . ($breadcrumb['active'] ? ' active' : '') . '">';
            if ($breadcrumb['active']) {
                echo $breadcrumb['text'];
            } else {
                echo '<a href="' . $breadcrumb['url'] . '">' . $breadcrumb['text'] . '</a>';
            }
            echo '</li>';
        }

        echo '</ol>';
        echo '</div><!-- /.col -->';
        echo '</div><!-- /.row -->';
        echo '</div><!-- /.container-fluid -->';
        echo '</div>';
    }
}
