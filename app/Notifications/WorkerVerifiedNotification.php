<?php

namespace App\Notifications;

use App\Models\Worker;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class WorkerVerifiedNotification extends Notification
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
            ->subject("Your Staff Verification has been Approved — {$orgName}")
            ->greeting("Dear {$this->worker->full_name},")
            ->line('We are pleased to inform you that your employment record has been verified and approved by the LGA HR Office.')
            ->line('**Staff Number:** ' . $this->worker->staff_number)
            ->line('**Department:** ' . ($this->worker->department?->name ?? 'N/A'))
            ->line('Your digital staff ID card is now available. Please log in to your worker portal to download your official ID card.')
            ->action('Login to Portal', route('portal.dashboard'))
            ->line('If you have any questions, contact the LGA HR office.')
            ->salutation("Regards,\n{$orgName} HR Office");
    }
}
