<?php

declare(strict_types=1);

namespace App\Notification;

class WebNotification 
{
    public static function add(string $title, string $type = 'success'): void
    {
        render('_components/notification', [
            'type' => $type,
            'title' => $title,
        ]);
    }
}
