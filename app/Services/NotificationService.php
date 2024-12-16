<?php

namespace App\Services;

use InvalidArgumentException;

class NotificationService
{
    public function sendNotification($status, $reviewer)
    {
        if (empty($status)) {
            throw new InvalidArgumentException('Status is required.');
        }

        if (is_null($reviewer)) {
            throw new InvalidArgumentException('Reviewer cannot be null.');
        }

        return [
            'status' => $status,
            'reviewer' => $reviewer
        ];
    }
}