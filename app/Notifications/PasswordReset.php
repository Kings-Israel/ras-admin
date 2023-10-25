<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordReset extends Notification
{
    use Queueable;

    public $token;
    public $user;

    /**
     * Create a new notification instance.
     */
    public function __construct(User $user, $token)
    {
        $this->token = $token;
        $this->user = $user;
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
        if (now()->diff($this->user->created_at) < 3) {
            return (new MailMessage)
                        ->line('You are receiving because your account has been created successfully on Real African Sources.')
                        ->line('Follow the link below to reset your password and login.')
                        ->action('Notification Action', url('password/reset', $this->token));
        }

        return (new MailMessage)
                    ->line('The introduction to the notification.')
                    ->action('Notification Action', url('password/reset', $this->token))
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
            //
        ];
    }
}
