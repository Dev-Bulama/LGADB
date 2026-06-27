<?php

namespace App\Notifications;

use App\Models\Worker;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WorkerSuspendedNotification extends Notification
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
            ->subject('Notice of Account Suspension')
            ->greeting("Dear {$this->worker->full_name},")
            ->line('We are writing to inform you that your staff account on the LGA Workforce Identity System has been suspended.')
            ->line('**Staff Number:** ' . $this->worker->staff_number)
            ->line('While your account is suspended, you will not be able to access the worker portal.')
            ->line('If you believe this suspension has been made in error, please contact the LGA HR office immediately for further assistance.')
            ->salutation("Regards,\n{$orgName} HR Office");
    }
}
