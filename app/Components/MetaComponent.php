<?php

namespace App\Components;

class MetaComponent extends Component
{
    protected $metaAttributes;

    public function __construct($data = [])
    {
        parent::__construct($data);

        $this->metaAttributes = $data['attributes'] ?? [];
    }

    protected function view()
    {
        foreach ($this->metaAttributes as $name => $content) {
            echo "<meta $name=\"$content\" />";
        }
    }
}
