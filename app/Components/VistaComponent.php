<?php

namespace App\Components;

class VistaComponent extends Component
{
    protected $viewName;

    public function __construct($viewName, $data = [])
    {
        parent::__construct($data);
        $this->viewName = $viewName;
        $this->view();
    }

    public function view()
    {
        $viewFile = $this->getViewFiles($this->viewName);

        if (file_exists($viewFile)) {
            extract($this->data);
            require $viewFile;
        } else {
            throw new \Exception('View not found: ' . $viewFile);
        }
    }

    protected function getViewFiles($viewName)
    {
        $viewsPath = __DIR__ . '/../Views/';

        if (pathinfo($viewName, PATHINFO_EXTENSION) === '') {
            $viewName .= '.php';
        }

        return $viewsPath . $viewName;
    }
}
