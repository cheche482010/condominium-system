<?php

namespace App\Components;

class NotificationsComponent extends Component
{
    protected $notifications;

    public function __construct($data = [])
    {
        parent::__construct($data);

        $this->notifications = $data ?? [];
    }

    public function view()
    {
        echo "<li class=\"nav-item dropdown\">\n";
        echo "\t\t<a class=\"nav-link\" data-toggle=\"dropdown\" href=\"#\">\n";
        echo "\t\t\t<i class=\"far fa-bell\"></i>\n";
        echo "\t\t\t<span class=\"badge badge-danger navbar-badge\">" . count($this->notifications) . "</span>\n";
        echo "\t\t</a>\n";
        echo "\t\t<div class=\"dropdown-menu dropdown-menu-lg dropdown-menu-right\">\n";
        echo "\t\t\t<span class=\"dropdown-item dropdown-header\">" . count($this->notifications) . " Notifications</span>\n";
        echo "\t\t\t<div class=\"dropdown-divider\"></div>\n";

        foreach ($this->notifications as $notification) {
            echo "\t\t\t<a href=\"" . $notification['link'] . "\" class=\"dropdown-item\">\n";
            echo "\t\t\t\t<i class=\"" . $notification['icon'] . " mr-2\"></i>" . $notification['text'] . "\n";
            echo "\t\t\t\t<span class=\"float-right text-muted text-sm\">" . $notification['timestamp'] . "</span>\n";
            echo "\t\t\t</a>\n";
            echo "\t\t\t<div class=\"dropdown-divider\"></div>\n";
        }

        echo "\t\t\t<a href=\"#\" class=\"dropdown-item dropdown-footer\">See All Notifications</a>\n";
        echo "\t\t</div>\n";
        echo "\t</li>\n";
    }

}
