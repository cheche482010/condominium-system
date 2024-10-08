<?php
class InputComponent
{
    protected $attributes = [];

    public function __construct($attributes = [])
    {
        $this->attributes = $attributes;
    }

    public function render()
    {
        $html = '<input ';
        
        foreach ($this->attributes as $key => $value) {
            $html .= $key . '="' . htmlspecialchars($value) . '" ';
        }
        
        $html .= '/>';
        
        return $html;
    }
}
