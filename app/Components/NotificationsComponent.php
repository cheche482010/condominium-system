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
        $output = "<li class=\"nav-item dropdown\">\n";
        $output .= "\t\t\t\t<a class=\"nav-link\" data-toggle=\"dropdown\" href=\"#\">\n";
        $output .= "\t\t\t\t\t<i class=\"far fa-bell\"></i>\n";
        $output .= "\t\t\t\t\t<span class=\"badge badge-danger navbar-badge\">" . count($this->notifications) . "</span>\n";
        $output .= "\t\t\t\t</a>\n";
        $output .= "\t\t\t\t<div class=\"dropdown-menu dropdown-menu-lg dropdown-menu-right\">\n";
        $output .= "\t\t\t\t\t<span class=\"dropdown-item dropdown-header\">" . count($this->notifications) . " Notificaciones</span>\n";
        $output .= "\t\t\t\t\t<div class=\"dropdown-divider\"></div>\n";

        foreach ($this->notifications as $notification) {
            $output .= "\t\t\t\t\t<a href=\"" . htmlspecialchars($notification['link']) . "\" class=\"dropdown-item\">\n";
            $output .= "\t\t\t\t\t\t<i class=\"" . htmlspecialchars($notification['icon']) . " mr-2\"></i>" . htmlspecialchars($notification['text']);
            $output .= "\t\t\t<span class=\"float-right text-muted text-sm\">" . htmlspecialchars($notification['timestamp']) . "</span>\n";
            $output .= "\t\t\t\t\t</a>\n";
            $output .= "\t\t\t\t\t<div class=\"dropdown-divider\"></div>\n";
        }

        $output .= "\t\t\t\t\t<a href=\"#\" class=\"dropdown-item dropdown-footer\">Ver todas las notificaciones</a>\n";
        $output .= "\t\t\t\t</div>\n";
        $output .= "\t\t\t</li>\n";

        echo $output;
    }

}
