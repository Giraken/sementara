<?php

namespace App\Library\Notification;

use App\Models\Notification;

class SystemUrl extends Notification
{
    /**
     * Check if CronJob is recently executed and log a notification if not.
     */
    public static function check()
    {
        $title = trans('messages.admin.notification.system_url_title');
        self::cleanupDuplicateNotifications($title);

        $current = url('/');
        $cached = config('app.url');
        if ($current != $cached) {
            $warning = [
                'title' => $title,
                'message' => trans('messages.admin.notification.system_url_not_match', ['cached' => $cached, 'current' => $current]),
            ];

            self::warning($warning);
        }
    }
}
