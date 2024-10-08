<?php

namespace App\Components;

class ButtonComponent extends Component
{
    protected $text;
    protected $style;

    public function __construct($data = [])
    {
        parent::__construct($data);

        $this->text = $data['text'] ?? 'Click me';
        $this->style = $data['style'] ?? '';
    }

    protected function view()
    {
        $text = $this->text ?? 'Click me';
        $style = $this->style ?? '';

        echo '<button style="' . $style . '">' . $text . '</button>';
    } 
}

