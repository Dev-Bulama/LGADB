<?php

namespace App\Notifications;

use App\Models\Worker;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WorkerRegisteredNotification extends Notification
{
    public function __construct(protected Worker $worker)
    {
    }

    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    public function toMail(object $notifiable): MailMessage
    {
        $orgName = config('lga.name', config('app.name'));

        return (new MailMessage)
            ->subject('New Worker Registration — Pending Verification')
            ->greeting('Hello,')
            ->line('A new worker has registered on the LGA Workforce Identity System and is awaiting verification.')
            ->line('**Full Name:** ' . $this->worker->full_name)
            ->line('**Staff Number:** ' . $this->worker->staff_number)
            ->line('**Department:** ' . ($this->worker->department?->name ?? 'Not Assigned'))
            ->line('Please review and verify this worker record at your earliest convenience.')
            ->action('Review in Admin Panel', route('filament.admin.resources.workers.index'))
            ->salutation("Regards,\n{$orgName} System");
    }
}
