<?php

namespace App\Components;

class LinkComponent extends Component
{
    protected $links;

    public function __construct($data = [])
    {
        parent::__construct($data);
        $this->links = $data ?? [];
    }

    public function view()
    {
        foreach ($this->links as $link) {
            echo "\n\t<link ";
            foreach ($link as $attribute => $value) {
                echo $attribute . '="' . $value . '" ';
            }
            echo ">\n";
        }
    }
}
