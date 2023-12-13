<?php

namespace App\Notifications;

use App\Models\FinancingRequest;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class FinancingRequestUpdated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(public FinancingRequest $financing_request, public string $status)
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
                    ->line('The financing request for the invoice, '.$this->financing_request->invoice->invoice_id.' has been updated.')
                    ->action('Click Here to view details', config('app.frontend_url').'/invoices/'.$this->financing_request->invoice.'/orders')
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
            'invoice' => $this->financing_request->invoice,
            'status' => $this->status
        ];
    }
}
