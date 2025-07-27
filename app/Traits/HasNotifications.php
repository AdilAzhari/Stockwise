<?php

namespace App\Traits;

use Filament\Notifications\Notification;

trait HasNotifications
{
    protected function notifySuccess(string $title = 'Success', string $message = ''): void
    {
        Notification::make()
            ->title($title)
            ->body($message)
            ->success()
            ->duration(3000)
            ->send();
    }

    protected function notifyError(string $title = 'Error', string $message = ''): void
    {
        Notification::make()
            ->title($title)
            ->body($message)
            ->danger()
            ->duration(4000)
            ->send();
    }
}
