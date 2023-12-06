<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UpdatedOrder extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public Order $order, public string $status = '')
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['mail', 'database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
                    ->greeting('Hello, '.$notifiable->first_name)
                    ->line('An update was made on your order.')
                    ->action('Click to view order', url(config('app.frontend_url').'/orders/'.$this->order->id))
                    ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        return [
            'order' => $this->order,
            'status' => $this->status != '' ? $this->status : NULL
        ];
    }
}
