<?php

namespace App\Components;

class ImageComponent extends Component
{
    protected $src;
    protected $alt;
    protected $class;
    protected $style;

    public function __construct($data = [])
    {
        parent::__construct($data);

        $this->src = $data['src'] ?? '';
        $this->alt = $data['alt'] ?? '';
        $this->class = $data['class'] ?? '';
        $this->style = $data['style'] ?? '';
    }

    protected function view()
    {
        echo '<img src="' . $this->src . '" alt="' . $this->alt . '" class="' . $this->class . '" style="' . $this->style . '">';
    }
}
