<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderPlaced extends Notification
{
    use Queueable;
    protected $details;

    /**
     * Create a new notification instance.
     */
    public function __construct($details)
    {
        $this->details=$details;

    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->subject('Order Created: ' . $this->details['name'])
            ->greeting('Hello,')
            ->line('This is an automated notification from ClydePixel.')
            ->line('Order **'.$this->details['name'].'** has been created.')
            ->line('Expected completion deadline: **'.$this->details['deadline'].'**.')
            ->action('View Orders', url('/OrderShow'))
            ->line('Regards,')
            ->line('ClydePixel Team');
    }


    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            //
        ];
    }
}
