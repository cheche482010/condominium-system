<?php

namespace App\Components;

class SidebarMenuComponent extends Component
{
    protected $menuItems = [];

    public function __construct($data = [])
    {
        parent::__construct($data);

        $this->menuItems = $data ?? [];
    }

    public function view()
    {
        echo '<div class="sidebar">';
        echo "\n\t\t\t\t<nav class=\"mt-2\">";
        echo "\n\t\t\t\t\t<ul class=\"nav nav-pills nav-sidebar flex-column\" data-widget=\"treeview\" role=\"menu\" data-accordion=\"false\">\n";

        // Loop through menu items and generate the menu
        foreach ($this->menuItems as $menuItem) {
            if (isset($menuItem['type']) && $menuItem['type'] === 'header') {
                $this->generateCategory($menuItem);
            } elseif (isset($menuItem['type']) && $menuItem['type'] === 'divider') {
                echo "\t\t\t\t\t\t<li class=\"divider\"></li>\n";
            } else {
                $this->generateMenuItem($menuItem);
            }
        }

        echo "\t\t\t\t\t</ul>\n";
        echo "\t\t\t\t</nav>\n";
        echo "\t\t\t</div>\n";
    }

    protected function generateCategory($category)
    {
        echo "\t\t\t\t\t\t<li class=\"nav-header\">" . $category['label'] . "</li>\n";
    }

    protected function generateMenuItem($menuItem)
    {
        $url = isset($menuItem['url']) ? $menuItem['url'] : '#';
        echo "\t\t\t\t\t\t\t<li class=\"nav-item\">\n";
        echo "\t\t\t\t\t\t\t\t<a href=\"" . $GLOBALS["URL"]. $url . "\" class=\"nav-link\">\n";
        echo "\t\t\t\t\t\t\t\t\t<i class=\"" . (isset($menuItem['icon']) ? $menuItem['icon'] : '') . "\"></i>\n";
        echo "\t\t\t\t\t\t\t\t\t<p>\n";
        echo "\t\t\t\t\t\t\t\t\t\t".$menuItem['label']."\n";
        if (!empty($menuItem['subItems'])) {
            echo "\t\t\t\t\t\t\t\t\t\t<i class=\"right fas fa-angle-left\"></i>\n";
            echo "\t\t\t\t\t\t\t\t\t</p>\n";
            echo "\t\t\t\t\t\t\t\t</a>\n";
            echo "\t\t\t\t\t\t\t\t<ul class=\"nav nav-treeview\">\n";
            foreach ($menuItem['subItems'] as $subItem) {
                $this->generateMenuItem($subItem);
            }
            echo "\t\t\t\t\t\t\t\t</ul>\n";
        } else {
            echo "\t\t\t\t\t\t\t\t\t</p>\n";
            echo "\t\t\t\t\t\t\t\t</a>\n";
        }
        echo "\t\t\t\t\t\t\t</li>\n";
    }
}
