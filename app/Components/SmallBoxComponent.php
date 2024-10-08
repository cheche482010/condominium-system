<?php

namespace App\Components;

class SmallBoxComponent extends Component
{
    protected $data;

    public function __construct($data = [])
    {
        parent::__construct($data);

        $this->data = $data;
    }

    public function view()
    {
        foreach ($this->data as $boxData) {
            echo '<div class="col-lg-3 col-6">';
            echo "\n\t<div class=\"small-box " . ($boxData['bgColor'] ?? 'bg-info') . "\">";
            echo "\n\t\t<div class=\"inner\">";
            echo "\n\t\t\t<h3>" . ($boxData['number'] ?? '0') . "</h3>";
            echo "\n\t\t\t<p>" . ($boxData['title'] ?? 'Title') . "</p>";
            echo "\n\t\t</div>";
            echo "\n\t\t<div class=\"icon\">";
            echo "\n\t\t\t<i class=\"" . ($boxData['icon'] ?? 'ion ion-ios-book') . "\"></i>";
            echo "\n\t\t</div>";
            echo "\n\t\t<a href=\"" . ($boxData['url'] ?? '#') . "\" class=\"small-box-footer\">" . ($boxData['linkText'] ?? 'Information') . " <i class=\"" . ($boxData['linkIcon'] ?? 'fas fa-arrow-circle-right') . "\"></i></a>";
            echo "\n\t</div>";
            echo '</div>';
        }
    }

}
