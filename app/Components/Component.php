<?php

namespace App\Components;

class Component
{
    protected $data = [];
 
    public function __construct(array $data = [])
    {
        $this->data = $data;
    }

    public function render()
    {
        ob_start();
        $this->view();
        return ob_get_clean();
    }

    protected function view()
    {
        
        $viewFile = $this->getViewFile();
        if (file_exists($viewFile)) {
            extract($this->data);
            include $viewFile;
        } else {
            throw new \Exception('Component view not found: ' . $viewFile);
        }
    }

    protected function getViewFile()
    {
        $className = str_replace('Component', '', get_class($this));
        $viewName = strtolower(preg_replace('/([a-zA-Z])(?=[A-Z])/', '$1-', $className));
        return __DIR__ . '/../Views/' . $viewName . '.php';
    }
}
