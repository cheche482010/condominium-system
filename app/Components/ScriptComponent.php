<?php

namespace App\Components;

class ScriptComponent extends Component
{
    protected $scripts = [];

    public function __construct($data = [])
    {
        parent::__construct($data);

        $this->scripts = $data ?? [];
    }

    public function view()
    {
        foreach ($this->scripts as $src) {
            echo "\n\t".'<script src="' . $src . '"></script>'."\n";
        }
    }
}
