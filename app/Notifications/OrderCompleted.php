<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OrderCompleted extends Notification
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
        ->greeting('Congratulation!!')
        ->line('We wanted to inform you that your order **'.$this->details['name'].'** has been Completed at **'.$this->details['deadline'].'**.')
        ->action('Click here to check', url('/OrderCompletedShow'))
        ->line('Thank you for using **CydePixel**!');
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
