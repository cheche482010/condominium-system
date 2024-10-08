<?php

namespace App\Components;

class CardComponent extends Component
{
    public function CardStart($title)
    {
        echo '<div class="card">';
        echo '<div class="card-header">';
        echo '<h3 class="card-title">' . $title . '</h3>';
        echo '<div class="card-tools">';
        echo '<button type="button" class="btn btn-tool" data-card-widget="collapse" title="Collapse">';
        echo '<i class="fas fa-minus"></i>';
        echo '</button>';
        echo '<button type="button" class="btn btn-tool" data-card-widget="remove" title="Remove">';
        echo '<i class="fas fa-times"></i>';
        echo '</button>';
        echo '</div>';
        echo '</div>';
        echo '<div class="card-body">';
    }

    public function CardEnd($footer = '')
    {
        echo '</div>';
        echo '<div class="card-footer">' . $footer . '</div>';
        echo '</div>';
    }
}
