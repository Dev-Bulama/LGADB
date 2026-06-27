<?php

namespace App\Notifications;

use App\Models\Worker;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WorkerRejectedNotification extends Notification
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
            ->subject('Staff Verification Update — Action Required')
            ->greeting("Dear {$this->worker->full_name},")
            ->line('Your staff verification record has been reviewed by the LGA HR Office.')
            ->line('Unfortunately, your record requires correction for the following reason:')
            ->line('**Reason:** ' . ($this->worker->rejection_reason ?? 'Please contact the HR office for details.'))
            ->line('Please contact the LGA HR office to resolve this issue.')
            ->line('You may resubmit your information by visiting the worker portal.')
            ->action('Login to Portal', route('portal.dashboard'))
            ->salutation("Regards,\n{$orgName} HR Office");
    }
}
